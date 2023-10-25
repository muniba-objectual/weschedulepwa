@extends('layouts.mobile')

@section('header')

    @php
        $contains = Str::contains(url()->current(), 'casemanage');

        if ($contains) {
            echo '<script>
                window.location.href = "/mobileCM";
            </script>';
        }
    @endphp

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.min.css">


    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton" data-bs-toggle="offcanvas" data-bs-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            We-Schedule.ca
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



@section('content')
    <style>
        .card-img-top-shift {
            width: 60px !important;
            margin-bottom: 0px !important;
            padding-bottom: 0px !important;
        }

        .offcanvas-bottom {
            height: 80% !important;
        }

        .alertContainer {
            /*background-color: whitesmoke !important;*/
        }

        .alertPopup {
            background-color: whitesmoke !important;

        }

        .alertTitle {
            color:blue !important;
        }
    </style>
    @livewireStyles

    <!-- welcome notification  -->
    <div id="notification-welcome" class="notification-box">
        <div class="notification-dialog android-style">
            <div class="notification-header">
                <div class="in">
                    <img src="/img/ws_orig.png" alt="image" class="imaged w24">
                    <strong>We-Schedule.ca</strong>
                    <span>just now</span>
                </div>
                <a href="#" class="close-button">
                    <ion-icon name="close"></ion-icon>
                </a>
            </div>
            <div class="notification-content">
                <div class="in">
                    <h3 class="subtitle">Welcome to We-Schedule.ca </h3>
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
            <img width="55%" src="/img/ws_orig.png" class="mx-auto d-block mb-3" />
            <!-- <h1 class="text-center">Mobile Dashboard</h1> -->
        </div>


        <!-- End of Shift Form Modal -->
        <div wire:ignore.self class="offcanvas offcanvas-bottom" id="EndOfShiftModal" tabindex="-1">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">End of Shift Report (Modifable Until Shift Sign Out)</h5>
                <a href="#" class="offcanvas-close" data-bs-dismiss="offcanvas">
                    <ion-icon name="close-outline">x</ion-icon>
                </a>
            </div>

            <div class="offcanvas-body">

                <div class="card card-primary">
                    <div class="card-header p-0 m-0">

                        <div class="card-tools p-0 m-0" style="height:0px !important;">
                            <button type="button" class="btn btn-tool"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        @livewire('mobile.endofshiftform-component', ['myshift_form'])
                    </div>
                    <!-- /.card-body -->

                    <!-- /.card -->

                </div>




            </div>
        </div>
        <!-- *End of Shift Form Modal -->




        <div class="section mt-3">
            <div>
                <!-- carousel multiple -->
                <div class="carousel-full splide">
                    <ul class="listview image-listview today-area">
                        <li>
                            <div class="item pb-0">

                                <div class="in">
                                    <div class=" mb-0 pb-0">
                                        <h3 class="today-shift px-3">Today's Shifts</h3>
                                        <!-- <div class="text-muted">05:20 AM</div> -->
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="splide__track">

                        <ul class="splide__list">


                            @if ($user->getPastPublishedSignedInShifts->count() > 0)

                                @foreach ($user->getPastPublishedSignedInShifts as $shift)
                                    <li class="splide__slide">
                                        <div class="card card-border-t-n">


                                            <img src="/mobilekit/assets/img/shift_icon.png"
                                                class="card-img-top-shift mx-auto mt-1" alt="image">
                                            <div class="card-body mt-0 pt-0">
                                                @livewire('mobile.signin-component', ['user' => $user, 'child' => $children, 'myshift' => $shift])
                                                <br /><span style="color:red;">*We have detected that you have not signed
                                                    out of a past shift; you must sign out of past shifts in order to access
                                                    future shifts.</span>

                                            </div>
                                            <!-- end of card -->

                                        </div>
                                    </li>
                                @endforeach
                            @else
                                @if ($user->getTodaysPublishedShifts->count() > 0)
                                    @foreach ($user->getTodaysPublishedShifts as $shift)
                                        <li class="splide__slide">
                                            <div class="card card-border-t-n">


                                                <img src="/mobilekit/assets/img/shift_icon.png"
                                                    class="card-img-top-shift mx-auto mt-1" alt="image">
                                                <div class="card-body mt-0 pt-0">
                                                    @livewire('mobile.signin-component', ['user' => $user, 'child' => $children, 'myshift' => $shift])
                                                </div>
                                                <!-- end of card -->

                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="splide__slide">
                                        <div class="card card-border-t-n">
                                            <img src="/mobilekit/assets/img/shift.svg"
                                                class="card-img-top-shift mx-auto mt-2" alt="image">
                                            <div class="card-body mt-0 pt-0">
                                                <!-- <h5 class="card-title">&nbsp;</h5>

                                                <h6 class="card-subtitle">&nbsp;</h6> -->
                                                <!-- <p class="card-text">
                                                    &nbsp;
                                                </p> -->
                                                <ul class="listview image-listview">
                                                    <li>
                                                        <div class="item">

                                                            <div class="in">
                                                                <span class="d-block mx-auto">No Shifts Available</span>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endif




                        </ul>
                    </div>
                </div>
                <!-- * carousel multiple -->

            </div>
        </div>

        <div class="section mt-3">
            <div class="card">
                <div class="card-body">
                    <!--<h6 class="card-title">CHILD PROFILES</h6>-->
                    <h3 class="today-shift">Upcoming Shifts</h3>

                    <img src="/mobilekit/assets/img/shift.svg"
                                                class="card-img-top-shift mx-auto mt-2 d-block m-auto" alt="image">
                    <ul class="listview image-listview">
                        @if ($user->getUpcomingPublishedShifts->count() > 0)
                            @foreach ($user->getUpcomingPublishedShifts->take(7) as $shift)
                                <li>
                                    <div class="item">

                                        <div class="icon-box bg-primary">
                                            <ion-icon name="calendar-outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div><span class="text-uppercase font-weight-bold"
                                                    style="color:blue;">{{ \Carbon\Carbon::parse($shift->start)->format('M d Y') }}
                                                    @ {{ \Carbon\Carbon::parse($shift->start)->format('g:i A') }} -
                                                    {{ \Carbon\Carbon::parse($shift->end)->format('g:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            <li>
                                <div class="item">

                                    <div class="icon-box bg-primary">
                                        <ion-icon name="list"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div><a class="text-white" data-bs-toggle="offcanvas" href="#offcanvas-left">View
                                                All Upcoming Shifts</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @else
                            <div class="in">
                                <span class="d-block mx-auto mt-2 text-center">No Shifts Available</span>
                            </div>
                        @endif



                    </ul>
                </div>
            </div>


        </div>



        <div class="section mt-3">
            <div class="card">
                <div class="card-body">
                    <!--<h6 class="card-title">CHILD PROFILES</h6>-->
                    <h3 class="today-shift">Child Profiles</h3>


                    <ul class="listview image-listview">
                        @if ($user->user_type == '1' && count($user->getAssignedChildren) > 0)
                            @foreach ($user->getAssignedChildren as $child)
                                <li>
                                    <a href="/mobile/child/{{ $child->id }}" class="item">
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="person-circle-outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>{{ $child->initials }}
                                                @if ($child->SRA)
                                                    <span class="badge bg-success">SRA</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        @if ($user->user_type == '1' && count($user->getAssignedChildren) <= 0)
                            <li>No children assigned</li>
                        @endif

                        @if ($user->user_type == '2' || $user->user_type == '3' || $user->user_type == 4 || $user->user_type == 10)
                            @foreach ($children as $child)
                                <li>
                                    <a href="/mobile/child/{{ $child->id }}" class="item">
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="person-circle-outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>{{ $child->initials }}
                                                <!--         @if ($child->SRA)
    <span class="badge bg-success">SRA</span>
    @endif
                                                           -->
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>


        </div>

        <!-- app footer -->
        <div class="appFooter pb-8 mt-0 ">
            <img src="/img/ws_blue.png" alt="icon" class="footer-logo mb-2">
            <div class="footer-title">
                Copyright © We-Schedule.ca <span class="yearNow"></span>. All Rights Reserved.
            </div>
        </div>
        <!-- * app footer -->
    </div>

    <!-- Offcanvas Left -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas-left">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">All Upcoming Shifts</h5>
            <a href="#" class="offcanvas-close" data-bs-dismiss="offcanvas">
                <ion-icon name="close-outline"></ion-icon>
            </a>
        </div>
        <div class="offcanvas-body">
            <div>
                <ul class="listview image-listview">
                    @if ($user->getUpcomingPublishedShifts->count() > 0)
                        @foreach ($user->getUpcomingPublishedShifts as $shift)
                            <li>
                                <div class="item">

                                    <div class="icon-box bg-primary">
                                        <ion-icon name="calendar-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div><span class="text-uppercase font-weight-bold"
                                                style="color:blue;">{{ \Carbon\Carbon::parse($shift->start)->format('M d Y') }}
                                                <br />@ {{ \Carbon\Carbon::parse($shift->start)->format('g:i A') }} -
                                                {{ \Carbon\Carbon::parse($shift->end)->format('g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <div class="in">
                            <span class="d-block mx-auto text-center">No Shifts Available</span>
                        </div>
                    @endif



                </ul>
            </div>
        </div>
    </div>
    <!-- * Offcanvas Left -->


    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />

    <script>
        var shiftID = "";
        window.onload = (event) => {
            // console.log('The page has fully loaded');


        };

        // Trigger welcome notification after 5 seconds
        /*
        setTimeout(() => {

        notification('notification-welcome', 5000);

        }, 2000);
        */

        function Load_End_of_Shift_Report(shiftID) {
            Livewire.emit('loadShiftForm', shiftID);

            window.scrollTo({
                top: 500,
                //left: 100,
                behavior: 'smooth'
            });

            var myOffcanvas = document.getElementById('EndOfShiftModal');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
            bsOffcanvas.show();
        }

        window.addEventListener('viewEndOfShiftModal', event => {
            //$("#frmAddMedication").trigger('reset');
            shiftID = event.detail.shiftID;
            Livewire.emit('loadShiftForm', shiftID);

            window.scrollTo({
                top: 500,
                //left: 100,
                behavior: 'smooth'
            });

            //        var myOffcanvas = document.getElementById('EndOfShiftModal');
            //        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
            //        bsOffcanvas.show();
            $('#EndOfShiftModal').offcanvas('show');

        })

        window.addEventListener('close_end_of_shift_report_modal', event => {
            $('#EndOfShiftModal').offcanvas('hide');
        })
    </script>


    <script>

        document.addEventListener("DOMContentLoaded", () => {
            const otherDate = new Date("01 June 2023"); // Carpe Diem 24th Anniversary
            const todayDate = new Date(); // Current or today's date

// Check if the other date matches today's date
            if (
                otherDate.getDate() === todayDate.getDate() &&
                otherDate.getMonth() === todayDate.getMonth() &&
                otherDate.getYear() === todayDate.getYear()
            ) {
                Swal.fire({
                    imageUrl: 'img/happy.gif',
                    imageHeight: 200,
                    imageWidth: 600,

                    background:'#fff',
                    position: 'center',
                    backdrop: true,
                    imageAlt: 'Happy 24th Birthday to Carpe Diem!',
                    confirmButtonText: "Thank you for being you!"
                })

            } else {
                // console.log("The date is not today!");
            }
        });


    </script>


@stop
