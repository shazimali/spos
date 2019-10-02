<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSaleRequest;
use App\Models\Customer;
use App\Models\PaymentType;
use App\Models\ProductHead;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\CustomerVoucher;
use App\Models\Stock;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function index()
    {
        return view('sales.index',[
            'sales'=>Sale::newType()->get()
        ]);
    }

    public function getCustomers($id=null)
    {
        if ($id){
            $sale=Sale::whereId($id)->with('customer','saleDetails.productHead.stock','paymentType')->first();
            return [
                'customers'=> Customer::orderBy('name')->get(),
                'sale'=> $sale,
                'cBalance'=>Customer::find($sale->customer_id)->cBalance(),
                'payment_types'=> PaymentType::whereIn('id',[1,2])->orderBy('title')->get(),
                'product_heads'=> ProductHead::orderBy('title')->whereHas('stock')->with('stock')->get(),
            ];
        }

        return [
            'customers'=> Customer::orderBy('name')->get(),
            'payment_types'=> PaymentType::whereIn('id',[1,2])->orderBy('title')->get(),
            'product_heads'=> ProductHead::orderBy('title')->whereHas('stock')->with('stock')->get(),
        ];

    }
    public function create()
    {
        return view('sales.create');
    }

    public function store(CreateSaleRequest $request)
    {

        Customer::whereId($request->customer)
            ->update([
                'balance'=>$request->balance
            ]);

        $sale = Sale::create([
            'payment_type_id'=>$request->payment_mode,
            'invoice_type_id'=>1,
            'customer_id'=>$request->customer,
            'total_price'=>$request->totalPrice,
            'total_qty'=>$request->totalQty,
            'cheque_id'=>$request->cheque_id,
            'cheque_date'=>$request->cheque_date,
            'bank'=>$request->cheque_bank,
            'cheque_amount'=>$request->cheque_amount,
            'date'=>$request->date,
            'time'=>$request->time,
            'pay'=>$request->pay_balance?:0,
            'closing_balance'=>$request->balance,
            'discount'=>$request->discount,
            'net_total'=>$request->netTotal,
            'remarks'=>$request->remarks,
        ]);

        foreach ($request->products as $product)
        {
            SaleDetail::create([

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

    public function getProducts(Request $request)
    {

        return ProductHead::where('title','LIKE','%'.$request->key.'%')->with('stock')->get()?:[];

    }

    public function show($id)
    {
        return view('sales.show',[
            'invoice'=>Sale::find($id)
        ]);
    }

    public function edit($id)
    {
        return view('sales.edit');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(CreateSaleRequest $request, $id)
    {
        $sale = Sale::find($id);
        $old_cus=$sale->customer_id;
        $new_cus=$request->customer;

        if ($old_cus != $new_cus )
        {
            $customer = customer::find($old_cus);
            $customer->balance -= ($sale->net_total - $sale->pay);
            $customer->save();

            customer::whereId($request->customer)
                ->update([
                    'balance'=>$request->balance
                ]);
        }
        else{

             customer::whereId($old_cus)
                ->update([
                    'balance'=>$request->balance
                ]);
        }
        $sale->total_price=$request->totalPrice;
        $sale->total_qty=$request->totalQty;
        $sale->cheque_id=$request->cheque_id;
        $sale->cheque_date=$request->cheque_date;
        $sale->bank=$request->bank;
        $sale->customer_id=$request->customer;
        $sale->cheque_amount=$request->cheque_amount;
        $sale->discount = $request->discount;
        $sale->net_total = $request->netTotal;
        $sale->payment_type_id=$request->payment_mode;
        $sale->pay=$request->pay_balance ?: 0;
        $sale->remarks = $request->remarks;
        $sale->date = $request->date;
        $sale->time = $request->time;

        $sale->save();



        foreach ($sale->saleDetails as $oldproduct)
        {
            $stock= Stock::where('product_head_id',$oldproduct->product_head_id)->first();

            $stock->out_qty -= $oldproduct->total_qty;

            $stock->save();

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




}