<?php

namespace App\Models;

use Eloquent;
use App\Traits\TenantableTrait;

class Account extends Eloquent {
    use TenantableTrait;

    protected $fillable = ['name', 'code', 'password'];
    protected $hidden = ['password'];

    public function dealer() {
        return $this->belongsTo('\App\Models\Dealer');
    }

    public function users() {
        return $this->hasMany('\App\User');
    }
}
