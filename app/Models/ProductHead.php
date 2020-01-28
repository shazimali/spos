<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHead extends Model
{
    protected $guarded=['id'];

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function purchaseDetail()
    {
        return $this->hasOne(PurchaseDetail::class);
    }

    public function allPurchases()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function purchases()
    {
        return $this->with(['allPurchases.purchase'=> function($q){
            $q->where('invoice_type_id',1);
          }]);
    }

    public function allSales()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }



}
