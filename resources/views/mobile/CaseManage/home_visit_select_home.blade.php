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

    <div class="extraHeader p-0">
        <div class="form-wizard-section">
            <a href="/mobileCM" class="button-item">
                <strong>1</strong>
                <p>Select Home for Site Visit</p>
            </a>
            <a href="#" class="button-item active">
                <strong>2</strong>
                <p>Verify Information</p>
            </a>
            <a href="#" class="button-item">
                <strong>
                    <ion-icon name="checkmark-outline"></ion-icon>
                </strong>
                <p>Submit Home Visit Form</p>
            </a>

        </div>
    </div>

    <div id="appCapsule">

        <div class="header-large-title">
            <img width="50%" src="/img/casemanage_logo_orig.png" class="mx-auto d-block mb-3"/>
            <h1 class="text-center">Mobile Dashboard</h1>
        </div>






        <div class="section mt-2">
            <div class="card">
                <img src="/img/home_visit_bg.jpg"  class="card-img-top" alt="image">
                <div class="card-body">
                    <h6 class="card-subtitle">{{$home->address}}, {{$home->city}}, {{$home->province}}</h6>
                    <h5 class="card-title">{{$home->name}}</h5>
                    <p class="card-text">{{$home->notes}}</p>
                </div>
            </div>
        </div>

        <div class="section mt-2">
            <div class="card">
                <div class="listview-title mt-2">CHILDREN</div>
                <ul class="listview image-listview">
                    @foreach ($children as $child)

                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="body"></ion-icon>
                            </div>
                            <div class="in">
                                <div>{{$child->initials}}</div>
                                <span class="badge badge-danger">10</span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    <li>
                        <div class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="videocam-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Case Manager</div>
                                <span class="text-muted">None</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <div class="icon-box bg-danger">
                                <ion-icon name="musical-notes-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>CAS</div>
                            </div>
                        </div>
                    </li>
                </ul>
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

    <script>




@stop
