<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePurchaseRequest;
use App\Models\PaymentType;
use App\Models\ProductHead;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ReturnPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase.return.index',[
            'purchases'=>Purchase::returnType()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchase.return.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePurchaseRequest $request)
    {

        Supplier::whereId($request->supplier)
            ->update([
                'balance'=>$request->balance
            ]);

        $purchase = Purchase::create([
            'payment_type_id'=>$request->payment_mode,
            'invoice_type_id'=>2,
            'supplier_id'=>$request->supplier,
            'total_price'=>$request->totalPrice,
            'total_qty'=>$request->totalQty,
            'cheque_id'=>$request->cheque_id,
            'cheque_date'=>$request->cheque_date,
            'bank'=>$request->cheque_bank,
            'cheque_amount'=>$request->cheque_amount,
            'date'=>$request->date,
            'time'=>$request->time,
            'remarks'=>$request->remarks,
            'pay'=>$request->pay_balance?:0,
            'closing_balance' => $request->balance
        ]);
        foreach ($request->products as $product)
        {
            PurchaseDetail::create([
                'purchase_id'=>$purchase->id,
                'product_head_id'=>$product['id'],
                'total_qty'=>$product['qty'],
                'total_price'=>$product['price'],
            ]);

            $stock =Stock::where('product_head_id',$product['id'])->first();
            $stock->total_qty -= $product['qty'];
            $stock->save();
        }


        if ($request->pf){

            return $purchase->id;
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
        return view('purchase.return.edit',[
            'purchase'=>Purchase::find($id)
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePurchaseRequest $request, $id)
    {
        $purchase = Purchase::find($id);
        $old_sup=$purchase->supplier_id;
        $new_sup=$request->supplier;

        if ($old_sup != $new_sup )
        {

            $purchase->supplier_id =$request->supplier;
            $supplier = Supplier::find($old_sup);
            $supplier->balance += ($purchase->total_price - $purchase->pay);
            $supplier->save();

            Supplier::whereId($request->supplier)
                ->update([
                    'balance'=>$request->balance
                ]);

        }else{

            Supplier::whereId($old_sup)
                ->update([
                    'balance'=>$request->balance
                ]);

        }

        $purchase->payment_type_id=$request->payment_mode;
        $purchase->supplier_id=$request->supplier;
        $purchase->remarks=$request->remarks;
        $purchase->time=$request->time;
        $purchase->date=$request->date;
        $purchase->total_price=$request->totalPrice;
        $purchase->total_qty=$request->totalQty;
        $purchase->pay=$request->pay_balance ?: 0;
        $purchase->closing_balance=$request->balance;
        $purchase->save();


        foreach ($purchase->purchaseDetails as $oldproduct)
        {
            $stock= Stock::where('product_head_id',$oldproduct->product_head_id)->first();

            $stock->total_qty= $stock->total_qty + $oldproduct->total_qty;

            $stock->save();

            $oldproduct->delete();
        }

        foreach ($request->products as $product)
        {
            PurchaseDetail::create([
                'purchase_id'=>$purchase->id,
                'product_head_id'=>$product['id'],
                'total_qty'=>$product['qty'],
                'total_price'=>$product['price'],
            ]);

            $stock =Stock::where('product_head_id',$product['id'])->first();

                $stock->total_qty -= $product['qty'];

                $stock->save();

        }


        if ($request->pf){

            return $purchase->id;
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
