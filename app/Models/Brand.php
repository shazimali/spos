<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function productHead()
    {
        return $this->hasOne(productHead::class);
    }
}
