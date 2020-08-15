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
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="white-box">
                <h3 class="box-title">Yearly Sales</h3>
                <div id="ct-visits" style="height: 405px;"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12">
            <div class="panel">
                <div class="p-20">
                    <div class="row">
                        <div class="col-xs-8">
                            <h4 class="m-b-0">{{ \Carbon\Carbon::now()->format('M')}} Earnings</h4>
                        <h2 class="m-t-0 font-medium">{{$current_month_sales->sum('net_total')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="panel-footer bg-extralight">
                    <ul class="earning-box">
                        {{-- @foreach($current_month_sales->sortBy('customer_id',) as $key => $cs) --}}
                        <li>
                            <div class="er-row">
                                <div class="er-text">
                                    <h3>Andrew Simon</h3><span class="text-muted">10-11-2016</span></div>
                                <div class="er-count ">$<span class="counter">46</span></div>
                            </div>
                        </li>
                        <li>
                            <div class="er-row">
                                <div class="er-pic"><img src="../plugins/images/users/govinda.jpg" alt="varun" width="60" class="img-circle"></div>
                                <div class="er-text">
                                    <h3>Daniel Kristeen</h3><span class="text-muted">10-11-2016</span></div>
                                <div class="er-count ">$<span class="counter">55</span></div>
                            </div>
                        </li>
                        <li>
                            <div class="er-row">
                                <div class="er-pic"><img src="../plugins/images/users/pawandeep.jpg" alt="varun" width="60" class="img-circle"></div>
                                <div class="er-text">
                                    <h3>Chris gyle</h3><span class="text-muted">10-11-2016</span></div>
                                <div class="er-count ">$<span class="counter">66</span></div>
                            </div>
                        </li>
                        <li class="center">
                            <a class="btn btn-rounded btn-info btn-block p-10">Withdrow money</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="panel">
                <div class="p-20">
                    <div class="row">
                        <div class="col-xs-6">
                            <h5 class="m-b-0">This months task</h5>
                            <h3 class="m-t-0 font-medium">TO-DO LIST</h3>
                        </div>
                        <div class="col-xs-6">
                            <a href="javascript:void(0)" class="pull-right btn btn-rounded btn-success m-t-15" data-toggle="modal" data-target="#myModal">Add Task</a>
                        </div>
                    </div>
                </div>
                <!-- .modal for add task -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Add Task</h4>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Your Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <div class="panel-footer">
                    <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                        <li class="list-group-item" data-role="task">
                            <div class="checkbox checkbox-info">
                                <input type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule">
                                <label for="inputSchedule"> <span>Schedule meeting with</span> </label>
                            </div>
                            <ul class="assignedto">
                                <li><img src="../plugins/images/users/1.jpg" alt="user img" data-toggle="tooltip" data-placement="top" title="Steave" /></li>
                                <li><img src="../plugins/images/users/2.jpg" alt="user img" data-toggle="tooltip" data-placement="top" title="Jessica" /></li>
                                <li><img src="../plugins/images/users/3.jpg" alt="user img" data-toggle="tooltip" data-placement="top" title="Priyanka" /></li>
                                <li><img src="../plugins/images/users/4.jpg" alt="user img" data-toggle="tooltip" data-placement="top" title="Selina" /></li>
                            </ul>
                        </li>
                        <li class="list-group-item" data-role="task">
                            <div class="checkbox checkbox-info">
                                <input type="checkbox" id="inputCall" name="inputCheckboxesCall">
                                <label for="inputCall"> <span>Give Purchase report to</span> <span class="label label-danger label-rounded">Today</span> </label>
                            </div>
                            <ul class="assignedto">
                                <li><img src="../plugins/images/users/3.jpg" alt="user ing" data-toggle="tooltip" data-placement="top" title="Priyanka" /></li>
                                <li><img src="../plugins/images/users/4.jpg" alt="user img" data-toggle="tooltip" data-placement="top" title="Selina" /></li>
                            </ul>
                        </li>
                        <li class="list-group-item" data-role="task">
                            <div class="checkbox checkbox-info">
                                <input type="checkbox" id="inputBook" name="inputCheckboxesBook">
                                <label for="inputBook"> <span>Book flight for holiday</span> </label>
                            </div>
                            <div class="item-date"> 26 jun 2017</div>
                        </li>
                        <li class="list-group-item" data-role="task">
                            <div class="checkbox checkbox-info">
                                <input type="checkbox" id="inputForward" name="inputCheckboxesForward">
                                <label for="inputForward"> <span>Forward all tasks</span> <span class="label label-warning label-rounded">2 weeks</span> </label>
                            </div>
                            <div class="item-date"> 26 jun 2017</div>
                        </li>
                        <li class="list-group-item" data-role="task">
                            <div class="checkbox checkbox-info">
                                <input type="checkbox" id="inputRecieve" name="inputCheckboxesRecieve">
                                <label for="inputRecieve"> <span>Recieve shipment</span> </label>
                            </div>
                            <div class="item-date"> 26 jun 2017</div>
                        </li>
                        <li class="list-group-item" data-role="task">
                            <div class="checkbox checkbox-info">
                                <input type="checkbox" id="inputForward2" name="inputCheckboxesd">
                                <label for="inputForward2"> <span>Important tasks</span> <span class="label label-success label-rounded">2 weeks</span> </label>
                            </div>
                            <ul class="assignedto">
                                <li><img src="../plugins/images/users/1.jpg" alt="user img" data-toggle="tooltip" data-placement="top" title="Assign to Steave" /></li>
                                <li><img src="../plugins/images/users/2.jpg" alt="user img" data-toggle="tooltip" data-placement="top" title="Assign to Jessica" /></li>
                                <li><img src="../plugins/images/users/4.jpg" alt="user img" data-toggle="tooltip" data-placement="top" title="Assign to Selina" /></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Recent comment, table & feed widgets -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- calendar widgets -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- chats, message & profile widgets -->
    <!-- ============================================================== -->


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
