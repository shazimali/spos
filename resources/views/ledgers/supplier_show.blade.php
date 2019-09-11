<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Invoice Print</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>--}}

</head>
<body>


<div id="pdf" >
    <div class="container">
        <br>
        <div class="card">
            <div class="card-body ">
                    <h1 class="text-center">Supplier Account Statement</h1>
                    <h4 class="text-center">{{$from_date ? 'From Date:'. $from_date : ''}} {{$to_date ? ' / To Date:'. $to_date : ''}}  </h4>
            </div>
        </div>
        <br>
        <div class="card">

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="mb-3">By:</h6>
                        <div>
                            <strong>I TECH DOOR</strong>
                        </div>
                        {{-- <div>Shop# 127</div>
                        <div>Muslim road, Gujranwala</div>
                        <div>Mob: +92 305 4949600</div>
                        <div>Phone: +92 55 4222144</div> --}}
                        <div>http://itechdoor.com</div>
                        <div>Gujranwala, PAK</div>
                        <div>Mob: +92 300 6472235</div>
                        <div>Mod: +92 324 6280768</div>
                    </div>

                    <div class="col-sm-6">
                        <h6 class="mb-3">Customer Info:</h6>
                        <div>
                            <strong>{{$customer->name}}</strong>
                        </div>
                    <div>Supplier ID:sp#{{$customer->id}}</div>
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

                            $prev_balance = 0;

                        @endphp
                    @foreach($results as $item)
                    @php


                    $debit=array_key_exists('total_price',$item) ? (float)($item['total_price']):0;
                    $credit=array_key_exists('pay',$item) ? (float)($item['pay']) : 0  + (array_key_exists('amount',$item) ? (float)($item['amount']) : 0);
                    $balance=$credit-$debit;
                    if(array_key_exists('amount',$item))
                    {
                        $debit= $prev_balance;
                     }


                     if(array_key_exists('invoice_type_id',$item)==2){
                        $balance=$credit-$debit;
                        $credit=$debit;
                        $debit= $prev_balance;
                        $prev_balance-=$balance;

                     }else{

                        $prev_balance+=$balance;

                     }

                    @endphp



                            <tr>

                            <td>{{$item['date']}}</td>
                                <td>Sale Invoice: #{{$item['id']}}</td>
                                <td>{{ (array_key_exists('invoice_type_id',$item)? $item['invoice_type_id']:0 ) ==1 ? 'Purchase Invoice' :''  }} {{ (array_key_exists('invoice_type_id',$item)?$item['invoice_type_id']:0)==2 ? 'Return Invoice' :''  }} {{ array_key_exists('amount',$item) ? 'Voucher' :''  }} : #{{$item['id']}}</td>
                                <td>{{$credit}}</td>
                                <td>{{$debit}}</td>
                                <td>{{$prev_balance}}</td>
                            </tr>


                    @endforeach
                        <tfoot>
                            <th colspan="5"></th>

                        <th>{{$customer->balance}}</th>
                        </tfoot>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
                <p class="mb-0">Developed by: http://itechdoor.com Contacts: +92 300 6472235, +92 324 6289768</p>
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
