<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>--}}

</head>
<body>


<div id="pdf" >
    <div class="container">
        <br>
        <div class="card">
            <div class="card-body ">
                <h1 class="text-center">{{$invoice->invoice_type_id == 1 ? 'PURCHASE INVOICE #' : 'RETURN PURCHASE INVOICE #'}} {{$invoice->id}}  /  Date:{{$invoice->date}} </h1>
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
                        <h6 class="mb-3">To:</h6>
                        <div>
                            <strong>{{$invoice->supplier->name}}</strong>
                        </div>
                        <div>Supplier ID:sp#{{$invoice->supplier->id}}</div>
                        @if($invoice->supplier->company_name != "")
                        <div>Compnay: {{$invoice->supplier->company_name}}</div>
                        @endif
                        @if($invoice->supplier->address1 != "")
                        <div>Address: {{$invoice->supplier->address1}}</div>
                        @endif
                        @if($invoice->supplier->address2 != "")
                        <div>Address2: {{$invoice->supplier->address2}}</div>
                        @endif
                        @if($invoice->supplier->city != "")
                        <div>City: {{$invoice->supplier->city}}</div>
                        @endif
                        @if($invoice->supplier->email != "")
                        <div>Email: {{$invoice->supplier->email}}</div>
                        @endif
                        @if($invoice->supplier->phone1 != "")
                        <div>Phone: +92 {{$invoice->supplier->phone1}}</div>
                        @endif
                        @if($invoice->supplier->phone2 != "")
                        <div>Phone2: +92 {{$invoice->supplier->phone2}}</div>
                        @endif
                        </div>
                    </div>
                    <div class="ml-1 row">
                        <h6 {{$invoice->remarks?'':"hidden"}}>Remarks:</h6><span>{{$invoice->remarks}}</span>
                    </div>


                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="center">#</th>
                            <th>Product Code</th>
                            <th>Product Title</th>

                            <th class="right">Unit Cost</th>
                            <th class="center">Qty</th>
                            <th class="right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($no=1)
                       @foreach($invoice->purchaseDetails as $item)
                        <tr>
                            <td class="center">{{$no++}}</td>
                            <td class="left strong">{{$item->productHead->code}}</td>
                            <td class="left">{{$item->productHead->title}}</td>

                            <td class="right">{{$item->total_price}}</td>
                            <td class="center">{{$item->total_qty}}</td>
                            <td class="right">{{$item->total_price * $item->total_qty}}</td>
                        </tr>
                       @endforeach
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

                            <tr>
                                <td class="left">
                                    <strong>Total Quantity</strong>
                                </td>
                                <td class="right">
                                    <strong>{{$invoice->total_qty}}</strong>
                                </td>
                            </tr>

                            <tr>
                                <td class="left">
                                    <strong>Total</strong>
                                </td>
                                <td class="right">
                                    <strong>{{$invoice->total_price}}</strong>
                                </td>
                            </tr>

                            @if($invoice->closing_balance > 0 )
                            <tr>
                                    <td class="left">
                                        <strong>Balance</strong>
                                    </td>
                                    <td class="right">
                                        <strong>{{$invoice->closing_balance}}</strong>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>

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
