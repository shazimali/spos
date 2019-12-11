<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded=['id'];

    public function purchase(){

        return $this->hasMany(Purchase::class);
    }

    public function supplier_voucher(){

        return $this->hasMany(SupplierVoucher::class);
    }

    public function cBalance()
    {
        return floatval($this->purchase->where('invoice_type_id',1)->sum('total_price')-$this->purchase->where('invoice_type_id',2)->sum('total_price')-$this->purchase->sum('pay')-$this->supplier_voucher->sum('amount') + $this->balance);
    }

}
