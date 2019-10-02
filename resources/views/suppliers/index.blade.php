@extends('_layout.master')

@section('title', 'Suppliers Record')
@section('css')

    <link href="{{asset('plugins/bower_components/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">

@stop

@section('content')
    <div class="row">

    <div class="col-sm-12">
        <div class="white-box">
            <h3 class="box-title m-b-0">Suppliers Record &nbsp; &nbsp;
                <button onclick="$('input').parent().removeClass('has-success')" class="btn btn-primary " data-toggle="modal" data-target="#responsive-modal" ><i class="fa fa-plus"></i> </button></h3>
            <hr>
            <div class="table-responsive">
                <table id="example23" class="display nowrap table table-hover table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Supplier Name</th>
                        <!-- <th>Email</th> -->
                        <th>Contact</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Supplier Name</th>
                        <!-- <th>Email</th> -->
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @php($sn=1)
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{$sn++}}</td>
                            <td>{{$supplier->name}}</td>
                            <!-- <td>{{$supplier->email}}</td> -->
                            <td>
                                {!! $supplier->phone1 ? '<li>'. $supplier->phone1 .'</li>': '' !!}
                                {!! $supplier->phone2 ? '<li>'. $supplier->phone2 .'</li>': '' !!}
                            </td>
                            <td>
                                {{$supplier->balance}}
                            </td>
                            <td>
                                <button class="btn btn-primary " onclick="$('input').parent().removeClass('has-success')" data-toggle="modal" data-target="#responsive-modal-{{$supplier->id}}" ><span class="glyphicon glyphicon-edit"></span> </button>
                                {{--<button class="btn btn-danger "  onclick="deleteConfirm({{$supplier->id}})" id="delete_confirm"><span class="glyphicon glyphicon-remove"></span> </button>--}}
                            </td>
                            @include('suppliers.edit')

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@include('suppliers.create')
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

        function deleteConfirm(id){
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {

                    $.ajax({
                        type:'DELETE',
                        url: '{{url('suppliers')}}/'+id,
                        headers:
                            {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        dataType: 'json',
                        success: function (data) {
                            Swal({
                                position: 'center',
                                type: 'success',
                                title: 'Your work has been saved',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(()=>{
                            location.reload();

                            },1500);

                        },
                        error: function (error) {
                            Swal({
                                position: 'center',
                                type: 'warning',
                                title: 'Network Error',
                                showConfirmButton: true,
                            });
                        }

                    });
                }
            });
        };



    </script>
    <script src="{{asset('plugins/bower_components/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>

    <script>

        function createSupplier(){


            $('.has-error').removeClass('has-error');
            $('.has-success').removeClass('has-success');
            $('.help-block').remove();
            $('.form-control-feedback').remove();
            $('input').parent().addClass('has-success');

            $.ajax({
                type:'POST',
                url: '{{url('suppliers')}}',
                data:$('#create-supplier').serialize(),
                dataType: 'json',
                success: function (data) {


                    Swal({
                        position: 'center',
                        type: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(()=>{

                        location.reload();

                    },1500);

                },
                error: function (error) {
                    Swal({
                        position: 'center',
                        type: 'warning',
                        title: 'Please Check Form Errors !',
                        showConfirmButton: true,
                    });
                    if (error.responseJSON) {

                        let errors = error.responseJSON.errors;
                        $.each(errors, function (key,value) {

                            $('#'+key).parent().removeClass('has-success ');
                            $('#'+key).parent().addClass('has-error has-feedback');
                            $('#'+key).after(' <span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                            $('#'+key).after('<div class="help-block with-errors">'+ value[0] +'</div>');
                        } );

                    }

                }

            });

        }
        function updateSupplier(id){


            $('.has-error').removeClass('has-error');
            $('.has-success').removeClass('has-success');
            $('.help-block').remove();
            $('.form-control-feedback').remove();
            $('input').parent().addClass('has-success');



            $.ajax({
                type:'PUT',
                url: '{{url('suppliers')}}/'+id+'/edit',
                data:$('#edit-supplier-'+id).serialize(),
                dataType: 'json',
                success: function (data) {

                    Swal({
                        position: 'center',
                        type: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    setTimeout(()=>{

                        location.reload();

                    },1500);

                },
                error: function (error) {
                    Swal({
                        position: 'center',
                        type: 'warning',
                        title: 'Please Check Form Errors !',
                        showConfirmButton: true,
                    });
                    if (error.responseJSON) {

                        let errors = error.responseJSON.errors;
                        $.each(errors, function (key,value) {
                                 key=key+'-'+id;
                            $('#'+key).parent().removeClass('has-success');
                            $('#'+key).parent().addClass('has-error has-feedback');
                            $('#'+key).after(' <span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                            $('#'+key).after('<div class="help-block with-errors">'+ value[0] +'</div>');
                        } );

                    }

                }

            });

        }

    </script>
    @stop