<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $guarded=['id'];

    public function productHead()
    {
        return $this->belongsTo(ProductHead::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }


}
