@extends('layouts.mobileCM')

@section('header')

{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"--}}
{{--            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>--}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.min.css">

    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton" data-bs-toggle="offcanvas" data-bs-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            CaseManage.ca
        </div>
        <div class="right">
            <!--
            <a href="#" class="headerButton toggle-searchbox">
                <ion-icon name="search-outline"></ion-icon>
            </a>
            -->
        </div>
    </div>

@stop



@section ('content')
    <style>
        .card-img-top-shift {
            width: 50% !important;
            margin-bottom: 0px !important;
            padding-bottom: 0px !important;
        }

        .offcanvas-bottom {
            height: 80% !important;
        }
    </style>
    @livewireStyles

    <!-- welcome notification  -->
    <div id="notification-welcome" class="notification-box">
        <div class="notification-dialog android-style">
            <div class="notification-header">
                <div class="in">
                    <img src="/img/ws_orig.png" alt="image" class="imaged w24">
                    <strong>CaseManage.ca</strong>
                    <span>just now</span>
                </div>
                <a href="#" class="close-button">
                    <ion-icon name="close"></ion-icon>
                </a>
            </div>
            <div class="notification-content">
                <div class="in">
                    <h3 class="subtitle">Welcome to CaseManage.ca </h3>
                    <div class="text">
                        Sample notification...
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * welcome notification -->



    <div id="appCapsule">

        <div class="header-large-title">
            <img width="50%" src="/img/casemanage_logo_orig.png" class="mx-auto d-block mb-3"/>
            <h1 class="text-center">Mobile Dashboard</h1>
        </div>

        {{--        If mobile user is 2.3 (Foster Parent Applicant)--}}
        @if (Auth::user()->user_type == 2.3)

            <div class="container mt-1 text-center">
                <br />
                <a href="mobile/CaseManage/FosterParentApplicationForm"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">
                        <ion-icon name="clipboard"></ion-icon>
                        APPLICATION FORM
                    </button></a> <br /> <br />



                {{--            Impersonate Option--}}
                @if(session('impersonated_by'))
                    <a href="{{ route('users.leave-impersonate') }}" class="btn btn-success me-2">Leave Impersonation of {{$user->name}}</a>

                @endif
                @if (Auth::user()->user_type == 10.0)

                    @php
                        $users = \App\Models\User::where('user_type','>','2.0')->where('user_type','<','7')->orderBy('name','ASC')->get();
                    @endphp

                    <h2>10.0 - User Impersonation</h2>

                    <div class="col">
                        <select class="mb-3" id="selectUserImpersonate" name="selectUserImpersonate" onchange="impersonateUser()">
                            <option value="">Choose User to Impersonate</option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}} [{{$user->user_type}}]</option>
                            @endforeach
                        </select>
                    </div>
                @endif


            </div>
        @else


            @if (Auth::user()->user_type == 10.0)

                <div class="container mt-1 text-center">

{{--                <a href="mobile/CaseManage/HomeVisit"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">--}}
{{--                    <ion-icon name="home"></ion-icon>--}}
{{--                    HOME VISIT--}}
{{--                </button></a> <br /> <br />--}}

                <a href="mobile/CaseManage/OnCall"><button type="button" class="btn btn-info btn-lg me-1 mb-1">
                        <ion-icon name="calendar"></ion-icon>
                        ON-CALL
                    </button></a>


                <a href="mobile/CaseManage/OnCallCYSW"><button type="button" class="btn btn-info btn-lg me-1 mb-1">
                        <ion-icon name="person"></ion-icon>
                        ON-CALL CYSW
                    </button></a> <br /> <br />

{{--                <a href="#"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">--}}
{{--                        <ion-icon name="people"></ion-icon>--}}
{{--                        ADMISSION--}}
{{--                    </button></a> <br /> <br />--}}


{{--old expenses--}}
{{--                <a href="mobile/CaseManage/Expenses"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">--}}
{{--                        <ion-icon name="cash"></ion-icon>--}}
{{--                        EXPENSES--}}
{{--                    </button></a> <br /> <br />--}}
{{--end of old expenses--}}

                                <a href="/mobile/CaseManage/ExpensesTest"><button type="button" class="btn btn-success btn-lg me-1 mb-1">
                                        <ion-icon name="cash"></ion-icon>
                                        EXPENSES
                                    </button></a> <br /> <br />


                                <a href="/mobile/CaseManage/HomeVisits"><button class="btn btn-primary btn-lg me-1 mb-1" type="button">
                                    <ion-icon name="location"></ion-icon>
                                    HOME VISITS
                                </button></a>





{{--                <a href="#"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">--}}
{{--                        <ion-icon name="alert"></ion-icon>--}}
{{--                        INCIDENT REPORTS--}}
{{--                    </button></a> <br /> <br />--}}

                {{--            Impersonate Option--}}
                @if(session('impersonated_by'))
                        <a href="{{ route('users.leave-impersonate') }}" class="btn btn-success me-2">Leave Impersonation of {{$user->name}}</a>


                    @endif
                @if (Auth::user()->user_type == 10.0)

                        @php
                        $users = \App\Models\User::where('user_type','>','2.0')->where('user_type','<','7')->orderBy('name','ASC')->get();
                        @endphp
                        <p>
                        <h2>10.0 - User Impersonation</h2>

                        <div class="col">
                            <select class="mb-3" id="selectUserImpersonate" name="selectUserImpersonate" onchange="impersonateUser()">
                            <option value="">Choose User to Impersonate</option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}} [{{$user->user_type}}]</option>
                        @endforeach
                        </select>
                        </div>
                    @endif
                    </p>

            </div>
            @else
                <div class="container mt-1 text-center">

                    {{--                            Mar 1 2023 - hide other modules, testing for Expenses only--}}
                    {{--            If mobile user is not 2.3 (Foster Parent Applicant)--}}
                    {{--                <a href="mobile/CaseManage/HomeVisit"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">--}}
                    {{--                    <ion-icon name="home"></ion-icon>--}}
                    {{--                    HOME VISIT--}}
                    {{--                </button></a> <br /> <br />--}}

                    {{--                <a href="mobile/CaseManage/OnCall"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">--}}
                    {{--                        <ion-icon name="calendar"></ion-icon>--}}
                    {{--                        ON-CALL--}}
                    {{--                    </button></a>--}}


                    {{--                <a href="mobile/CaseManage/OnCallCYSW"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">--}}
                    {{--                        <ion-icon name="person"></ion-icon>--}}
                    {{--                        ON-CALL CYSW--}}
                    {{--                    </button></a> <br /> <br />--}}

                    {{--                <a href="#"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">--}}
                    {{--                        <ion-icon name="people"></ion-icon>--}}
                    {{--                        ADMISSION--}}
                    {{--                    </button></a> <br /> <br />--}}


                    {{--old expenses--}}
                    {{--                <a href="mobile/CaseManage/Expenses"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">--}}
                    {{--                        <ion-icon name="cash"></ion-icon>--}}
                    {{--                        EXPENSES--}}
                    {{--                    </button></a> <br /> <br />--}}
                    {{--end of old expenses--}}

                    <a href="/mobile/CaseManage/ExpensesTest"><button type="button" class="btn btn-success btn-lg me-1 mb-1">
                            <ion-icon name="cash"></ion-icon>
                            EXPENSES
                        </button></a> <br /> <br />

                    @if (Auth::user()->user_type == "4.0" || (Auth::user()->user_type >=4.2  && Auth::user()->user_type < 6.0) )

                        @if (Auth::user()->user_type == "4.4")
                            {{--                            Turn on On-Call CYSW for Mandy--}}
                            <a href="mobile/CaseManage/OnCallCYSW"><button type="button" class="btn btn-info btn-lg me-1 mb-1">
                                    <ion-icon name="person"></ion-icon>
                                    ON-CALL CYSW
                                </button></a> <br /> <br />
                        @endif


                        {{--                    Mentor Home Access--}}
{{--                        Mentor home visit 4’s (minus Larry) 5’s and 10’s--}}
                            <a href="/mobile/CaseManage/HomeVisits"><button class="btn btn-primary btn-lg me-1 mb-1" type="button">
                                    <ion-icon name="location"></ion-icon>
                                    HOME VISITS
                                </button></a>
                    @endif
                    {{--                <a href="#"><button type="button" class="btn btn-primary btn-lg me-1 mb-1">--}}
                    {{--                        <ion-icon name="alert"></ion-icon>--}}
                    {{--                        INCIDENT REPORTS--}}
                    {{--                    </button></a> <br /> <br />--}}

                    {{--            Impersonate Option--}}
                    @if(session('impersonated_by'))
                        <a href="{{ route('users.leave-impersonate') }}" class="btn btn-success me-2">Leave Impersonation of {{$user->name}}</a>

                    @endif
                    @if (Auth::user()->user_type == 10.0)

                        @php
                            $users = \App\Models\User::where('user_type','>','2.0')->where('user_type','<','7')->orderBy('name','ASC')->get();
                        @endphp

                        <h2>10.0 - User Impersonation</h2>

                        <div class="col">
                            <select class="mb-3" id="selectUserImpersonate" name="selectUserImpersonate" onchange="impersonateUser()">
                                <option value="">Choose User to Impersonate</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}} [{{$user->user_type}}]</option>
                                @endforeach
                            </select>
                        </div>
                    @endif


                </div>
            @endif
        @endif
        <script>


            function impersonateUser() {
                $url = '{{ route('users.impersonate', 'myUserID') }}';
                $url = $url.replace('myUserID', document.getElementById("selectUserImpersonate").value);
                console.log ($url);
                location.replace($url);
            }
        </script>

        <script>

            document.addEventListener("DOMContentLoaded", () => {
                const otherDate = new Date("01 June 2023"); // Carpe Diem 24th Anniversary
                const RPACDate = new Date("07 June 2023"); //RPAC Message
                const todayDate = new Date(); // Current or today's date

// Check if the other date matches today's date
                if (
                    RPACDate.getDate() === todayDate.getDate() &&
                    RPACDate.getMonth() === todayDate.getMonth() &&
                    RPACDate.getYear() === todayDate.getYear()
                ) {
                    Swal.fire({
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        },
                        imageUrl: 'img/RPAC.png',
                        // imageHeight: 200,
                        // imageWidth: 800,
                        // width: '800',
                        // height: '300',
                        title: '<font color="black">What is RPAC?</font>',
                        html: "<b>RPAC</b> is an abbreviation for <b>R</b>esidential <b>P</b>lacement <b>A</b>dvisory <b>C</b>ommittee that is a mandated review as outlined in the Child, Youth and Family Services Act. <br /><br /><b>RPAC</b> has a role to review the appropriateness of a child’s residential placement. Reviews include the child’s point of view, the parent/guardian’s point of view and key service providers involved. Reviews must occur for each child and youth who moves into a residential program licensed for ten or more individuals when the placement will be more than three months. Additionally, any child/youth living in either foster care or a group home of any size can ask for a review. <br /><br /><i>It’s your right!</i>",
                        background: '#fff',
                        position: 'center',
                        backdrop: true,
                        imageAlt: 'RPAC',
                        // confirmButtonText: "Thank you for being you!",
                        showCancelButton: true,

                        confirmButtonText:
                            '<i class="fa fa-thumbs-up"></i> Great!',
                        cancelButtonText:
                            '<i class="fa fa-info"></i> More Info!',

                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                '<font color="black">Great!</font>',
                                'By clicking OK, you acknowledge that you have read and understand the meaning of RPAC. <br /><br />If you have any questions regarding RPAC please contact <b>Blair Lewis</b> @ 416-459-1999 immediately.',
                                'success'
                            )
                        } else {
                            Swal.fire(
                                '<font color="black">Imagine a Foster Parent just clicked "OK"</font>',
                                'The <b>"RPAC reviewed badge"</b> would automatically appear on their <b>Learning Plan</b> as well as <b>AR</b> and <b>Timeline</b>, with a date and time stamp. <br /><br />Take a moment and imagine all the other information we could review virtually with our <b>Foster Parents</b> and <b>Staff</b> . . . <br /><br />  Welcome to CaseManage.ca, ' + "<br /><i>We're just getting started</i>",
                                'info'
                            )
                        }


                    });
                }
            });


        </script>
        <!-- app footer -->
        <div class="appFooter pb-8 mt-0 ">
            <img src="/img/casemanage_logo_horz.png" height="50px" alt="icon" class=" mb-2">
            <div class="footer-title">
                Copyright © CaseManage.ca <span class="yearNow"></span>. All Rights Reserved.
            </div>
        </div>
        <!-- * app footer -->
    </div>
    @livewireScripts



@stop
