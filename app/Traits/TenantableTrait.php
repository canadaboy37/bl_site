<?php namespace App\Traits;

use App\TenantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait TenantableTrait {

    /**
     * Boot the tenantable trait for the model
     *
     * @return void
     */
    public static function bootTenantableTrait()
    {
        static::addGlobalScope(new TenantScope);
    }

}