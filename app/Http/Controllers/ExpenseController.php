<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseHead;
use Carbon\carbon;
class ExpenseController extends Controller
{
    public function index(){

        return view('expense.index',['expense' => Expense::all(), 'i' => 1]);
    }

    public function create(){

        return view('expense.create',['expense_title' => ExpenseHead::all()]);
    }

    public function store(Request $request){

        $request->validate([

            'date' => 'required',
            'expense_id'=>'required',
            'amount' => 'required'
        ]);
        // return $request->date;
        $date = date("Y-m-d H:i:s", strtotime($request->date));
        Expense::create([

            'date' => $date,
            'expense_id' => $request->expense_id,
            'amount' => $request->amount
        ]);
        return redirect('expense')->with('success','Expense Created Successfully.');
    }

    public function edit($id){

        return view('expense.edit',[

            'expense' => Expense::find($id),
            'expense_title' => ExpenseHead::all()
        ]);
    }

    public function update(Request $request,$id){

        $expense = Expense::find($id);
        $date = date("Y-m-d H:i:s", strtotime($request->date));
        Expense::whereId($id)
        ->update([

            'date' =>$date,
            'expense_id' => $request->expense_id,
            'amount' => $request->amount
        ]);

        return redirect('expense')->with('success','Expense Updated Successfully.');

    }
}
