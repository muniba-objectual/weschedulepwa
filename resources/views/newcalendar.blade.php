
@extends('adminlte::page')


@section('title', 'We-Schedule')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<link rel="stylesheet" href="/plugins/tui-calendar/tui-calendar.min.css" />
<link rel="stylesheet" type="text/css" href="/plugins/tui-calendar/default.css">
<link rel="stylesheet" type="text/css" href="/plugins/tui-calendar/icons.css">
<script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>

<script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>

<script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>

<script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>

<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />

<!-- If you use the default popups, use this. -->


<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />

<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />


@section('content_header')
<h1 class="m-0 text-dark">Calendar</h1>
@unless (Auth::check())
You are not signed in.
@endunless



@stop

@section('content')

    <div class="row">
            <div class="lnb-new-schedule">

                <button id="btn-new-schedule" type="button" class="btn btn-default btn-block lnb-new-schedule-btn" data-toggle="modal">
                    New schedule</button>
            </div>
    </div>

    <div class="row">
        <div class="col-2">
            <div class="card">
                <div class="card-body">


                    <div id="lnb-calendars" class="lnb-calendars">
                            <div class="lnb-calendars-item">
                                <label>
                                    <input class="tui-full-calendar-checkbox-square" type="checkbox" value="all" checked>
                                    <span></span>
                                    <strong>View all</strong>
                                </label>
                            </div>
                        <div id="calendarList" class="lnb-calendars-d1">

                        </div>
                    </div>


            </div>
            </div>

            </div>

          <div class="col-10">
              <div class="card">
                  <div class="card-body">


                        <span class="dropdown">
                <button id="dropdownMenu-calendarType" class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    <i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;"></i>
                    <span id="calendarTypeName">Dropdown</span>&nbsp;
                    <i class="calendar-icon tui-full-calendar-dropdown-arrow"></i>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-calendarType">
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-daily">
                            <i class="calendar-icon ic_view_day"></i>Daily
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weekly">
                            <i class="calendar-icon ic_view_week"></i>Weekly
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-monthly">
                            <i class="calendar-icon ic_view_month"></i>Month
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks2">
                            <i class="calendar-icon ic_view_week"></i>2 weeks
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks3">
                            <i class="calendar-icon ic_view_week"></i>3 weeks
                        </a>
                    </li>
                    <li role="presentation" class="dropdown-divider"></li>
                    <li role="presentation">
                        <a role="menuitem" data-action="toggle-workweek">
                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-workweek" checked>
                            <span class="checkbox-title"></span>Show weekends
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" data-action="toggle-start-day-1">
                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-start-day-1">
                            <span class="checkbox-title"></span>Start Week on Monday
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" data-action="toggle-narrow-weekend">
                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-narrow-weekend">
                            <span class="checkbox-title"></span>Narrower than weekdays
                        </a>
                    </li>
                </ul>
            </span>
                 <span id="menu-navi">
                <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">Today</button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
                    <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
                    <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
                </button>
            </span>
                 <span id="renderRange" class="render-range"></span>



              <div id="calendar" class="col-12">
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/chance/1.0.13/chance.min.js"></script>
                  <script src="/plugins/tui-calendar/calendars.js"></script>
                  <script src="/plugins/tui-calendar/schedules2.js"></script>
                  <!-- <script src="./js/theme/dooray.js"></script> -->
                  <script src="/plugins/tui-calendar/app.js"></script>

              </div>
         </div>
              </div>
          </div>


</div>



@stop
