<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://unpkg.com/fullcalendar@5.10.1/main.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body>

<div class="container">
    <div id='calendar'></div>
</div>

<script>
    $(document).ready(function () {

        var SITEURL = "{{ url('/') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {

            headerToolbar: {
                left: 'dayGridMonth,timeGridWeek,timeGridDay custom1',
                center: 'title',
                right: 'custom2 prevYear,prev,next,nextYear'
            },

            footerToolbar: {
                left: 'custom1,custom2',
                center: '',
                right: 'prev,next'
            },
            customButtons: {
                custom1: {
                    text: 'custom 1',
                    click: function () {
                        alert('clicked custom button 1!');
                    }
                },
                custom2: {
                    text: 'custom 2',
                    click: function () {
                        alert('clicked custom button 2!');
                    }
                }
            },

            initialView: 'timeGridWeek',
            editable: false,
            events: SITEURL + "/calendar/getRecords",
            displayEventTime: true,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                var title = prompt('Event Title:');
                if (title) {
                    var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                    var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                    $.ajax({
                        url: SITEURL + "/calendarAjax",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            type: 'add'
                        },
                        type: "POST",
                        success: function (data) {
                            displayMessage("Event Created Successfully");

                            calendar.fullCalendar('renderEvent',
                                {
                                    id: data.id,
                                    title: title,
                                    start: start,
                                    end: end,
                                    allDay: allDay
                                },true);

                            calendar.fullCalendar('unselect');
                        }
                    });
                }
            },
            eventDrop: function (event, delta) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

                $.ajax({
                    url: SITEURL + '/calendarAjax',
                    data: {
                        title: event.title,
                        start: start,
                        end: end,
                        id: event.id,
                        type: 'update'
                    },
                    type: "POST",
                    success: function (response) {
                        displayMessage("Event Updated Successfully");
                    }
                });
            },
            eventClick: function (event) {
                var deleteMsg = confirm("Do you really want to delete?");
                if (deleteMsg) {
                    $.ajax({
                        type: "POST",
                        url: SITEURL + '/calendarAjax',
                        data: {
                            id: event.id,
                            type: 'delete'
                        },
                        success: function (response) {
                            calendar.fullCalendar('removeEvents', event.id);
                            displayMessage("Event Deleted Successfully");
                        }
                    });
                }
            }
        });
        calendar.render();

        /*
         var calendar = $('#calendar').fullCalendar({
             editable: true,
             events: SITEURL + "/calendar",
             displayEventTime: true,
             initialView: 'dayGridMonth',
             editable: true,
             eventRender: function (event, element, view) {
                 if (event.allDay === 'true') {
                     event.allDay = true;
                 } else {
                     event.allDay = false;
                 }
             },
             selectable: true,
             selectHelper: true,
             select: function (start, end, allDay) {
                 var title = prompt('Event Title:');
                 if (title) {
                     var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                     var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                     $.ajax({
                         url: SITEURL + "/calendarAjax",
                         data: {
                             title: title,
                             start: start,
                             end: end,
                             type: 'add'
                         },
                         type: "POST",
                         success: function (data) {
                             displayMessage("Event Created Successfully");

                             calendar.fullCalendar('renderEvent',
                                 {
                                     id: data.id,
                                     title: title,
                                     start: start,
                                     end: end,
                                     allDay: allDay
                                 },true);

                             calendar.fullCalendar('unselect');
                         }
                     });
                 }
             },
             eventDrop: function (event, delta) {
                 var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                 var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

                 $.ajax({
                     url: SITEURL + '/calendarAjax',
                     data: {
                         title: event.title,
                         start: start,
                         end: end,
                         id: event.id,
                         type: 'update'
                     },
                     type: "POST",
                     success: function (response) {
                         displayMessage("Event Updated Successfully");
                     }
                 });
             },
             eventClick: function (event) {
                 var deleteMsg = confirm("Do you really want to delete?");
                 if (deleteMsg) {
                     $.ajax({
                         type: "POST",
                         url: SITEURL + '/calendarAjax',
                         data: {
                             id: event.id,
                             type: 'delete'
                         },
                         success: function (response) {
                             calendar.fullCalendar('removeEvents', event.id);
                             displayMessage("Event Deleted Successfully");
                         }
                     });
                 }
             }

         });

     });
 */
        function displayMessage(message) {
            toastr.success(message, 'Event');
        }
    });

</script>

</body>
</html>
