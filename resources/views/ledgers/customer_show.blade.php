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
                    <h1 class="text-center"> Account Statement</h1>
                    <h4 class="text-center">{{$from_date ? 'From Date:'. $from_date : ''}} {{$to_date ? ' / To Date:'. $to_date : ''}}  </h4>
            </div>
        </div>
        <br>
        <div class="card">

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <h6 class="mb-3">Customer Info:</h6>
                        <div>
                            <strong>{{$customer->name}}</strong>
                        </div>
                    <div>Customer ID:cs#{{$customer->id}}</div>
                    @if($customer->company_name != "")
                    <div>Compnay: {{$customer->company_name}}</div>
                    @endif
                    @if($customer->address1 != "")
                    <div>Address: {{$customer->address1}}</div>
                    @endif
                    @if($customer->address2 != "")
                    <div>Address2: {{$customer->address2}}</div>
                    @endif
                    @if($customer->city != "")
                    <div>City: {{$customer->city}}</div>
                    @endif
                    @if($customer->email != "")
                    <div>Email: {{$customer->email}}</div>
                    @endif
                    @if($customer->phone1 != "")
                    <div>Phone: +92 {{$customer->phone1}}</div>
                    @endif
                    @if($customer->phone2 != "")
                    <div>Phone2: +92 {{$customer->phone2}}</div>
                    @endif
                    </div>



                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="center">Date</th>
                            <th class="center">VchNo</th>
                            <th class="center">Description</th>

                            <th class="center">Debit</th>
                            <th class="center">Credit</th>
                            <th class="center">Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php

                            $prev_balance = $balance;
                            $voucher_count = 0;
                            $voucher_num = 0;
                            $sale_count = 0;
                            $sale_num = 0;

                        @endphp
                    @foreach($results as $item)
                    @php
                    $debit= isset($item['net_total']) && $item['net_total'] ? (float)($item['net_total']):0  ;
                        if(isset($item['pay'])){
                                $credit=$item['pay'] ? (float)($item['pay']):0;
                        }
                        if(isset($item['amount'])){
                            $credit=(float)($item['amount']);
                        }
                       
                                $voucher_num = $item['id'];
                                $current_balance=$debit-$credit;
                                if(isset($item['amount']) && $item['amount']){
                                    $debit= $prev_balance;
                                    $voucher_count++;
                                    $voucher_num = $voucher_count;
                                    $prev_balance -= $item['amount'];
                                    
                                 }
                                 if(isset($item['invoice_type_id']) && $item['invoice_type_id']==2){
                                    $debit=(float)($item['total_price']);
                                    $current_balance=$debit-$credit;
                                    $credit=$debit;
                                    $debit=$prev_balance;
                                    $prev_balance-=$current_balance;

                                 }
                                 if(isset($item['invoice_type_id']) && $item['invoice_type_id']==1){
                                    
                                    $prev_balance+=$current_balance;
                                    $sale_num = $item['customer_id'].'-'.$sale_count;
                                    $sale_count++;

                                 }
                        
                    @endphp

                    <tr>
                        <td>{{$item['date']}}</td>
                        <td> {{ isset($item['invoice_type_id']) && $item['invoice_type_id']==1 ? $sale_num  :''  }} {{ isset($item['invoice_type_id']) && $item['invoice_type_id']==2 ? $item['id'] :''  }} {{ isset($item['amount']) && $item['amount']  ? $voucher_count  :''  }}</td>  
                        <td> {{  isset($item['invoice_type_id']) && $item['invoice_type_id']==1 ? 'Sale Invoice#'. $sale_num  :''  }} {{ isset($item['invoice_type_id']) && $item['invoice_type_id']==2 ? 'Return Invoice#'.$item['id'] :''  }} {{ isset($item['amount']) && $item['amount'] ? 'Voucher#'.$voucher_count  :''  }}</td>
                        <td>{{ number_format($credit,2)}}</td>
                        <td>{{number_format($debit,2)}}</td>
                        <td>{{number_format($prev_balance,2) }}</td>
                    </tr>

                            <!-- <tr>

                            <td>{{$item['date']}}</td>
                                <td>Sale Invoice: #{{$item['id']}}</td>
                                <td>{{ (array_key_exists('invoice_type_id',$item)? $item['invoice_type_id']:0 ) ==1 ? 'Sale Invoice' :''  }} {{ (array_key_exists('invoice_type_id',$item)?$item['invoice_type_id']:0)==2 ? 'Return Invoice' :''  }} {{ array_key_exists('amount',$item) ? 'Voucher' :''  }} : #{{$item['id']}}</td>
                                <td>{{ number_format($credit,2)}}</td>
                                <td>{{number_format($debit,2)}}</td>
                                <td>{{number_format($prev_balance,2) }}</td>
                            </tr> -->


                    @endforeach
                        <tfoot>
                            <th colspan="5"></th>

                        <th>{{number_format($prev_balance,2)}}</th>
                        </tfoot>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
