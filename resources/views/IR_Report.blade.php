@extends('adminlte::page')

@section('title', 'We-Schedule')
<meta name="csrf-token" content="{{ csrf_token() }}">



<!-- Include the overlay-component.css stylesheet -->
<link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

<!-- Include the overlay-component.js script -->
<script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>

{{--    uncomment for sockets--}}
<script src="{{ mix('js/app.js') }}" ></script>




<!-- Popperjs -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp"
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script src="/plugins/pikaday/pikaday.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.0/css/pikaday.min.css" integrity="sha512-yFCbJ3qagxwPUSHYXjtyRbuo5Fhehd+MCLMALPAUar02PsqX3LVI5RlwXygrBTyIqizspUEMtp0XWEUwb/huUQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://casemanage.ca/vendor/fontawesome-free/css/all.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js" integrity="sha512-rpLlll167T5LJHwp0waJCh3ZRf7pO6IT1+LZOhAyP6phAirwchClbTZV3iqL3BMrVxIYRbzGTpli4rfxsCK6Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script  src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


{{--<link href="https://unpkg.com/tabulator-tables@5.4.3/dist/css/tabulator.min.css" rel="stylesheet">--}}
<script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.4.3/dist/js/tabulator.min.js"></script>
    <link href="https://unpkg.com/tabulator-tables@5.4.3/dist/css/tabulator_bootstrap4.min.css" rel="stylesheet">


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">



@section('content_header')



    @livewireStyles

    <x-comments::styles />


    <style>


        .badge-notify{
            background:red;
            position:relative;
            top: -10px;
            left: 2px;
            color:white;
        }

        #btnAddImage {
            display:none;
        }

        .comments-textarea, .comments-placeholder {
            min-height: 4rem;
            width: 98%;

        }

        .comments-avatar {
            margin-left: 5px;
        }

        .comments-no-comment-yet {
            margin: 0px;
        }

        .comments-reactions {
            display:none;
        }

        .current-user {
            /* text-align: right; */
            /* background-color: #ccc; */
            display: flex;
            flex-wrap: wrap;
            justify-content: end;
            margin-bottom: 20px;
            align-items: center;
        }
        .inner_c_wrapper {
            margin-left: 10px;
            margin-right: 10px;
            background: #248bf5;
            border: 0px solid;
            padding: 5px 15px 20px;
            min-width: 40%;
            display: block;
            flex-wrap: wrap;
            flex-direction: column;
            position: relative;
            /* align-items: center; */
            justify-content: unset;
            border-radius: 14px;
        }
        p.message_text {
            font-size: 16px;
            line-height: 16px;
        }
        p.info_text {
            font-size: 10px;
            margin-bottom: 0px;
            position: absolute;
            bottom: 5px;
            right: 10px;
            font-weight:700;
        }
        .message_board {
            height: 350px;
            overflow-y: scroll;
            padding-top: 10px;
            background: #fff;
        }
        .other-user {
            display: flex;
            flex-wrap: wrap;
            justify-content: start;
            margin-bottom: 20px;
            align-items: center;
        }
        .inner_o_wrapper {
            margin-left: 10px;
            margin-right: 10px;
            border: 0px solid;
            /* width: auto; */
            padding: 5px 15px 20px;
            min-width: 40%;
            /* height: 48px; */
            display: block;
            flex-wrap: wrap;
            flex-direction: column;
            position: relative;
            /* align-items: center; */
            justify-content: unset;
            background: #e5e5ea;
            border-radius: 14px;
        }
        .inner_o_wrapper .info_text {
            left: 10px;
        }
        .inner_c_wrapper p {
            color: #fff;
        }
        .inner_c_wrapper::after {
            content: "p";
            position: absolute;
            bottom: 2px;
            right: 0px;
            width: 10px;
            height: 10px;
            font-size: 0px;
            background: #248bf5;
            transform: rotate(79deg);

        }
        .inner_o_wrapper::after {
            content: "p";
            position: absolute;
            bottom: 2px;
            left: -1px;

            width: 10px;

            height: 10px;
            font-size: 0px;
            background: #e5e5ea;
            transform: rotate(96deg);

        }
        .console_board input {
            background: #34b7f1;
            border: 0px solid;
            color: #fff;
            padding: 5px 37px;
            font-size: 13px;
            width: 100%;
        }
        .console_board textarea {
            width: 100%;
            border: 0px;
            padding: 10px;
        }
        .console_board {
            background: #e5e5ea;
            padding: 10px;
        }
        .chat-date {
            background-color: #e5e5ea;
            text-align: center;
            color: #000;
            border-radius: 5px;
            font-size: 12px;
            padding: 5px 0px;
        }
        .date-box{
            width:25%;
            margin:auto;
            border-radius:20px;
        }

        filepond--item {
            width: calc(50% - 0.5em);
        }

        .filepond--root {
            /*max-height: 10em;*/
        }

        .main-sidebar {
            z-index: auto !important;
        }
    </style>
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@4" rel="stylesheet">


    @section('content')
    <h1 class="m-0 text-dark">IR's Reporting</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless


    @livewire('i-r_-report')


{{--    @livewire('modal-pro')--}}
    @livewire('slide-over-pro')


    <!-- Require the Modal Pro component -->
{{--    @livewire('modal-pro')--}}
    @livewireScripts

    <x-livewire-alert::scripts />


@stop
