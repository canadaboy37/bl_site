<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ScopeInterface;
use App\Lib\Utilities\Helper;
use Session;

class TenantScope implements ScopeInterface
{
    /**
    * Apply the scope to a given Eloquent query builder.
    *
    * @param  \Illuminate\Database\Eloquent\Builder  $builder
    * @param  \Illuminate\Database\Eloquent\Model  $model
    * @return void
    */
    public function apply(Builder $builder, Model $model)
    {
        if (Session::has('dealerId'))
        {
            $dealer = Helper::getDealer();
            $builder->where('dealer_id', '=', $dealer->id);
        }
    }

    /**
    * Remove the scope from the given Eloquent query builder.
    *
    * @param  \Illuminate\Database\Eloquent\Builder  $builder
    * @param  \Illuminate\Database\Eloquent\Model  $model
    * @return void
    */
    public function remove(Builder $builder, Model $model)
    {
        $query = $builder->getQuery();

        foreach((array)$query->wheres as $key => $where) {

            if($where['column'] == 'dealer_id') {

                unset($query->wheres[$key]);

                $query->wheres = array_values($query->wheres);
            }
        }
    }
}