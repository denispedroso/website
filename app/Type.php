<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Get all of the brands for the type.
     */
    public function brands()
    {
        return $this->morphToMany('App\Brand', 'brandable');
    }
}
