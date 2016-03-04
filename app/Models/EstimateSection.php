<?php

namespace App\Models;

use Eloquent;
use App\Traits\TenantableTrait;

class EstimateSection extends Eloquent {
    use TenantableTrait;

    protected $fillable = ['estimate_id', 'name'];

    public function dealer() {
        return $this->belongsTo('\App\Models\Dealer');
    }

    public function estimate() {
        return $this->belongsTo('\App\Models\Estimate');
    }

    public function details() {
        return $this->hasMany('\App\Models\EstimateDetail');
    }
}
