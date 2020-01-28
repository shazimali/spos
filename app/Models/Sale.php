<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded=['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function saleDetail()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function scopeReturnType()
    {
        return $this->where('invoice_type_id',2);
    }

    public function scopeNewType()
    {
        return $this->where('invoice_type_id',1);
    }

    public function ScopeProfitLoss($query)
    {
        return $query->with('customer','saleDetail.purchaseRate');
    }

    public function customerSale()
    {
        return $this->belongsToMany(Sale::class,'customer_sale');
    }




}
