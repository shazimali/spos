<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $guarded=['id'];

    public function productHead()
    {
        return $this->belongsTo(ProductHead::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class,'sale_detail_tax');
    }

    public function purchaseRate()
    {
        return $this->hasOne(PurchaseDetail::class,'product_head_id','product_head_id')->orderBy('total_price','desc');
    }

}
