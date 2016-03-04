<?php

namespace App\Models;

use Eloquent;
use App\Lib\Utilities\EpicorImporter;

class Dealer extends Eloquent {

    public function runImporter() {
        if ($this->erp_type =='Epicor') {
            $importer = new EpicorImporter($this);
            $importer->run();
        }
    }

    public function accounts() {
        return $this->hasMany('\App\Models\Account');
    }

    public function users() {
        return $this->hasMany('\App\User');
    }

    public function categories() {
        return $this->hasMany('\App\Models\Category');
    }

    public function products() {
        return $this->hasMany('\App\Models\Product');
    }

    public function estimates() {
        return $this->hasMany('\App\Models\Estimate');
    }

    public function estimateDetails() {
        return $this->hasMany('\App\Models\EstimateDetail');
    }
}
