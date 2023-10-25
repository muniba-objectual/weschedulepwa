@extends('layouts.mobile')
@section('header')
    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            We-Schedule.ca (End Of Shift Form)
        </div>
        <div class="right">
            <!--
                <a href="#" class="headerButton" data-bs-toggle="offcanvas" data-bs-target="#actionSheetShare">
                    <ion-icon name="share-outline"></ion-icon>
                </a>
                -->
        </div>
    </div>

@stop




@section('content')
    <style>
        .offcanvas-bottom {
            height: 62% !important;
        }
    </style>

    <div id="appCapsule" class="full-height">

        <div class="blog-post">

            <h1 class="title">End of Shift Form</h1>


            <div class="post-body">
                <div class="form-group">
                    <label for="medication_type">Mood Upon Arrival</label>
                    <textarea readonly rows="5" cols="30" class="form-control" id="mood_upon_arrival">{{ $shift_form->mood_upon_arrival }}</textarea>

                </div>


                <div class="form-group">
                    <label for="medication_type">Interaction with Staff</label>
                    <textarea readonly rows="5" cols="30" class="form-control" id="interaction_with_staff">{{ $shift_form->interaction_with_staff }}</textarea>

                </div>

                <div class="form-group">
                    <label for="medication_type">General Observations</label>
                    <textarea readonly rows="5" cols="30" class="form-control" id="general_observations">{{ $shift_form->general_observations }}</textarea>

                </div>

                <!-- <div class="form-group">
                        <label for="medication_type">Dietary Notes</label>
                        <textarea readonly rows="5" cols="30" class="form-control" id="dietary_notes">{{ $shift_form->dietary_notes }}</textarea>

                    </div> -->
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







@stop
