@extends('_layout.master')

@section('title', 'Creat Role')

@section('content')
<div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Role Manager</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="">Dashboard</a></li>
                <li class="active">Create Role</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Create Role</h3>
                    <br/>
                <form id="roleForm" class="form-horizontal" method="post" action="{{url('/role/store')}}">
                            @csrf
                        <div class="form-group">
                            <label class="col-md-12">Title</label>
                            <div class="col-md-12">
                                <input id="title" type="text" class="form-control" name="name"> </div>
                        </div>

                        <div id="permissionsBlock" class="form-group">
                                <label class="col-md-12">Permissions</label>
                                <div class="col-md-12">
                                @foreach($permissions as $pr)
                                            <span style="display:inline-block;" class="col-md-4 checkbox checkbox-success checkbox-circle">
                                            <input class="chk" name="{{$pr->id}}" type="checkbox">
                                            <label >{{$pr->display_name}}</label>
                                            </span>
                                @endforeach
                                </div>
                        </div>
                        <div class="form-group">
                            <input id="btn_create" type="submit" class="btn btn-primary pull-right" value="Create">
                        </div>
                    </form>
                </div>
            </div>
        </div>

@stop



@section('js')
<script>

    $("#btn_create").on('click',function(event){

        event.preventDefault();
        $(".title-error").remove()
        $(".permission-error").remove()
        if($("#title").val() == "")
            $("#title").after('<span class="title-error text-danger">Role title required.</span>');

        if($("input:checked").length < 1)
        $("#permissionsBlock").after('<span class="permission-error text-danger">At least one permission need to checked.</span>');

        if($("#title").val() != "" && $("input:checked").length >= 1)
        $("#roleForm").submit();

        });

</script>

    <script src="{{asset('plugins/bower_components/datatables/datatables.min.js')}}"></script>

    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('js/jszip.min.js')}}"></script>
    <script src="{{asset('js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/buttons.print.min.js')}}"></script>
       @stop
