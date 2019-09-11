<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseHead;
class ExpenseHeadController extends Controller
{
    public function index(){

        return view('expense-head.index',[

            'head' =>  ExpenseHead::all(),
            'i' => 1
        ]);
    }

    public function store(Request $request){

            $request->validate([

                'title' => 'required|unique:expense_heads|max:255',
            ]);

            ExpenseHead::create($request->all());
            return 1;
    }

    public function update(Request $request,$id){

        $request->validate([

            'title' => 'required|unique:expense_heads|max:255',
        ]);
        ExpenseHead::whereId($id)
        ->update($request->except(['_token']));
        return 1;
}
}
