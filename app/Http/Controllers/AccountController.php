<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 8/5/2015
 * Time: 10:54 AM
 */

namespace App\Http\Controllers;

use Auth;
use App\Models\Account;
use App\Models\Dealer;
use App\Repositories\Erp\ErpFactory;
use App\Lib\Utilities\Helper;

class AccountController extends Controller
{
    protected $erp;

    public function __construct()
    {
        $this->erp = Helper::erpFromAuthenticatedUser();
    }

    public function index()
    {
        $account = Auth::user()->account;
        $accountStatus = $this->erp->accountStatus($account->code, $account->code);
        $totalBalance = 0;

        $jobsList = $this->erp->getJobs($account->code);

        //print_r($jobsList);
        foreach($jobsList as $job) {
            if(isset($job[0])) {
                $tmpStatus = $this->erp->accountStatus($account->code, $job[0]);
                $totalBalance += $tmpStatus['Main'][4];
            }
        }

        $lastPayAmt = $accountStatus['Main'][2];
        $lastPayDate = $accountStatus['Main'][3];
        //$totalBalance = $accountStatus['Main'][4];
        $lastSaleAmt = $accountStatus['Main'][5];
        $lastSaleDate = $accountStatus['Main'][6];
        $creditLimit = $accountStatus['Main'][7];
        $mtdPay = $accountStatus['Main'][8];
        $mtdChg = $accountStatus['Main'][9];
        $creditStatus = $accountStatus['Main'][10];
        $ytdPay = $accountStatus['Main'][11];
        $ytdSales = $accountStatus['Main'][12];
        $salesperson = $accountStatus['Main'][13];
        $lastStmtBalance = $accountStatus['Main'][14];
        $seqNum = $accountStatus['Main'][15];

        $statements = Auth::user()->getStatements();
        $estimates = Auth::user()->estimates()->orderBy('name')->limit(3)->get();

        return view('account.index', compact('account', 'totalBalance', 'creditLimit', 'statements', 'estimates'));
    }

    public function accountTest()
    {
        $account = Auth::user()->account;
        $accountStatus = $this->erp->arPeriods();

        print_r($accountStatus);
    }

    public function associate()
    {
        return view ('account.associate');
    }

    public function accountBalance()
    {

    }

    public function accountStatements()
    {

    }

    public function accountEstimates()
    {

    }

    public function accountCredit()
    {

    }
}