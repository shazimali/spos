<?php

namespace App\Http\Controllers;

use App\Models\ProductHead;
use App\Models\Unit;
use App\Models\SaleDetail;
use App\Models\PurchaseDetail;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product-head.index',[

           'products_heads'=> ProductHead::all(),
           'units'=> Unit::all(),
           'brands'=> Brand::all(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|min:3|max:300',
            'code'=>'required|unique:product_heads',
            'min_stock'=>'required',
            'sale'=>'required',
            'unit_id'=>'required',
            'brand_id'=>'required',
            'purchase'=>'required'
        ]);

        ProductHead::create($request->all());
        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductHead  $productHead
     * @return \Illuminate\Http\Response
     */
    public function show(ProductHead $productHead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductHead  $productHead
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductHead $productHead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductHead  $productHead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required|min:3|max:300',
            'min_stock'=>'required',
            'purchase'=>'required',
            'sale'=>'required',
            'unit_id'=>'required',
            'brand_id'=>'required',
        ]);
        ProductHead::whereId($id)->update($request->except(['_token']));
        
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductHead  $productHead
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $IsSale = SaleDetail::where('product_head_id',$id)->get();
        $IsPurchase = PurchaseDetail::where('product_head_id',$id)->get();

        if(count($IsSale) || count($IsPurchase)){
            return 2;
        }
        else{
            ProductHead::destroy($id);
            return 1;
        }
    }
}
