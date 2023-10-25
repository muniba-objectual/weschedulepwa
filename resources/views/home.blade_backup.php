@extends('adminlte::page')

@section('title', 'We-Schedule')

@section('content_header')

    <h1 class="m-0 text-dark">Dashboard - Welcome {{$user->name ?? 'no name'}}
        [{{$user->get_user_type->name ?? 'no role'}}]</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless


@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h5>Current Shift</h5>
                            @if ($shifts->count() > 0)

                                {{$shifts[0]->title}}
                                @ {{$shifts[0]->get_child->get_home->name}}
                                <br/>{{Str::before($shifts[0]->start,' ')}} <br />
                                <b>{{$shifts[0]->status}}</b>
                            @else
                                N/A
                            @endif

                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <a href="/myshifts/{{$shifts[0]->id}}" class="small-box-footer">View Shift <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h5>My Shifts</h5>
                            @if ($shifts->count() > 0)
                                {{$shifts->count()}} Upcoming Shifts <br />
                                Next Shift: {{$shifts[1]->start}}
                            @else
                            N/A
                                @endif
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <a href="/myshifts" class="small-box-footer">View All Shifts <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h5>My User Profile</h5>

                            <p>Manage your We-Schedule User Profile</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="/users/MyProfile" class="small-box-footer">Manage User Profile <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h5>Alerts / Messages</h5>

                            <p>View your alerts and notifications</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <a href="#" class="small-box-footer">View All <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->

            <!--
            <div class="row">

                <div class="col-md-6">
                    <div class="card card-tabs">
                        <div class="card-header">

                            <ul class="nav nav-tabs" id="ShiftTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="ShiftTabs-Upcoming" data-toggle="pill"
                                       href="#ShiftTabsContent-Upcoming" role="tab"
                                       aria-controls="ShiftTabsContent-Upcoming" aria-selected="true">Upcoming
                                        Shifts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="ShiftTabs-Past" data-toggle="pill"
                                       href="#ShiftTabsContent-Past" role="tab" aria-controls="ShiftTabsContent-Past"
                                       aria-selected="false">Past Shifts</a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="ShiftTabsContent">


                                <div class="tab-pane fade active show" id="ShiftTabsContent-Upcoming" role="tabpanel"
                                     aria-labelledby="ShiftTabs-Upcoming">

                                    @if ($shifts->count() > 0)

                                        @foreach ($shifts as $index=>$myshift)


                                            @if (!$shifts->currentPage()) //no pagination detected
                                            @if ($loop->first)
                                                <div id="shiftCard-{{$myshift->id}}" class="card card-primary">
                                                    @else
                                                        <div id="shiftCard-{{$myshift->id}}"
                                                             class="card card-primary collapsed-card">
                                                            @endif

                                                            @else
                                                                @if ($shifts->currentPage() == 1 && $loop->iteration == 1)
                                                                    <div id="shiftCard-{{$myshift->id}}"
                                                                         class="card card-primary">
                                                                        @else
                                                                            <div id="shiftCard-{{$myshift->id}}"
                                                                                 class="card card-primary collapsed-card">
                                                                                @endif
                                                                                @endif
                                                                                <div class="card-header"
                                                                                     id="shift-{{$myshift->id}}">
                                                                                    <h3 class="card-title">{{$myshift->title}}
                                                                                        @ {{$myshift->get_child->get_home->name}}
                                                                                        <br/>{{Str::before($myshift->start,' ')}}
                                                                                    </h3>
                                                                                    <div class="card-tools">
                                                                                        <!-- Collapse Button -->
                                                                                        <button type="button"
                                                                                                class="btn btn-tool"
                                                                                                data-card-widget="collapse">
                                                                                            @if (!$shifts->currentPage())
                                                                                                //no pagination detected
                                                                                                @if ($loop->first)
                                                                                                    <i class="fas fa-minus"></i>
                                                                                        </button>
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
                                                                                                <b>Start Time</b> <a
                                                                                                    class="float-right">{{Str::after($myshift->start, ' ')}}</a>
                                                                                            </li>
                                                                                            <li class="list-group-item">
                                                                                                <b>End Time</b> <a
                                                                                                    class="float-right">{{Str::after($myshift->end, ' ')}}</a>
                                                                                            </li>
                                                                                            <li class="list-group-item">
                                                                                                <b>Scheduled Hours</b>
                                                                                                <a
                                                                                                    class="float-right">{{$myshift->calculateShiftHours()}}</a>
                                                                                            </li>
                                                                                            <li class="list-group-item">
                                                                                                <b>Status</b> <a
                                                                                                    class="float-right">{{$myshift->status}}</a>
                                                                                            </li>
                                                                                            <li class="list-group-item">
                                                                                                <a href="/myshifts/{{$myshift->id}}"
                                                                                                   class="btn btn-primary btn-block"><b>View
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


                                                                <div class="tab-pane fade" id="ShiftTabsContent-Past"
                                                                     role="tabpanel" aria-labelledby="ShiftTabs-Past">
                                                                    @if ($pastShifts->count() > 0)

                                                                        @foreach ($pastShifts as $index=>$myshift)

                                                                            <div class="card card-primary">
                                                                                <div class="card-header"
                                                                                     id="shift-{{$myshift->id}}">
                                                                                    <h3 class="card-title">{{$myshift->title}}
                                                                                        @ {{$myshift->get_child->get_home->name}}
                                                                                        <br/>{{Str::before($myshift->start,' ')}}
                                                                                    </h3>
                                                                                    <div class="card-tools">
                                                                                        <!-- Collapse Button -->
                                                                                        <button type="button"
                                                                                                class="btn btn-tool"
                                                                                                data-card-widget="collapse">
                                                                                            <i class="fas fa-minus"></i>
                                                                                        </button>

                                                                                    </div>
                                                                                </div>

                                                                                @if (!$shifts->currentPage()) //no
                                                                                pagination detected
                                                                                @if ($loop->first)
                                                                                    <div class="card-body">
                                                                                        @else
                                                                                            <div
                                                                                                class="card-body collapse">
                                                                                                @endif

                                                                                                @else
                                                                                                    @if ($shifts->currentPage() == 1 && $loop->iteration == 1)
                                                                                                        <div
                                                                                                            class="card-body">
                                                                                                            @else
                                                                                                                <div
                                                                                                                    class="card-body collapse">
                                                                                                                    @endif
                                                                                                                    @endif
                                                                                                                    <div
                                                                                                                        class="col-md-12">

                                                                                                                        <ul class="list-group list-group-unbordered mb-3">
                                                                                                                            <li class="list-group-item">
                                                                                                                                <b>Start
                                                                                                                                    Time</b>
                                                                                                                                <a class="float-right">{{Str::after($myshift->start, ' ')}}</a>
                                                                                                                            </li>
                                                                                                                            <li class="list-group-item">
                                                                                                                                <b>End
                                                                                                                                    Time</b>
                                                                                                                                <a class="float-right">{{Str::after($myshift->end, ' ')}}</a>
                                                                                                                            </li>
                                                                                                                            <li class="list-group-item">
                                                                                                                                <b>Scheduled
                                                                                                                                    Hours</b>
                                                                                                                                <a
                                                                                                                                    class="float-right">{{$myshift->calculateShiftHours()}}</a>
                                                                                                                            </li>
                                                                                                                            <li class="list-group-item">
                                                                                                                                <b>Status</b>
                                                                                                                                <a class="float-right">{{$myshift->status}}</a>
                                                                                                                            </li>
                                                                                                                            <li class="list-group-item">
                                                                                                                                <a href="/myshifts/{{$myshift->id}}"
                                                                                                                                   class="btn btn-primary btn-block"><b>View
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
                                                                                                You do not have any past
                                                                                                shifts.
                                                                                            @endif


                                                                                    </div>
                                                                            </div>


                                                                </div>


                                                        </div>


                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card card-outline card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Children</h3>
                                                           <div class="card-tools">
                                                               <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>


                                                           </div>
                                                        </div>
                                                        <div class="card-body">
                                                            @foreach ($children as $child)
                                                              @foreach ($child['child'] as $childModel)
                                                                    {{$childModel->initials}}
                                                                @endforeach


                                                                 <!-- <div id="childCardDIV-{{$childModel->id}}" class="card card-success"> -->
                                                                    Activity Wall


                                                                                                  <div class="card-header"
                                                                                                       id="child-{{$childModel->id}}">
                                                                                                      <h3 class="card-title">Activity Wall
                                                                                                      </h3>
                                                                                                      <div class="card-tools">
                                                                                                          <!-- Collapse Button -->
                                                                                                          <button type="button"
                                                                                                                  class="btn btn-tool"
                                                                                                                  data-card-widget="collapse">

                                                                                                                      <i class="fas fa-minus"></i>
                                                                                                          </button>


                                                                                                      </div>
                                                                                                  </div>

                                                                                                  <div class="card-body">

                                                                                                          @if ($child['activities']->count() >= 0)
                                                                                                      @foreach ($child['activities'] as $childAW)

                                                                                                             <div class="post">
                                                                                                                  <div class="user-block">
                                                                                                                      <img class="img-circle img-bordered-sm" src="/img/ws_icon.jpg"
                                                                                                                           alt="user image">
                                                                                                                      <span class="username">
                                                                            <a href="#">{{$childAW->causer->name}}</a>
                        </span>
                                                                                                                      <span
                                                                                                                          class="description">Posted {{ $diff = Carbon\Carbon::parse($childAW->updated_at)->diffForHumans(Carbon\Carbon::now()) }}</span>
                                                                                                                  </div>
                                                                                                                  <!-- /.user-block -->
                                                                                                                  <p>

                                                                                                                  @if ($childAW->event == "Photo")
                                                                                                                      <div class="col-md-8"><a
                                                                                                                              href="/storage/activities_photos/{{substr($childAW->description,25)}}"><img
                                                                                                                                  width="50%"
                                                                                                                                  src="/storage/activities_photos/{{substr($childAW->description,25)}}"/></a>
                                                                                                                      </div>
                                                                                                                      @endif
                                                                                                                      @if ($childAW->event == "Message")
                                                                                                                      {{$childAW->description}}
                                                                                                                      @endif
                                                                                                                      </p>

                                                                                                              </div>
                                                                                                          @endforeach
                                                                                                          <div class="d-flex justify-content-center">
                                                                                                              {!! $child['activities']->links() !!}
                                                                                                          </div>
                                                                                                      @endif


                                                                                                  </div>
                                                                                              </div>



                                                                                              @endforeach

                                                </div>
                                                <!-- /.row (main row) -->
                                                    </div>
                                                </div>

                                </div><!-- /.container-fluid -->
                                <!-- TO DO List -->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="ion ion-clipboard mr-1"></i>
                                            Announcements
                                        </h3>

                                        <div class="card-tools">
                                            <ul class="pagination pagination-sm">

                                                <li class="page-item"><a href="#"
                                                                         class="page-link">1</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <img src="img/happy_holidays.jpg" width="100%">
                                        <br/>
                                        <p>Happy Holidays!
                                            <br>
                                            <b>We-Schedule.ca Management</b></p>

                                        <hr>

                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <!-- <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button> -->
                                    </div>
                                </div>
                                <!-- /.card -->
                                <!-- /.content -->
                            </div>
                        </div>



@stop
