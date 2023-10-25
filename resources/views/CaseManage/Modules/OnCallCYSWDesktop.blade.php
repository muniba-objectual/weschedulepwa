
@extends('adminlte::page')


@section('title', 'Case Manage')

@livewireStyles

<x-comments::styles />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Include the overlay-component.css stylesheet -->
<link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

<!-- Include the overlay-component.js script -->
<script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>
<!-- Alpine Plugins -->
<script  src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>

<!-- Popperjs -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<!-- Tempus Dominus JavaScript -->
<script src="/plugins/tempus-dominusv6/js/tempus-dominus.js" crossorigin="anonymous"></script>

<!-- Tempus Dominus Styles -->
<link href="/plugins/tempus-dominusv6/css/tempus-dominus.css" rel="stylesheet" crossorigin="anonymous">

<script src="jSpreadsheet-ce/index.js" crossorigin="anonymous"></script>
<link href="jSpreadsheet-ce/jspreadsheet.css" rel="stylesheet" crossorigin="anonymous">

<script src="jSuites/jsuites.js" crossorigin="anonymous"></script>
<link href="jSuites/jsuites.css" rel="stylesheet" crossorigin="anonymous">

<script src="currencyJS/currency.min.js" type="text/javascript"></script>

@section('content_header')
    <h1 class="m-0 text-dark">On Call CYSW</h1>

    @unless (Auth::check())
        You are not signed in.
    @endunless


@stop

@section('content')


    <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
             @livewire('forms.case-manage.on-call-c-y-s-w-form-desktop')

                </div>
            </div>
        </div>
    </div>
</div>
    @livewire('modal-pro')

    @livewireScripts

    <x-comments::scripts />

@stop
@section('js')


@stop


