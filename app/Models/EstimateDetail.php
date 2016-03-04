<?php

namespace App\Models;

use Eloquent;
use App\Traits\TenantableTrait;
use App\Models\EstimateSection;

class EstimateDetail extends Eloquent {
    use TenantableTrait;

    protected $appends = array('section_name');

    public function dealer() {
        return $this->belongsTo('\App\Models\Dealer');
    }

    public function estimate() {
        return $this->belongsTo('\App\Models\Estimate');
    }

    public function section() {
        return $this->belongsTo('\App\Models\EstimateSection');
    }

    protected function getSectionNameAttribute() {
        $section = EstimateSection::find($this->estimate_section_id);
        if ($section !== null) {
            return $section->name;
        } else {
            return '';
        }
    }
}
