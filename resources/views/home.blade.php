@extends('adminlte::page')

@section('title', 'We-Schedule')

@section('content_header')

    {{-- redirect CYSW to mobile site --}}
    @if($user->user_type == "1")
        <script>window.location.href = "/mobile";</script>

    @endif

    {{-- redirect user_type >= 2.3 to Case Manage --}}
    @if($user->user_type == "2.3")
        <script>window.location.href = "https://casemanage.ca";</script>

    @endif
    <h1 class="m-0 text-dark">Dashboard</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless

    <link href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css" rel="stylesheet">

    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>

    @livewireStyles


@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->

            @if (auth()->user()->user_type == "3.4")

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h5>Shift Management</h5>

                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar"></i>
                    </div><br />
                    <a href="/calendar" class="small-box-footer">Manage Shifts <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        @endif

            @if (auth()->user()->user_type == "3.3" ||  auth()->user()->user_type == "4.0" || auth()->user()->user_type == "4.1" || auth()->user()->user_type == "4.2" || auth()->user()->user_type == "4.3"  || auth()->user()->id == 1 || auth()->user()->id == 2)

            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h5>Staff Management</h5>

                        </div>

                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div><br />

                            <a href="/users/" class="small-box-footer">Manage Staff <i
                                    class="fas fa-arrow-circle-right"></i></a>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h5>Home Management</h5>

                        </div>
                        <div class="icon">
                            <i class="fas fa-home"></i>
                        </div><br />
                        <a href="/homes" class="small-box-footer">Manage Homes <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h5>Child Management</h5>

                        </div>
                        <div class="icon">
                            <i class="fas fa-child"></i>
                        </div><br />
                        <a href="/children" class="small-box-footer">Manage Children <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h5>Shift Management</h5>

                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div><br />
                        <a href="/calendar" class="small-box-footer">Manage Shifts <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            @endif

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

            {{--
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


                 </div>
        </div>
--}}

        <style>

            .child-small {
                /*font-size: 0.7rem;*/
            }

            .card {

                border: none;
                border-radius: 10px;
                background-color: #fff
            }



        </style>

            @if ($user->user_type == 2 | $user->user_type == 3 | $user->user_type == 4 || $user->id == 1 || $user->id == 2 || $user->user_type = 4.2 || $user->user_type = 5.1 )

             @livewire('dashboard-elements.lists.child-profiles', ['toggleActive' => 'toggleActive'])

            @livewire('dashboard-elements.lists.c-y-s-w-profiles',['toggleActive' => 'toggleActive','users' => $users])


{{--
            <!-- CYSW Profiles -->
        <div class="container-fluid">
            <div class="row justify-content-md">

                    <div class="container-fluid mt-3 mb-3">
                        CYSW PROFILES

                        <div class="row gx-4 gx-lg-5 row-cols-6 row-cols-md-6 row-cols-xl-6 mt-2 justify-content-center">
                            @foreach ($users as $user)
                                <div class="col-xl-2 col-md-2 mb-4">
                                    <div class="card border-0 shadow">
                                        @if (!$user->profile_pic)


                                            <img height="150px" src="/img/default-avatar.png" alt="avatar" class="card-img-top" />
                                        @else

                                            <img height="150px" src="/storage/profile_pic/{{substr($user->profile_pic,20)}}" alt="avatar" class="card-img-top imaged rounded mr-2">
                                        @endif
                                            @if ($user->getSignedInShift)
                                                <span class="badge bg-success mt-0">Signed In</span>
                                            @else
                                                <span class="badge bg-red mt-0">Offline</span>

                                            @endif
                                        <div class="card-body text-center">
                                            <h6 class="mb-0 text-center @php
                                                if (strlen($user->name) >25)
                                                    echo "child-small ";
                                            @endphp">                      <br />{{$user->name}}</h6>
                                            <div class="card-text text-black-50">                                            <div class="button mt-2 d-flex flex-row align-items-center"> <button onclick="viewUserProfile('{{$user->id}}')" class="btn btn-sm btn-primary w-100">Profile</button> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>




        </div>
            <!-- *CYSW Profiles -->
--}}

        </div>
        </div>

        @endif

    </section>
    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />

    <script>

        $(document).ready(function(){
            const otherDate = new Date("01 June 2023"); // Carpe Diem 24th Anniversary
            const todayDate = new Date(); // Current or today's date

// Check if the other date matches today's date
            if (
                otherDate.getDate() === todayDate.getDate() &&
                otherDate.getMonth() === todayDate.getMonth() &&
                otherDate.getYear() === todayDate.getYear()
            ) {
                Swal.fire({
                    imageUrl: 'img/Happy 24th Birthday.gif',
                    imageHeight: 200,
                    imageWidth: 600,
                    width:'75%',
                    height:'100%',
                    background:'#fff',
                    position: 'center',
                    backdrop: true,
                    imageAlt: 'Happy 24th Birthday to Carpe Diem!',
                    confirmButtonText: "Thank you for being you!"
                })

            } else {
                // console.log("The date is not today!");
            }

        });

        function viewChildProfile($id) {
            window.location.href = "/children/" + $id;
        }

        function viewUserProfile($id) {
            window.location.href = "/users/" + $id;
        }
    </script>
@stop
