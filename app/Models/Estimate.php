<?php

namespace App\Models;

use Eloquent;
use App\Traits\TenantableTrait;

class Estimate extends Eloquent {
    use TenantableTrait;

    protected $fillable = ['name', 'notes', 'last_refresh'];

    public function dealer() {
        return $this->belongsTo('\App\Models\Dealer');
    }

    public function user() {
        return $this->belongsTo('\App\User');
    }

    public function sections() {
        return $this->hasMany('\App\Models\EstimateSection');
    }

    public function details() {
        return $this->hasMany('\App\Models\EstimateDetail');
    }
}
