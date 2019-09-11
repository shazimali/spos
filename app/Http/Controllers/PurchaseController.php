<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePurchaseRequest;
use App\Models\ProductHead;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase.index',[
            'purchases'=>Purchase::newType()->get()
        ]);
    }

    public function getSuppliers($id=null)
    {
        if ($id){
            $purchase=Purchase::whereId($id)->with('supplier','purchaseDetails.productHead.stock','paymentType')->first();
            return [
                'suppliers'=> Supplier::orderBy('name')->get(),
                'purchase'=>$purchase ,
                'cBalance'=>Supplier::find($purchase->supplier_id)->cBalance(),
                'payment_types'=> PaymentType::whereIn('id',[1,2])->orderBy('title')->get(),
                'product_heads'=> ProductHead::orderBy('title')->get(),
            ];
        }

        return [
            'suppliers'=> Supplier::orderBy('name')->get(),
            'payment_types'=> PaymentType::whereIn('id',[1,2])->orderBy('title')->get(),
            'product_heads'=> ProductHead::orderBy('title')->with('purchaseDetail')->get(),
            ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchase.create');
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
            'invoice_type_id'=>1,
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
            if ($stock){
                $stock->total_qty += $product['qty'];
                $stock->price = $product['retail'];
                $stock->save();
            }else{
                Stock::create([
                    'product_head_id'=>$product['id'],
                    'total_qty'=>$product['qty'],
                    'price'=>$product['retail'],
                ]);
            }
        }
        if ($request->pf){

            return $purchase->id;
        }


        return 'no';

    }





    public function show($id)
    {
        return view('purchase.show',[
            'invoice'=>Purchase::find($id)
        ]);
    }


    public function edit($id)
    {

        return view('purchase.edit',[
            'purchase'=>Purchase::find($id)
        ]);
    }

    public function editSupplier($id)
    {
        return Purchase::find($id);
    }

    public function update(CreatePurchaseRequest $request, $id)
    {
         $purchase = Purchase::find($id);
         $old_sup=$purchase->supplier_id;
         $new_sup=$request->supplier;

         if ($old_sup != $new_sup )
         {

            $purchase->supplier_id =$request->supplier;
            $supplier = Supplier::find($old_sup);
            $supplier->balance -= ($purchase->total_price - $purchase->pay);
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

        $purchase->supplier_id=$request->supplier;
        $purchase->total_price=$request->totalPrice;
        $purchase->total_qty=$request->totalQty;
        $purchase->pay=$request->pay_balance > 0 ? $request->pay_balance:0;
        $purchase->payment_type_id=$request->payment_mode;
        $purchase->cheque_id=$request->cheque_id;
        $purchase->cheque_date=$request->cheque_date;
        $purchase->bank=$request->bank;
        $purchase->cheque_amount=$request->cheque_amount;
        $purchase->closing_balance = $request->balance;
        $purchase->date= $request->date;
        $purchase->time=$request->time;
        $purchase->remarks=$request->remarks;
        $purchase->save();


        foreach ($purchase->purchaseDetails as $oldproduct)
        {
             $stock= Stock::where('product_head_id',$oldproduct->product_head_id)->first();

             $stock->total_qty= $stock->total_qty-$oldproduct->total_qty;

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
            if ($stock){
                $stock->total_qty += $product['qty'];

                $stock->price = $product['retail'];
                $stock->save();
            }else{
                Stock::create([
                    'product_head_id'=>$product['id'],
                    'total_qty'=>$product['qty'],
                    'price'=>$product['retail'],
                ]);
            }
        }


        if ($request->pf){

            return $purchase->id;
        }


        return 'no';

    }

    public function destroy($id)
    {

        return $id;
    }
}
