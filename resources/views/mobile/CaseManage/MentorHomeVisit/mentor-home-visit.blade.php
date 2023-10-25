@extends('layouts.mobileCM')

@section('header')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/sweetalert2/theme-dark/dark.css">



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
            <img width="50%" src="/img/casemanage_logo_orig.png" class="mx-auto d-block mb-3"/>
            <h1 class="text-center">Mentor Home Repair/Maintenance Visit</h1>
        </div>






        <div class="section mt-3">
            <div class="card">
                <div class="card-body">

                    @livewire('forms.case-manage.mentor-home-visit-form', ["user" => $user])
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />

@stop
