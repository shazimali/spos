<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EapenseHead;
class Expense extends Model
{
    protected $fillable = ['date','expense_id','amount'];

    public function expensHead(){

        return $this->hasOne(ExpenseHead::class,'id','expense_id');
    }
}
