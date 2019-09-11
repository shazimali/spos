<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Customer extends Model
{
    protected $guarded=['id'];

    public function sale(){

        return $this->hasMany(Sale::class);
    }

    public function customer_voucher(){

        return $this->hasMany(CustomerVoucher::class);
    }

    public function cBalance()
    {
        return floatval($this->sale->where('invoice_type_id',1)->sum('net_total')-$this->sale->where('invoice_type_id',2)->sum('total_price')-$this->sale->sum('pay')-$this->customer_voucher->sum('amount'));
    }
}
