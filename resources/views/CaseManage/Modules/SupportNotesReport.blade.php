
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

@section('content_header')
    <h1 class="m-0 text-dark">Support Notes Report</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless


    <style>
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
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @livewire('support-notes-report.support-notes-report', ['user' => $user, 'request' => $request])


                </div>
            </div>
        </div>
    </div>
</div>
@livewire('slide-over-pro')

    @livewireScripts

    <x-comments::scripts />

@stop
@section('js')


@stop


