<?php

namespace App\Http\Controllers;

use App\Models\ProductHead;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {

    //    return  ProductHead::whereHas('allPurchases')->whereHas('allSales')->with('allPurchases','allSales')->get();
                //    return  ProductHead::with('allSales')->get();
        return view('stock.index',[

            'stocks'=> ProductHead::whereHas('allPurchases')->with('allPurchases','allSales')->get(),

            ]);
    }
}
