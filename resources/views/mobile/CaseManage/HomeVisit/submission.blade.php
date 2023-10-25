@extends('layouts.mobileCM')

@section('header')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>



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
                    <img src="/img/ws.png" alt="image" class="imaged w24">
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
            <img width="70%" src="/img/casemanage_logo_orig.png" class="mx-auto d-block mb-3"/>
            <h1 class="text-center">Mobile Dashboard</h1>
        </div>






        <div class="section mt-3">
            <div class="card">
                <div class="card-body">

                    <!--<h6 class="card-title">CHILD PROFILES</h6>-->
                    <h3 class="m-1 p-1 d-flex justify-content-center">SELECT HOME FOR SITE VISIT</h3>

                    <select class="select2-blue d-flex justify-content-center" id="selectHome" data-dropdown-css-class="select2-blue"  style="width:100%;" name="selectHome">
                        @foreach ($homes as $home)
                            <option value="{{$home->id}}">{{$home->name}} - {{$home->address}}, {{$home->city}}</option>
                            @endforeach
                    </select>

                    <br />

                    {{--<ul class="listview image-listview">
                        @foreach ($homes as $home)

                            <li>
                                <a href="/mobileCM-home_visit_select_home?id={{$home->id}}" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="home"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{$home->name}}
                                            <span class="text-center">- {{$home->address}}, {{$home->city}}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                        @endforeach


                    </ul>--}}
                </div>
            </div>



        </div>

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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>


        //Initialize Select2 Elements
        $('#selectHome').select2({
            theme: 'classic'
        })
</script>
@stop
