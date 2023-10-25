
@extends('adminlte::page')


@section('title', 'We-Schedule')
<meta name="csrf-token" content="{{ csrf_token() }}">


@section('content_header')
<h1 class="m-0 text-dark">Calendar</h1>
@unless (Auth::check())
You are not signed in.
@endunless



@stop

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://unpkg.com/fullcalendar@5.10.1/main.js"></script>
    <!-- Popperjs -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <!-- Tempus Dominus JavaScript -->
    <script src="/plugins/tempus-dominusv6/js/tempus-dominus.js" crossorigin="anonymous"></script>

    <!-- Tempus Dominus Styles -->
    <link href="/plugins/tempus-dominusv6/css/tempus-dominus.css" rel="stylesheet" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
        .lnb-calendars-item {
            min-height: 12px;
            line-height: 12px;
            padding: 8px 0;
            font-size: 12px;
            padding-left: 6px;

        }

        input[type='checkbox'].tui-full-calendar-checkbox-square {
            display: none;
        }

        input[type='checkbox'].tui-full-calendar-checkbox-square + span {
            display: inline-block;
            cursor: pointer;
            line-height: 14px;
            margin-right: 8px;
            width: 14px;
            height: 14px;
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAAAAXNSR0IArs4c6QAAADpJREFUKBVjPHfu3O5///65MJAAmJiY9jCcOXPmP6kApIeJBItQlI5qRAkOVM5o4KCGBwqPkcxEvhsAbzRE+Jhb9IwAAAAASUVORK5CYII=) no-repeat;
            vertical-align: middle;
        }

        input[type='checkbox'].tui-full-calendar-checkbox-square:checked + span {
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAAAAXNSR0IArs4c6QAAAMBJREFUKBWVkjEOwjAMRe2WgZW7IIHEDdhghhuwcQ42rlJugAQS54Cxa5cq1QM5TUpByZfS2j9+dlJVt/tX5ZxbS4ZU9VLkQvSHKTIGRaVJYFmKrBbTCJxE2UgCdDzMZDkHrOV6b95V0US6UmgKodujEZbJg0B0ZgEModO5lrY1TMQf1TpyJGBEjD+E2NPN7ukIUDiF/BfEXgRiGEw8NgkffYGYwCi808fpn/6OvfUfsDr/Vc1IfRf8sKnFVqeiVQfDu0tf/nWH9gAAAABJRU5ErkJggg==) no-repeat;
        }

        input[type='checkbox'].tui-full-calendar-checkbox-round {
            display: none;
        }

        input[type='checkbox'].tui-full-calendar-checkbox-round + span {
            display: inline-block;
            cursor: pointer;
            width: 14px;
            height: 14px;
            line-height: 14px;
            vertical-align: middle;
            margin-right: 4px;
            border-radius: 8px;
            border: solid 2px;
            background: transparent;
        }

        .draft   {
            background-image: repeating-linear-gradient(45deg, #ccc, #ccc 30px, #dbdbdb 30px, #dbdbdb 60px );
            border-width: 3px;
            color: black !important;
        }

        .published  {
            background-image: initial ;
            background-size: initial;
            border-width: 1px;
            color: white !important;
        }

        .signed_in {
            background-image: initial;
            background-size: initial;
            border-width: 2px;

            animation: blinker 0.5s step-end infinite alternate;

        }

        @keyframes blinker {
            50% { border-color: green; }

        }
        /*
        .fc-scrollgrid-section-liquid {
            height: 1px !important;
        }
        */

       .fc-timegrid-slot {
            height: 0.2em !important;
        border-bottom: 0 !important;
        }
        .fc-basic-view .fc-body .fc-row {
            min-height: 3em !important;
        }

    </style>
<div class="row">
    <div class="col-2">
        <div class="card">
            <div class="card-body mx-0 px-0">

                  <!--
                    {!! Form::Label('staff_id', 'Staff Filter:') !!}
                    <select class="form-control" name="staff_id" id="staff_id">
                        <option value="All_Staff">All</option>
                        @foreach($staff as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                -->

                <div class="lnb-calendars-item " >
                    <label>
                        <input class="tui-full-calendar-checkbox-square" name="viewAll" id="viewAll" type="checkbox" value="all" checked>
                        <span></span>
                        <strong>View all</strong>
                    </label>
                </div>
                <div id="calendarStaff" name="calendarStaff">
                      @foreach($staff as $user)

                 <div class="lnb-calendars-item"><label>
                         <input type="checkbox" class="tui-full-calendar-checkbox-round" value="{{$user->id}}" checked>
                         @switch ($user->id)
                             @case (1)
                             <span style="border-color: blue; background-color: blue;"></span>
                             @break

                             @case (2)
                             <span style="border-color: red; background-color: red;"></span>
                             @break
                             @case (3)
                             <span style="border-color: green; background-color: green;"></span>                             @break
                             @case (4)
                             <span style="border-color: khaki; background-color: khaki;"></span>                             @break
                             @case (5)
                             <span style="border-color: orange; background-color: orange;"></span>                             @break
                             @case (6)
                             <span style="border-color: purple; background-color: purple;"></span>                             @break
                             @case (7)
                             <span style="border-color: cyan; background-color: cyan;"></span>                             @break
                             @case (8)
                             <span style="border-color: coral; background-color: coral;"></span>                             @break
                             @case (9)
                             <span style="border-color: goldenrod; background-color: goldenrod;"></span>                             @break
                             @case (10)
                             <span style="border-color: cadetblue; background-color: cadetblue;"></span>
                             @break

                             @case (11)
                             <span style="border-color: IndianRed; background-color: IndianRed;"></span>
                             @break
                             @case (12)
                             <span style="border-color: Lavender; background-color: Lavender;"></span>
                             @break
                             @case (13)
                             <span style="border-color: DeepPink; background-color: DeepPink;"></span>
                             @break
                             @case (14)
                             <span style="border-color: RebeccaPurple; background-color: RebeccaPurple;"></span>
                             @break
                             @case (15)
                             <span style="border-color: DarkSlateBlue; background-color: DarkSlateBlue;"></span>
                             @break
                             @case (16)
                             <span style="border-color: MediumSeaGreen; background-color: MediumSeaGreen;"></span>
                             @break
                             @case (17)
                             <span style="border-color: LightSteelBlue; background-color: LightSteelBlue;"></span>
                             @break
                             @case (18)
                             <span style="border-color: Maroon; background-color: Maroon;"></span>
                             @break
                             @case (19)
                             <span style="border-color: DarkCyan; background-color: DarkCyan;"></span>
                             @break
                             @case (20)
                             <span style="border-color: DarkRed; background-color: DarkRed;"></span>
                             @break
                             @default
                             <span style="border-color: navy; background-color: navy;"></span>                         @endswitch

                            <span>{{$user->name}}</span>
                            </label></div>


            @endforeach
                </div>
            <!--
                <div class="form-group col-3">
                    {!! Form::Label('home_id', 'Home Filter:') !!}
                <select class="form-control" name="home_id" id="home_id">
                    <option value="All_Homes">All</option>
@foreach($staff as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                </select>
            </div>
-->
            </div>
        </div>
    </div>
    <div class="col-10">
        <div class="card">
            <div class="card-body">



                    <div  id='calendar'></div>
            <!--
                <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-red">

                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
-->

                <script>
                    var calendar;
                    var calendarEl;



                    function stringToColour(str){
                        var hash = 0;
                        for(var i=0; i < str.length; i++) {
                            hash = str.charCodeAt(i) + ((hash << 3) - hash);
                        }
                        var color = Math.abs(hash).toString(16).substring(0, 6);

                        return "#" + '000000'.substring(0, 6 - color.length) + color;
                    }

                    const isDate = (date) => {
                        return (new Date(date) !== "Invalid Date") && !isNaN(new Date(date));
                    }
                    $(document).ready(function () {


                      $DT_frmAdd_start =  new tempusDominus.TempusDominus(document.getElementById('frmAdd_start'),
                          {
                              display:{
                                  sideBySide:true,
                              },
                              //promptTimeOnDateChange:true
                              keepInvalid:false,
                              hooks:{
                                  inputFormat:(context, date) => { return moment(date).format('MM/DD/YYYY h:mm A') },
                                  inputParse:(context, value) => {
                                      if (!isDate(value) ) {
                                          return  new tempusDominus.DateTime(new Date())
                                      } else {
                                          return new tempusDominus.DateTime(value)
                                      }
                                  }

                              }

                          }
                      );

                        const subscription = $DT_frmAdd_start.subscribe(tempusDominus.Namespace.events.error, (e) => {

                            console.log(e);
                            if (!e.date) {
                                //$DT_frmAdd_start.dates.setDate('2022-01-29');
                                alert ('invalid date');
                            }

                        });

                        document.getElementById('frmAdd_startInput').addEventListener("error", function() {window.alert ('error');});
                        document.getElementById('frmAdd_start').addEventListener("error", function() {window.alert ('TDerror');});

                        $DT_frmAdd_end =  new tempusDominus.TempusDominus(document.getElementById('frmAdd_end'),
                            {
                                display: {
                                    sideBySide:true,
                                },
                                //promptTimeOnDateChange:true
                                keepInvalid: false,
                                hooks: {
                                    inputFormat: (context, date) => {
                                        return moment(date).format('MM/DD/YYYY h:mm A')
                                    },
                                    inputParse: (context, value) => {
                                        if (!isDate(value)) {
                                            return new tempusDominus.DateTime(moment(new Date()).add(1, 'hour'))
                                        } else {
                                            return new tempusDominus.DateTime(value)
                                        }
                                    }
                                }
                            }

                        );
                        $DT_frmEdit_start =  new tempusDominus.TempusDominus(document.getElementById('frmEdit_start'),
                            {
                                display:{
                                    sideBySide:true,
                                },
                                //promptTimeOnDateChange:true
                                keepInvalid:false,
                                hooks:{
                                    inputFormat:(context, date) => { return moment(date).format('MM/DD/YYYY h:mm A') },
                                    inputParse:(context, value) => {
                                        if (!isDate(value) ) {
                                            return  new tempusDominus.DateTime(new Date())
                                        } else {
                                            return new tempusDominus.DateTime(value)
                                        }
                                    }

                                }

                            }
                        );

                        $DT_frmEdit_end =  new tempusDominus.TempusDominus(document.getElementById('frmEdit_end'),
                            {
                                display: {
                                    sideBySide:true,
                                },
                                //promptTimeOnDateChange:true
                                keepInvalid: false,
                                hooks: {
                                    inputFormat: (context, date) => {
                                        return moment(date).format('MM/DD/YYYY h:mm A')
                                    },
                                    inputParse: (context, value) => {
                                        if (!isDate(value)) {
                                            return new tempusDominus.DateTime(moment(new Date()).add(1, 'hour'))
                                        } else {
                                            return new tempusDominus.DateTime(value)
                                        }
                                    }
                                }
                            }

                        );


                        $('#frmEditModal').on('hidden.bs.modal', function(e)
                        {
                            //$(this).removeData();
                          //  $("#frmEditModal input").val("")
                            //calendar.fullCalendar('unselect');
                            calendar.unselect();

                        }) ;




                        $('#frmAddModal').on('hidden.bs.modal', function(e)
                        {

                          //  $("#frmAddModal input").val("")
                           // window.location.reload();

                            calendar.unselect();
                            //calendar.fullCalendar('unselect');

                            //$('#frmAdd_start').datetimepicker('destroy');
                            //$('#frmAdd_end').datetimepicker('destroy');



                        }) ;

                        //var staff_select = document.getElementById('staff_id').value;

                        var SITEURL = "{{ url('/') }}";

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        calendarEl = document.getElementById('calendar');
                        calendar = new FullCalendar.Calendar(calendarEl, {
                            eventTimeFormat: {
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true,
                                omitZeroMinute: false,
                                meridiem: 'narrow'
                            },
                            nextDayThreshold: '00:00',
                            slotMinTime: "00:00:00",
                            slotMaxTime: "23:59:00",

                            allDaySlot: false,
                            themeSystem: 'bootstrap',
                            eventOverlap: true,
                            weekNumbers: true,
                            firstDay: 1, //0 = Sunday
                            //weekText: "Week ",
                            lazyFetching: false,
                            //eventMaxStack: 2,
                            headerToolbar: {
                                left: 'dayGridMonth,dayGridWeek,dayGridDay,timeGridWeek,timeGridDay,listMonth',
                                center: 'title',
                                right: 'prevYear,prev,next,nextYear'
                            },

                            footerToolbar: {
                                left: 'publishAll',
                                center: '',
                                right: 'copySchedule'
                            },
                            customButtons: {
                                copySchedule: {
                                    text: 'Copy Schedule',
                                    click: function () {
                                        confirm('Would you like to copy this schedule to next week?');
                                    }
                                },
                                publishAll: {
                                    text: 'Publish This Week',
                                    click: function () {
                                        alert('[Batch Publish All Entries]');
                                    }
                                }
                            },

                            initialView: 'timeGridWeek',
                           // contentHeight: 800,
                            height: 'auto',
                           // aspectRatio: 1,

                            editable: true,
                            datesSet: function(dateInfo) {
                               // console.log (dateInfo);
                               // calendar.refetchEvents();
                                //calendar.render();
                                },
                            eventSources: [
                                //default get all records
                                //{
                                    //url: SITEURL + "/calendar/getRecords"

                                //},

                                    @foreach ($staff as $key=>$user)
                                {
                                    url: SITEURL + "/calendar/getRecords?id={{$user->id}}",
                                    //color: 'red',
                                    //color: stringToColour('{{$user->name}}')
                                    @switch ($user->id)
                                    @case (1)
                                        color: 'blue',
                                    @break

                                        @case (2)
                                    color: 'red',
                                    @break
                                        @case (3)
                                    color: 'green',
                                    @break
                                        @case (4)
                                    color: 'khaki',
                                    @break
                                        @case (5)
                                    color: 'orange',
                                    @break
                                        @case (6)
                                    color: 'purple',
                                    @break
                                        @case (7)
                                    color: 'cyan',
                                    @break
                                        @case (8)
                                    color: 'coral',
                                    @break
                                        @case (9)
                                    color: 'goldenrod',
                                    @break
                                        @case (10)
                                    color: 'cadetblue',
                                    @break
                                        @case (11)
                                    color: 'IndianRed',
                                    @break
                                        @case (12)
                                    color: 'Lavender',
                                    @break
                                        @case (13)
                                    color: 'DeepPink',
                                    @break
                                        @case (14)
                                    color: 'RebeccaPurple',
                                    @break
                                        @case (15)
                                    color: 'DarkSlateBlue',
                                    @break
                                        @case (16)
                                    color: 'MediumSeaGreen',
                                    @break
                                        @case (17)
                                    color: 'LightSteelBlue',
                                    @break
                                        @case (18)
                                    color: 'Maroon',
                                    @break
                                        @case (19)
                                    color: 'DarkCyan',
                                    @break
                                        @case (20)
                                    color: 'DarkRed',
                                    @break
                                    @default
                                    color: 'navy',
                                    @endswitch
                                },
                                @endforeach

                            ],
                            progressiveEventRendering: true,

                            eventDidMount: function(info) {
                               /*
                                if (info.event.extendedProps.published_status == "Draft") {
                                    //info.el.style.textColor="black";
                                    //info.el.style.color="black";
                                }

                                */
                               // console.log ('mounted: ' + info.el);
                            },
                            eventWillUnmount: function(info) {
                                //console.log ('unmounting: ' + info.el);
                            },

                            displayEventTime: true,
                            eventContent: function (arg) {
                              /*  var event = arg.event;


                                if (event.allDay === 'true') {
                                    event.allDay = true;
                                } else {
                                    event.allDay = false;
                                }
*/


                            },
                            selectable: true,
                            selectMirror: true,
                            select: function (selectionInfo) {

                                $("#frmAddModal").modal("show");

                                $("#frmAdd_child_assigned").val("Please select...");
                                $("#frmAdd_staff_assigned").val("Please select...");



                                //Initialize Date and time picker

                                $DT_frmAdd_start.dates.set(selectionInfo.start);
                                $DT_frmAdd_end.dates.set(selectionInfo.end);


                                console.log (selectionInfo);

                                //$('input[name=frmEdit_published_status]:checked').val();


                                    $("input[name=frmAdd_published_status][value='Draft']").prop('checked', true);
                                    $("input[name=frmAdd_published_status][value='Published']").prop('checked', false);




                                },


                            eventDrop: function (event, delta) {

                                //fix for Google Chrome and/or to ensure the start date and end date are formatted correctly
                                var start = moment(event.event.start).format('YYYY-MM-DD H:mm');
                                var end = moment(event.event.end).format('YYYY-MM-DD H:mm');

                                //var start = event.event.start;
                                //var end = event.event.end;


                                if (!end) {
                                    end = moment(event.event.start).add(1,'hour').format('YYYY-MM-DD H:mm')
                                }

                                $.ajax({
                                    url: SITEURL + '/calendarAjax',
                                    data: {
                                        title: event.event.title,
                                        start: start,
                                        end: end,
                                        id: event.event.id,
                                        fk_ChildID: event.event.extendedProps.fk_ChildID,
                                        fk_UserID: event.event.extendedProps.fk_UserID,
                                        published_status: event.event.extendedProps.published_status,
                                        type: 'update'
                                    },
                                    type: "POST",
                                    success: function (response) {
                                        displayMessage("Event Updated Successfully", "We-Schedule.ca");
                                        calendar.refetchEvents();
                                    },
                                    error: function (response) {
                                        displayErrorMessage("Event Update Error", "We-Schedule.ca");
                                        event.revert();
                                        calendar.refetchEvents();
                                    }

                                });
                            },
                            //eventContent: 'some text', //use this to add more content to the event text display

                                eventResize: function (eventResizeInfo) {
                                    //fix for Google Chrome and/or to ensure the start date and end date are formatted correctly
                                    var start = moment(event.event.start).format('YYYY-MM-DD H:mm');
                                    var end = moment(event.event.end).format('YYYY-MM-DD H:mm');


                                    $.ajax({
                                    url: SITEURL + '/calendarAjax',
                                    data: {
                                        title: eventResizeInfo.title,
                                        start: start,
                                        end: end,
                                        id: eventResizeInfo.event.id,
                                        fk_ChildID: eventResizeInfo.event.extendedProps.fk_ChildID,
                                        fk_UserID: eventResizeInfo.event.extendedProps.fk_UserID,
                                        published_status: eventResizeInfo.event.extendedProps.published_status,
                                        type: 'update'
                                    },
                                    type: "POST",
                                    success: function (response) {
                                        displayMessage("Event Updated Successfully", "We-Schedule.ca");
                                        calendar.refetchEvents();
                                      //  $('#frmEditModal').trigger("reset");


                                    }
                                });
                            },
                            eventClick: function (event) {
                                console.log('event clicked: ' + event.event.title + ", " + event.event.start + ", " + event.event.end)
                                //Initialize Date and time picker

                                $DT_frmEdit_start.dates.set(event.event.start);
                                $DT_frmEdit_end.dates.set(event.event.end);


                                $("#frmEdit_child_assigned").val(event.event.extendedProps.fk_ChildID);
                                $("#frmEdit_staff_assigned").val(event.event.extendedProps.fk_UserID);






                                //$('input[name=frmEdit_published_status]:checked').val();

                                if (event.event.extendedProps.published_status == "Draft") {
                                    $("input[name=frmEdit_published_status][value='Draft']").prop('checked', true);
                                    $("input[name=frmEdit_published_status][value='Published']").prop('checked', false);

                                }
                                if (event.event.extendedProps.published_status == "Published") {
                                    $("input[name=frmEdit_published_status][value='Draft']").prop('checked',false);
                                    $("input[name=frmEdit_published_status][value='Published']").prop('checked',true);

                                }

                                $("#frmEdit_id").val(event.event.id);
                                $("#frmEditModal").modal("show");

                            },

                            eventClassNames: function(arg) {

                                if (arg.event.extendedProps.published_status == "Draft") {
                                    return ['draft']
                                }
                                if (arg.event.extendedProps.signed_in) {
                                    return ['signed_in']
                                }

                                else {
                                    return ['']
                                }

                            }

                        });




                        calendar.render();


                        function displayMessage(message) {
                            toastr.success(message, 'We-Schedule.ca');
                        }

                        function displayErrorMessage(message) {
                            toastr.error(message, 'We-Schedule.ca');
                        }

                        $('#viewAll').change (function (e) {
                            var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarStaff input'));

                            if (!this.checked) {
                                //uncheck all
                                calendarElements.forEach(function(input) {
                                    input.checked = false;
                                    input.nextElementSibling.style.backgroundColor = "transparent";
                                });
                            } else {
                                //check all
                                calendarElements.forEach(function(input) {
                                    input.checked = true;
                                    input.nextElementSibling.style.backgroundColor = input.nextElementSibling.style.borderColor;
                                });
                            }


                            });

                        $('input[type="checkbox"]').change(function (e) {

                            var calendarId = e.target.value;
                            var checked = e.target.checked;
                            var viewAll = document.querySelector('#viewAll');
                            var calendarElements = Array.prototype.slice.call(document.querySelectorAll('#calendarStaff input'));
                            var allCheckedCalendars = true;

                            /*
                            if (calendarId === 'all') {
                                allCheckedCalendars = checked;

                                calendarElements.forEach(function(input) {
                                    var span = input.parentNode;
                                    input.checked = checked;
                                    span.style.backgroundColor = checked ? span.style.borderColor : 'transparent';
                                });

                                CalendarList.forEach(function(calendar) {
                                    calendar.checked = checked;
                                });
                            } else {
                               // findCalendar(calendarId).checked = checked;

                                allCheckedCalendars = calendarElements.every(function(input) {
                                    return input.checked;
                                });

                                if (allCheckedCalendars) {
                                    viewAll.checked = true;
                                } else {
                                    viewAll.checked = false;
                                }
                            }
*/
                            //var span = input.parentNode;
                            if (checked) {
                                //uncheck element
                                e.target.nextElementSibling.style.backgroundColor = e.target.nextElementSibling.style.borderColor;


                            }

                            if (!checked) {
                                //check element
                                e.target.nextElementSibling.style.backgroundColor = "transparent";
                            }
                            //calendar.removeAllEvents();
                            calendar.removeAllEventSources();
var color = "";
                            calendarElements.forEach(function(input) {
                                var span = input.parentNode;
                               if (input.checked) {
                                   switch (input.value) {
                                       case "1":
                                           var color = 'blue';
                                           break;

                                       case "2":
                                           var color = 'red';
                                           break;

                                       case "3":
                                           var color = 'green';
                                           break;

                                       case "4":
                                           var color = 'khaki';
                                           break;

                                       case "5":
                                           var color = 'orange';
                                           break;

                                       case "6":
                                           var color = 'purple';
                                           break;

                                       case "7":
                                           var color = 'cyan';
                                           break;

                                       case "8":
                                           var color = 'coral';
                                           break;

                                       case "9":
                                           var color = 'goldenrod';
                                           break;

                                       case "10":
                                           var color = 'cadetblue';
                                           break;

                                       default:
                                           var color = 'navy';
                                   }
                                   calendar.addEventSource({
                                       url: SITEURL + "/calendar/getRecords?id=" + input.value,
                                       color: color
                                   })

                               }

                            });


                        });

                        $('#staff_id').on('change', function () {
                            calendar.removeAllEvents();
                            calendar.removeAllEventSources();
                            calendar.addEventSource(SITEURL + "/calendar/getRecords?id=" + this.value)

                            calendar.refetchEvents();
                        });





                    });
                    function addModalSubmit() {
                        var SITEURL = "{{ url('/') }}";

                        if (!isDate($DT_frmAdd_start._input.value) || !isDate($DT_frmAdd_end._input.value)) {
                            alert ('Please enter valid dates for both Shift Start & Shift End');
                        } else {
                            $.ajax({
                                url: SITEURL + '/calendarAjax',
                                data: {
                                    //title: $("#frmEdit_child_assigned").val(),
                                    start: $("#frmAdd_start").find("input").val(),
                                    end: $("#frmAdd_end").find("input").val(),
                                    fk_ChildID: $("#frmAdd_child_assigned").val(),
                                    fk_UserID: $("#frmAdd_staff_assigned").val(),
                                    published_status: $('input[name=frmAdd_published_status]:checked').val(),
                                    type: 'add'
                                },
                                type: "POST",
                                success: function (response) {
                                    toastr.success("Event Created Successfully", 'We-Schedule.ca');
                                    calendar.refetchEvents();
                                    $("#frmAddModal").modal("hide");


                                }
                            });
                        }
                    }



                    function editModalSubmit() {
                        var SITEURL = "{{ url('/') }}";


                        $.ajax({
                            url: SITEURL + '/calendarAjax',
                            data: {
                                //title: $("#frmEdit_child_assigned").val(),
                                id: $("#frmEdit_id").val(),
                                start: $("#frmEdit_start").find("input").val(),
                                end: $("#frmEdit_end").find("input").val(),
                                fk_ChildID: $("#frmEdit_child_assigned").val(),
                                fk_UserID: $("#frmEdit_staff_assigned").val(),
                                published_status: $('input[name=frmEdit_published_status]:checked').val(),
                                type: 'update'
                            },
                            type: "POST",
                            success: function (response) {
                                toastr.success("Event Updated Successfully", 'We-Schedule.ca');

                                calendar.refetchEvents();
                                //calendar.fullCalendar('unselect');

                                $("#frmEditModal").modal("hide");

                            }
                        });

                    }

                    function editModalDelete() {
                        var SITEURL = "{{ url('/') }}";
                        var delConfirm = confirm("Are you sure you want to delete this shift?");
                        if (delConfirm == true) {
                            $.ajax({
                                url: SITEURL + '/calendarAjax',
                                data: {
                                    //title: $("#frmEdit_child_assigned").val(),
                                    id: $("#frmEdit_id").val(),
                                    type: 'delete'
                                },
                                type: "POST",
                                success: function (response) {
                                    toastr.success("Event Deleted Successfully", 'We-Schedule.ca');

                                    calendar.refetchEvents();

                                    $("#frmEditModal").modal("hide");

                                }
                            });
                        }


                    }
                </script>

            </div>

            <!-- Modal frmAdd -->
            <div class="modal fade" id="frmAddModal" tabindex="-1" role="dialog" aria-labelledby="frmAddModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-blue">
                            <span class="modal-title" id="mymodelLabel">Add Shift</span>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                        </div>

                        <div class="modal-body">

                            <form id="frmAddEvent" >
                                <input type="hidden" id="frmAdd_id" name="frmAdd_id" />
                                <div class="form-group">
                                    <label for="title">Child Assigned</label>
                                    <select class="form-control" name="frmAdd_child_assigned" id="frmAdd_child_assigned" wire:model="shift">

                                        @foreach($children as $child)
                                            <option value="{{$child->id}}">{{$child->initials}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="title">CYSW Assigned</label>
                                    <select class="form-control" name="frmAdd_staff_assigned" id="frmAdd_staff_assigned" wire:model="shift">

                                        @foreach($staff as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Shift Start</label>
                                    <div class="input-group" id="frmAdd_start" data-td-target-input='nearest' data-td-target-toggle='nearest'>
                                        <input id='frmAdd_startInput' type='text' class='form-control' data-td-target='#frmAdd_start'
                                        />
                                       <span class='input-group-text' data-td-target='#frmAdd_start' data-td-toggle='frmAdd_start'>
                                            <span class='fas fa-calendar'></span>
                                       </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Shift End</label>
                                    <div class="input-group" id="frmAdd_end" data-td-target-input='nearest' data-td-target-toggle='nearest'>
                                        <input id='frmAdd_endInput' type='text' class='form-control' data-td-target='#frmAdd_end'
                                        />
                                        <span class='input-group-text' data-td-target='#frmAdd_end' data-td-toggle='frmAdd_end'>
                                            <span class='fas fa-calendar'></span>
                                       </span>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <label>Published Status</label><br />
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="frmAdd_published_status" name="frmAdd_published_status" value="Draft">
                                        <label for="radioPrimary1">
                                            Draft
                                        </label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="frmAdd_published_status" name="frmAdd_published_status" value="Published">
                                        <label for="radioPrimary2">
                                            Published
                                        </label>
                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" onclick="addModalSubmit();" class="btn btn-primary" >Save & Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->

            </div>

                <!-- Modal frmEdit-->

                <div class="modal fade" id="frmEditModal" tabindex="-1" role="dialog" aria-labelledby="frmEditModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-blue">
                                <span class="modal-title" id="mymodelLabel">Edit Shift</span>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>

                            <div class="modal-body">

                                <form id="frmEditEvent" >
                                    <input type="hidden" id="frmEdit_id" name="frmEdit_id" />
                                    <div class="form-group">
                                        <label for="title">Child Assigned</label>
                                        <select class="form-control" name="frmEdit_child_assigned" id="frmEdit_child_assigned" wire:model="shift">

                                            @foreach($children as $child)
                                                <option value="{{$child->id}}">{{$child->initials}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="title">CYSW Assigned</label>
                                        <select class="form-control" name="frmEdit_staff_assigned" id="frmEdit_staff_assigned" wire:model="shift">

                                            @foreach($staff as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Shift Start</label>
                                        <div class="input-group" id="frmEdit_start" data-td-target-input='nearest' data-td-target-toggle='nearest'>
                                            <input id='frmEdit_startInput' type='text' class='form-control' data-td-target='#frmEdit_start'
                                            />
                                            <span class='input-group-text' data-td-target='#frmEdit_start' data-td-toggle='frmEdit_start'>
                                            <span class='fas fa-calendar'></span>
                                       </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Shift End</label>
                                        <div class="input-group" id="frmEdit_end" data-td-target-input='nearest' data-td-target-toggle='nearest'>
                                            <input id='frmEdit_endInput' type='text' class='form-control' data-td-target='#frmEdit_end'
                                            />
                                            <span class='input-group-text' data-td-target='#frmEdit_end' data-td-toggle='frmEdit_end'>
                                            <span class='fas fa-calendar'></span>
                                       </span>
                                        </div>
                                    </div>

                                    <div class="form-group clearfix">
                                        <label>Published Status</label><br />
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="frmEdit_published_status" name="frmEdit_published_status" value="Draft">
                                            <label for="radioPrimary1">
                                            Draft
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="frmEdit_published_status" name="frmEdit_published_status" value="Published">
                                            <label for="radioPrimary2">
                                            Published
                                            </label>
                                        </div>

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button" onclick="editModalDelete();" class="btn btn-danger" >Delete Shift</button>
                                        <button type="button" onclick="editModalSubmit();" class="btn btn-primary" >Save & Submit</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->

            </div>
        </div>

</div>


@stop
