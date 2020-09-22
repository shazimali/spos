@extends('_layout.master')
@section('title', 'Dashboard')
@section('css')
    <!-- morris CSS -->
    <link href="{{asset('plugins/bower_components/morrisjs/morris.css')}}" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="{{asset('plugins/bower_components/chartist-js/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet">
    <!-- Calendar CSS -->
    <link href="{{asset('plugins/bower_components/calendar/dist/fullcalendar.css')}}" rel="stylesheet" />
    <!-- animation CSS -->
@stop

@section('content')

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">New Customers</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div id="sparklinedash"></div>
                    </li>
                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success">{{$new_customers}}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Today Sale</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div id="sparklinedash2"></div>
                    </li>
                <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple">{{$today_sale}}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Today Purchase</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div id="sparklinedash3"></div>
                    </li>
                <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info">{{$today_purchase}}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">New Suppliers</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div id="sparklinedash4"></div>
                    </li>
                <li class="text-right"><i class="ti-arrow-up text-danger"></i> <span class="text-danger">{{$new_suppliers}}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Total Debit</h3>
                <ul class="list-inline two-part">
                <li class="text-right"><span class="counter text-success">{{ number_format($debit,2) }}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">Total Credit</h3>
                <ul class="list-inline two-part">
                <li class="text-right"><span class="text-danger">{{ number_format($credit,2) }}</span></li>
                </ul>
            </div>
        </div>
    </div>
    <!--/.row -->
    <!--row -->
    <!-- /.row -->
    <div class="row">
        @if(count($recent_sales))
        <div class="col-md-6 col-lg-6 col-sm-6">
            <div class="white-box">
                <h3 class="box-title text">Recent Sales</h3>
                <div class="row sales-report">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <h2>{{ \Carbon\Carbon::parse($recent_sales->first()->created_at)->format('M Y') ? \Carbon\Carbon::parse($recent_sales->first()->created_at)->format('M Y'): ''}}</h2>
                        <p>SALE REPORT</p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 ">
                    <h1 class="text-right text-info m-t-20">{{floatval ($recent_sales->where('invoice_type_id',1)->sum('net_total'))-floatval ($recent_sales->where('invoice_type_id',2)->sum('total_price'))}}</h1>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>NAME</th>
                            <th>STATUS</th>
                            <th>DATE</th>
                            <th>PRICE</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_sales as $rs)
                        <tr>
                        <td>{{$sr++}}</td>
                        <td class="txt-oflo">{{$rs->customer->name}}</td>
                        <td><span class="{{$rs->invoice_type_id == 1?'label label-success label-rouded':'label label-danger label-rouded'}}">{{$rs->invoice_type_id == 1?'SALE':'RETURN'}}</span> </td>
                        <td class="txt-oflo">{{ \Carbon\Carbon::parse($rs->date)->toFormattedDateString()}}</td>
                        <td><span class="{{$rs->invoice_type_id == 1?'text-success':'text-danger'}}">{{$rs->invoice_type_id == 1?$rs->net_total:$rs->total_price}}</span></td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        @if(count($recent_purchases))
        <div class="col-md-6 col-lg-6 col-sm-6">
                <div class="white-box">
                    <h3 class="box-title text">Recent Purchases</h3>
                    <div class="row sales-report">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h2>{{ \Carbon\Carbon::parse($recent_purchases->first()->created_at)->format('M Y') ? \Carbon\Carbon::parse($recent_purchases->first()->created_at)->format('M Y'): ''}}</h2>
                            <p>PURCHASE REPORT</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                        <h1 class="text-right text-info m-t-20">{{floatval ($recent_purchases->where('invoice_type_id',1)->sum('total_price'))-floatval ($recent_purchases->where('invoice_type_id',2)->sum('total_price'))}}</h1>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>NAME</th>
                                <th>STATUS</th>
                                <th>DATE</th>
                                <th>PRICE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($recent_purchases))
                                @foreach($recent_purchases as $rs)
                            <tr>
                            <td>{{$sr++}}</td>
                            <td class="txt-oflo">{{$rs->supplier->name}}</td>
                            <td><span class="{{$rs->invoice_type_id == 1?'label label-success label-rouded':'label label-danger label-rouded'}}">{{$rs->invoice_type_id == 1?'PURCHASE':'RETURN'}}</span> </td>
                            <td class="txt-oflo">{{ \Carbon\Carbon::parse($rs->date)->toFormattedDateString()}}</td>
                            <td><span class="{{$rs->invoice_type_id == 1?'text-success':'text-danger'}}">{{$rs->total_price}}</span></td>
                            </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
    </div>
    @stop
@section('js')

    <!--Wave Effects -->
    <script src="{{asset('js/waves.js')}}"></script>
    <!-- chartist chart -->
    <script src="{{asset('plugins/bower_components/chartist-js/dist/chartist.min.js')}}"></script>
    <script src="{{asset('plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js')}}"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="{{asset('plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js')}}"></script>

    <script src="{{asset('js/dashboard1.js')}}"></script>
    <script src="{{asset('plugins/bower_components/toast-master/js/jquery.toast.js')}}"></script>
    <!--Style Switcher -->
    <script src="{{asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js')}}"></script>


@stop
