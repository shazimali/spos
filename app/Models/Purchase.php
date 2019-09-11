<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\BinaryUuid\HasBinaryUuid;

class Purchase extends Model
{
//    use HasBinaryUuid;

    protected $guarded=['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }


    public function scopeReturnType()
    {
        return $this->where('invoice_type_id',2);
    }

    public function scopeNewType()
    {
        return $this->where('invoice_type_id',1);
    }



}
