
@extends('adminlte::page')


@section('title', 'Case Manage')

@livewireStyles

<x-comments::styles />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Include the overlay-component.css stylesheet -->
<link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

<!-- Include the overlay-component.js script -->
<script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>

<!-- Include the insert-component.css stylesheet -->
<link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-insert-component.css') }}">

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

<script src="/jSpreadsheet-ce/index.js" crossorigin="anonymous"></script>
<link href="/jSpreadsheet-ce/jspreadsheet.css" rel="stylesheet" crossorigin="anonymous">

<script src="/jSuites/jsuites.js" crossorigin="anonymous"></script>
<link href="/jSuites/jsuites.css" rel="stylesheet" crossorigin="anonymous">

<script src="/currencyJS/currency.min.js" type="text/javascript"></script>

<script src="https://cdn.jsdelivr.net/gh/underground-works/clockwork-browser@1/dist/toolbar.js"></script>

@section('content_header')
    <h1 class="m-0 text-dark">Expense Reports</h1>
    <script>
        $userID = {{$user->id}};
    </script>

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






        /** Specifically for expenses*/
        .im-tagged {
            border-style:solid !important;
            border-color:red !important;
        }

        /* Define the animation */
        @keyframes flash-border {
            0% { border-width: 5px; }
            20% { border-width: 1px; }
            40% { border-width: 5px; }
            50% { border-width: 1px; }
            60% { border-width: 5px; }
            70% { border-width: 1px; }
            80% { border-width: 5px; }
            100% { border-width: 1px; }
        }

        /* Apply the animation to the button when clicked */
        .flash-border {
            animation-name: flash-border;
            animation-duration: 10s;
        }

        .focused-expense, .focused-expense-node {
            border-style:solid !important;
            border-width:2px !important;
            border-color:red !important;
        }
        /** End specifically for expenses*/
    </style>

@stop

@section('content')


    <div class="container-fluid" id='expense-fluid-container' style="width:100%; height:85%; overflow-y:auto;">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div>
                        <a href="#" class="btn btn-sm" style="float:right;margin-top: 1em;/*position:fixed;right: 40px;*/"
                           title="View  Notifications"
                           onclick="Livewire.emit('slide-over.open', 'notifications.expense-action-center', {'embeddedSlider':'true'})"
                        >
                            <i class="fa-solid fa-bell fa-xl" style="color: orangered;"></i>
                        </a>
                    </div>


                    <div class="card-header p-2">
                        <ul class="nav nav-pills" role="tablist">

                            @foreach($tabCollection as $tabHead)
                                <?php
                                    $isActive = Route::current()->uri() == 'Expense/Report' && session('expense.report.active-tab')==$tabHead;
                                    $baseId = \Illuminate\Support\Str::snake($tabHead);
                                ?>

                                <li class="nav-item">
                                    <a
                                        class="nav-link {{$isActive?'active':''}}"
                                        id="{{$baseId}}_tab_head"
{{--                                        data-toggle="tab"--}}
                                        href="{{ route('expense.report', ['tab_key' => $tabHead, 'optimized' => request('optimized', false)]) }}#{{$baseId}}_panel"
                                        role="tab"
                                        aria-controls="{{$baseId}}_panel"
                                        aria-selected="{{$isActive?'true':'false'}}"
                                    >
                                        {{$tabHead}}
                                    </a>
                                </li>
                            @endforeach

                            @if(auth()->user()->user_type == 10.0)
                                <li class="nav-item">
                                    <a
                                        class="nav-link {{Route::current()->uri() == 'Expense/PermissionEscalation'?'active':''}}"
                                        id="permission_escalation_tab_head"
{{--                                        data-toggle="tab"--}}
                                        href="{{ route('expense.permission-escalation') }}#permission_escalation_panel"
                                        role="tab"
                                        aria-controls="permission_escalation_panel"
                                        aria-selected="{{Route::current()->uri() == 'Expense/PermissionEscalation'?'true':'false'}}"
                                    >
                                        Verify Permission Escalation
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">

                            @if(Route::current()->uri() == 'Expense/Report')
                                <div
                                    class="tab-pane fade show active"
                                    id="{{\Illuminate\Support\Str::snake( session('expense.report.active-tab') )}}_panel"
                                    role="tabpanel"
                                    aria-labelledby="{{\Illuminate\Support\Str::snake( session('expense.report.active-tab') )}}_tab_head"
                                >
                                    @livewire('expenses-report.dynamic-expense-report-component', ['focussedExpense' => request()->get('focus-expense')])
                                </div>


                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        @if(request()->has('focus-expense'))
                                        focusToExpense({{request()->get('focus-expense')}});
                                        @endif

                                        @if(request()->has('show-notification-slider'))
                                        //Auto open notification sidebar
                                        Livewire.emit('slide-over.open', 'notifications.expense-action-center', {'size':'lg'});
                                        @endif
                                    });

                                    function focusToExpense(expenseId){
                                        Livewire.emit('focusToExpense', expenseId);

                                        //find expense
                                        $node = $('#expense-bill-'+expenseId);

                                        //use JS to update since, livewire is ignored on this div
                                        $('#collapseddiv_'+expenseId).addClass('show');

                                        //scroll to expense
                                        $('#expense-fluid-container').animate({
                                            scrollTop: $node.offset().top// scroll to h3 minus height of h1
                                        }, 500);

                                        //flash the boarder for better eye focus
                                        $node.addClass('flash-border');
                                        setTimeout(function() {
                                            $node.removeClass('flash-border');
                                        }, 11000);
                                    }
                                </script>

                            @endif

                            @if(Route::current()->uri() == 'Expense/PermissionEscalation')
                                @if(auth()->user()->user_type == 10.0)
                                    <div
                                        class="tab-pane fade show active"
                                        id="permission_escalation_panel"
                                        role="tabpanel"
                                        aria-labelledby="permission_escalation_tab_head"
                                    >
                                        @livewire('expenses-report.permission-escalation-component')
                                    </div>
                                @else
                                    {{abort(403)}}
                                @endif
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('modal-pro')
    @livewire('slide-over-pro')
    <!-- Require the Insert Pro component -->
    @livewire('insert-pro')

    <!-- Include the insert-component.js script -->
    <script src="{{ asset('vendor/wire-elements-pro/js/insert-component.js') }}"></script>
    @livewireScripts

    <x-comments::scripts />

@stop


@section('js')
@stop
