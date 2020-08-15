<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSaleRequest;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\CustomerVoucher;
use Illuminate\Http\Request;

class ReturnSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.return.index',[
            'sales'=>Sale::returnType()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.return.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSaleRequest $request)
    {
        $sale = Sale::create([
            'payment_type_id'=>$request->payment_mode,
            'invoice_type_id'=>2,
            'customer_id'=>$request->customer,
            'total_price'=>$request->totalPrice,
            'total_qty'=>$request->totalQty,
            'pay'=>$request->pay_balance?:0,
            'cheque_id'=> 0,
            'closing_balance' => $request->balance,
            'date' => $request->date,
            'time' => $request->time,
            'remarks' => $request->remarks,
            'discount' => $request->discount
        ]);

        foreach ($request->products as $product)
        {
            SaleDetail::create([
                'sale_id'=>$sale->id,
                'product_head_id'=>$product['id'],
                'total_qty'=>$product['qty'],
                'total_price'=>$product['price'],
            ]);
            // $stock =Stock::where('product_head_id',$product['id'])->first();

            // $stock->out_qty -= $product['qty'];

            // $stock->save();

        }
        if ($request->pf){

            return $sale->id;
        }

        return 'no';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('sales.return.edit',[
            'sale'=>Sale::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateSaleRequest $request, $id)
    {
        $sale = Sale::find($id);
        $sale->payment_type_id=$request->payment_mode;
        $sale->customer_id=$request->customer;
        $sale->total_price=$request->totalPrice;
        $sale->total_qty=$request->totalQty;
        $sale->pay=$request->pay_balance ?: 0;
        $sale->cheque_id = 0;
        $sale->closing_balance = $sale->closing_balance - $request->balance_difference;
        $sale->remarks = $request->remarks;
        $sale->time = $request->time;
        $sale->discount = $request->discount;
        $sale->date = $request->date;
        $sale->save();


        foreach ($sale->saleDetails as $oldproduct)
        {
            // $stock= Stock::where('product_head_id',$oldproduct->product_head_id)->first();

            // $stock->out_qty -= $oldproduct->total_qty;

            // $stock->save();

            $oldproduct->delete();
        }

        foreach ($request->products as $product)
        {
            saleDetail::create([
                'sale_id'=>$sale->id,
                'product_head_id'=>$product['id'],
                'total_qty'=>$product['qty'],
                'total_price'=>$product['price'],
            ]);

            $stock =Stock::where('product_head_id',$product['id'])->first();
            $stock->out_qty += $product['qty'];
            $stock->save();

        }

        if ($request->pf){

            return $sale->id;
        }

        return 'no';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
