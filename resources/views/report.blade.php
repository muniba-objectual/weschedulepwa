@extends('adminlte::page')

@section('title', 'We-Schedule')
<meta name="csrf-token" content="{{ csrf_token() }}">



@section('content')

    <?php $report->render(); ?>



@stop

