@extends('_layout.master')

@section('title', 'User Record')
@section('css')

    <link href="{{asset('plugins/bower_components/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')

<div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">Users List &nbsp; &nbsp;

                    <a href="{{url('user/create')}}" class="btn btn-danger waves-effect waves-light"><i class="fa fa-plus"></i></a>

                </h3>
                <hr>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                @permission(['edit_user','delete_user'])
                                <th>Action</th>
                                @endpermission
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                            <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                            <td>{{$user->role->first()->name}}</td>
                            <td>{{$user->created_at->diffForHumans()}}</td>
                            @permission(['edit_user','delete_user'])
                            <td>
                            @permission(['edit_user'])
                            <a href="{{url('user/edit/'.$user->id)}}" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> </a>
                            @endpermission
                            @permission(['edit_user'])
                            <button class="btn btn-danger "  onclick="deleteConfirm({{$user->id}})" id="delete_confirm"><span class="glyphicon glyphicon-remove"></span> </button>
                            @endpermission
                        </td>
                            @endpermission
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

    <script>
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
            url: '{{url("user/delete")}}/'+id,
            headers:
            {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function (data) {
            Swal({
            position: 'center',
            type: 'success',
            title: 'User deleted successfully.',
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
    <script src="{{asset('plugins/bower_components/datatables/datatables.min.js')}}"></script>

    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('js/jszip.min.js')}}"></script>
    <script src="{{asset('js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/bower_components/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{asset('plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js')}}"></script>
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
                'new user', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('.buttons-new-user, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary m-r-10');
    </script>

    @stop
