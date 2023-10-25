@extends('layouts.mobile')

@section('header')
    <script src="https://code.jquery.com/jquery-3.6.2.slim.min.js" integrity="sha256-E3P3OaTZH+HlEM7f1gdAT3lHAn4nWBZXuYe89DFg2d0=" crossorigin="anonymous"></script>

    <x-comments::styles />

    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton" data-bs-toggle="offcanvas" data-bs-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            We-Schedule.ca (Child Profile)
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

        #upcomingShiftsUL {
            margin-left:0px;
            /*color:white;*/
        }
        input[type="file"] {
            display: none;
        }

        .custom-file-upload_AW {
            background-color: blue;
            color: white;
            padding: 2px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            border-radius: 0rem;
            cursor: pointer;
            margin-top: 1px;
            width: 10px;
        }

        .custom-send {
            background-color: red;
            color: white;
            padding: 2px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            border-radius: 0rem;
            cursor: pointer;
            margin-top: 1px;

        }

        .offcanvas-bottom {
            height: 62% !important;
        }

        .icon-inner, .ionicon, svg {
            display: block;
            height: 111%;
            width: 100%;
        }


        .chatFooter {
            min-height: 56px;
            background: #FFF;
            border-top: 1px solid #E1E1E1;
            position: relative;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-left: 14px;
            padding-right: 14px;
            padding-bottom: env(safe-area-inset-bottom);
            display: block;
        }

        .SRA-badge {
            display: inline !important;
            font-size: 14px !important;
        }


        /* CSS for Dark Mode - Laravel-Comments */
        /* Dark colors */
        .comments {
            --comments-color-background: rgb(34, 34, 34);
            --comments-color-background: rgb(34, 34, 34);
            --comments-color-background-nested: rgb(34, 34, 34);
            --comments-color-background-paper: rgb(55, 51, 51);
            --comments-color-background-info: rgb(104, 89, 214);

            --comments-color-reaction: rgb(59, 59, 59);
            --comments-color-reaction-hover: rgb(65, 63, 63);
            --comments-color-reacted: rgba(67, 56, 202, 0.25);
            --comments-color-reacted-hover: rgba(67, 56, 202, 0.5);

            --comments-color-border: rgb(221, 221, 221);

            --comments-color-text:white;
            --comments-color-text-dimmed: rgb(164, 164, 164);
            --comments-color-text-inverse: white;

            --comments-color-accent: rgba(67, 56, 202);
            --comments-color-accent-hover: rgba(67, 56, 202, 0.75);

            --comments-color-danger: rgb(225, 29, 72);
            --comments-color-danger-hover: rgb(225, 29, 72, 0.75);

            --comments-color-success: rgb(10, 200, 134);
            --comments-color-success-hover: rgb(10, 200, 134, 0.75);

            --comments-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        /*fix for auto-resize textarea */
        .tab-pane {
            height: 0;
            overflow: hidden;
            display: block !important;
        }

        .tab-pane.active {
            height: auto;
            overflow: visible;
        }
    </style>
    @livewireStyles
    <x-comments::styles />

    <div id="appCapsule" class="full-height">
        <div>
            <img class="profile-banner" src="/img/profile-banner.png" />
        </div>
        <div class="mx-3 mt-5">
        <div class="card glass">
        <div class="section mt-2">
            <div class="profile-head">
                <div class="avatar">
                    <img src="/img/ws_icon.jpg" alt="avatar" class="imaged  profile-image">
                </div>
                <div class="in">
                    <h3 class="name">{{$child->initials}}
                        @if ($child->SRA)
                            <span class="badge SRA-badge bg-success">SRA</span>
                        @endif

                    </h3>
                    <h3 class="subtext">

                        <!-- <ion-icon name="home-outline"
                                  class="text-primary headericon_mic"></ion-icon>&nbsp; -->
                                  {{$child->get_home->name}}

                    </h3>
                </div>
            </div>
        </div>

        <div class="section full mt-2 border-top">
            <div class="profile-stats ps-2 pe-2 py-3">
                <a href="#" class="item">
                    <strong>{{$child->DOB}} ({{Carbon\Carbon::parse($child->DOB)->diff(Carbon\Carbon::now())->y}})</strong>Date of Birth
                </a>
                <a href="#" class="item">
                    <strong>{{$child->get_medicationentries_count}}</strong>Medication Entries
                </a>
                <a href="#" class="item">
                    <strong>{{$incidents->Count()}}</strong>Incident Entries
                </a>

                <!--  <a href="#" class="item">
                      <strong>506</strong>following
                  </a>
                  -->
            </div>
        </div>
        </div>
        </div>
        
       

    <!--
        <div class="section">
            <div class="profile-info">
                <div class=" bio">
                    <span style="color: white;">Notes: </span>{{$child->notes}}
        </div>

    </div>
</div>
-->
        <div class="section full mt-2 mx-3">

            <ul class="nav nav-tabs capsuled" role="tablist" id="myTab">

                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#profile" role="tab" data-toggle="tab">
                        <!-- <ion-icon name="person-circle"></ion-icon> -->
                        <img src="/mobilekit/assets/img/user.svg" class="" style="width: 13px;" alt="image">
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#AW2" role="tab" data-toggle="tab">
                        <!-- <ion-icon name="apps-sharp"></ion-icon> -->
                        <img src="/mobilekit/assets/img/apps-menu.svg" class="" style="width: 13px;" alt="image">
                    </a>
                </li>

                <!--
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#AW" role="tab" data-toggle="tab">
                        <ion-icon name="apps-sharp"></ion-icon>

                    </a>
                </li>
                -->


                <!--
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#timeline" role="tab" data-toggle="tab">
                        <ion-icon name="time"></ion-icon>

                    </a>
                </li>
                -->

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#EOD" role="tab" data-toggle="tab">
                        <!-- <ion-icon name="document"></ion-icon> -->
                        <img src="/mobilekit/assets/img/document.svg" class="" style="width: 13px;" alt="image">
                    </a>
                </li>

                {{-- Hayden only --}}
                @if ($child->id == "3")
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#medication" role="tab" data-toggle="tab">
                            <ion-icon name="medical"></ion-icon>
                        </a>
                    </li>
                @endif

                {{-- HIDE INCIDENTS - TEMPORARY
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#incidents" role="tab" data-toggle="tab">
                        <ion-icon name="clipboard"></ion-icon>

                    </a>
                </li>
                --}}

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#safetyplan" onclick="autosize($('.autoResize'));" role="tab" data-toggle="tab">
                        <!-- <ion-icon name="briefcase"></ion-icon> -->
                        <img src="/mobilekit/assets/img/briefcase.svg" class="" style="width: 13px;" alt="image">
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#expenses" onclick="autosize($('.autoResize'));" role="tab" data-toggle="tab">
                        <!-- <ion-icon name="cash"></ion-icon> -->
                        <img src="/mobilekit/assets/img/box-dollar.svg" class="" style="width: 13px;" alt="image">
                    </a>
                </li>

            </ul>

        </div>


        <!-- tab content -->
        <div class="section full mx-3 mt-2 mb-0">
            <div class="tab-content">

                <!-- Profile -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <div class="card p-2">
                    <h3 class="">Profile Information</h3>
                        <div class=" pb-1 pt-2">

                        <form>
                            <div class="form-group boxed">
                                <div class="input-wrapper d-web-inline">
                                    <label class="form-label" for="name5">Initials:</label>
                                    <input disabled type="text" class="form-control" id="name5" placeholder="Initials"
                                           autocomplete="off" value="{{$child->initials}}">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>

                            <div class="form-group boxed">
                                <div class="input-wrapper d-web-inline">
                                    <label class="form-label" for="email5">Date of Birth:</label>
                                    <input disabled type="text" class="form-control" id="name5" placeholder="Initials"
                                           autocomplete="off" value="{{$child->DOB}}">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>

                            <div class="form-group boxed">
                                <div class="input-wrapper d-web-inline">
                                    <label class="form-label" for="email5">Assigned Home:</label>
                                    <input disabled type="text" class="form-control" id="name5" placeholder="Home"
                                           autocomplete="off" value="{{$child->get_home->name}}">
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>

                            <div class="form-group boxed">
                                <div class="input-wrapper d-web-inline">
                                    <label class="form-label" for="notes">Notes:</label>
                                    <textarea disabled class="form-control autoResize" id="notes" placeholder="Notes..."
                                              autocomplete="off" value="{{$child->notes}}">{{$child->notes}}</textarea>
                                    <i class="clear-input">
                                        <ion-icon name="close-circle"></ion-icon>
                                    </i>
                                </div>
                            </div>

                            <div class="form-group boxed">
                                <div class="input-wrapper d-web-inline">
                                    <label class="form-label" for="upcomingShifts">Upcoming Shifts (24 Hours)</label>

                                    @if ($getUpcomingShifts->count() == 0)
{{--                                      No shifts available in next 24 hours--}}
                                        <div class=" autoResize" id="upcomingShifts" placeholder="" >
                                            <ul id="upcomingShiftsUL" class="">
                                                <li class="">N/A</li>
                                            </ul>

                                        </div>
                                    @endif

                                    @if ($getUpcomingShifts->count() > 0 && !$showOnlyNextShift)
                                        <div class="" id="upcomingShifts" placeholder=""  >
                                        <ul id="upcomingShiftsUL" class="">
                                    @foreach ($getUpcomingShifts as $shift)
                                            @php $CYSW_Profile =\App\Models\CYSW_Profile_Model::where('fk_UserID','=',$shift->get_user->id)->first();
                                            @endphp
                                            @if($CYSW_Profile)
                                                @php
                                                    $raw_phone = preg_replace('/\D/', '', $CYSW_Profile->cellular);
                                                    $temp = str_split($raw_phone);
                                                    $phone_number = "";
                                            for ($x=count($temp)-1;$x>=0;$x--) {
                                                if ($x === count($temp) - 5 || $x === count($temp) - 8 || $x === count($temp) - 11) {
                                                    $phone_number = "-" . $phone_number;
                                                }

                                                $phone_number = $temp[$x] . $phone_number;
                                            }
                                            if ($phone_number == "") {
                                            $phone_number = "N/A";
                                            }
                                                @endphp
                                            @endif
                                           <li>{{$shift->get_user->name}} (<a href="tel:{{$phone_number}}">{{$phone_number}}</a>) @ {{Carbon\Carbon::parse($shift->start)->toDayDateTimeString()}} - {{Carbon\Carbon::parse($shift->end)->format('g:i A')}}</li>
{{--                                            <script>$('#upcomingShifts').html($('#upcomingShifts').html() + '{{$shift->get_user->name}} ({{$phone_number}}) @ {{Carbon\Carbon::parse($shift->start)->toDayDateTimeString()}} - {{Carbon\Carbon::parse($shift->end)->format('g:i A')}}&#13;&#10');</script>--}}
                                        @endforeach
                                        </ul>
                                        </div>
                                    @endif


                                    @if ($getUpcomingShifts->count() > 0 && $showOnlyNextShift)
                                        <div id="upcomingShifts" >
                                            <ul id="upcomingShiftsUL" class="">
                                                @php $CYSW_Profile =\App\Models\CYSW_Profile_Model::where('fk_UserID','=',$getUpcomingShifts->first()->get_user->id)->first();
                                                @endphp
                                                @if($CYSW_Profile)
                                                    @php
                                                        $raw_phone = preg_replace('/\D/', '', $CYSW_Profile->cellular);
                                                        $temp = str_split($raw_phone);
                                                        $phone_number = "";
                                                for ($x=count($temp)-1;$x>=0;$x--) {
                                                    if ($x === count($temp) - 5 || $x === count($temp) - 8 || $x === count($temp) - 11) {
                                                        $phone_number = "-" . $phone_number;
                                                    }

                                                    $phone_number = $temp[$x] . $phone_number;
                                                }
                                                if ($phone_number == "") {
                                                $phone_number = "N/A";
                                                }


                                                @endphp


                                                @endif
                                                <li>{{$getUpcomingShifts->first()->get_user->name}} (<a href="tel:{{$phone_number}}">{{$phone_number}}</a>) @ {{Carbon\Carbon::parse($getUpcomingShifts->first()->start)->toDayDateTimeString()}} - {{Carbon\Carbon::parse($getUpcomingShifts->first()->end)->format('g:i A')}}</li>
                                            </ul>
                                        </div>
                                            @endif




                                </div>
                            </div>


                        </form>

                    </div>
                    </div>
                  
                    
                </div>
                <!-- * Profile -->

                <!-- AW2.0 -->
                <div class="tab-pane fade" id="AW2" role="tabpanel">
                    <div class="card p-2 pt-1">
                    <ul class="listview image-listview">
                        <li>
                            <div class="item pb-0 pt-0">

                                <div class="in">
                                    <div class="mb-0 pb-0">
                                        <h3 class="today-shift">Activity Wall</h3>
                                        <!-- <div class="text-muted">05:20 AM</div> -->
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    {{--<livewire:comments :model="$child" newest-first />--}}
                   <div class="mt-1">
                       @livewire('custom-comments.comments-component', ['model' => $child, 'newestFirst' => true, 'showAvatar' => true])
                   </div>
                    </div>
                    

                    <script>



                        window.addEventListener('new_image_filename', event => {
                            // $("#previewImage").html("Image Preview: <img src='/storage/" + event.detail.filename.substring(7) + "' width='200px' />");
                            $("#commentBox").html("<figure><figcaption>Enter Caption</figcaption><br /><br /><img src='/storage/" + event.detail.filename.substring(7) + "' height='300px' /></figure>");
                            //alert('New image: ' + event.detail.filename.substring(7));
                            console.log (event);
                            //$("#summernote111").summernote('code', "Image: <br />  src='/storage/" + event.detail.filename.substring(7) + "' style='width:400px'  />");
                            $("#btnAddImage").hide();

                        });


                        window.addEventListener('new_video_filename', event => {
                            // $("#previewImage").html("Image Preview: <img src='/storage/" + event.detail.filename.substring(7) + "' width='200px' />");
                            $("#commentBox").html("<figure><figcaption>Enter Caption</figcaption><video height='300' controls><source src='/storage/" + event.detail.filename.substring(7) + "'> Your browser does not support the video tag.</video>");

                            //alert('New image: ' + event.detail.filename.substring(7));
                            console.log (event);
                            //$("#summernote111").summernote('code', "Image: <br />  src='/storage/" + event.detail.filename.substring(7) + "' style='width:400px'  />");
                            $("#btnAddImage").hide();

                        });
                        window.addEventListener('empty_comment', event => {
                            // $("#previewImage").html("Image Preview: <img src='/storage/" + event.detail.filename.substring(7) + "' width='200px' />");
                            $("#commentBox").html("");
                            // location.reload();
                            $("#btnAddImage").show();

                        });


                        $('#commentBox').on('input', (e) => {
                            // your code here
                            console.log (e.target.innerHTML)
                            Livewire.emit('UpdateText',e.target.innerHTML);
                            Livewire.emit('UpdateReplyText',e.target.innerHTML);

                        });

                    </script>
                    <x-comments::scripts />

                </div>

                <!-- * AW2.0 -->

                <!-- AW -->
                {{--
                <div class="tab-pane fade" id="AW" role="tabpanel">
                    <ul class="listview image-listview">
                        <li>
                            <div class="item pb-0">

                                <div class="in">
                                    <div class="mb-0 pb-0">
                                        <h3 class="today-shift">Activity Wall</h3>
                                        <!-- <div class="text-muted">05:20 AM</div> -->
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    @livewire('mobile.activity-wall', ['user' => $user, 'child' => $child])
                </div>
                    --}}
                <!-- * AW -->

                <!--  Timeline -->

                <div class="tab-pane fade" id="timeline" role="tabpanel">
                    <div>
                        <ul class="listview image-listview">
                            <li>
                                <div class="item pb-0">

                                    <div class="in">
                                        <div class="mb-0 pb-0">
                                            <h3 class="">TIMELINE</h3>

                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        @if ($timeline_data->count() >= 0)
                            <div class="timeline timed">




                                @foreach ($timeline_data as $details)
                                        <div class="item">
                                            <span class="time"><i class="far fa-clock"></i> {{ $diff = Carbon\Carbon::parse($details->updated_at)->diffForHumans(Carbon\Carbon::now()) }}</span>

                                            {{--

                                        @if ($details->event == "Message")
                                            <div class="dot bg-primary"></div>

                                        @endif
                                        @if ($details->event == "Photo")
                                                <div class="dot bg-danger"></div>
                                        @endif

                                            --}}

                                            @if ($details->event == "IR")
                                                <div class="dot bg-danger"></div>
                                            @endif

                                            @if ($details->event == "Medication")
                                                <div class="dot bg-primary"></div>
                                            @endif

                                            @if ($details->event == "EndOfShiftForm")

                                                <div class="dot bg-primary"></div>
                                            @endif

                                            @if ($details->event == "ShiftSignIn")

                                                <div class="dot bg-success"></div>

                                            @endif

                                            @if ($details->event == "ShiftSignOut")

                                                <div class="dot bg-warning"></div>

                                            @endif
                                            <div class="content">

                                                {{--
                                            @if ($details->event == "Message")
                                                    <span class="title text-primary">{{App\Models\User::getUser($details->causer_id)->name}} </span> posted a message to <span class="text-danger">{{App\Models\Child::getChild($details->subject_id)->initials}}'s</span> Activity Wall
                                                    <div class="text"> {{$details->description}}</div>


                                            @endif

                                            @if ($details->event == "Photo")
                                                    <h4 class="title">{{App\Models\User::getUser($details->causer_id)->name}}</h4> posted a photo to {{App\Models\Child::getChild($details->subject_id)->initials}}
                                                    's Activity Wall
                                                    <div class="text"> <div class="col-md-8"><a
                                                                href="/storage/activities_photos/{{substr($details->description,25)}}"><img
                                                                    width="50%"
                                                                    src="/storage/activities_photos/{{substr($details->description,25)}}"/></a>
                                                        </div>
                                                    </div>

                                            @endif
                                                --}}

                                                @if ($details->event == "IR")

                                                    <span class="title text-primary">{{App\Models\User::getUser($details->causer_id)->name}} </span> submitted an <a href="IR_Entry?id={{substr($details->properties, 1,-1)}}&childID={{$child->id}}">Incident Report</a></span>
                                                    <div class="text"> Incident Type: {{$details->description}}</div>
                                                  @endif

                                                @if ($details->event == "Medication")
                                                    <span class="title text-primary">{{App\Models\User::getUser($details->causer_id)->name}} </span> submitted a Medication Entry
                                                    <div class="text"> Medication Type: {{$details->description}}</div>
                                                @endif

                                                @if ($details->event == "EndOfShiftForm")
                                                    <span class="title text-primary">{{App\Models\User::getUser($details->causer_id)->name}} </span> submitted an End of Shift Report
                                                    <div class="text"> @php
                                                            $eventDetails = json_decode($details->description, true);
                                                           //var_dump($eventDetails);

                                                        @endphp
                                                        @if ($eventDetails)
{{--                                                            Date/Time: {{ $eventDetails['datetime'] }} <br />--}}
{{--                                                            Mood Upon Arrival: {{ $eventDetails['mood_upon_arrival'] }} <br />--}}
{{--                                                            Interaction with Staff: {{ $eventDetails['interaction_with_staff'] }} <br />--}}
{{--                                                            General Observations: {{ $eventDetails['general_observations'] }} <br />--}}
{{--                                                            Dietary Notes: {{ $eventDetails['dietary_notes'] }}--}}
                                                        @endif
                                                    </div>
                                                @endif


                                                @if ($details->event == "ShiftSignIn")
                                                    <span class="title text-primary">{{App\Models\User::getUser($details->causer_id)->name}} </span> Signed In

                                                @endif

                                                @if ($details->event == "ShiftSignOut")
                                                    <span class="title text-primary">{{App\Models\User::getUser($details->causer_id)->name}} </span> Signed Out

                                                @endif
                                            </div>
                                        </div>
                                            @endforeach

                                        </div>
                                    </div>
                        @endif


                                    <!-- END timeline item -->




                    </div>

                <!-- * Timeline -->


                <!-- EOD -->
                 <div class="tab-pane fade" id="EOD" role="tabpanel">
                <div class="card p-2">
                <ul class="listview image-listview">
                    <li>
                        <div class="item pb-0 pt-0">

                            <div class="in">
                                <div class="mb-0 pb-0">
                                    <h3 class="today-shift">End Of Shift Form Entries</h3>
                                    <!-- <div class="text-muted">05:20 AM</div> -->
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                {{-- $EOD_forms --}}
                     <div id="EOD_entries" wire:ignore>
                         @if ($EOD_forms->count() > 0)



                             @foreach ($EOD_forms->sortByDesc('datetime')->groupBy(function ($item, $key) {
                                         return substr($item['datetime'],0,10);
                                     }) as $index=>$form)
                                 <ul class="listview image-listview media mb-2">
                                     <li class="multi-level">
                                         <a href="#" class="item">
                                         <img alt="Image" class="" src="/mobilekit/assets/img/briefcase-blue.svg" />
                                        &nbsp;
                                             {{$index}}
                                         </a>
                                         @foreach ($form as $form_entry)
                                             @php
                                             $entry_OriginalShift = App\Models\Shift::where('fk_ShiftFormID','=',$form_entry->id)->get()->first();
                                             $entry_user = App\Models\User::where("id", "=", $entry_OriginalShift->fk_UserID)->first();
                                             @endphp
                                             <ul class="listview link-listview">
                                                 <li>
                                                     <a href="/mobile/child/EOD_Viewer?id={{$form_entry->id}}" class="item">

                                                         <div wire:ignore class="imageWrapper">

                                                                 <ion-icon name="document" class="text-primary"></ion-icon>

                                                         </div>
                                                         <div class="in">
                                                             <div>
                                                                Form Entry
                                                                 <div class="text-muted">Last Updated at {{substr($form_entry->updated_at,11,5)}} by
                                                                     {{$entry_user->name}}</div>
                                                             </div>
                                                             <!-- <span  class="text-muted">View Entry</span> -->
                                                         </div>
                                                     </a>
                                                 </li>
                                             </ul>
                                         @endforeach
                                     </li>

                                 </ul>

                                 @endforeach

                                 </ul>
                                 {{-- $EOD_forms->links() --}}
                                 @else
                                     <p>No End of Shift Form Entries</p>
                                 @endif
                     </div>
                </div>
              


                 </div>
               <!-- * EOD -->


                @if ($child->id == "3")
                {{-- Hayden only --}}

                <!-- Medication -->
                <div class="tab-pane fade" id="medication" role="tabpanel">
                    <ul class="listview image-listview">
                        <li>
                            <div class="item pb-0">

                                <div class="in">
                                    <div class="mb-0 pb-0">
                                        <h3 class="">MEDICATION ENTRIES</h3>
                                        <!-- <div class="text-muted">05:20 AM</div> -->
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    @livewire('mobile.medication', ['user' => $user, 'child' => $child])

                </div>
                <!-- * Medication -->
                @endif

                {{-- HIDE INCIDENTS - TEMPORARY
                <!-- Incidents -->
                 <div class="tab-pane fade" id="incidents" role="tabpanel">
                    <ul class="listview image-listview">
                        <li>
                            <div class="item pb-0">

                                <div class="in">
                                    <div class="mb-0 pb-0">
                                        <h3 class="">INCIDENT REPORTS</h3>
                                        <!-- <div class="text-muted">05:20 AM</div> -->
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    @livewire('mobile.i-r', ['user' => $user, 'child' => $child])



                </div>
                <!-- * Incidents -->
                --}}

                <!-- Safety Plan -->
                <div class="tab-pane fade" id="safetyplan" role="tabpanel">
                    <div class="card p-2">
                    <ul class="listview image-listview">
                        <li>
                            <div class="item pb-0 pt-0">

                                <div class="in">
                                    <div class="mb-0 pb-0">
                                        <h3 class="today-shift">Safety Plan</h3>
                                        <!-- <div class="text-muted">05:20 AM</div> -->
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="section full mt-2 mb-2">
                        @livewire('mobile.l-v_-child-safety-plan', ['user' => $user, 'child' => $child])
                    </div>
                    </div>
                 
                </div>
                <!-- * Safety Plan -->


                <!-- Expense Creation -->
                <div class="tab-pane fade" id="expenses" role="tabpanel">
                    <div class="card p-2">
                    <ul class="listview image-listview">
                        <li>
                            <div class="item pb-0">
                                <div class="in">
                                    <div class="mb-0 pb-0">
                                        <h3 class="">Add Expense</h3>
                                    </div>
{{--                                    <span style="float:right;">--}}
{{--                                        <a href="#" class="btn btn-outline-primary btn-sm">Button Sample</a>--}}
{{--                                    </span>--}}
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="section full mt-2 mb-2">
                        @if($shiftIsSignedIn)
                            @livewire('mobile.expense.creation')
                        @else
                            <h4 style="height: 100px;text-align: center;" class="text-muted"> You need to sign in to your shift first! </h4>
                        @endif
                    </div>
                    </div>
                  

                  

                </div>
                <!-- * Expense Creation -->


            </div>
        </div>
        <!-- * tab content -->
        <!-- app footer -->
        <div class="appFooter pb-8 mt-0 ">
            <img src="/img/ws_blue.png" alt="icon" class="footer-logo mb-2">
            <div class="footer-title">
                Copyright © We-Schedule.ca <span class="yearNow"></span>. All Rights Reserved.
            </div>
        </div>
        <!-- * app footer -->
    </div>


    <!-- toast top iconed -->
    <div id="toast-success" class="toast-box toast-top">
        <div class="in">
            <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
            <div class="text">
                <span id="toast-success-message" name="toast-success-message">Saved</span>
            </div>
        </div>
        <!--        <button type="button" class="btn btn-sm btn-text-success close-button">CLOSE</button>
           -->
    </div>
    <!-- * toast top iconed -->

    <!-- toast top iconed -->
    <div id="toast-warning" class="toast-box toast-top">
        <div class="in">
            <ion-icon name="alert-circle" class="text-warning"></ion-icon>
            <div class="text">
                <span id="toast-warning-message" name="toast-warning-message">Error</span>
            </div>
        </div>
        <!--        <button type="button" class="btn btn-sm btn-text-success close-button">CLOSE</button>
           -->
    </div>




    <!-- * toast top iconed -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.js" ></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="  crossorigin="anonymous"></script>



    <script>

        $(function () {
/*
            const ptr = PullToRefresh.init({
                mainElement: 'body',
                onRefresh() {
                    var activeTab = window.localStorage.getItem('activeTab');
                    window.location.reload();
                }
            });
*/
            /* var queryPairs = window.location.href.split('?').pop().split('&');
             for (var i = 0; i < queryPairs.length; i++)
             {
                 var pair = queryPairs[i].split('=');
                 if (pair[1] == 'AW')
                 {
                     $('#myTab a[href="#activity"]').tab('show'); // Select tab by name

                     return;
                 }
                 if (pair[1] == 'SafetyPlan')
                 {
                     $('#myTab a[href="#safety_plan"]').tab('show'); // Select tab by name

                     return;
                 }

                 if (pair[1] == 'Profile')
                 {
                     $('#myTab a[href="#profile"]').tab('show'); // Select tab by name

                     return;
                 }
             }*/

            $('a[data-toggle="tab"]').on('click', function(e) {
                window.localStorage.setItem('activeTab', $(e.target).attr('href'));
               // console.log ('active tab set');
            });
            var activeTab = window.localStorage.getItem('activeTab');
            if (activeTab) {
                //console.log ('active tab found');
                $('#myTab a[href="' + activeTab + '"]').tab('show');
               // window.localStorage.removeItem("activeTab");
            }

        });



        function addActivityMessage($childID) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });

            if (document.getElementById('inputAddMessage').value != "") {


                $.ajax({
                    type: 'POST',
                    // url: "{{ route('activity.edit') }}",
                    url: "{{route('myshifts.edit')}}",
                    data: {
                        type: 'AddMessage',
                        UserID: {{Auth::id()}},
                        ChildID: $childID,
                        message: document.getElementById('inputAddMessage').value,

                    },
                    success: function (data) {

                        //close modal

                        //fire success toast
                        $("#toast-success-message").text('Message Posted to the Activity Wall');
                        toastbox('toast-success', 3000)
                    }
                });
            } else {

                //fire warning toast
                $("#toast-warning-message").text('Error Posting to the Activity Wall');

                toastbox('toast-warning', 3000)


            }

        }

        function AddIncidentEntry($id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });

            var arrayWhoWasNotified = []
            var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

            for (var i = 0; i < checkboxes.length; i++) {
                arrayWhoWasNotified.push(checkboxes[i].value)
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('myshifts.edit') }}",
                data: {
                    type: 'AddIncidentEntry',
                    fk_ChildID: $id,
                    child: document.getElementById('inputNameOfChild').value,
                    dob: document.getElementById('inputDOB').value,
                    date_of_placement: document.getElementById('inputDateofPlacement').value,
                    foster_home: document.getElementById('inputFosterHome').value,
                    placing_agency: document.getElementById('inputPlacingAgency').value,
                    legal_guardian: document.getElementById('inputLegalGuardian').value,
                    incident_type: document.getElementById('inputIncidentType').value,
                    serious_occurence: document.getElementById('inputSeriousOccurence').value,
                    level1_serious_occurence: document.getElementById('inputLevel1SeriousOccurence').value,
                    date_of_incident: document.getElementById('inputDateofIncident').value,
                    time_duration: document.getElementById('inputTimeDuration').value,
                    datetime_report_received: document.getElementById('inputDateTimeReportReceived').value,
                    location_of_incident: document.getElementById('inputLocationofIncident').value,
                    antecedent_leading_to_incident: document.getElementById('inputAntecedent').value,
                    description_of_incident: document.getElementById('inputDescription').value,
                    action_taken: document.getElementById('inputActionTaken').value,
                    who_was_notified: arrayWhoWasNotified,
                    physical_injuries: document.getElementById('inputPhysicalInjuries').value,
                    property_damage: document.getElementById('inputPropertyDamage').value,
                    comments: document.getElementById('inputComments').value

                },
                success: function (data) {

                    //close modal
                    $("#addIncidentModal").hide();

                    //fire success toast
                    $("#toast-success-message").text('Incident Entry added successfully.')
                    toastbox('toast-success', 3000)

                }
            });
        }


        /*
             function viewEOD(id) {

                 const $EOD_forms = @json($EOD_forms);

            //const $found = $staffArr.find(id => $eventDetails.extendedProps.fk_UserID);
            const $found = $EOD_forms.find((element) => element.id == id);

//            $('#mood_upon_arrival').val($found['mood_upon_arrival']);
            $('#mood_upon_arrival').val('test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test  555');
            $('#interaction_with_staff').val($found['interaction_with_staff']);
            $('#general_observations').val($found['general_observations']);
            $('#dietary_notes').val($found['dietary_notes']);

            $('#viewEODModal').modal('show');
            $('#viewEODModal').on('shown.bs.modal', function () {
                $('#mood_upon_arrival').trigger('focus');
            })
        }
*/
    </script>





    <script>

        document.addEventListener('autoResizeTextArea', event => {
            //console.log ('resized_textarea');
            autosize($('.autoResize'));



        });

        document.addEventListener('alpine:initialized', () => {
            console.log('alpine loaded');
            autosize($('.autoResize'));

        });


            document.addEventListener('livewire:load', function () {
                console.log ('loaded');
                autosize($('.autoResize'));
                console.log('ready3');


                document.addEventListener("DOMContentLoaded", () => {
                    Livewire.hook('component.initialized', (component) => {
                        console.log ('component.initalized');
                        autosize($('.autoResize'));



                    });

                    Livewire.hook('message.received', (component) => {
                    });
        });



        });
    </script>

    @livewireScripts



    <x-comments::scripts />
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

@stop
