<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Sale;

class ProfitLossController extends Controller
{
    public function customer(){

        return view('profit-loss.customer_profit_loss');
    }

    public function customerSearch(Request $request){

        $customer = $request->customer;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $results =  Sale::when($customer,function ($query,$customer){

           return $query->whereCustomerId($customer);

            })

        ->when($from_date,function ($query,$from_date){

                return $query->whereDate('date', '>=',$from_date);

                 })

        ->when($to_date,function ($query,$to_date){

                return $query->whereDate('date', '<=',$to_date);

                 })
        ->ProfitLoss()->get();

        return $results;

    }

    public function product(){

        return view('profit-loss.product_profit_loss');
    }

    public function productSearch(Request $request){

        $product = $request->product;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $results =  Sale::when($product,function ($query,$customer){

           return $query->whereCustomerId($customer);

            })

        ->when($from_date,function ($query,$from_date){

                return $query->whereDate('date', '>=',$from_date);

                 })

        ->when($to_date,function ($query,$to_date){

                return $query->whereDate('date', '<=',$to_date);

                 })
        ->ProfitLoss()->get();

        return $results;

    }
}
