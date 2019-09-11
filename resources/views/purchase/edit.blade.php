@extends('_layout.master')
@section('title', 'Invoice # '.$purchase->id)
@section('css')

@stop

@section('content')


                <div id="edit-purchase"></div>



@stop

@section('js')

    <script src="{{ asset('js/app.js') }}"></script>

@stop