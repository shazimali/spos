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
            <h1 class="text-center"> {{$product?$product->code.'-'.$product->title.' Product':'All Products'}} Ledger</h1>
                    <h4 class="text-center">{{$from_date ? 'From Date:'. $from_date : ''}} {{$to_date ? ' / To Date:'. $to_date : ''}}  </h4>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-body">
                @if($type == 1 || $type == 2)
            <h1>{{$type == 1?"Sale Products":''}}{{$type == 2?"Purchase Products":''}}</h1>
                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th  class="center">Invoice#</th>
                            <th  class="center">Product Code</th>
                            <th  class="center">Product Title</th>
                            <th  class="center">Product Quantity</th>
                            <th  class="center">Created</th>
                            <th  class="center">Unit Price</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $r)
                                <tr>
                                    <td>{{$type == 1?'sl#'.$r->sale_id:''}} {{$type == 2?"pr#".$r->purchase_id:''}}</td>

                                    <td>
                                    {{$r->productHead->code }}
                                    </td>
                                    <td>{{ $r->productHead->title}}</td>
                                    <td>{{$r->total_qty}}</td>
                                    <td>{{$type == 1?$r->sale->date:''}} {{$type == 2?$r->purchase->date:''}}</td>
                                    <td>{{$r->total_price}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    @if($sales)
            <h1 class="text-center">Sale Products</h1>
                    <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th  class="center">Invoice#</th>
                                    <th  class="center">Product Code</th>
                                    <th  class="center">Product Title</th>
                                    <th  class="center">Product Quantity</th>
                                    <th  class="center">Created</th>
                                    <th  class="center">Unit Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $r)
                                        <tr>
                                            <td>{{'sl#'.$r->sale_id}} </td>

                                            <td>
                                            {{$r->productHead->code }}
                                            </td>
                                            <td>{{ $r->productHead->title}}</td>
                                            <td>{{$r->total_qty}}</td>
                                            <td>{{$r->sale->date}}</td>
                                            <td>{{$r->total_price}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if($purchases)
            <h1 class="text-center">Purchase Products</h1>
                    <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th  class="center">Invoice#</th>
                                    <th  class="center">Product Code</th>
                                    <th  class="center">Product Title</th>
                                    <th  class="center">Product Quantity</th>
                                    <th  class="center">Created</th>
                                    <th  class="center">Unit Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchases as $r)
                                        <tr>
                                            <td>{{'pr#'.$r->purchase_id}} </td>

                                            <td>
                                            {{$r->productHead->code }}
                                            </td>
                                            <td>{{ $r->productHead->title}}</td>
                                            <td>{{$r->total_qty}}</td>
                                            <td>{{$r->purchase->date}}</td>
                                            <td>{{$r->total_price}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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
