@extends('_layout.master')

@section('title', 'Supplier Voucher')
@section('css')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <link href="{{asset('plugins/bower_components/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
@stop

@section('content')
<div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title ">Supplier Voucher List &nbsp; &nbsp; <a class="btn btn-success"  data-toggle="modal" data-target="#responsive-modal"><i class="fa fa-plus"></i></a> </h3>
                <hr>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Voucher#</th>
                                <th>Supplier ID</th>
                                <th>Supplier Name</th>
                                <th>Amount</th>
                                <th>created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vouchers as $vc)
                            <tr>
                            <td>SR#{{$vc->id}}</td>
                            <td>SP#{{$vc->supplier_id}}</td>
                            <td>{{$vc->supplier->name}}</td>
                            <td>{{$vc->amount}}</td>
                            <td>{{$vc->date}}</td>
                            <td>
                            <button class="btn btn-primary " onclick="$('input').parent().removeClass('has-success')" data-toggle="modal" data-target="#responsive-modal-{{$vc->id}}" ><span class="glyphicon glyphicon-edit"></span> </button>
                            @include('supplier-voucher.edit')
                            </td>
                            </tr >
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('supplier-voucher.create')
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
                    url: '{{url('customers')}}/'+id,
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

    function getSupplierBalance(id){

        if(id){

            var url = "{{url('/supplier-balance')}}/"+id;

            $.get(url,function(data){

                if(data){

                    $("#supplier_name").after('<span class="supplier_balance text-bold">Balance:'+ data +'</span>');
                    $("#balance").val(data);
                }

            })
        }

        $(".supplier_balance").hide();

    }

    function getSupplierBalanceForUpdate(id){

        if(id){

            var url = "{{url('/supplier-balance')}}/"+id;

            $.get(url,function(data){

                if(data){

                    $(".edit_supplier_name").after('<span class="edit_supplier_balance">Balance:'+ data +'</span>');
                    $("#edit_balance").val(data);
                }

            })
        }

        $(".edit_supplier_balance").hide();

    }

    function createSupplierVoucher(){

        $('.has-error').removeClass('has-error');
        $('.has-success').removeClass('has-success');
        $('.help-block').remove();
        $('.form-control-feedback').remove();



        $.ajax({
            type:'POST',
            url: '{{url("/supplier-voucher/store")}}',
            data:$('#create-supplier-voucher').serialize(),
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

                        $('#'+key).parent().addClass('has-error has-feedback');
                        $('#'+key).after(' <span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                        $('#'+key).after('<div class="help-block with-errors">'+ value[0] +'</div>');
                    } );

                }

            }

        });

    }
    function updateSupplierVoucher(id){

        $('.has-error').removeClass('has-error');
        $('.has-success').removeClass('has-success');
        $('.help-block').remove();
        $('.form-control-feedback').remove();



        $.ajax({
            type:'PUT',
            url: '{{url("supplier-voucher/update")}}/'+id,
            data:$('#edit-supplier-voucher-'+id).serialize(),
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

                    // location.reload();

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

    $(function(){
  var d = new Date(),
      h = d.getHours(),
      m = d.getMinutes(),
      s= d.getSeconds();
  if(h < 10) h = '0' + h;
  if(m < 10) m = '0' + m;
  if(s < 10) s = '0' + s;
  $('input[type="time"][value="now"]').each(function(){
    $(this).attr({'value': h + ':' + m + ':' + s});
  });

});

</script>

    @stop
