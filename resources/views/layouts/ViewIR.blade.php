@extends('adminlte::page')

@section('title', 'We-Schedule')
<meta name="csrf-token" content="{{ csrf_token() }}">


@section('content_header')
    <h1 class="m-0 text-dark">View IR</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless

    @livewireStyles

    <script src="{{ mix('js/app.js') }}" ></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
     <!-- Tempus Dominus JavaScript -->
    <script src="/plugins/tempus-dominusv6/js/tempus-dominus.js" crossorigin="anonymous"></script>

    <!-- Tempus Dominus Styles -->
    <link href="/plugins/tempus-dominusv6/css/tempus-dominus.css" rel="stylesheet" crossorigin="anonymous">

{{--    Sweet Alert--}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
{{--    <x-livewire-alert::flash />--}}

    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@4" rel="stylesheet">

    <script src="/js/syncscroll.js"></script>

    <script src="/pdfJS/build/pdf.js"></script>
    <style>

        .pre-scrollable {
            max-height: 850px;
            overflow-y: scroll;
        }

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

@stop

@section('content')


        {{ $slot }}


{{--    Broadcast--}}
{{--    <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>--}}

    @livewireScripts

@stop

@section('footer')
@stop

