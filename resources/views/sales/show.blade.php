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

@php  $tax_id = $invoice->saleDetails->first()->taxes->pluck('id'); @endphp
<div id="pdf" >
    <div class="container">
        <br>
        <div class="card">
            <div class="card-body ">
            <h1 class="text-center">{{$invoice->invoice_type_id == 1 ? 'BILL #' : 'RETURN BILL #'}}  {{$invoice->invoice_type_id == 1?$invoice_id:$invoice->id}} / Date: {{$invoice->date}} / {{ $invoice->payment_type_id == 1? 'CASH':'CREDIT'}}</h1>
            </div>
        </div>
        <br>
        <div class="card">

            <div class="card-body">
            <div class="row mb-4">
            <div class="col-sm-6">
                    <h6 class="mb-3">To:</h6>
                        <div>
                            <strong>{{$invoice->customer->name}}</strong>
                        </div>
                        @if($invoice->customer->company_name != "")
                        <div>Company: {{$invoice->customer->company_name}}</div>
                        @endif
                        @if($invoice->customer->address1 != "")
                        <div>Address: {{$invoice->customer->address1}}</div>
                        @endif
                        @if($invoice->customer->address2 != "")
                        <div>Address2: {{$invoice->customer->address2}}</div>
                        @endif
                        @if($invoice->customer->city != "")
                        <div>City: {{$invoice->customer->city}}</div>
                        @endif
                        @if($invoice->customer->phone1 != "")
                        <div>Phone: +92 {{$invoice->customer->phone1}}</div>
                        @endif
                        @if($invoice->customer->phone2 != "")
                        <div>Phone2: +92 {{$invoice->customer->phone2}}</div>
                        @endif
                        @if($invoice->customer->nic != "" && count($tax_id))
                        <div>CNIC: +92 {{$invoice->customer->nic}}</div>
                        @endif
                        @if($invoice->customer->passport_no != "" && count($tax_id))
                        <div>GST: {{$invoice->customer->passport_no}}</div>
                        @endif
                        @if($invoice->customer->email != "" && count($tax_id))
                        <div>NTN: {{$invoice->customer->email}}</div>
                        @endif
                        @if($invoice->remarks != "")
                        <div>Remarks: {{$invoice->remarks}}</div>
                        @endif
                </div>
                @if(count($tax_id))
                    @include('_layout.information')
                @endif
            </div>
               
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="center">#</th>
                            <th>Code</th>
                            <th>Product Title</th>
                            <th class="right">Unit Price</th>
                            <th class="center">Qty</th>

                            @if($invoice->saleDetails->sum('net_percentage_discount') > 0)
                            <th class="center">Disc%</th>
                            <th class="center">Disc Amount</th>
                            @endif
                            @if($invoice->saleDetails->sum('net_discount') > 0)
                            <th class="center">Disc</th>
                            @endif
                            @foreach($taxes as $tax)
                            @if(in_array($tax->id,$tax_id->toArray()))
                            <th class="center">{{$tax->title.'('.$tax->value.'%)'}}</th>
                            @endif
                            @endforeach
                            <th class="right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $no=1; $net_total= 0; $total_ext_tax=0; $total_gst_tax=0; $total_tax=0; $total_net_pr_dics_am= 0;$total_net_disc=0; $total_net_pr_dics = 0; @endphp
                       @foreach($invoice->saleDetails as $item)
                        @php $current_tax =0; $total_net_pr_dics +=$item->net_percentage_discount;  $disc = $item->total_price * $item->total_qty/100 * $item->net_percentage_discount; $total_net_pr_dics_am += $disc; $total_net_disc += $item->net_discount; @endphp   
                        <tr>
                            <td class="center">{{$no++}}</td>
                            <td class="left strong">{{$item->productHead->code}}</td>
                            <td class="left">{{$item->productHead->title}}</td>

                            <td class="right">{{$item->total_price}}</td>
                            <td class="center">{{$item->total_qty}}</td>
                            @if($invoice->saleDetails->sum('net_percentage_discount') > 0)
                            <td class="center">{{$item->net_percentage_discount}}%</td>
                            <td class="center">{{$disc}}</td>
                            @endif
                            @if($invoice->saleDetails->sum('net_discount') > 0)
                            <td class="center">{{$item->net_discount}}</td>
                            @endif
                            @if($item->taxes->count() > 0)
                            @php $show_first_tax=0; $showTotalTax = 0;@endphp
                            @foreach($item->taxes as $tax)
                            @php 
                            if($loop->first){
                                $show_first_tax = $item->total_price*$item->total_qty/100*$tax->value;
                                $showTotalTax = $show_first_tax;
                                $current_tax +=$item->total_price*$item->total_qty/100*$tax->value;
                                $total_gst_tax +=$item->total_price*$item->total_qty/100*$tax->value;
                            }
                            if(!$loop->first){
                            $showTotalTax =  ($tax->value/100) * ($item->total_price*$item->total_qty + $show_first_tax);
                            $total_ext_tax +=$showTotalTax;
                            $current_tax += ($tax->value/100) * ($item->total_price*$item->total_qty + $show_first_tax);
                            }
                            @endphp
                            <td class="center"> {{ number_format($showTotalTax,2,'.','') }}</td>
                            @endforeach
                            @endif
                            @php 
                            $net_total += $item->total_price * $item->total_qty -$item->net_discount - $disc + $current_tax;
                            @endphp
                            <td class="right">{{number_format($item->total_price * $item->total_qty -$item->net_discount - $disc + $current_tax, 2, '.', '')}}</td>
                        </tr>
                       @endforeach
                       <tfoot>
                       <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td> <strong>{{$invoice->total_qty}}</strong></td>
                            @if($invoice->saleDetails->sum('net_percentage_discount') > 0)
                            <!-- <td><strong>{{$total_net_pr_dics}}%</strong></td> -->
                            <td></td>
                            <td><strong>{{number_format($total_net_pr_dics_am, 2, '.', '')}}</strong></td>
                            @endif
                            @if($invoice->saleDetails->sum('net_discount') > 0)
                            <td> <strong>{{$total_net_disc}}</strong> </td>
                            @endif
                            @if(count($tax_id))
                            <td><strong>{{number_format($total_gst_tax, 2, '.', '')}}</strong></td>
                            <td><strong>{{number_format($total_ext_tax, 2, '.', '')}}</strong></td>
                            @endif
                            <td><strong>{{number_format($net_total, 2, '.', '')}}</strong></td>
                       </tr>
                       </tfoot>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5">

                    </div>

                    <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                            {{--<tr>--}}
                                {{--<td class="left">--}}
                                    {{--<strong>Subtotal</strong>--}}
                                {{--</td>--}}
                                {{--<td class="right">$8.497,00</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<td class="left">--}}
                                    {{--<strong>Discount (20%)</strong>--}}
                                {{--</td>--}}
                                {{--<td class="right">$1,699,40</td>--}}
                            {{--</tr>--}}

                            @if($invoice->discount > 0)
                            <tr>
                                <td class="left">
                                    <strong>Discount</strong>
                                </td>
                                <td class="right">
                                    <strong>{{$invoice->discount}}</strong>
                                </td>
                            </tr>
                            @endif
                            @if($invoice->discount > 0)
                            <tr>
                                <td class="left">
                                    <strong>Discount%</strong>
                                </td>
                                <td class="right">
                                    <strong>{{$invoice->pr_dics}}%</strong>
                                </td>
                            </tr>
                            @endif
                            @if($invoice->net_total > 0)
                            <tr>
                                <td class="left">
                                    <strong>Net Total</strong>
                                </td>
                                <td class="right">
                                    <strong>{{number_format($invoice->net_total,2)}}</strong>
                                </td>
                            </tr>
                            @endif
                            @if($invoice->payment_type_id == 2 || $invoice->invoice_type_id == 2)
                            <tr>
                                <td class="left">

                                    <strong> {{$invoice->invoice_type_id == 1? 'Remaining': 'Previous'}} Balance</strong>
                                </td>
                                <td class="right">
                                @if($invoice->invoice_type_id == 2)
                                <strong>{{number_format($invoice->closing_balance + $invoice->total_price,2)}}</strong>
                                @endif
                                @if($invoice->invoice_type_id == 1)
                                <strong>{{number_format($invoice->closing_balance - $invoice->net_total,2)}}</strong>
                                @endif
                                </td>
                            </tr>
                            @endif
                            @if($invoice->closing_balance > 0)
                            <tr>
                                <td class="left">
                                    <strong>Balance</strong>
                                </td>
                                <td class="right">
                                    <strong>{{ number_format($invoice->closing_balance,2) }}</strong>
                                </td>
                            </tr>
                            @endif
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>
                <!-- <p class="mb-0">Developed by SHAZIM, Contacts +92 300 6472235</p> -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script>

    // $(window).on('load',function () {
    //     window.print()
    //     // var doc = new jsPDF("p", "pt", "a4");
    //     //
    //     //
    //     // var data = doc.fromHTML($('#pdf').get(0), 10, 10, );
    //     //
    //     // function debugBase64(base64URL){
    //     //     var win = window.open();
    //     //     win.document.write('<iframe src="' + base64URL  + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>');
    //     // }
    //     //
    //     // debugBase64(doc.output('datauri'))
    //     window.close()
    // })

</script>
</body>
</html>
