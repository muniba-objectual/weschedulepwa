@extends('layouts.mobile')
@section('header')
    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            We-Schedule.ca (IR Entry)
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




@section ('content')
    <style>

        .offcanvas-bottom {
            height: 62% !important;
        }

    </style>

    <div id="appCapsule" class="full-height">

        <div class="blog-post">

            <h1 class="title">Incident Report</h1>


            <div class="post-body">
                <div class="form-group" id="IR_form_entry"
                     name="IR_form_entry" style="">
                    <div class="form-group">
                        <label for="inputNameOfChild">Name of
                            Child</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputNameOfChild"
                               value="{{$child->initials}}">
                    </div>

                    <div class="form-group">
                        <label for="inputDOB">Date of Birth</label>
                        <input disabled type="text" class="form-control"
                               id="inputDOB"
                               value="{{$child->DOB}}">
                    </div>

                    <div class="form-group">
                        <label for="inputDateofPlacement">Date of
                            Placement</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputDateofPlacement"
                               value="{{ Carbon\Carbon::now()->toDateString('Y-m-d H:i')}}">
                    </div>

                    <div class="form-group">
                        <label for="inputFosterHome">Foster Home</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputFosterHome"
                                value="{{$child->get_home->address}}, {{$child->get_home->city}}, {{$child->get_home->postal}}">
                    </div>

                    <div class="form-group">
                        <label for="inputPlacingAgency">Placing
                            Agency</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputPlacingAgency"
                               value="Carpe Diem Residential Therapeutic Treatment Homes for Children"
                        >
                    </div>

                    <div class="form-group">
                        <label for="inputLegalGuardian">Legal Guardian's
                            Name</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputLegalGuardian"
                        value="{{$incident->legal_guardian_name}}">
                    </div>


                    <div class="form-group">
                        <br /><br />
                        <span style="color:red;">NOTIFY / REPORT WITHIN 24 HOURS / S.O. AS SOON AS POSSIBLE</span>
                        <br/><b>*Carpe Diem must submit Serious
                            Occurrence Reports to Ministry within 24
                            hours</b>
                        <br /><br />
                        <label for="inputIncidentType">Incident Type</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputIncidentType"
                               value="{{$incident->incident_type}}"
                        >
                    </div>
                    @if ($incident->serious_occurence)
                    <div class="form-group">
                        <label for="inputSeriousOccurence">Serious
                            Occurence</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputSeriousOccurence"
                               value="{{$incident->serious_occurence}}"

                        >
                    </div>
                    @endif

                    @if ($incident->level1_serious_occurence)
                    <div class="form-group">
                        <label for="inputLevel1SeriousOccurence">Level 1
                            - Serious Occurence</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputLevel1SeriousOccurence"
                               value="{{$incident->level1_serious_occurence}}"

                        >
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="inputDateofIncident">Date of
                            Incident</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputDateofIncident"
                               value="{{$incident->date_of_incident}}"

                        >
                    </div>

                    <div class="form-group">
                        <label
                            for="inputTimeDuration">Time/Duration</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputTimeDuration"
                               value="{{$incident->time_duration}}"

                        >
                    </div>

                    <div class="form-group">

                        <label for="inputDateTimeReportReceived">Date/Time
                            Report Received</label>
                        <input disabled type="text"
                               class="form-control"
                               id="inputDateTimeReportReceived"
                               value="{{$incident->datetime_report_received}}"

                        >
                    </div>

                    <div class="form-group">
                        <label for="inputLocationofIncident">Location of
                            Incident</label>
                        <textarea disabled id="inputLocationofIncident"
                                  class="form-control"
                                  rows="4">{{$incident->location_of_incident}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="inputAntecedent">Antecedent leading
                            to the Incident</label>
                        <textarea disabled id="inputAntecedent"
                                  class="form-control"
                                  rows="4">{{$incident->antecedent_leading_to_incident}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="inputDescription">Description of
                            Incident (What, When, Where and How)</label>
                        <textarea disabled id="inputDescription"
                                  class="form-control"
                                  rows="4">{{$incident->description_of_incident}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="inputActionTaken">Action
                            Taken</label>
                        <textarea disabled id="inputActionTaken"
                                  class="form-control"
                                  rows="4">{{$incident->action_taken}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="inputWhoWasNotified">Who Was
                            Notified</label><br/>
                        <input disabled type="text"
                               class="form-control"
                               id="inputWhoWasNotified"
                               value="{{$incident->who_was_notified}}"
                        >

                    </div>

                    <div class="form-group">
                        <label for="inputPhysicalInjuries">Physical
                            Injuries (Include specific details of injury
                            and medical intervention)</label>
                        <textarea disabled id="inputPhysicalInjuries"
                                  class="form-control"
                                  rows="4">{{$incident->physical_injuries}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="inputPropertyDamage">Property Damage
                            (Attach Damage Form)</label>
                        <textarea disabled id="inputPropertyDamage"
                                  class="form-control"
                                  rows="4">{{$incident->property_damage}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="inputComments">Comments
                            (Why)</label>
                        <textarea disabled id="inputComments"
                                  class="form-control"
                                  rows="4">{{$incident->comments}}</textarea>
                    </div>



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







@stop
