@extends('adminlte::page')
@section('title', 'We-Schedule')
@section('content_header')
    <h1 class="m-0 text-dark">My Shifts</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless


@stop

@section('content')


    <div class="row">
        <div class="col-md-6">
            <div class="card card-tabs">
                <div class="card-header p-0 pt-1">

                    <ul class="nav nav-tabs" id="ShiftTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="ShiftTabs-Upcoming" data-toggle="pill" href="#ShiftTabsContent-Upcoming" role="tab" aria-controls="ShiftTabsContent-Upcoming" aria-selected="true">Upcoming Shifts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ShiftTabs-Past" data-toggle="pill" href="#ShiftTabsContent-Past" role="tab" aria-controls="ShiftTabsContent-Past" aria-selected="false">Past Shifts</a>
                        </li>

                    </ul>
                </div>
                        <div class="card-body">
                            <div class="tab-content" id="ShiftTabsContent">


                                <div class="tab-pane fade active show" id="ShiftTabsContent-Upcoming" role="tabpanel" aria-labelledby="ShiftTabs-Upcoming">

                                    @if ($shifts->count() > 0)

                                @foreach ($shifts as $index=>$myshift)


                                        @if (!$shifts->currentPage()) //no pagination detected
                                        @if ($loop->first)
                                            <div id="shiftCard-{{$myshift->id}}" class="card card-primary">
                                                @else
                                                    <div id="shiftCard-{{$myshift->id}}" class="card card-primary collapsed-card">
                                                        @endif

                                                        @else
                                                            @if ($shifts->currentPage() == 1 && $loop->iteration == 1)
                                                                <div id="shiftCard-{{$myshift->id}}" class="card card-primary">
                                                                    @else
                                                                        <div id="shiftCard-{{$myshift->id}}" class="card card-primary collapsed-card">
                                                                            @endif
                                                                            @endif
                                    <div class="card-header" id="shift-{{$myshift->id}}">
                                        <h3 class="card-title">{{$myshift->title}} @ {{$myshift->get_child->get_home->name}}
                                            <br />{{Str::before($myshift->start,' ')}}</h3>
                                        <div class="card-tools">
                                            <!-- Collapse Button -->
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                @if (!$shifts->currentPage()) //no pagination detected
                                                @if ($loop->first)
                                                    <i class="fas fa-minus"></i></button>
                                                        @else
                                                <i class="fas fa-plus"></i></button>
                                                                @endif

                                                                @else
                                                                    @if ($shifts->currentPage() == 1 && $loop->iteration == 1)
                                                    <i class="fas fa-minus"></i></button>
                                                                            @else
                                                    <i class="fas fa-plus"></i></button>
                                                                                    @endif
                                                                                    @endif

                                        </div>
                                    </div>

                                            <div class="card-body">
                                        <div class="col-md-12">

                                                    <ul class="list-group list-group-unbordered mb-3">
                                                        <li class="list-group-item">
                                                            <b>Start Time</b> <a class="float-right">{{Str::after($myshift->start, ' ')}}</a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>End Time</b> <a class="float-right">{{Str::after($myshift->end, ' ')}}</a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>Scheduled Hours</b> <a
                                                                class="float-right">{{$myshift->calculateShiftHours()}}</a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>Status</b> <a class="float-right">{{$myshift->status}}</a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <a href="/myshifts/{{$myshift->id}}" class="btn btn-primary btn-block"><b>View
                                                                    Shift</b></a>
                                                        </li>
                                                    </ul>



                                                </div>


                                        </div>
                                    </div>



                                                                        @endforeach
                                        {{ $shifts->links() }}
                                                                </div>
                                                                        @else
                                                                        You do not have any upcoming shifts.

                                                            @endif
                                                    </div>

                                <div class="tab-pane fade" id="ShiftTabsContent-Past" role="tabpanel" aria-labelledby="ShiftTabs-Past">
                                    @if ($pastShifts->count() > 0)

                                    @foreach ($pastShifts as $index=>$myshift)

                                        <div class="card card-primary">
                                            <div class="card-header" id="shift-{{$myshift->id}}">
                                                <h3 class="card-title">{{$myshift->title}} @ {{$myshift->get_child->get_home->name}}
                                                    <br />{{Str::before($myshift->start,' ')}}</h3>
                                                <div class="card-tools">
                                                    <!-- Collapse Button -->
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>


                                            @if (!$shifts->currentPage()) //no pagination detected
                                            @if ($loop->first)
                                                <div class="card-body">
                                                    @else
                                                        <div class="card-body collapse">
                                                            @endif

                                                            @else
                                                                @if ($shifts->currentPage() == 1 && $loop->iteration == 1)
                                                                    <div class="card-body">
                                                                        @else
                                                                            <div class="card-body collapse">
                                                                                @endif
                                                                                @endif
                                                                                <div class="col-md-12">

                                                                                    <ul class="list-group list-group-unbordered mb-3">
                                                                                        <li class="list-group-item">
                                                                                            <b>Start Time</b> <a class="float-right">{{Str::after($myshift->start, ' ')}}</a>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <b>End Time</b> <a class="float-right">{{Str::after($myshift->end, ' ')}}</a>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <b>Scheduled Hours</b> <a
                                                                                                class="float-right">{{$myshift->calculateShiftHours()}}</a>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <b>Status</b> <a class="float-right">{{$myshift->status}}</a>
                                                                                        </li>
                                                                                        <li class="list-group-item">
                                                                                            <a href="/myshifts/{{$myshift->id}}" class="btn btn-primary btn-block"><b>View
                                                                                                    Shift</b></a>
                                                                                        </li>
                                                                                    </ul>



                                                                                </div>


                                                                            </div>
                                                                    </div>

                                                                    @endforeach
                                                                    {{ $shifts->links() }}

                                                                @else
                                                                You do not have any past shifts.
                                    @endif




        <!--
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button  class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Today's Shifts [{{date("l F d, Y")}}]
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">

                                    <table id ="todays_shifts" class=" table-bordered yajra-datatable responsive" style="width:100%" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Status</th>
                                            <th>Time Until Shift Starts</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                        {{--
                                      @if (count($shifts))
                                            <ul>
                                            @forelse ($shifts as $shift)

                                            @if (date('Y-m-d', strtotime($shift->start)) == date('Y-m-d'))

                                                    @php
                                                    $sd = date_create($shift->start);
                                                    $ed = date_create($shift->end);
                                                    @endphp
                                                    <li>{{$shift->title}} [{{date_format($sd,"H:m")}} - {{date_format($ed,"H:m")}}] - {{$shift->status}} - <i>{{\Carbon\Carbon::createFromTimeStamp(strtotime($shift->start))->diffForHumans()}}</i>
                                                    <br /><button>Start Shift</button> | <button>End Shift</button> | <button>Complete End of Shift Report</button> | <button>View End of Day Report</button>
                                                    <br /><br />
                                                    </li>

                                        @endif
                                        @empty
                                            <p>No Avaialable Shifts for Today</p>
                                        @endforelse
                                        </ul>
                                          @else
                                                No Shifts Available
                                          @endif
        --}}
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button  class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Upcoming Shifts
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <table id ="upcoming_shifts" class="table table-bordered yajra-datatable responsive" style="width:100%" width="100%">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>Status</th>
                                                <th>Time Until Shift Starts</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        {{--
                                        @if (count($upcomingShifts))
                                            @forelse ($upcomingShifts as $upcomingShift)

                                                @php
                                                    $sd = date_create($upcomingShift->start);
                                                    $ed = date_create($upcomingShift->end);
                                                @endphp
                                                <p>{{$upcomingShift->title}} [{{date_format($sd,"Y-m-d H:m")}} - {{date_format($ed,"H:m")}}] - {{$upcomingShift->status}} - <i>{{\Carbon\Carbon::createFromTimeStamp(strtotime($upcomingShift->start))->diffForHumans()}}</i>
                                                </p>

                                            @empty
                                                <p>No Avaialable Upcoming Shifts</p>
                                            @endforelse

                                        @else
                                            No Shifts Available
                                        @endif
                                        --}}
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button onclick="recalc_responsive();" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Past Shifts
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        No shifts found.
                                    </div>
                                </div>
                            </div>
                        </div>
-->



                    </div>
                                                </div>
                                        </div>
                                </div>
                                            </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>

    @stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>




    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function(){
            // Add minus icon for collapse element which is open by default
            $(".collapse.show").each(function(){
                $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
            });

            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
            }).on('hide.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
            });
        });


        function recalc_responsive () {
            window.alert ('now');
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust()
                .responsive.recalc();
        }

        $(function () {
            $('body').on('show.bs.collapse', function () {
                alert('Hey, this alert shows up when you expand it');
            })
        });
        $(function () {
// keeps the responsive columns working in tabs
            $(document).on("show.bs.collapse", '.accordion' , function () {
                alert ('2');

            });


            //today's shifts
            var table = $('#todays_shifts').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                rowReorder: false,


                ajax: "{{ route('myshifts.getTodaysShifts') }}",
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'start', name: 'start'},
                    {data: 'end', name: 'end'},
                    {data: 'status', name: 'status'},
                    {data: 'relative', name: 'relative'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    },
                ]
            });

            //upcoming shifts
            var tblUpcomingShifts = $('#upcoming_shifts').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                rowReorder: false,


                ajax: "{{ route('myshifts.getUpcomingShifts') }}",
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'start', name: 'start'},
                    {data: 'end', name: 'end'},
                    {data: 'status', name: 'status'},
                    {data: 'relative', name: 'relative'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    },
                ]
            });

        });
    </script>
@endsection
