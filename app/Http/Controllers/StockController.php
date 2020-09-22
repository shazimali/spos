<?php

namespace App\Http\Controllers;

use App\Models\ProductHead;
use App\Models\PurchaseDetail;
use App\Models\SaleDetail;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
            // return     PurchaseDetail::where('product_head_id',141)->get();
            // return  SaleDetail::where('product_head_id',141)->with('sale')->get();
                
            // $saleStocks =   SaleDetail::where('product_head_id',141)->with('sale')->get();
            // $purchaseStocks =   PurchaseDetail::where('product_head_id',141)->with('purchase')->get();
            // $sale = 0;
            // $purchase = 0;
            // foreach($saleStocks as $st){
            //     if($st->sale->invoice_type_id == 2){
                
            //         $sale += $st->total_qty ;
            //     }
            // }
            
            // foreach($purchaseStocks as $st){
            //     if($st->purchase->invoice_type_id == 1){
                
            //         $purchase += $st->total_qty ;
            //     }
            // }
            
            // return $sale;
        
        //   return ProductHead::with('allPurchases.purchase','allSales.sale')->get();
                //    return  ProductHead::with('allSales')->get();
                // ProductHead::whereHas('allPurchases')->with('allPurchases','allSales')->get(),
        return view('stock.index',[

            'stocks'=> ProductHead::with('allPurchases.purchase','allSales.sale')->get(),

            ]);
    }
}
