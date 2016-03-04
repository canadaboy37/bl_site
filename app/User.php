<?php

namespace App;

use Auth;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Traits\TenantableTrait;
use App\Lib\Utilities\Helper;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, TenantableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $appends = array('followed');
    protected $hidden = ['dealer_id', 'password', 'remember_token'];

    public function dealer() {
        return $this->belongsTo('\App\Models\Dealer');
    }

    public function account() {
        return $this->belongsTo('\App\Models\Account');
    }

    public function estimates() {
        return $this->hasMany('\App\Models\Estimate');
    }

    public function following()
    {
        return $this->belongsToMany('App\User', 'following', 'user_id', 'followed_user_id');
    }

    protected function getFollowedAttribute() {
        if (Auth::user()->following->contains($this->id))
            return true;
        else
            return false;
    }

    public function getRecentActivity()
    {
        return "Hello world!";
    }

    public function getStatements() {
        $erp = Helper::erpFromAuthenticatedUser();

        // Get statement periods
        $statementPeriods = $erp->ARPeriods();

        if (isset($statementPeriods['Main']))
            unset($statementPeriods['Main']);

        // Remove extra data
        foreach ($statementPeriods as $key => $statementPeriod)
        {
            if ($key !== "Main") //skip Main
            {
                $statementPeriods[$key] = $statementPeriod[0];
            }
        }

        // Get jobs
        $jobs = array();
        $jobsArray = $erp->getJobs($this->account->code);
        foreach ($jobsArray as $job)
        {
            if(isset($job[2]))
                $jobs[$job[0]] = $job[2];
        }

        // Get statements
        $statementArray =  $erp->NewAccountStatement($this->account->code, ' ', ' ', $statementPeriods[0]);

        // Clean up data
        $statements = array();
        foreach($statementArray as $key => $value)
        {
            if($value[0] == 'HEADER') {
                $jobCode = $value[2];
            }
            else if($key !== 'Main' && $value[0] == 'LINE')
            {
                $statement = array();

                if(isset($jobs[$jobCode]))
                    $statement['job']  = $jobs[$jobCode]; // Match the job code to a job name
                else
                    $statement['job']  = $jobCode; // If a job name is not found, use the job code

                $statement['transactionNumber'] =  $value[2];
                $statement['transactionDate'] =  $value[3];
                $statement['transactionType'] =  $value[4];
                $statement['transactionAmount'] =  $value[5];
                $statement['DiscountDate'] =  $value[6];
                $statement['PaidAmount'] =  $value[7];

                array_push($statements, $statement);
            }
        }

        usort($statements, array($this, 'sortStatements'));

        return $statements;
    }

    /**
     * Sort Statements primarily by date and secondarily by transaction number
     */
    protected static function sortStatements($a ,$b) {
        // Order statements

        if ($a['transactionDate'] > $b['transactionDate']) {
            return -1;
        } elseif  ($a['transactionDate'] < $b['transactionDate']) {
            return 1;
        } else {
            return strcmp($b['transactionNumber'], $a['transactionNumber']);
        }
    }
}
