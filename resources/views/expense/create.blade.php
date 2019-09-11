@extends('_layout.master')

@section('title', 'Creat User')
@section('css')

 <link href="{{asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />

 @stop
@section('content')
<div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Expense Manager</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="">Dashboard</a></li>
            <li><a href="{{url('user')}}">Expense Manager</a></li>
                <li class="active">Create Expense</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Create Expense</h3>
                    <br/>
                <form class="form-horizontal" method="post" action="{{url('/expense/store')}}">
                            @csrf
                        <div class="form-group">
                            <label class="col-md-12">Date</label>
                            <div class="col-md-12">
                                    <input type="date" name="date" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
                                @if($errors->has('date'))<span class="text-danger">{{$errors->first('date')}}</span>@endif
                            </div>

                        </div>
                        <div class="form-group">
                                <label class="col-md-12">Expense Title</label>
                                <div class="col-md-12">
                                    <select name="expense_id" class="form-control">
                                        <option value="">Please Select Expense Title</option>
                                        @foreach($expense_title as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('expense_id'))<span class="text-danger">{{$errors->first('expense_id')}}</span>@endif
                                </div>

                        </div>

                        <div class="form-group">
                                <label class="col-md-12">Amount</label>
                                <div class="col-md-12">
                                        <input type="number" name="amount" class="form-control">
                                    @if($errors->has('amount'))<span class="text-danger">{{$errors->first('amount')}}</span>@endif
                                </div>

                            </div>


                        <div class="form-group">
                            <input type="submit" class="btn btn-primary pull-right" value="Create">
                        </div>
                    </form>
                </div>
            </div>
        </div>

@stop



@section('js')
<script>
jQuery('.mydatepicker, #datepicker').datepicker();
jQuery('#datepicker-autoclose').datepicker({
    autoclose: true,
    todayHighlight: true
});
jQuery('#date-range').datepicker({
    toggleActive: true
});
jQuery('#datepicker-inline').datepicker({
    todayHighlight: true
});
// Daterange picker
$('.input-daterange-datepicker').daterangepicker({
    buttonClasses: ['btn', 'btn-sm'],
    applyClass: 'btn-danger',
    cancelClass: 'btn-inverse'
});
$('.input-daterange-timepicker').daterangepicker({
    timePicker: true,
    format: 'MM/DD/YYYY h:mm A',
    timePickerIncrement: 30,
    timePicker12Hour: true,
    timePickerSeconds: false,
    buttonClasses: ['btn', 'btn-sm'],
    applyClass: 'btn-danger',
    cancelClass: 'btn-inverse'
});
$('.input-limit-datepicker').daterangepicker({
    format: 'MM/DD/YYYY',
    minDate: '06/01/2015',
    maxDate: '06/30/2015',
    buttonClasses: ['btn', 'btn-sm'],
    applyClass: 'btn-danger',
    cancelClass: 'btn-inverse',
    dateLimit: {
        days: 6
    }
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
