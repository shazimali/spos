@extends('_layout.master')

@section('title', 'Stock Record')
@section('css')

    <link href="{{asset('plugins/bower_components/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">

@stop

@section('content')
    <div class="row">

    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Stock Record
            </h3>
                {{-- <div class="row">
                    <form role="form" class="form-horizontal" action="{{url()->current()}}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="r_qty">Remaining Stock</label>
                            <div class="col-sm-4">
                                <input type="number" id="r_qty" name="r_qty" class="form-control input-sm" placeholder="Remaining Stock">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                </div> --}}
            <hr>

            <div class="table-responsive">
                <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Products</th>
                        <th>Total In</th>
                        <th>Total Out</th>
                        <th>Remaining</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($stocks as $st)
                        <tr>
                            @php
                            $pr_qty = 0;
                            $sl_qty = 0;
                            @endphp
                            <td hidden>@foreach($st->allPurchases as $pr){{ $pr_qty += $pr->total_qty}}@endforeach</td>
                            <td hidden>@foreach($st->allSales as $sl){{$sl_qty += $sl->total_qty}}@endforeach</td>
                        <td>{{$st->code.'-'.$st->title}}</td>
                        <td>{{$pr_qty}}</td>
                        <td>{{$sl_qty}}</td>
                        <td>{{$pr_qty - $sl_qty}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    </div>

@stop



@section('js')


    <script src="{{asset('plugins/bower_components/datatables/datatables.min.js')}}"></script>

    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('js/jszip.min.js')}}"></script>
    <script src="{{asset('js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>
    <script>
        $(function() {
            $('#myTable').DataTable();
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;
                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                    }
                });
                // Order by the grouping
                $('#example tbody').on('click', 'tr.group', function() {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                        table.order([2, 'desc']).draw();
                    } else {
                        table.order([2, 'asc']).draw();
                    }
                });
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary m-r-10');




    </script>
    <script src="{{asset('plugins/bower_components/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>

    @stop
