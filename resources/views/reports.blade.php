@extends('adminlte::page')

@section('title', 'We-Schedule')
<meta name="csrf-token" content="{{ csrf_token() }}">


@section('content_header')
    <h1 class="m-0 text-dark">Reports</h1>
    @unless(Auth::check())
        You are not signed in.
    @endunless



@stop

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
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


    <style>

    </style>
    <div class="row">

        <div class="col-12 container">
            <div class="row pb-0">

                <!-- New Payroll Report -->
                <!-- only for 10 and 4.1 -->

                @if (Auth::user()->user_type == '10' || Auth::user()->user_type == '4.1')
                    <div class="col-4">

                        <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                            <img class="card-img-top border-2" height="212px" src="images/reports/payroll_header.jpg"
                                alt="Payroll Report">
                            <div class="card-body mb-0 pb-0">

                                <h5 class="">Payroll Report</h5>
                                <p class="card-text">
                                <div class="form-group boxed">
                                    <div class="input-wrapper mb-1">
                                        <select class="form-control form-select" name="mainFilter">
                                            <option value="all">All</option>
                                            <option value="cysw">Filter by CYSW</option>
                                            <option value="child">Filter by Child</option>
                                        </select>
                                    </div>
                                    <div class="input-wrapper">
                                        <select class="form-control form-select" name="subFilter" multiple="true" disabled>

                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-0 pb-0">
                                    <div class="col-5 ml-0 mr-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="fromDateNewPayroll"
                                                style="text-align:center;" placeholder="From Date">
                                        </div>
                                    </div>

                                    <div class="col-5 ml-0 mr-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="toDateNewPayroll"
                                                style="text-align:center;" placeholder="To Date">
                                        </div>
                                    </div>

                                    <div class="col">
                                        <button onclick="javascript:generateNewPayrollReport();" type="button"
                                            class="btn btn-primary"> > </button>
                                    </div>


                                </div>



                                </p>
                            </div>
                        </div>

                    </div>
                @endif
                <!-- End of New Payroll Report -->

                <!-- Stat Holiday Report -->
                <!-- only for 10 and 4.1 -->
                @if (Auth::user()->user_type == '10' || Auth::user()->user_type == '4.1')
                    <div class="col-4">
                        <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                            <img class="card-img-top border-2" height="212px" src="images/reports/stat_holiday_header.png"
                                alt="Statutory Holiday Report">
                            <div class="card-body mb-0 pb-0">
                                <h5 class="">Statutory Holiday Report</h5>
                                <p class="card-text">
                                    <div class="row mb-0 pb-0">
                                        <div class="col-10 ml-0 mr-0">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="statHolidayMonthYear" style="text-align:center;" placeholder="Select Month/Year">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button onclick="javascript:generateStatHolidayReport();" type="button" class="btn btn-primary"> > </button>
                                        </div>
                                    </div>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- End of Stat Holiday Report -->

                @if(str_contains(url()->current(), 'casemanage'))

                    <!-- Bank Deposits -->
                    @if (Auth::user()->user_type == '10' || Auth::user()->user_type == '7' || Auth::user()->user_type == '4.1')
                        <div class="col-4">

                            <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                                <img class="card-img-top border-2" height="212px" src="images/reports/bank_deposits_header.jpg"
                                    alt="Bank Deposits Report">
                                <div class="card-body">

                                    <h5 class="">Bank Deposits Report</h5>
                                    <p class="card-text" style="margin-bottom:11px !important;">


                                        <button onclick="window.location='{{ route('BankDeposits') }}'" type="button"
                                            class="btn btn-primary mt-2">View Report</button>

                                    </p>
                                </div>
                            </div>
                            {{--                    <div class="card bg-green"> --}}
                            {{--                        <div class="card-header"> --}}
                            {{--                            <h3 class="card-title">New Payroll Report</h3> --}}
                            {{--                        </div> --}}
                            {{--                        <form> --}}
                            {{--                            <div class="card-body"> --}}
                            {{--                                <div class="row"> --}}
                            {{--                                    <div class="col"> --}}
                            {{--                                        <div class="form-group"> --}}
                            {{--                                            <label for="fromDate">From Date</label> --}}
                            {{--                                            <input type="text" class="form-control" id="fromDateNewPayroll" placeholder="From Date"> --}}
                            {{--                                        </div> --}}
                            {{--                                    </div> --}}

                            {{--                                    <div class="col"> --}}
                            {{--                                        <div class="form-group"> --}}
                            {{--                                            <label for="fromDate">To Date</label> --}}
                            {{--                                            <input type="text" class="form-control" id="toDateNewPayroll" placeholder="To Date"> --}}
                            {{--                                        </div> --}}
                            {{--                                    </div> --}}

                            {{--                                </div> --}}

                            {{--                            </div> --}}

                            {{--                            <div class="card-footer text-center"> --}}
                            {{--                                <button onclick="javascript:generateNewPayrollReport();" type="button" class="btn btn-primary">Generate</button> --}}
                            {{--                            </div> --}}
                            {{--                        </form> --}}
                            {{--                    </div> --}}
                        </div>
                    @endif
                    <!-- End of Bank Deposits -->

                    <!-- On Call Report -->
                    @if (Auth::user()->user_type >= '3' && Auth::user()->user_type != '7')
                        <div class="col-4">

                            <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                                <img class="card-img-top border-2" height="212px" src="images/reports/on-call_header.jpg"
                                    alt="On-Call Report">
                                <div class="card-body">

                                    <h5 class="">On-Call Report</h5>
                                    <p class="card-text" style="margin-bottom:11px !important;">

                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Select Report to View
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="OnCallCYSWReport">CYSW Report</a>

                                            <a class="dropdown-item" href="OnCallReport">On-Call Report</a>
                                        </div>
                                    </div>

    {{--                                    <button onclick="window.location='{{ route('OnCallReport') }}'" type="button"--}}
    {{--                                        class="btn btn-primary mt-2">View Report</button>--}}
    {{--                                    &nbsp;&nbsp;<button onclick="window.location='{{ route('OnCallCYSWReport') }}'"--}}
    {{--                                        type="button" class="btn btn-primary mt-2">CYSW Report</button>--}}


                                    </p>
                                </div>
                            </div>
                            {{--                    <div class="card bg-green"> --}}
                            {{--                        <div class="card-header"> --}}
                            {{--                            <h3 class="card-title">New Payroll Report</h3> --}}
                            {{--                        </div> --}}
                            {{--                        <form> --}}
                            {{--                            <div class="card-body"> --}}
                            {{--                                <div class="row"> --}}
                            {{--                                    <div class="col"> --}}
                            {{--                                        <div class="form-group"> --}}
                            {{--                                            <label for="fromDate">From Date</label> --}}
                            {{--                                            <input type="text" class="form-control" id="fromDateNewPayroll" placeholder="From Date"> --}}
                            {{--                                        </div> --}}
                            {{--                                    </div> --}}

                            {{--                                    <div class="col"> --}}
                            {{--                                        <div class="form-group"> --}}
                            {{--                                            <label for="fromDate">To Date</label> --}}
                            {{--                                            <input type="text" class="form-control" id="toDateNewPayroll" placeholder="To Date"> --}}
                            {{--                                        </div> --}}
                            {{--                                    </div> --}}

                            {{--                                </div> --}}

                            {{--                            </div> --}}

                            {{--                            <div class="card-footer text-center"> --}}
                            {{--                                <button onclick="javascript:generateNewPayrollReport();" type="button" class="btn btn-primary">Generate</button> --}}
                            {{--                            </div> --}}
                            {{--                        </form> --}}
                            {{--                    </div> --}}
                        </div>
                    @endif


                    @if (Auth::user()->user_type >= '10')
                        <!-- Privacy & Support Notes Report -->
                        <div class="col-4">

                            <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                                <img class="card-img-top border-2" height="212px"
                                    src="images/reports/privacy_notes_header.jpg" alt="Privacy Notes Report">
                                <div class="card-body">

                                    <h5 class="">Privacy & Support Notes Report</h5>
                                    <p class="card-text" style="margin-bottom:11px !important;">

                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Select Report to View
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            <a class="dropdown-item" href="PrivacyNotesReport">Privacy Notes</a>
                                            <a class="dropdown-item" href="SupportNotesReport">Support Notes</a>

                                        </div>
                                    </div>

    {{--                                    <button onclick="window.location='{{ route('PrivacyNotesReport') }}'" type="button"--}}
    {{--                                        class="btn btn-primary mt-2">View Report</button>--}}

                                    </p>
                                </div>
                            </div>

                        </div>
                    @endif

                    @if (Auth::user()->user_type == '10.0' || Auth::user()->user_type == '4.0' || (Auth::user()->user_type >= '4.2' && Auth::user()->user_type <= 6.0))
                        {{--Except for Larry--}}
                        <!-- Home Visits Report -->
                        <div class="col-4">

                            <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                                <img class="card-img-top border-2" height="212px"
                                    src="images/reports/support_notes_header.jpg" alt="Support Notes Report">
                                <div class="card-body">

                                    <h5 class="">Mentor Home Repair/Maintenance Report</h5>
                                    <p class="card-text" style="margin-bottom:11px !important;">


                                        <button onclick="window.location='{{ route('MentorHomeVisitReport') }}'" type="button"
                                            class="btn btn-primary mt-2">View Report</button>

                                    </p>
                                </div>
                            </div>

                        </div>
                    @endif

                    @if (Auth::user()->user_type >= '10')
                        <!-- New Child Report -->
                        <div class="col-4">

                            <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                                <img class="card-img-top border-2" height="212px" src="images/reports/new_child_header.jpg"
                                    alt="Bank Deposits Report">
                                <div class="card-body">

                                    <h5 class="">New Child Admission Report</h5>
                                    <p class="card-text" style="margin-bottom:11px !important;">


                                        <button onclick="window.location='{{ route('NewChildAdmission') }}'" type="button"
                                            class="btn btn-primary mt-2">View Report</button>

                                    </p>
                                </div>
                            </div>

                        </div>
                    @endif

                    <!-- Expense Report -->
                    @if (Auth::user()->user_type == "10.0" || Auth::user()->user_type >= "3.0" && Auth::user()->user_type < "6.0")
                        {{--3,4,5,10's --}}
                        <div class="col-4">

                        <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                            <img class="card-img-top border-2" height="212px" src="images/reports/expenses_header.png"
                                alt="Expenses Report">
                            <div class="card-body">

                                <h5 class="">Expenses Report</h5>
                                <p class="card-text" style="margin-bottom:11px !important;">

        {{--                                <div class="dropdown">--}}

        {{--                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
        {{--                                        Select Report to View--}}
        {{--                                    </button>--}}
        {{--                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}

        {{--                                        <a class="dropdown-item" href="Expense/Report">Expense Report</a>--}}
        {{--                                        <a class="dropdown-item" href="Expense/ScrumBoard">Expense Summary Report (WIP)</a>--}}

        {{--                                    </div>--}}
        {{--                                </div>--}}
                                    <a href='/Expense/Report?optimized=true' class="btn btn-primary mt-2">View Report</a>
                                    @if (Auth::user()->user_type == "10.0")
                                        <a href='/qb/dashboard' class="btn btn-primary mt-2">Manage QB</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif


                    @if (Auth::user()->user_type >= '10' ||
                            Auth::user()->user_type == '3.2' ||
                            (Auth::user()->user_type >= 5.0 && Auth::user()->user_type <= 5.2))
                        <!-- New IR Report -->
                        <div class="col-4">

                            <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                                <img class="card-img-top border-2" height="212px" src="images/reports/ir_report_header.jpeg"
                                    alt="Incident Report">
                                <div class="card-body">

                                    <h5 class="">Incident Report</h5>
                                    <p class="card-text" style="margin-bottom:11px !important;">


                                        <button onclick="window.location='/reports/IR_Report'" type="button"
                                            class="btn btn-primary mt-2">View Report</button>

                                    </p>
                                </div>
                            </div>
                        </div>

                        {{--                </div> --}}
                        {{--        </div> --}}
                    @endif

                    <div class="col-4">
                        <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                            <img class="card-img-top border-2" height="212px" src="images/reports/ir_report_header.jpeg" alt="Child Referral Report">
                            <div class="card-body">
                                <h5 class="">Child Referral Report</h5>
                                <p class="card-text" style="margin-bottom:11px !important;">
                                    <a href="/reports/child/ReferralReport" type="button" class="btn btn-primary mt-2">View Report</a>
                                </p>
                            </div>
                        </div>
                    </div>

                @endif

                <!-- Stat Expense CSV Report -->
                <!-- only for 10 and 4.1 -->
                @if (Auth::user()->user_type == '10' || Auth::user()->user_type == '4.1')
                    <div class="col-4">
                        <div class="card border-2 shadow justify-content-center text-center" style="width: 400px;">
                            <img class="card-img-top border-2" height="212px" src="images/reports/expense_csv_header.png" alt="Expense CSV Report">
                            <div class="card-body mb-0 pb-0">
                                <h5>Expense CSV Report</h5>
                                <p class="card-text">
                                <div class="row mb-0 pb-0">
                                    <div class="col-10 ml-0 mr-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="expenseCsvReportMonthYear" style="text-align:center;" placeholder="Select Month/Year">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button onclick="javascript:generateExpenseCsvReport();" type="button" class="btn btn-primary"> > </button>
                                    </div>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- End of Stat Expense CSV Report -->

                <script>
                    $(document).ready(function() {
                        subFilter = $('select[name="subFilter"]')
                        mainFilter = $('select[name="mainFilter"]')
                        $('select[name="mainFilter"]').on("change", function(e) {
                            if ($(this).val() == "cysw") {
                                $.get("calendar/getStaff", function(d) {
                                    subFilter.empty()
                                    d.forEach(i => {
                                        console.log(i)
                                        var option = new Option(i.name, i.id, false, false);
                                        subFilter.append(option).trigger("change")
                                    })
                                    subFilter.attr("disabled", false)
                                })
                            } else if ($(this).val() == "child") {
                                $.get("ajax/getChildren", function(d) {
                                    subFilter.empty()
                                    d.forEach(i => {
                                        console.log(i)
                                        var option = new Option(i.initials, i.id, false, false);
                                        subFilter.append(option).trigger("change")
                                    })
                                    subFilter.attr("disabled", false)
                                })
                            } else {
                                subFilter.empty()
                                subFilter.attr("disabled", true)
                            }
                        })
                        $('select[name="subFilter"]').select2({
                            placeholder: "Select data"
                        });

                        $New_FD = new tempusDominus.TempusDominus(document.getElementById('fromDateNewPayroll'), {
                            display: {
                                sideBySide: false,
                            },
                            //promptTimeOnDateChange:true
                            keepInvalid: false,
                            hooks: {
                                inputFormat: (context, date) => {
                                    return moment(date).format('YYYY-MM-DD')
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

                        //
                        // $gen_FD = new tempusDominus.TempusDominus(document.getElementById('fromDate'),
                        //     {
                        //         display: {
                        //             sideBySide: false,
                        //         },
                        //         //promptTimeOnDateChange:true
                        //         keepInvalid: false,
                        //         hooks: {
                        //             inputFormat: (context, date) => {
                        //                 return moment(date).format('YYYY-MM-DD')
                        //             },
                        //             inputParse: (context, value) => {
                        //                 if (!isDate(value)) {
                        //                     return new tempusDominus.DateTime(new Date())
                        //                 } else {
                        //                     return new tempusDominus.DateTime(value)
                        //                 }
                        //             }
                        //
                        //         }
                        //
                        //     }
                        // );
                        //
                        // $gen_FD_CYSW = new tempusDominus.TempusDominus(document.getElementById('fromDateCYSW'),
                        //     {
                        //         display: {
                        //             sideBySide: false,
                        //         },
                        //         //promptTimeOnDateChange:true
                        //         keepInvalid: false,
                        //         hooks: {
                        //             inputFormat: (context, date) => {
                        //                 return moment(date).format('YYYY-MM-DD')
                        //             },
                        //             inputParse: (context, value) => {
                        //                 if (!isDate(value)) {
                        //                     return new tempusDominus.DateTime(new Date())
                        //                 } else {
                        //                     return new tempusDominus.DateTime(value)
                        //                 }
                        //             }
                        //
                        //         }
                        //
                        //     }
                        // );
                        //
                        // $gen_FD_Child = new tempusDominus.TempusDominus(document.getElementById('fromDateChild'),
                        //     {
                        //         display: {
                        //             sideBySide: false,
                        //         },
                        //         //promptTimeOnDateChange:true
                        //         keepInvalid: false,
                        //         hooks: {
                        //             inputFormat: (context, date) => {
                        //                 return moment(date).format('YYYY-MM-DD')
                        //             },
                        //             inputParse: (context, value) => {
                        //                 if (!isDate(value)) {
                        //                     return new tempusDominus.DateTime(new Date())
                        //                 } else {
                        //                     return new tempusDominus.DateTime(value)
                        //                 }
                        //             }
                        //
                        //         }
                        //
                        //     }
                        // );
                        //
                        // $gen_TD = new tempusDominus.TempusDominus(document.getElementById('toDate'),
                        //     {
                        //         display: {
                        //             sideBySide: false,
                        //         },
                        //         //promptTimeOnDateChange:true
                        //         keepInvalid: false,
                        //         hooks: {
                        //             inputFormat: (context, date) => {
                        //                 return moment(date).format('YYYY-MM-DD')
                        //             },
                        //             inputParse: (context, value) => {
                        //                 if (!isDate(value)) {
                        //                     return new tempusDominus.DateTime(new Date())
                        //                 } else {
                        //                     return new tempusDominus.DateTime(value)
                        //                 }
                        //             }
                        //
                        //         }
                        //
                        //     }
                        // );
                        //
                        // $gen_TD_CYSW = new tempusDominus.TempusDominus(document.getElementById('toDateCYSW'),
                        //     {
                        //         display: {
                        //             sideBySide: false,
                        //         },
                        //         //promptTimeOnDateChange:true
                        //         keepInvalid: false,
                        //         hooks: {
                        //             inputFormat: (context, date) => {
                        //                 return moment(date).format('YYYY-MM-DD')
                        //             },
                        //             inputParse: (context, value) => {
                        //                 if (!isDate(value)) {
                        //                     return new tempusDominus.DateTime(new Date())
                        //                 } else {
                        //                     return new tempusDominus.DateTime(value)
                        //                 }
                        //             }
                        //
                        //         }
                        //
                        //     }
                        // );
                        //
                        // $gen_TD_Child = new tempusDominus.TempusDominus(document.getElementById('toDateChild'),
                        //     {
                        //         display: {
                        //             sideBySide: false,
                        //         },
                        //         //promptTimeOnDateChange:true
                        //         keepInvalid: false,
                        //         hooks: {
                        //             inputFormat: (context, date) => {
                        //                 return moment(date).format('YYYY-MM-DD')
                        //             },
                        //             inputParse: (context, value) => {
                        //                 if (!isDate(value)) {
                        //                     return new tempusDominus.DateTime(new Date())
                        //                 } else {
                        //                     return new tempusDominus.DateTime(value)
                        //                 }
                        //             }
                        //
                        //         }
                        //
                        //     }
                        // );


                        $new_TD = new tempusDominus.TempusDominus(document.getElementById('toDateNewPayroll'), {
                            display: {
                                sideBySide: false,
                            },
                            //promptTimeOnDateChange:true
                            keepInvalid: false,
                            hooks: {
                                inputFormat: (context, date) => {
                                    return moment(date).format('YYYY-MM-DD')
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


                        $statHolidaySelector = new tempusDominus.TempusDominus(document.getElementById(
                            'statHolidayMonthYear'), {
                            display: {
                                sideBySide: false,
                                viewMode: 'months',
                                components: {
                                    calendar: true,
                                    date: false,
                                    month: true,
                                    year: true,
                                    decades: false,
                                    clock: false,
                                    hours: false,
                                    minutes: false,
                                    seconds: false,
                                    useTwentyfourHour: undefined
                                },

                            },
                            //promptTimeOnDateChange:true
                            keepInvalid: false,


                            hooks: {
                                inputFormat: (context, date) => {
                                    return moment(date).format('MMMM YYYY')
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


                        new tempusDominus.TempusDominus(document.getElementById('expenseCsvReportMonthYear'), {
                            display: {
                                sideBySide: false,
                                viewMode: 'months',
                                components: {
                                    calendar: true,
                                    date: false,
                                    month: true,
                                    year: true,
                                    decades: false,
                                    clock: false,
                                    hours: false,
                                    minutes: false,
                                    seconds: false,
                                    useTwentyfourHour: undefined
                                },

                            },
                            keepInvalid: false,


                            hooks: {
                                inputFormat: (context, date) => {
                                    return moment(date).format('MMMM YYYY')
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

                    });

                    function generateNewPayrollReport() {
                        window.location.href = '/report?from_date=' + $("#fromDateNewPayroll").val() + '&to_date=' + $(
                                "#toDateNewPayroll").val() + '&user=' + '{{ Auth::user()->name }}' + '&' + mainFilter.val() + '=' +
                            subFilter.val();
                    }

                    function generatePayrollReport() {
                        window.location.href = '/reports/PayrollReport?from_date=' + $("#fromDate").val() + '&to_date=' + $("#toDate")
                            .val();
                    }

                    function generatePayrollReportbyCYSW() {
                        window.location.href = '/reports/PayrollReportbyCYSW?from_date=' + $("#fromDateCYSW").val() + '&to_date=' + $(
                            "#toDateCYSW").val() + '&CYSW=' + $("#CYSW").val();
                    }

                    function generatePayrollReportbyChild() {
                        window.location.href = '/reports/PayrollReportbyChild?from_date=' + $("#fromDateChild").val() + '&to_date=' + $(
                            "#toDateChild").val() + '&Child=' + $("#Child").val();
                    }

                    function generateStatHolidayReport() {
                        window.location.href = '/StatHolidayReport?MonthYear=' + $("#statHolidayMonthYear").val() + '&Child=' +
                            '&user=' + '{{ Auth::user()->name }}';
                    }

                    function generateExpenseCsvReport() {
                        window.location.href = '/Expense/CsvReport?month=' + $("#expenseCsvReportMonthYear").val();
                    }
                </script>
            </div>


            {{--        <ul> --}}
            {{--            <li><a href="/PrivacyNotesReport">Privacy Notes</a></li> --}}
            {{--            <li><a href="SupportNotesReport">Support Notes</a></li> --}}
            {{--            <li><a href="/NewChildReport">New Child Report (Case-Manage)</a></li> --}}
            {{--            <li>New CYSW Report (We-Schedule)</li> --}}

            {{--        </ul> --}}

        </div>
    </div>
@stop

