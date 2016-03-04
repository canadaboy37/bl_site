<?php

namespace App\Models;

use Eloquent;
use App\Traits\TenantableTrait;

class Category extends Eloquent {
    use TenantableTrait;

    public $table = 'categories';

    protected $fillable = ['code'];

    public function dealer() {
        return $this->belongsTo('\App\Models\Dealer');
    }

    public function products() {
        return $this->hasMany('\App\Models\Product');
    }

    public function children() {
        return $this->hasMany('\App\Models\Category');
    }

    public function parent() {
        return $this->belongsTo('\App\Models\Category');
    }
}
