<?php

namespace App\Models;

use Eloquent;
use App\Traits\TenantableTrait;

class Product extends Eloquent {
    use TenantableTrait;

    protected $fillable = ['sku'];

    public function dealer() {
        return $this->belongsTo('\App\Models\Dealer');
    }

    public function category() {
        return $this->belongsTo('\App\Models\Category');
    }

    public function keywords() {
        return "getKeywords() not yet implemented";
    }

    public function yourPrice() {
        // TODO: move logic to a repository
        return $this->list_price + 1; // TODO: get price from GetPrice Erp method
    }

    public function setListPriceAttribute($value)
    {
        $this->attributes['list_price'] = $value * 100;
    }

    public function getListPriceAttribute($value) {
        return $value / 100;
    }
}
