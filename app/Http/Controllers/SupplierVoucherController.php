<?php

namespace App\Http\Controllers;

use App\Models\SupplierVoucher;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier-voucher.index',[

            'suppliers' => Supplier::all(),
            'vouchers' => SupplierVoucher::all()
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

            'date'=>'required',
            'supplier_name'=>'required',
            'amount'=>'required|numeric',
        ]);

        $date = date("Y-m-d H:i:s", strtotime($request->date));

        SupplierVoucher::create([

            'date' => $date,
            'supplier_id' => $request->supplier_name,
            'amount' => $request->amount,
            'time' => $request->time,
            'remarks' => $request->remarks,
            'closing_balance' => $request->balance - $request->amount
        ]);

        $supplier = Supplier::whereId($request->supplier_name)->first();

        $supplier->balance = $supplier->balance - $request->amount;

        $supplier->save();

        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierVoucher  $supplierVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierVoucher $supplierVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierVoucher  $supplierVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierVoucher $supplierVoucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierVoucher  $supplierVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $supplierVoucher)
    {
        $request->validate([

            'date'=>'required',
            'supplier_name'=>'required',
            'amount'=>'required|numeric',
        ]);

        $date = date("Y-m-d H:i:s", strtotime($request->date));

        $oldVoucher = SupplierVoucher::whereId($supplierVoucher)->first();

        if($request->supplier_name != $oldVoucher->supplier_id){

            $oldSupplier = Supplier::whereId($oldVoucher->supplier_id)->first();

            $oldSupplier->update([

                'balance' => $oldSupplier->balance + $oldVoucher->amount
            ]);

            $oldSupplier->save();

            $newSupplier = Supplier::whereId($request->supplier_name)->first();

            $newSupplier->balance = $newSupplier->balance - $request->amount;

            $newSupplier->save();
            SupplierVoucher::whereId($supplierVoucher)->update([

                'supplier_id' => $request->supplier_name,
                'amount' => $request->amount,
                'closing_balance' => $newSupplier->balance,
                'remarks' => $request->remarks

            ]);
        }

        else{

            $supplier = Supplier::whereId($request->supplier_name)->first();

            $supplier->balance = ($supplier->balance + $oldVoucher->amount) - $request->amount;

            $supplier->save();

            SupplierVoucher::whereId($supplierVoucher)->update([

                'supplier_id' => $request->supplier_name,
                'amount' => $request->amount,
                'closing_balance' =>  ($request->edit_balance + $oldVoucher->amount) - $request->amount,
                'remarks' => $request->remarks
            ]);

        }





        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierVoucher  $supplierVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierVoucher $supplierVoucher)
    {
        //
    }

    public function getSupplierBalance($id){

        return Supplier::whereId($id)->first()->cBalance();

    }
}
