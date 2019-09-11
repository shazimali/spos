<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale Invoice Print</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>--}}

</head>
<body>


<div id="pdf" >
    <div class="container">
        <br>
        <div class="card">
            <div class="card-body ">
                    <h1 class="text-center"> Day Book</h1>
                    <h4 class="text-center">{{$from_date ? 'From Date:'. $from_date : ''}} {{$to_date ? ' / To Date:'. $to_date : ''}}  </h4>
            </div>
        </div>
        <br>
        <div class="card">

            <div class="card-body">

                @if($chk_customer == 'true')
                    <h1>Customers</h1>
                    <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                        <tr>
                                                <th class="text-center">Cutomer#</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">company</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Phone</th>
                                                <th class="text-center">Address</th>
                                            </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $cs)

                                    <tr>
                                            <td class="text-center">cus#{{$cs->id}}</td>

                                            <td class="text-center">
                                           {{$cs->name}}
                                            </td>
                                            <td class="text-center"> {{$cs->company}}</td>
                                            <td class="text-center">{{$cs->email}}</td>
                                            <td class="text-center">{{$cs->phone}}</td>
                                            <td class="text-center">{{$cs->address}}</td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($chk_sale == 'true')
                    @php
                     $total_sale=0;
                     $total_sale_qty=0;
                    @endphp
                    <h1>Sales</h1>
                    <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                        <tr>
                                            <th  class="text-center">Invoice#</th>
                                            <th  class="text-center">Csutomer Name</th>
                                            <th  class="text-center">Payment Mode</th>
                                            <th  class="text-center">Total Qty</th>
                                            <th  class="text-center">Total Price</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $cs)

                                    <tr>
                                            <td class="text-center">sl#{{$cs->id}}</td>
                                            <td class="text-center">{{$cs->customer->name}}</td>
                                            <td class="text-center"> {{$cs->paymentType->title}}</td>
                                            <td class="text-center">{{$cs->total_qty}}</t>
                                            <td class="text-center">{{$cs->net_total}}</td>
                                            <td hidden >{{$total_sale += $cs->net_total}}</td>
                                            <td hidden>{{$total_sale_qty += $cs->total_qty}}</td>
                                        </tr>

                                    @endforeach
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><b>{{$total_sale_qty}}</b></td>
                                        <td class="text-center font-bold"><b>{{$total_sale}}</b></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($chk_return_sale == 'true')
                    @php
                     $total_return_sale=0;
                     $total_return_sale_qty=0;
                    @endphp
                    <h1>Return Sales</h1>
                    <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                        <tr>
                                            <th  class="text-center">Invoice#</th>
                                            <th  class="text-center">Csutomer Name</th>
                                            <th  class="text-center">Total Qty</th>
                                            <th  class="text-center">Total Price</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $cs)

                                    <tr>
                                            <td class="text-center">rs#{{$cs->id}}</td>
                                            <td class="text-center">{{$cs->customer->name}}</td>
                                            <td class="text-center">{{$cs->total_qty}}</td>
                                            <td class="text-center">{{$cs->total_price}}</td>
                                            <td hidden >{{$total_return_sale += $cs->total_price}}</td>
                                            <td hidden>{{$total_return_sale_qty += $cs->total_qty}}</td>
                                        </tr>

                                    @endforeach
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><b>{{$total_return_sale_qty}}</b></td>
                                        <td class="text-center font-bold"><b>{{$total_return_sale}}</b></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($chk_customer_voucher == 'true')
                    @php
                     $total_customer_voucher=0;
                    @endphp
                    <h1>Customer Vouchers</h1>
                    <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                        <tr>
                                            <th  class="text-center">Vch#</th>
                                            <th  class="text-center">Csutomer#</th>
                                            <th  class="text-center">Name</th>
                                            <th  class="text-center">Amount</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer_vouchers as $cs)

                                    <tr>
                                            <td class="text-center">cv#{{$cs->id}}</td>
                                            <td class="text-center">cs#{{$cs->customer_id}}</td>
                                            <td class="text-center">{{$cs->customer->name}}</td>
                                            <td class="text-center">{{$cs->amount}}</td>
                                            <td hidden >{{$total_customer_voucher += $cs->amount}}</td>
                                        </tr>

                                    @endforeach
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center font-bold"><b>{{$total_customer_voucher}}</b></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if($chk_supplier == 'true')
                    <h1>Suppliers</h1>
                    <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                        <tr>
                                                <th class="text-center">Supplier#</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">company</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Phone</th>
                                                <th class="text-center">Address</th>
                                            </tr>
                                </thead>
                                <tbody>
                                    @foreach($suppliers as $cs)

                                    <tr>
                                            <td class="text-center">sp#{{$cs->id}}</td>

                                            <td class="text-center">
                                           {{$cs->name}}
                                            </td>
                                            <td class="text-center"> {{$cs->company}}</td>
                                            <td class="text-center">{{$cs->email}}</td>
                                            <td class="text-center">{{$cs->phone}}</td>
                                            <td class="text-center">{{$cs->address}}</td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($chk_purchase == 'true')
                    @php
                     $total_purchase=0;
                     $total_purchase_qty=0;
                    @endphp
                    <h1>Purchases</h1>
                    <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                        <tr>
                                            <th  class="text-center">Invoice#</th>
                                            <th  class="text-center">Supplier Name</th>
                                            <th  class="text-center">Payment Mode</th>
                                            <th  class="text-center">Total Qty</th>
                                            <th  class="text-center">Total Price</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchases as $cs)

                                    <tr>
                                            <td class="text-center">pr#{{$cs->id}}</td>
                                            <td class="text-center">{{$cs->supplier->name}}</td>
                                            <td class="text-center"> {{$cs->paymentType->title}}</td>
                                            <td class="text-center">{{$cs->total_qty}}</td>
                                            <td class="text-center">{{$cs->total_price}}</td>
                                            <td hidden >{{$total_purchase_qty += $cs->total_qty}}</td>
                                            <td hidden>{{$total_purchase += $cs->total_price}}</td>
                                        </tr>

                                    @endforeach
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><b>{{$total_purchase_qty}}</b></td>
                                        <td class="text-center font-bold"><b>{{$total_purchase}}</b></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($chk_return_purchase == 'true')
                    @php
                     $total_return_purchase=0;
                     $total_return_purchase_qty=0;
                    @endphp
                    <h1>Return Purchase</h1>
                    <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                        <tr>
                                            <th  class="text-center">Invoice#</th>
                                            <th  class="text-center">Supplier Name</th>
                                            <th  class="text-center">Total Qty</th>
                                            <th  class="text-center">Total Price</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach($return_purchases as $cs)

                                    <tr>
                                            <td class="text-center">rp#{{$cs->id}}</td>
                                            <td class="text-center">{{$cs->supplier->name}}</td>
                                            <td class="text-center">{{$cs->total_qty}}</td>
                                            <td class="text-center">{{$cs->total_price}}</td>
                                            <td hidden >{{$total_return_purchase += $cs->total_price}}</td>
                                            <td hidden>{{$total_return_purchase_qty += $cs->total_qty}}</td>
                                        </tr>

                                    @endforeach
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td class="text-center"><b>{{$total_return_purchase_qty}}</b></td>
                                        <td class="text-center font-bold"><b>{{$total_return_purchase}}</b></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($chk_supplier_voucher == 'true')
                    @php
                     $total_supplier_voucher=0;
                    @endphp
                    <h1>Supplier Vouchers</h1>
                    <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                        <tr>
                                            <th  class="text-center">Vch#</th>
                                            <th  class="text-center">Supplier#</th>
                                            <th  class="text-center">Name</th>
                                            <th  class="text-center">Amount</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach($supplier_vouchers as $cs)

                                    <tr>
                                            <td class="text-center">sv#{{$cs->id}}</td>
                                            <td class="text-center">sp#{{$cs->supplier_id}}</td>
                                            <td class="text-center">{{$cs->supplier->name}}</td>
                                            <td class="text-center">{{$cs->amount}}</td>
                                            <td hidden >{{$total_supplier_voucher += $cs->amount}}</td>
                                        </tr>

                                    @endforeach
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center font-bold"><b>{{$total_supplier_voucher}}</b></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

            </div>
        </div>
                <p class="mb-0">Developed by: http://itechdoor.com Contacts: +92 300 6472235, +92 324 6289768</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
