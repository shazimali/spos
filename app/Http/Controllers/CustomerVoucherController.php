<?php

namespace App\Http\Controllers;

use App\Models\CustomerVoucher;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Sale;

class CustomerVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('customer-voucher.index',[

            'customers' => Customer::all(),
            'vouchers' => CustomerVoucher::all()
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
            'customer_name'=>'required',
            'amount'=>'required',
        ]);
        $amount = $request->amount;
        if( strpos($amount, ',') !== false ) {
           $amount =  str_replace(',','', $amount);
        }

        $date = date("Y-m-d H:i:s", strtotime($request->date));

        CustomerVoucher::create([

            'date' => $date,
            'customer_id' => $request->customer_name,
            'amount' => $amount,
            'closing_balance' => $request->balance,
            'time'=> $request->time,
            'remarks'=> $request->remarks,
        ]);

        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerVoucher  $customerVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerVoucher $customerVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerVoucher  $customerVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerVoucher $customerVoucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerVoucher  $customerVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customerVoucher)
    {
        $request->validate([

            'date'=>'required',
            'customer_name'=>'required',
            'amount'=>'required',
        ]);
        $amount = $request->amount;
        if( strpos($amount, ',') !== false ) {
           $amount =  str_replace(',','', $amount);
        }
        $date = date("Y-m-d H:i:s", strtotime($request->date));

        $oldVoucher = CustomerVoucher::whereId($customerVoucher)->first();


        CustomerVoucher::whereId($customerVoucher)->update([
            'customer_id' => $request->customer_name,
            'amount' => $amount,
            'closing_balance' => $oldVoucher->closing_balance - ($amount - $oldVoucher->amount),
            'remarks' => $request->remarks
        ]);



        return 1;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerVoucher  $customerVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerVoucher $customerVoucher)
    {
        //
    }

    public function getCustomerBalance($id){

        return Customer::whereId($id)->first()->cBalance();

    }
}
