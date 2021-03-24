<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
}
