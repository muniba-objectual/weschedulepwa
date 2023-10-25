@extends('adminlte::page')

@section('title', 'We-Schedule')

@section('content_header')

    <h1 class="m-0 text-dark">Dashboard</h1>
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
                                <br/>{{Str::before($shifts[0]->start,' ')}} <br/>
                                <b>{{$shifts[0]->status}}</b>
                            @else
                                N/A
                            @endif
                            &nbsp;

                        </div>
                        <br/>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        @if ($shifts->count() > 0)

                        <a href="/myshifts/{{$shifts[0]->id}}" class="small-box-footer">View Shift <i
                                class="fas fa-arrow-circle-right"></i></a>
                        @else
                            <a href="/myshifts/#" class="small-box-footer">View Shift <i
                                    class="fas fa-arrow-circle-right"></i></a>
                            @endif
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h5>My Shifts</h5>
                            @if ($shifts->count() > 0)
                                {{$shifts->count()}} Upcoming Shifts <br/>
                                Next Shift: {{$shifts[1]->start}}
                            @else
                                N/A
                            @endif
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <a href="/myshifts" class="small-box-footer">View All Shifts <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h5>My Profile</h5>

                            Manage your We-Schedule User Profile
                            &nbsp;
                        </div>
                        <br/>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="/users/MyProfile" class="small-box-footer">Manage Profile <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h5>Alerts / Messages</h5>

                            View your alerts and notifications
                            &nbsp;

                        </div>
                        <br/>
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


            <!--  <div class="row">

              <span class="fa-stack fa-8x">
    <i class="fas fa-comment fa-stack-4x"></i>
    <i class="fas fa-twitter fa-stack-4x"></i>
  </span>
                  <span class="fa-stack fa-8x">
    <i class="fas fa-circle fa-stack-8x"></i>
    <i class="fas fa-flag fa-stack-8x"></i>
  </span>
                  <span class="fa-stack fa-2x">
    <i class="fas fa-square fa-stack-2x"></i>
    <i class="fas fa-terminal fa-stack-1x fa-inverse"></i>
  </span>
                  <span class="fa-stack fa-4x">
    <i class="fas fa-square fa-stack-2x"></i>
    <i class="fas fa-terminal fa-stack-1x fa-inverse"></i>
  </span>
              </div>
  -->
@if (isset($children))
      Children
            @foreach ($children as $child)
                @foreach ($child['child'] as $childModel)
                    <div class="row">


                        <style>
                            .btn-lg {
                                font-size: 20px;
                            }
                        </style>

                        <div class="card collapsed-card card-primary" style="width:100%">
                            <div class="card-header">
                                <h3 class="card-title">                    {{$childModel->initials}}
                                </h3>
                                <div class="card-tools">
                                    <!-- Collapse Button -->
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i></button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="card-group">
                                    <div class="col-md-3 col-xs-6">
                                        <div class="card">
                                            <div class="card-body bg-gradient-dark text-center">

                                                <h5 class="text-center">Activity Wall</h5>
                                                <p class="card-text"><i class="fas fa-comment fa-3x"></i></p>
                                                <a class="btn-lg bg-primary" href="/children/{{$childModel->id}}?nav=AW">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-xs-6">
                                        <div class="card">
                                            <div class="card-body bg-gradient-dark text-center">

                                                <h5 class="text-center">Safety Plan</h5>
                                                <p class="card-text"><i class="fas fa-briefcase-medical fa-3x"></i></p>
                                                <a class="btn-lg bg-primary" href="/children/{{$childModel->id}}?nav=SafetyPlan">
                                                    View
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-3 col-xs-6">

                                        <div class="card">
                                            <div class="card-body bg-gradient-dark text-center">

                                                <h5 class="text-center">Calendar Entries</h5>
                                                <p class="card-text"><i class="fas fa-calendar-alt fa-3x"></i></p>
                                                <a class="btn-lg bg-primary" href="/calendar?child={{$childModel->id}}">
                                                    View
                                                </a>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-xs-6">

                                        <div class="card">
                                            <div class="card-body bg-gradient-dark text-center">

                                                <h5 class="text-center">Child Profile</h5>
                                                <p class="card-text"><i class="fas fa-child fa-3x"></i></p>
                                                <a class="btn-lg bg-primary" href="/children/{{$childModel->id}}?nav=Profile">
                                                    View
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    </div>


                @endforeach
            @endforeach
@endif
        </div>

    </section>


@stop
