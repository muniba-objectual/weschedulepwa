@extends('adminlte::page')

@section('title', 'We-Schedule')
<meta name="csrf-token" content="{{ csrf_token() }}">


@section('content_header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://unpkg.com/fullcalendar@5.11.0/main.js"></script>
    <!-- Popperjs -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous">
    </script>
    <!-- Tempus Dominus JavaScript -->
    <script src="/plugins/tempus-dominusv6/js/tempus-dominus.js" crossorigin="anonymous"></script>

    <!-- Tempus Dominus Styles -->
    <link href="/plugins/tempus-dominusv6/css/tempus-dominus.css" rel="stylesheet" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- contextMenu plugin -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" />


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

        input[type='checkbox'].tui-full-calendar-checkbox-square+span {
            display: inline-block;
            cursor: pointer;
            line-height: 14px;
            margin-right: 8px;
            width: 14px;
            height: 14px;
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAAAAXNSR0IArs4c6QAAADpJREFUKBVjPHfu3O5///65MJAAmJiY9jCcOXPmP6kApIeJBItQlI5qRAkOVM5o4KCGBwqPkcxEvhsAbzRE+Jhb9IwAAAAASUVORK5CYII=) no-repeat;
            vertical-align: middle;
        }

        input[type='checkbox'].tui-full-calendar-checkbox-square:checked+span {
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAAAAXNSR0IArs4c6QAAAMBJREFUKBWVkjEOwjAMRe2WgZW7IIHEDdhghhuwcQ42rlJugAQS54Cxa5cq1QM5TUpByZfS2j9+dlJVt/tX5ZxbS4ZU9VLkQvSHKTIGRaVJYFmKrBbTCJxE2UgCdDzMZDkHrOV6b95V0US6UmgKodujEZbJg0B0ZgEModO5lrY1TMQf1TpyJGBEjD+E2NPN7ukIUDiF/BfEXgRiGEw8NgkffYGYwCi808fpn/6OvfUfsDr/Vc1IfRf8sKnFVqeiVQfDu0tf/nWH9gAAAABJRU5ErkJggg==) no-repeat;
        }

        input[type='checkbox'].tui-full-calendar-checkbox-round {
            display: none;
        }

        input[type='checkbox'].tui-full-calendar-checkbox-round+span {
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

        .draft {
            background-image: repeating-linear-gradient(45deg, #ccc, #ccc 30px, #dbdbdb 30px, #dbdbdb 60px);
            border-width: 3px;
            color: black !important;
        }

        .published {
            background-image: initial;
            background-size: initial;
            border-width: 1px;
            color: white !important;
        }

        .signed_in {
            background-image: initial;
            background-size: initial;

            border-width: 10px;

            animation: blinker 2.0s step-end infinite alternate;


        }

        @keyframes blinker {
            50% {
                border-color: green;
            }

        }

        select.filter {
            width: 500px !important;
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

        .username_rotate {

            float: left !important;
            transform: rotate(90deg) !important;
            display: inline-block !important;
            margin-top: 10px !important;
            height: 150px !important;
            /*margin-left: -97px !important;*/
            margin-left: -85px !important
        }

        .fc-timegrid-event .fc-event-time {
            white-space: normal !important;
        }

        .fc-event-time {
            white-space: normal !important;

        }

        .fc-event-main {

            /*
                                                                                                                                transform: rotate(90deg) !important;
                                                                                                                                float: left !important;
                                                                                                                                height: 15% !important;
                                                                                                                                margin-top: 25% !important;
                                                                                                                               */

        }

        .fc-event-title-container {

            /*
                                                                                                                                transform: rotate(90deg) !important;
                                                                                                                                float: left !important;
                                                                                                                                height: 15% !important;
                                                                                                                                margin-top: 20% !important;
                                                                                                                                */

        }


        .event-hidden {
            display: none;
        }

        .validated {
            background-image: url("/img/validated.png") !important;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100px;

        }

        .completed {
            background-image: url("/img/completed.png") !important;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100px;

        }

        .exception_pastEventModified {

            border-width: 10px !important;
            border-color: black !important;
            color: white !important;


        }

        .placeholder-event {

            border-width: 5px !important;
            border-color: red !important;
            color: white !important;


        }
    </style>

    <h1 class="m-0 text-dark">Calendar</h1>
    @unless(Auth::check())
        You are not signed in.
    @endunless


    <script>
        var calendar;
        var calendarEl;

        var SITEURL = "{{ url('/') }}";

        function submitGoToWeek() {



            calendar.gotoDate(moment().week($(".popover-body .gotoweek-week").val()).year($(".popover-body .gotoweek-year")
                    .val())
                .startOf('isoWeek').isoWeekday(
                    1).format('YYYY-MM-DD'));
        }

        function frmCopySubmit() {
            $("#frmCopyTitle").text("Copy Shifts from Week: " + moment(calendar.getDate()).isoWeek());

            $tmpEvents = calendar.getEvents();
            $numberOfWeeks = $("#frmCopy_weeks").val();
            // alert (document.getElementById("frmCopy_child").value);
            $tmpEvents.forEach(batchPublish);

            function batchPublish(tmpEvent) {

                for (i = 1; i <= $numberOfWeeks; i++) {
                    var currentWeekNumber_based_on_currentDay_in_calendar = moment(calendar.getDate()).isoWeek();
                    var startWeekNumber = moment(tmpEvent.start).isoWeek();
                    // console.log("week number of event: " + startWeekNumber);
                    // console.log("startWeekNumber = " + startWeekNumber);
                    // console.log("currentWeekNumber_based... = " + currentWeekNumber_based_on_currentDay_in_calendar);
                    // console.log("tmpEvent.ext...fk_ChildID = " + tmpEvent.extendedProps.fk_ChildID);
                    // console.log("frmCopy_child.val = " + document.getElementById("frmCopy_child").value);
                    // console.log("tmpEvent..ext...published_status = " + tmpEvent.extendedProps.published_status);

                    if ((startWeekNumber == currentWeekNumber_based_on_currentDay_in_calendar) && (tmpEvent.extendedProps
                            .fk_ChildID == document.getElementById("frmCopy_child").value)
                        /*&& (tmpEvent.extendedProps
                                                   .published_status == "Published")*/
                    ) { //we have a match for the week number
                        $newStart = moment(tmpEvent.start).clone().add(7 * i, 'days').format('YYYY-MM-DD H:mm');

                        $newEnd = moment(tmpEvent.end).clone().add(7 * i, 'days').format('YYYY-MM-DD H:mm');



                        $.ajax({
                            url: SITEURL + '/calendarAjax',
                            data: {
                                title: tmpEvent.title,
                                start: $newStart,
                                end: $newEnd,
                                //id: tmpEvent.id,
                                fk_ChildID: tmpEvent.extendedProps.fk_ChildID,
                                fk_UserID: tmpEvent.extendedProps.fk_UserID,
                                published_status: 'Draft',
                                type: 'add'
                            },
                            type: "POST",
                            success: function(response) {
                                displayMessage("Event Copied Successfully", "We-Schedule.ca");
                                calendar.refetchEvents();
                                $("frmCopyModal").modal('hide');
                            },
                            error: function(response) {
                                displayErrorMessage("Event Copy Error", "We-Schedule.ca");
                                event.revert();
                                calendar.refetchEvents();
                                $("frmCopyModal").modal('hide');

                            }

                        });
                    }

                }

            }

            // console.log($tmpEvents);
        }


        //syncronize css animations from css-animation-sync
        //https://stackoverflow.com/questions/4838972/how-to-sync-css-animations-across-multiple-elements
        const defaultOptions = {
            graceful: true
        };

        function sync(animationName, options = {}) {
            const opts = {
                ...defaultOptions,
                ...options
            };

            const elements = new Set();
            let eventTime;
            let lastInterationTS = now();
            let interationDuration = 0;

            function animationStart(event) {
                if (event.animationName === animationName) {
                    const el = event.target;

                    if (opts.graceful && !elements.has(el) && interationDuration !== 0) {
                        gracefulStart(el, interationDuration, lastInterationTS);
                    }

                    elements.add(el);
                }
            }

            function animationIteration(event) {
                if (event.animationName === animationName) {
                    elements.add(event.target);

                    requestAnimationFrame(frameTime => {
                        if (frameTime !== eventTime) {
                            interationDuration = now() - lastInterationTS;
                            lastInterationTS = now();
                            restart(elements);
                        }

                        eventTime = frameTime;
                    });
                }
            }


            window.addEventListener('animationstart', animationStart, true);
            window.addEventListener('animationiteration', animationIteration, true);


            return {
                free() {
                    window.removeEventListener('animationstart', animationStart);
                    window.removeEventListener('animationiteration', animationIteration);

                    this.start();
                    elements.clear();
                },

                start() {
                    elements.forEach(el => {
                        if (validate(elements, el)) {
                            el.style.removeProperty('animation');
                        }
                    });
                },

                stop() {
                    elements.forEach(el => {
                        if (validate(elements, el)) {
                            el.style.setProperty('animation', 'none');
                        }
                    });
                },

                pause() {
                    elements.forEach(el => {
                        if (validate(elements, el)) {
                            el.style.setProperty('animation-play-state', 'paused');
                        }
                    });
                }
            };
        }


        function restart(elements) {
            elements.forEach(el => {
                if (window.getComputedStyle(el).animationPlayState !== 'paused') {
                    if (validate(elements, el)) {
                        el.style.setProperty('animation', 'none');
                    }
                }
            });

            requestAnimationFrame(() => {
                elements.forEach(el => {
                    if (window.getComputedStyle(el).animationPlayState !== 'paused') {
                        if (validate(elements, el)) {
                            el.style.removeProperty('animation');
                        }
                    }
                });
            });
        }


        function gracefulStart(el, interationDuration, lastInterationTS) {
            const remaining = interationDuration - (now() - lastInterationTS);
            el.style.setProperty('animation-duration', remaining);
        }


        function now() {
            return (new Date()).getTime();
        }


        function validate(elements, el) {
            const isValid = document.body.contains(el);
            if (!isValid) {
                elements.delete(el);
            }
            return isValid;
        }


        const animationController = sync("blinker", {
            graceful: true
        });
        /* window.setInterval(() => acimationController.start(), 8000);
         */


        $(document).ready(function() {


            $("#frmEdit_staff_assigned").on('change', function() {
                if ($(this).val() == null || $(this).val() == 999) {
                    $("input[name=frmEdit_published_status][value='Draft']").prop('checked', true);
                    $("input[name=frmEdit_published_status][value='Published']").prop('checked', false);

                    $("input[name=frmEdit_published_status][value='Published']").parent().toggleClass(
                        "d-none", true);
                    $("input[name=frmEdit_published_status][value='Published']").parent().toggleClass(
                        "d-inline", false);
                } else {
                    $("input[name=frmEdit_published_status][value='Published']").parent().toggleClass(
                        "d-none", false);
                    $("input[name=frmEdit_published_status][value='Published']").parent().toggleClass(
                        "d-inline", true);
                }
            })



            //initialize selective dropdown for Child Assigned / CYSW Assigned (Add Shift/Edit f Modals)
            $("#frmEdit_child_assigned").on('change', function() {
                var childID = $(this).val();
                if (childID) {
                    $.ajax({
                        url: '/calendar/getCYSWbyChildID?childID=' + childID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#frmEdit_staff_assigned').empty();




                            $.each(data, function(key, value) {
                                $('#frmEdit_staff_assigned').append('<option value="' +
                                    value.id + '">' + value.name + '</option>');
                            });
                            if ($('#frmEdit_staff_assigned').has('option').length == 0) {
                                $('#frmEdit_staff_assigned').append(
                                    '<option disabled value="">No CYSWs have been assigned.</option>'
                                );
                                // $('#frmEdit_staff_assigned').attr('disabled', 'disabled');
                            } else {

                                $("input[name=frmEdit_published_status][value='Published']")
                                    .parent().toggleClass("d-none", false);
                                $("input[name=frmEdit_published_status][value='Published']")
                                    .parent().toggleClass("d-inline", true);
                                $('#frmEdit_staff_assigned').removeAttr('disabled');
                            }
                            $('#frmEdit_staff_assigned').removeAttr('disabled');
                            $('#frmEdit_staff_assigned').append(
                                '<option value="999">PLACEHOLDER</option>');
                        }

                    });
                } else {
                    $('#frmEdit_staff_assigned').empty();
                }
            });


            //initialize select2
            $('#type_filter').on('select2:select', function(e) {
                const $selected = $('#type_filter').select2('data');

                //calendar.refetchEvents();
                //console.log($selected);

                calendar.removeAllEvents();
                calendar.removeAllEventSources();



                $selected.forEach(addEventsBySelected);

                function addEventsBySelected(item, index, arr) {
                    const $staffArr = @json($staff);

                    const $found = $staffArr.find((element) => element.id == item.id);
                    if (!$found) {
                        calendar.addEventSource({
                            url: SITEURL + "/calendar/getRecords?id=" + item.id,
                            color: 'blue'
                        })
                    } else {

                        calendar.addEventSource({
                            url: SITEURL + "/calendar/getRecords?id=" + item.id,
                            color: $found.calendarColor
                        })
                    }


                }


                calendar.refetchEvents();
            });

            $('#type_filter').on('select2:unselect', function(e) {
                const $selected = $('#type_filter').select2('data');
                calendar.removeAllEvents();
                calendar.removeAllEventSources();

                if ($selected.length === 0) {
                    //alert ('selected is blank');
                    const $staffArr = @json($staff);

                    $staffArr.forEach(addEventsBySelected);

                } else {
                    $selected.forEach(addEventsBySelected);
                }



                function addEventsBySelected(item, index, arr) {
                    var test222 = "";
                    var color = "";

                    const $staffArr = @json($staff);
                    console.log($staffArr)

                    const $found = $staffArr.find((element) => element.id == item.id);
                    if (!$found) {
                        calendar.addEventSource({
                            url: SITEURL + "/calendar/getRecords?id=" + item.id,
                            color: 'blue'
                        })
                    } else {

                        calendar.addEventSource({
                            url: SITEURL + "/calendar/getRecords?id=" + item.id,
                            color: $found.calendarColor
                        })
                    }

                }
            });


            $("#children_filter").on("select2:unselect select2:clear", function(e) {
                // calendar.removeAllEventSources();


                const $selected = $('#type_filter').select2('data');

                //$selected.forEach(updateFilter);
                //filterBasedOnChildren();
                calendar.refetchEvents();
            });



            $("#type_filter").select2({
                placeholder: "Filter CYSWs",
                allowClear: true,
                templateResult: formatState,
                templateSelection: formatStateSelection,
            });


            $("#children_filter").select2({
                placeholder: "Filter Children",
                allowClear: true
            });

            $("#children_filter").on("select2:select select2:unselect select2:clearing", function(e) {

                calendar.refetchEvents();
                //filterBasedOnChildren();
            });

            $("#published_filter").select2({
                placeholder: "Filter Published Status",
                allowClear: true
            });

            $("#signedin_filter").select2({
                placeholder: "Filter Children",
                allowClear: true
            });
            //end of initialize

            $DT_frmEdit_start = new tempusDominus.TempusDominus(document.getElementById('frmEdit_start'), {
                display: {
                    sideBySide: true,
                },
                //promptTimeOnDateChange:true
                keepInvalid: false,
                hooks: {
                    inputFormat: (context, date) => {
                        return moment(date).format('MM/DD/YYYY h:mm A')
                    },
                    inputParse: (context, value) => {
                        if (!isDate(value)) {
                            return new tempusDominus.DateTime(new Date())
                        } else {
                            return new tempusDominus.DateTime(value)
                        }
                    }

                }

            });

            $DT_frmEdit_end = new tempusDominus.TempusDominus(document.getElementById('frmEdit_end'), {
                display: {
                    sideBySide: true,
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
            });


            $('#frmEditModal').on('hidden.bs.modal', function(e) {
                //$(this).removeData();
                //  $("#frmEditModal input").val("")
                //calendar.fullCalendar('unselect');
                calendar.unselect();

            });


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

                nextDayThreshold: '00:00:00',

                slotMinTime: "00:00:00",
                slotMaxTime: "23:59:59",
                allDaySlot: false,
                themeSystem: 'bootstrap',
                eventOverlap: true,
                // weekNumbers: true,
                weekNumbers: "ISO",
                firstDay: 1, //0 = Sunday
                //weekText: "Week ",
                lazyFetching: false,
                forceEventDuration: true,
                //eventMaxStack: 2,

                loading: function(isLoading, view) {
                    if (isLoading) { // isLoading gives boolean value
                        //show your loader here
                        $('#loadingIndicator').show();
                    } else {
                        //hide your loader here
                        $('#loadingIndicator').hide();
                        $(".fc-gotoWeekNumber-button").popover({
                            placement: 'bottom',
                            html: true,
                            title: function() {
                                return $("#popover-head").html();
                            },
                            content: function() {
                                return $("#message_popover_content span.form-inline")
                                    .clone()
                            },

                            container: 'body'
                        });


                        $(".gotoweek-week").val(moment(calendar.getDate()).isoWeek())
                        $(".gotoweek-year").val(moment(calendar.getDate()).year()).change();
                        console.log($(".gotoweek-year").val())
                    }
                },
                headerToolbar: {
                    left: 'dayGridMonth,dayGridWeek,dayGridDay,timeGridWeek,timeGridDay,listMonth',
                    center: 'title',
                    right: 'prevWeek,gotoWeekNumber,nextWeek prev,next'
                },

                @if (auth()->user()->user_type == '3.4')

                    footerToolbar: {
                        left: '',
                        center: 'gotoYear',
                        right: ''
                    },
                @else

                    footerToolbar: {
                        left: 'publishAll',
                        center: 'gotoYear fivedayweek',
                        right: 'copySchedule'
                    },
                @endif

                customButtons: {
                    fivedayweek: {
                        text: 'Toggle Weekends',
                        click: function() {

                            calendar.setOption('weekends', !calendar.getOption('weekends'));
                        }
                    },
                    gotoYear: {
                        text: 'Go-to Year',
                        click: function() {
                            enterYear = prompt('Please enter the week year:');
                            if (enterYear) {
                                // console.log (moment().week(weekNum).startOf('week').isoWeekday(1));

                                calendar.gotoDate(moment().year(enterYear).startOf('month').isoWeekday(
                                    1).format('YYYY-MM-DD'));
                            }
                        }
                    },
                    prevWeek: {
                        text: '«',
                        click: function() {

                            lWeek = moment(calendar.getDate()).isoWeek() - 1
                            lYear = lWeek < 1 ? moment(calendar.getDate()).year() - 1 : moment(calendar
                                .getDate()).year()

                            calendar.gotoDate(moment().week(lWeek).year(lYear)
                                .startOf('isoWeek').isoWeekday(
                                    1).format('YYYY-MM-DD'));
                        }
                    },
                    nextWeek: {
                        text: '»',
                        click: function() {
                            lWeek = moment(calendar.getDate()).isoWeek() + 1
                            lYear = lWeek > 52 ? moment(calendar.getDate()).year() + 1 : moment(calendar
                                .getDate()).year()

                            calendar.gotoDate(moment().week(lWeek).year(lYear)
                                .startOf('isoWeek').isoWeekday(
                                    1).format('YYYY-MM-DD'));
                        }
                    },
                    gotoWeekNumber: {
                        text: 'Go-to Week #',
                        click: function() {
                            /*  weekNum = prompt('Please enter the week number:');
                              if (weekNum) {
                                  // console.log (moment().week(weekNum).startOf('week').isoWeekday(1));

                                  calendar.gotoDate(moment().week(weekNum).startOf('isoWeek').isoWeekday(
                                      1).format('YYYY-MM-DD'));
                              }*/
                        }
                    },
                    copySchedule: {
                        text: 'Copy Schedule',
                        click: function() {
                            $("#frmCopyTitle").text("Copy Shifts from Week " + moment(calendar
                                .getDate()).isoWeek());
                            $("#frmCopyModal").modal('show');
                        }
                    },
                    publishAll: {
                        text: 'Publish This Week',
                        click: function() {

                            $answer = window.prompt("Which week number would you like to publish?",
                                moment(calendar.getDate()).isoWeek());
                            $tmpEvents = calendar.getEvents();
                            $tmpEvents.forEach(batchPublish);

                            function batchPublish(tmpEvent) {
                                var startWeekNumber = moment(tmpEvent.start).isoWeek();
                                // console.log("week number of event: " + startWeekNumber);

                                //fix for Google Chrome and/or to ensure the start date and end date are formatted correctly
                                var start = moment(tmpEvent.start).format('YYYY-MM-DD H:mm');
                                var end = moment(tmpEvent.end).format('YYYY-MM-DD H:mm');


                                if ((startWeekNumber == $answer) && (tmpEvent.extendedProps
                                        .published_status == "Draft"
                                    ) && tmpEvent.extendedProps.fk_UserID !=
                                    999) { //we have a match for the week number
                                    // tmpEvent.setExtendedProp('published_status', 'Published');
                                    $.ajax({
                                        url: SITEURL + '/calendarAjax',
                                        data: {
                                            title: tmpEvent.title,
                                            start: start,
                                            end: end,
                                            id: tmpEvent.id,
                                            fk_ChildID: tmpEvent.extendedProps.fk_ChildID,
                                            fk_UserID: tmpEvent.extendedProps.fk_UserID,
                                            published_status: 'Published',
                                            type: 'update'
                                        },
                                        type: "POST",
                                        success: function(response) {
                                            displayMessage("Event Updated Successfully",
                                                "We-Schedule.ca");
                                            calendar.refetchEvents();
                                        },
                                        error: function(response) {
                                            displayErrorMessage("Event Update Error",
                                                "We-Schedule.ca");
                                            event.revert();
                                            calendar.refetchEvents();
                                        }

                                    });
                                }
                            }

                            // console.log($tmpEvents);
                        }
                    }
                },

                initialView: 'timeGridWeek',
                // contentHeight: 800,
                height: 'auto',
                // aspectRatio: 1,

                @if (auth()->user()->user_type == '3.4')

                    editable: false,
                    eventStartEditable: false,
                    selectable: false,
                @else

                    editable: true,
                    selectable: true,
                @endif

                eventSources: [
                    //default get all records
                    //{
                    //url: SITEURL + "/calendar/getRecords"

                    //},


                    @foreach ($staff as $key => $user)
                        {
                            url: SITEURL + "/calendar/getRecords?id={{ $user->id }}",
                            //color: 'red',
                            //color: stringToColour('{{ $user->name }}')
                            color: '{{ $user->calendarColor ?? 'blue' }}',
                        },
                    @endforeach

                ],
                progressiveEventRendering: true,

                eventDidMount: function(info) {
                    filterBasedOnChildren();
                    const eventId = info.event.id;
                    $(info.el).attr('calendar-eventID', eventId);

                    info.el.addEventListener("contextmenu", (jsEvent) => {
                        jsEvent.preventDefault()
                    })

                },

                displayEventTime: true,
                eventContent: function(arg) {
                    var event = arg.event;

                    if (arg.event.extendedProps.get_user) {
                        var view = calendar.view;
                        if (view.type == "timeGridWeek") {


                            // e.find('.fc-title').css('display', 'inline-block');
                            return {
                                html: "<div class='fc-event-time'>" + arg.timeText + "<br />" + arg
                                    .event.title + "<div class='username_rotate'>" + "" + arg.event
                                    .extendedProps.get_user.name + "</div></div>"
                            }

                        } else {
                            return {
                                html: "<div class='fc-event-time'>" + arg.timeText + "<br />" + "<b>" +
                                    arg.event.title + "</b><div>[" + arg.event.extendedProps.get_user
                                    .name + "]</div></div>"
                            }
                        }
                    } else {
                        return {
                            html: "<div class='fc-event-time'>" + arg.timeText + "<br />" + arg.event
                                .title + "</div>"
                        }
                    }

                },
                selectMirror: true,
                select: function(selectionInfo) {
                    $('#frmEdit_staff_assigned').attr('disabled', true);
                    $("#frmEditModal").modal("show");
                    $("#frmEditModal .edit-modal").hide();
                    $("#frmEditModal .add-modal").show();

                    $("#frmEdit_child_assigned").val("Please select...");
                    $("#frmEdit_staff_assigned").val("Please select...");

                    $DT_frmEdit_start.dates.set(selectionInfo.start);
                    $DT_frmEdit_end.dates.set(selectionInfo.end);


                    $("input[name=frmEdit_published_status][value='Draft']").prop('checked', true);
                    $("input[name=frmEdit_published_status][value='Published']").prop('checked', false);


                },

                eventDrop: eventBoxEdit,
                eventResize: eventBoxEdit,
                eventClick: function(event) {

                    $("#frmEditModal").modal("show");
                    $("#frmEditModal .edit-modal").show();

                    $("#frmEditModal .add-modal").hide();

                    //read only for 3.4
                    @if (auth()->user()->user_type == '3.4')
                        $("#frmEditModal :input").attr("disabled", true);
                        $("#frmEditButtonClose").attr("disabled", false);
                    @endif

                    $DT_frmEdit_start.dates.set(event.event.start);
                    $DT_frmEdit_end.dates.set(event.event.end);

                    $("#frmEdit_child_assigned").val(event.event.extendedProps.fk_ChildID);

                    //$("#frmEdit_child_assigned").trigger('change');
                    $.ajax({
                        url: '/calendar/getCYSWbyChildID?childID=' + event.event.extendedProps
                            .fk_ChildID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#frmEdit_staff_assigned').empty();
                            $.each(data, function(key, value) {
                                if (value.id == event.event.extendedProps
                                    .fk_UserID) {
                                    $('#frmEdit_staff_assigned').append(
                                        '<option selected value="' + value.id +
                                        '">' + value.name + '</option>');
                                } else {
                                    $('#frmEdit_staff_assigned').append(
                                        '<option value="' + value.id + '">' +
                                        value.name + '</option>');
                                }

                            });
                            if ($('#frmEdit_staff_assigned').has('option').length == 0) {
                                $('#frmEdit_staff_assigned').append(
                                    '<option value="">No CYSWs have been assigned.</option>'
                                );
                            } else {
                                $("input[name=frmEdit_published_status][value='Published']")
                                    .parent().toggleClass("d-none", false);
                                $("input[name=frmEdit_published_status][value='Published']")
                                    .parent().toggleClass("d-inline", true);
                                $('#frmEdit_staff_assigned').removeAttr('disabled');
                            }
                            $('#frmEdit_staff_assigned').removeAttr('disabled');
                            if (999 == event.event.extendedProps
                                .fk_UserID) {
                                $('#frmEdit_staff_assigned').append(
                                    '<option value="999" selected>PLACEHOLDER</option>');
                                $("#frmEdit_staff_assigned").trigger("change")
                            } else
                                $('#frmEdit_staff_assigned').append(
                                    '<option value="999">PLACEHOLDER</option>');
                        }

                    });

                    if (event.event.extendedProps.published_status == "Draft") {
                        $("input[name=frmEdit_published_status][value='Draft']").prop('checked', true);
                        $("input[name=frmEdit_published_status][value='Published']").prop('checked',
                            false);

                    }
                    if (event.event.extendedProps.published_status == "Published") {
                        $("input[name=frmEdit_published_status][value='Draft']").prop('checked', false);
                        $("input[name=frmEdit_published_status][value='Published']").prop('checked',
                            true);

                    }

                    $("#frmEdit_id").val(event.event.id);

                },

                eventClassNames: function(arg) {


                    var types = $("#children_filter").val();
                    if (types.length > 0) {

                        if (!types.includes(arg.event.title)) {
                            return ['event-hidden'];

                        }
                    }

                    var $filter_by_CYSW = $("#type_filter").val();

                    if ($filter_by_CYSW.length > 0) {
                        if (!$filter_by_CYSW.includes(String(arg.event.extendedProps.fk_UserID))) {
                            return ['event-hidden'];

                        }
                    }

                    if (arg.event.extendedProps.exception_pastEventModified) {
                        if (arg.event.extendedProps.validated) {
                            return ['exception_pastEventModified', 'validated', 'context-menu']
                        } else {
                            return ['exception_pastEventModified', 'context-menu']
                        }
                    }

                    if (arg.event.extendedProps.fk_UserID == 999) {
                        return ['placeholder-event', 'draft', 'context-menu']

                    }

                    if (arg.event.extendedProps.published_status == "Draft") {
                        return ['draft', 'context-menu']
                    }

                    if (arg.event.extendedProps.validated) {
                        return ['validated', 'context-menu']
                    }
                    if (arg.event.extendedProps.status == "Ended - Pending Verification" || arg.event
                        .extendedProps.status == "Ended - Incomplete" || arg.event.extendedProps
                        .status == "Ended - Complete") {
                        return ['completed', 'context-menu']
                    }

                    if (arg.event.extendedProps.signed_in) {
                        return ['signed_in', 'context-menu']
                    } else {
                        return ['context-menu']
                    }

                }

            });


            calendar.render();


            $('#viewAll').change(function(e) {
                var calendarElements = Array.prototype.slice.call(document.querySelectorAll(
                    '#calendarStaff input'));

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
                        input.nextElementSibling.style.backgroundColor = input.nextElementSibling
                            .style.borderColor;
                    });
                }


            });

            $('input[type="checkbox"]').change(function(e) {

                var calendarId = e.target.value;
                var checked = e.target.checked;
                var viewAll = document.querySelector('#viewAll');
                var calendarElements = Array.prototype.slice.call(document.querySelectorAll(
                    '#calendarStaff input'));
                var allCheckedCalendars = true;

                //var span = input.parentNode;
                if (checked) {
                    //uncheck element
                    e.target.nextElementSibling.style.backgroundColor = e.target.nextElementSibling.style
                        .borderColor;


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

                            case "11":
                                color = 'IndianRed';
                                break;
                            case "12":
                                color = 'Lavender';
                                break;
                            case "13":
                                color = 'DeepPink';
                                break;
                            case "14":
                                color = 'RebeccaPurple';
                                break;
                            case "15":
                                color = 'DarkSlateBlue';
                                break;
                            case "16":
                                color = 'MediumSeaGreen';
                                break;
                            case "17":
                                color = 'LightSteelBlue';
                                break;
                            case "18":
                                color = 'Maroon';
                                break;
                            case "19":
                                color = 'DarkCyan';
                                break;
                            case "20":
                                color = 'DarkRed';
                                break;

                            case "21":
                                color = 'blue';
                                break;

                            case "22":
                                color = 'red';
                                break;

                            case "23":
                                color = 'green';
                                break;

                            case "24":
                                color = 'khaki';
                                break;
                            case "25":
                                color = 'orange';
                                break;
                            case "26":
                                color = 'purple';
                                break;
                            case "27":
                                color = 'cyan';
                                break;
                            case "28":
                                color = 'coral';
                                break;
                            case "29":
                                color = 'goldenrod';
                                break;
                            case "30":
                                color = 'cadetblue';
                                break;
                            case "31":
                                color = 'IndianRed';
                                break;
                            case "32":
                                color = 'Lavender';
                                break;
                            case "33":
                                color = 'DeepPink';
                                break;
                            case "34":
                                color = 'RebeccaPurple';
                                break;
                            case "35":
                                color = 'DarkSlateBlue';
                                break;
                            case "36":
                                color = 'MediumSeaGreen';
                                break;
                            case "37":
                                color = 'LightSteelBlue';
                                break;
                            case "38":
                                color = 'Maroon';
                                break;
                            case "39":
                                color = 'DarkCyan';
                                break;
                            case "40":
                                color = 'DarkRed';
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

            $('#staff_id').on('change', function() {
                calendar.removeAllEvents();
                calendar.removeAllEventSources();
                calendar.addEventSource(SITEURL + "/calendar/getRecords?id=" + this.value)

                calendar.refetchEvents();
            });


        });

        function eventBoxEdit(event) {
            //fix for Google Chrome and/or to ensure the start date and end date are formatted correctly
            var start = moment(event.event.start).format('YYYY-MM-DD H:mm');
            var end = moment(event.event.end).format('YYYY-MM-DD H:mm');

            if (!end) {
                end = moment(event.event.start).add(1, 'hour').format('YYYY-MM-DD H:mm')
            }
            var exception_pastEventModified = event.event.extendedProps.exception_pastEventModified;

            if (moment(event.event.start).isBefore(moment()) && event.event.extendedProps.published_status == "Published") {

                exception_pastEventModified = "1";
                do {
                    var $exceptionReason = "";

                    $exceptionReason = window.prompt('What is the reason for modifying this entry (in the past)?');
                    if ($exceptionReason == null || $exceptionReason === "") {
                        alert("Exception Reason cannot be blank.");
                        $exceptionReason = window.prompt('What is the reason for modifying this entry (in the past)?');

                    }
                } while ($exceptionReason === "")

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
                    validated: event.event.extendedProps.validated,
                    type: 'update',
                    exception_pastEventModified: exception_pastEventModified,
                    exceptionReason: $exceptionReason

                },
                type: "POST",
                success: function(response) {
                    displayMessage("Event Updated Successfully", "We-Schedule.ca");
                    calendar.refetchEvents();
                },
                error: function(response) {
                    displayErrorMessage("Event Update Error", "We-Schedule.ca");
                    event.revert();
                    calendar.refetchEvents();
                }

            });
        }

        @if (auth()->user()->user_type == '3.4')
        @else
            $.contextMenu({

                selector: '.context-menu',


                items: {
                    /*
                     "edit": {name: "Edit", icon: "edit"},
                     "cut": {name: "Cut", icon: "cut"},
                     copy: {name: "Copy", icon: "copy"},
                     "paste": {name: "Paste", icon: "paste"},
                     "delete": {name: "Delete", icon: "delete"},


                    "sep1": "---------",
                     */

                    "validate": {
                        name: "Validate Shift",
                        icon: "fa-check",
                        callback: function(itemKey, opt, e) {
                            var m = "Validate was clicked";
                            window.console && console.log(m);
                            // console.log ($(this));
                            $eventDetails = calendar.getEventById(opt.$trigger.attr('calendar-eventID'));

                            if ($eventDetails.extendedProps.validated == "1") {
                                window.alert('Warning: This shift has already been validated.');
                                $("#btnValidateShift").attr('disabled', "disabled");
                                $("#btnValidateShift").html('Shift Validated');

                                //return;
                            }

                            if ($eventDetails.extendedProps.status != "Ended - Pending Verification" &&
                                $eventDetails.extendedProps.status != "Ended - Incomplete") {
                                window.alert('Shifts can only be validated once they have ended.');
                                return;
                            }
                            $("#frmValidate_id").val($eventDetails.id);
                            $("#frmValidate_fkUserID").val($eventDetails.extendedProps.fk_UserID);
                            $("#frmValidate_fkChildID").val($eventDetails.extendedProps.fk_ChildID);
                            $("#frmValidate_exception_pastEventModified").val($eventDetails.extendedProps
                                .exception_pastEventModified);


                            $("#frmValidate_child_assigned").val($eventDetails.title);
                            const $staffArr = @json($staff);

                            //const $found = $staffArr.find(id => $eventDetails.extendedProps.fk_UserID);
                            const $found = $staffArr.find((element) => element.id == $eventDetails.extendedProps
                                .fk_UserID);
                            $("#frmValidate_staff_assigned").val($found.name);
                            $("#frmValidate_start").val(moment($eventDetails.start).format('YYYY-MM-DD H:mm'));

                            $("#frmValidate_actual_start").val($eventDetails.extendedProps.actual_shift_start);

                            $("#frmValidate_end").val(moment($eventDetails.end).format('YYYY-MM-DD H:mm'));

                            $("#frmValidate_actual_end").val($eventDetails.extendedProps.actual_shift_end);

                            $("#frmValidate_Total_Scheduled_Hours").val(moment($eventDetails.end).diff(moment(
                                $eventDetails.start), 'hours'));
                            $("#frmValidate_Total_Actual_Hours").val(moment($eventDetails.extendedProps
                                .actual_shift_end).diff(moment($eventDetails.extendedProps
                                .actual_shift_start), 'hours'));

                            $diff = $("#frmValidate_Total_Scheduled_Hours").val() - $(
                                "#frmValidate_Total_Actual_Hours").val();
                            if ($diff < 0) {

                                $("#lblShiftAutoCalculation").css("color", "red");
                                $("#lblShiftAutoCalculation").text("Shift was OVERWORKED by " + ($diff * -1) +
                                    " hour(s).");
                            }

                            if ($diff > 0) {
                                $("#lblShiftAutoCalculation").css("color", "blue");
                                $("#lblShiftAutoCalculation").text("Shift was UNDERWORKED by " + $diff +
                                    " hour(s).");
                            }

                            if ($diff == 0) {
                                $("#lblShiftAutoCalculation").css("color", "green");
                                $("#lblShiftAutoCalculation").text("Shift was worked as per scheduled hours.");
                            }


                            $("#frmValidateModal").modal("show");

                        }



                    },
                    "sep1": "---------",
                    "view_EDR": {
                        name: "View End-of-Shift Report",
                        icon: "fa-clipboard",
                        callback: function(itemKey, opt, e) {
                            // console.log ($(this));
                            $eventDetails = calendar.getEventById(opt.$trigger.attr('calendar-eventID'));
                            // console.log ($eventDetails);
                            viewEDR($eventDetails.id);

                        }
                    },
                    "sep2": "---------",
                    "view_ExceptionReason": {
                        name: "View Exception Reason (if applicable)",
                        icon: "fa-exclamation",
                        callback: function(itemKey, opt, e) {
                            // console.log ($(this));
                            $eventDetails = calendar.getEventById(opt.$trigger.attr('calendar-eventID'));
                            // console.log ($eventDetails);
                            viewExceptionReason($eventDetails.id);

                        }
                    },
                    "sep3": "---------",

                    "force_sign_out": {
                        name: "Force Sign-out",
                        icon: "fa-sign-out",
                        callback: function(itemKey, opt, e) {
                            var m = "Force Sign-out was clicked";
                            window.console && console.log(m);
                            // console.log ($(this));
                            $eventDetails = calendar.getEventById(opt.$trigger.attr('calendar-eventID'));
                            // console.log ($eventDetails);
                            forceConfirm = confirm('Are you sure you want to force sign out this shift?');

                            if (forceConfirm) {
                                forceSignOutShift($eventDetails.id)
                            }
                        }



                    },

                }
            });
        @endif

        function stringToColour(str) {
            var hash = 0;
            for (var i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 3) - hash);
            }
            var color = Math.abs(hash).toString(16).substring(0, 6);

            return "#" + '000000'.substring(0, 6 - color.length) + color;
        }

        const isDate = (date) => {
            return (new Date(date) !== "Invalid Date") && !isNaN(new Date(date));
        }

        function showTypes() {
            var types = $("#type_filter").val();


            if (types && types.length > 0) {
                if (types[0] == "all") {
                    show_type = true;
                } else {
                    show_type = types.indexOf(event.type) >= 0;
                }
            }
            return types;

        }

        function formatState(state) {
            const option = $(state.element);
            const color = option.data("color");

            if (!color) {
                return state.text;
            }


            return $(
                ` <i class="fa fa-circle" style="font-size:10px;color:${color}"></i>&nbsp; <span style="color:black;">${state.text}</span>`
            );
        };

        function formatStateSelection(state) {
            const option = $(state.element);
            const color = option.data("color");

            if (!color) {
                return state.text;
            }


            return $(
                ` <i class="fa fa-circle" style="font-size:10px;color:${color}"></i>&nbsp; <span style="color:white;">${state.text}</span>`
            );
        };

        function updateFilter(item) {
            var SITEURL = "{{ url('/') }}";
            var color = "";
            console.log("item id: " + item.id);
            switch (item.id) {
                case "1":
                    color = 'blue';
                    break;

                case "2":
                    color = 'red';
                    break;

                case "3":
                    color = 'green';
                    break;

                case "4":
                    color = 'khaki';
                    break;
                case "5":
                    color = 'orange';
                    break;
                case "6":
                    color = 'purple';
                    break;
                case "7":
                    color = 'cyan';
                    break;
                case "8":
                    color = 'coral';
                    break;
                case "9":
                    color = 'goldenrod';
                    break;
                case "10":
                    color = 'cadetblue';
                    break;
                case "11":
                    color = 'IndianRed';
                    break;
                case "12":
                    color = 'Lavender';
                    break;
                case "13":
                    color = 'DeepPink';
                    break;
                case "14":
                    color = 'RebeccaPurple';
                    break;
                case "15":
                    color = 'DarkSlateBlue';
                    break;
                case "16":
                    color = 'MediumSeaGreen';
                    break;
                case "17":
                    color = 'LightSteelBlue';
                    break;
                case "18":
                    color = 'Maroon';
                    break;
                case "19":
                    color = 'DarkCyan';
                    break;
                case "20":
                    color = 'DarkRed';
                    break;

                case "21":
                    color = 'blue';
                    break;

                case "22":
                    color = 'red';
                    break;

                case "23":
                    color = 'green';
                    break;

                case "24":
                    color = 'khaki';
                    break;
                case "25":
                    color = 'orange';
                    break;
                case "26":
                    color = 'purple';
                    break;
                case "27":
                    color = 'cyan';
                    break;
                case "28":
                    color = 'coral';
                    break;
                case "29":
                    color = 'goldenrod';
                    break;
                case "30":
                    color = 'cadetblue';
                    break;
                case "31":
                    color = 'IndianRed';
                    break;
                case "32":
                    color = 'Lavender';
                    break;
                case "33":
                    color = 'DeepPink';
                    break;
                case "34":
                    color = 'RebeccaPurple';
                    break;
                case "35":
                    color = 'DarkSlateBlue';
                    break;
                case "36":
                    color = 'MediumSeaGreen';
                    break;
                case "37":
                    color = 'LightSteelBlue';
                    break;
                case "38":
                    color = 'Maroon';
                    break;
                case "39":
                    color = 'DarkCyan';
                    break;
                case "40":
                    color = 'DarkRed';
                    break;
                default:
                    color = 'navy';
            }
            calendar.addEventSource({
                url: SITEURL + "/calendar/getRecords?id=" + item.id,
                color: color
            })

        }

        function filterBasedOnChildren() {

            removeEvents = calendar.getEvents();

            var types = $("#children_filter").val();
            if (types.length > 0) {
                removeEvents.forEach(event => {

                    if (!types.includes(event.title)) {
                        event.remove();
                    }

                });
            }

        }

        function displayMessage(message) {
            toastr.success(message, 'We-Schedule.ca');
        }

        function displayErrorMessage(message) {
            toastr.error(message, 'We-Schedule.ca');
        }

        function forceSignOutShift(id) {
            $.ajax({
                url: SITEURL + '/calendarAjax',
                data: {

                    id: id,
                    type: 'forceSignOut',

                },
                type: "POST",
                success: function(response) {
                    displayMessage("Shift has been forced signed out.", "We-Schedule.ca");
                    calendar.refetchEvents();
                },
                error: function(response) {
                    displayErrorMessage("Force Sign Out Error.", "We-Schedule.ca");

                    calendar.refetchEvents();
                }

            });
        }

        function validateShift(id) {
            $.ajax({
                url: SITEURL + '/calendarAjax',
                data: {
                    title: $("#frmValidate_child_assigned").val(),
                    start: $("#frmValidate_start").val(),
                    end: $("#frmValidate_end").val(),
                    id: id,
                    fk_ChildID: $("#frmValidate_fkChildID").val(),
                    fk_UserID: $("#frmValidate_fkUserID").val(),
                    published_status: "Published",
                    validated: "1",
                    type: 'update',
                    exception_pastEventModified: $("#frmValidate_exception_pastEventModified").val()

                },
                type: "POST",
                success: function(response) {
                    displayMessage("Event Validated Successfully", "We-Schedule.ca");
                    calendar.refetchEvents();
                },
                error: function(response) {
                    displayErrorMessage("Event Validation Error", "We-Schedule.ca");
                    event.revert();
                    calendar.refetchEvents();
                }

            });
        }


        function viewEDR(id) {
            $.ajax({
                url: SITEURL + '/calendarAjax',
                data: {

                    id: id,
                    type: 'viewEDR',

                },
                type: "POST",
                success: function(response) {
                    // console.log (response);
                    $("#frmViewEDR_datetime").val(response['datetime']);
                    $("#frmViewEDR_mood_upon_arrival").val(response['mood_upon_arrival']);
                    $("#frmViewEDR_interaction_with_staff").val(response['interaction_with_staff']);
                    $("#frmViewEDR_general_observations").val(response['general_observations']);
                    $("#frmViewEDR_dietary_notes").val(response['dietary_notes']);
                    $("#frmViewEDR").modal("show");

                },
                error: function(response) {
                    displayErrorMessage("Error Retrieving End of Shift Report", "We-Schedule.ca");

                }

            });


        }

        function viewExceptionReason(id) {
            $.ajax({
                url: SITEURL + '/calendarAjax',
                data: {

                    id: id,
                    type: 'viewExceptionReason',

                },
                type: "POST",
                success: function(response) {
                    // console.log (response);
                    $("#frmViewExceptionReason_reason").val(response['exceptionReason']);
                    $("#frmViewExceptionReason").modal("show");

                },
                error: function(response) {
                    displayErrorMessage("Error Retrieving Exception Reason", "We-Schedule.ca");

                }

            });


        }



        function editModalSubmit(action = 'update') {
            action = action == "update" ? 'update' : "add"
            var SITEURL = "{{ url('/') }}";

            var exception_pastEventModified = false;

            if (moment($("#frmEdit_start").find("input").val()).isBefore(moment()) && $(
                    'input[name=frmEdit_published_status]:checked').val() == "Published") {
                //if the changed event is before now; flag it
                // console.log ("edited even is flagged!");
                exception_pastEventModified = "1";
                //changeInfo.event.setExtendedProp('exception_pastEventModified', true);
                // console.log (changeInfo.event);
                exception_pastEventModified = "1";
                do {
                    var $exceptionReason = "";

                    $exceptionReason = window.prompt('What is the reason for modifying this entry (in the past)?');
                    if ($exceptionReason == null || $exceptionReason === "") {
                        alert("Exception Reason cannot be blank.");
                        $exceptionReason = window.prompt('What is the reason for modifying this entry (in the past)?');

                    } else {

                        //update Shift to include exceptionReason


                    }
                } while ($exceptionReason === "")

                //changeInfo.event.setExtendedProp('exception_pastEventModified', true);
                // console.log (changeInfo.event);
            }


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
                    // validated: $('input[name=frmEdit_validated]:checked').val(),
                    exception_pastEventModified: exception_pastEventModified,
                    exceptionReason: $exceptionReason,

                    type: action
                },
                type: "POST",
                success: function(response) {
                    toastr.success("Shift " + (action == "update" ? 'Updated' : "Added") + " Successfully",
                        'We-Schedule.ca');

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
                    success: function(response) {
                        toastr.success("Event Deleted Successfully", 'We-Schedule.ca');

                        calendar.refetchEvents();

                        $("#frmEditModal").modal("hide");

                    }
                });
            }


        }
    </script>
@stop

@section('content')


    <div class="row">
        <div class="col-12 container-fluid pb-2">
            <div class="row pb-2">

                <div class="col-6">

                    <div class="input-group">
                        <select class="filter" id="type_filter" multiple="multiple">
                            @foreach ($staff as $key => $staff_name)
                                @php
                                    $color = $staff_name->calendarColor ?? 'blue';
                                @endphp
                                <option data-color={{ $color }} value="{{ $staff_name->id }}">
                                    {{ $staff_name->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">

                    <div class="input-group">
                        <select class="filter" id="children_filter" multiple="multiple">
                            @foreach ($children as $key => $child)
                                <option value="{{ $child->initials }}">{{ $child->initials }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <!-- Modal frmValidate -->
            <div class="modal fade" id="frmValidateModal" tabindex="-1" role="dialog"
                aria-labelledby="frmValidateModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-blue">
                            <span class="modal-title" id="mymodelLabel">Validate Shift</span>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>

                        <div class="modal-body">

                            <form id="frmValidateEvent">
                                <input type="hidden" id="frmValidate_id" name="frmValidate_id" />
                                <input type="hidden" id="frmValidate_fkUserID" name="frmValidate_fkUserID" />
                                <input type="hidden" id="frmValidate_fkChildID" name="frmValidate_fkChildID" />
                                <input type="hidden" id="frmValidate_exception_pastEventModified"
                                    name="frmValidate_exception_pastEventModified" />


                                <div class="row form-group">
                                    <div class="col">
                                        <label for="title">Child Assigned</label>
                                        <input readonly type="text" class="form-control"
                                            name="frmValidate_child_assigned" id="frmValidate_child_assigned">
                                    </div>
                                    <div class="col">
                                        <label for="title">CYSW Assigned</label>
                                        <input readonly type="text" class="form-control input-group-append"
                                            name="frmValidate_staff_assigned" id="frmValidate_staff_assigned">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col">
                                        <label>Shift Start</label>
                                        <input readonly id='frmValidate_start' type='text' class='form-control' />
                                    </div>
                                    <div class="col">
                                        <label>Actual Shift Start</label>
                                        <input readonly id='frmValidate_actual_start' type='text' class='form-control' />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col">
                                        <label>Shift End</label>
                                        <input readonly id='frmValidate_end' type='text' class='form-control' />
                                    </div>

                                    <div class="col">
                                        <label>Actual Shift End</label>
                                        <input readonly id='frmValidate_actual_end' type='text' class='form-control' />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col">
                                        <label>Total Scheduled Hours</label>
                                        <input readonly id='frmValidate_Total_Scheduled_Hours' type='text'
                                            class='form-control' />
                                    </div>

                                    <div class="col">
                                        <label>Total Actual Hours</label>
                                        <input readonly id='frmValidate_Total_Actual_Hours' type='text'
                                            class='form-control' />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col">
                                        <label id="lblShiftAutoCalculation" name="lblShiftAutoCalculation">(Shift
                                            Auto-Calculation)</label>
                                    </div>

                                </div>



                                <div class="modal-footer">
                                    <button type="button" id="btnValidateShift" name="btnValidateShift"
                                        onclick="validateShift($('#frmValidate_id').val())"
                                        class="btn btn-primary">Validate Shift</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->

            </div>
            <!-- *frmValidate -->

            <!-- Modal frmViewEDR -->
            <div class="modal fade" id="frmViewEDR" tabindex="-1" role="dialog"
                aria-labelledby="frmValidateModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-blue">
                            <span class="modal-title" id="mymodelLabel">View End of Shift Report</span>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>

                        <div class="modal-body">

                            <form id="frmViewEDR">


                                <div class="row form-group ml-1 mr-1">

                                    <label for="title">Date/Time</label>
                                    <input readonly type="text" class="form-control" name="frmViewEDR_datetime"
                                        id="frmViewEDR_datetime">


                                </div>

                                <div class="row form-group ml-1 mr-1">
                                    <label for="title">Mood Upon Arrival</label>
                                    <textarea readonly rows="10" class="form-control input-group-append" name="frmViewEDR_mood_upon_arrival"
                                        id="frmViewEDR_mood_upon_arrival"></textarea>
                                </div>

                                <div class="row form-group ml-1 mr-1">
                                    <label for="title">Interaction with Staff</label>
                                    <textarea readonly rows="10" class="form-control input-group-append" name="frmViewEDR_interaction_with_staff"
                                        id="frmViewEDR_interaction_with_staff"></textarea>
                                </div>

                                <div class="row form-group ml-1 mr-1">
                                    <label for="title">General Observations</label>
                                    <textarea readonly rows="10" class="form-control input-group-append" name="frmViewEDR_general_observations"
                                        id="frmViewEDR_general_observations"></textarea>
                                </div>

                                <!-- <div class="row form-group ml-1 mr-1">
                                                                            <label for="title">Dietary Notes</label>
                                                                            <textarea readonly rows="10" class="form-control input-group-append" name="frmViewEDR_dietary_notes"
                                                                                id="frmViewEDR_dietary_notes"></textarea>
                                                                        </div> -->







                                <div class="modal-footer">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->

            </div>
            <!-- *frmViewEDR -->

            <!-- Modal frmViewExceptionReason -->
            <div class="modal fade" id="frmViewExceptionReason" tabindex="-1" role="dialog"
                aria-labelledby="frmValidateModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-blue">
                            <span class="modal-title" id="mymodelLabel">View Exception Reason (Black Box)</span>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>

                        <div class="modal-body">

                            <form id="frmViewExceptionReasonForm">


                                <div class="row form-group ml-1 mr-1">

                                    <label for="title">Reason</label>
                                    <textarea readonly rows="10" class="form-control input-group-append" name="frmViewExceptionReason_reason"
                                        id="frmViewExceptionReason_reason"></textarea>

                                </div>








                                <div class="modal-footer">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->

            </div>
            <!-- *frmViewExceptionReason -->


            <div class="card">
                <div id="loadingIndicator" class="h-100  align-items-center justify-content-center"
                    style="position: absolute;left: 50%;top: 15%;z-index: 100;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="card-body">



                    <div id='calendar'></div>

                </div>



                <!-- Modal frmEdit -->

                <div class="modal fade" id="frmEditModal" tabindex="-1" role="dialog"
                    aria-labelledby="frmEditModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-blue edit-modal">
                                <span class="modal-title" id="mymodelLabel">Edit Shift</span>

                                <button id="frmEditButtonClose" type="button" class="close" data-dismiss="modal"
                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>

                            <div class="modal-header bg-gradient-blue add-modal">
                                <span class="modal-title" id="mymodelLabel">Add Shift</span>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>

                            </div>


                            <div class="modal-body">

                                <form id="frmEditEvent">
                                    <input type="hidden" id="frmEdit_id" name="frmEdit_id" />
                                    <div class="form-group">
                                        <label for="title">Child Assigned</label>
                                        <select class="form-control" name="frmEdit_child_assigned"
                                            id="frmEdit_child_assigned">

                                            @foreach ($children as $child)
                                                <option value="{{ $child->id }}">{{ $child->initials }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="title">CYSW Assigned</label>
                                        <select class="form-control" name="frmEdit_staff_assigned"
                                            id="frmEdit_staff_assigned" disabled>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Shift Start</label>
                                        <div class="input-group" id="frmEdit_start" data-td-target-input='nearest'
                                            data-td-target-toggle='nearest'>
                                            <input id='frmEdit_startInput' type='text' class='form-control'
                                                data-td-target='#frmEdit_start' />
                                            <span class='input-group-text' data-td-target='#frmEdit_start'
                                                data-td-toggle='frmEdit_start'>
                                                <span class='fas fa-calendar'></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Shift End</label>
                                        <div class="input-group" id="frmEdit_end" data-td-target-input='nearest'
                                            data-td-target-toggle='nearest'>
                                            <input id='frmEdit_endInput' type='text' class='form-control'
                                                data-td-target='#frmEdit_end' />
                                            <span class='input-group-text' data-td-target='#frmEdit_end'
                                                data-td-toggle='frmEdit_end'>
                                                <span class='fas fa-calendar'></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group clearfix">
                                        <label>Published Status</label><br />
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="frmEdit_published_status"
                                                name="frmEdit_published_status" value="Draft">
                                            <label for="radioPrimary1">
                                                Draft
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="frmEdit_published_status"
                                                name="frmEdit_published_status" value="Published">
                                            <label for="radioPrimary2">
                                                Published
                                            </label>
                                        </div>

                                        <div class="modal-footer add-modal">

                                            <button type="button" onclick="editModalSubmit('add');"
                                                class="btn btn-primary">Save &
                                                Submit
                                            </button>
                                        </div>

                                        <div class="modal-footer edit-modal">

                                            <button type="button" onclick="editModalDelete();"
                                                class="btn btn-danger">Delete
                                                Shift
                                            </button>
                                            <button type="button" onclick="editModalSubmit();"
                                                class="btn btn-primary">Save
                                                & Submit
                                            </button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal -->

                </div>

                <!-- *Modal frmEdit -->


            </div>
            <!-- FrmCopy centered modal -->
            <div class="modal fade" id="frmCopyModal" tabindex="-1" role="dialog" aria-labelledby="frmCopyModal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-gradient-blue">
                            <span class="modal-title" id="frmCopyTitle" name="frmCopyTitle">Copy Shifts</span>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>

                        </div>

                        <div class="modal-body">

                            <form id="frmCopy">
                                <div class="form-group">
                                    <label for="title">Select Child</label>
                                    <select class="form-control" name="frmCopy_child" id="frmCopy_child">

                                        @foreach ($children as $child)
                                            <option value="{{ $child->id }}">{{ $child->initials }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="title">Select Number of Weeks</label>
                                    <select class="form-control" name="frmCopy_weeks" id="frmCopy_weeks">


                                        <option selected value="1">1 Week</option>
                                        <option value="2">2 Weeks</option>
                                        <option value="3">3 Weeks</option>
                                        <option value="4">4 Weeks</option>

                                    </select>
                                </div>

                                <div class="modal-footer">

                                    <button type="button" onclick="frmCopySubmit();" class="btn btn-primary">Save &
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->

            </div>

        </div>

    </div>


    <div id="message_popover_content" class="d-none">

        <span class="form-inline">
            <div class="form-group">
                <input type="number" class="form-control form-control-sm gotoweek-week" max="52"
                    min="1" />

                <select name="year" class="form-control form-control-sm gotoweek-year">
                    <option value="{{ date('Y') + 1 }}">
                        {{ date('Y') + 1 }}
                    </option>
                    @for ($year = date('Y'); $year > date('Y') - 10; $year--)
                        <option @if (date('Y') == $year) selected @endif value="{{ $year }}">
                            {{ $year }}
                        </option>
                    @endfor
                </select>

                <button class="btn btn-sm btn-primary gotoweek-submit" onclick="submitGoToWeek()">GO</button>
            </div>
        </span>
    </div>
@stop
