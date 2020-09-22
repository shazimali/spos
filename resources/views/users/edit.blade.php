@extends('_layout.master')

@section('title', 'Edit User')

@section('content')

    <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Edit User</h3>
                    <br/>
                <form class="form-horizontal" method="post" action="{{url('/user/update/'.$user->id)}}">
                            @csrf
                        <div class="form-group">
                            <label class="col-md-12">Name</label>
                            <div class="col-md-12">
                            <input type="text" value="{{$user->name}}" class="form-control" name="name">
                                @if($errors->has('name'))<span class="text-danger">{{$errors->first('name')}}</span>@endif
                            </div>

                        </div>
                        <div class="form-group">
                                <label class="col-md-12">Email</label>
                                <div class="col-md-12">
                                    <input readonly type="text" value="{{$user->email}}" class="form-control" >
                            @if($errors->has('email'))<span class="text-danger">{{$errors->first('email')}}</span>@endif

                                </div>

                        </div>
                        <div class="form-group">
                                <label class="col-md-12">Role</label>
                                <div class="col-md-12">
                                    <select name="role" class="form-control">
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                    <option @if($user->hasRole($role->name)) selected @endif value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                    </select>
                                @if($errors->has('role'))<span class="text-danger">{{$errors->first('role')}}</span>@endif

                                </div>

                        </div>
                        <div class="form-group">
                                <label class="col-md-12">New Password</label>
                                <div class="col-md-12">
                                    <input name="password" type="password" class="form-control" >
                            @if($errors->has('password'))<span class="text-danger">{{$errors->first('password')}}</span>@endif

                                </div>

                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary pull-right" value="Update">
                        </div>
                    </form>
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
       @stop
