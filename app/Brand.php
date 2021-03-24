<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Get all of the types that are assigned this brand.
     */
    public function types()
    {
        return $this->morphedByMany('App\Type', 'brandable');
    }
}
