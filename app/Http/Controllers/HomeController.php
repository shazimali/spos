<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\ProductHead;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // $details =   Customer::whereHas('sale',function($q){
        //     $q->where('invoice_type_id',1)
        //     ->whereMonth('created_at', Carbon::now()->month);
        //     })
        //     ->with('sale')->get();
            // return Customer::whereHas('sale',function($q){

            //     $q->where('invoice_type_id',1)->whereMonth('created_at', Carbon::now()->month);

            //     })->with('sale')->get();

        return view('dashboard',[

            'new_customers'=> Customer::whereDate('created_at', Carbon::today())->count(),
            'new_suppliers'=> Supplier::whereDate('created_at', Carbon::today())->count(),
            'today_sale' => Sale::whereDate('date',Carbon::today())->sum('net_total'),
            'today_purchase' => Purchase::whereDate('date',Carbon::today())->sum('total_price'),
            'recent_sales' =>  Sale::take(10)->orderBy('id','desc')->get(),
            'recent_purchases' =>  Purchase::take(10)->orderBy('id','desc')->get(),
            'current_month_sales' => Sale::where('invoice_type_id',1)->whereMonth('created_at', Carbon::now()->month)->get(),
            // 'current_month_cutomers' => Customer::whereHas(['sale'=>function($q){
            //                             $q->where('invoice_type_id',1)
            //                             ->whereMonth('created_at', Carbon::now()->month);
            //                             }])
            //                             ->get(),
            'sr' => 1
        ]
    );
    }

    public function customers()
    {
       return  Customer::orderBy('name')->get();

    }

    public function products()
    {
        return  ProductHead::orderBy('title')->get();
    }
}
