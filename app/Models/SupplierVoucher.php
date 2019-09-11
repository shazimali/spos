<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierVoucher extends Model
{
    protected $guarded = ['id'];

    public function supplier(){

        return $this->belongsTo(Supplier::class);
    }
}
