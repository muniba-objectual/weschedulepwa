@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')




    @unless(Auth::check())
        You are not signed in.
    @endunless

    <!-- Bootstrap 5 -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- *Bootstrap 5 -->

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"
        integrity="sha512-jTgBq4+dMYh73dquskmUFEgMY5mptcbqSw2rmhOZZSJjZbD2wMt0H5nhqWtleVkyBEjmzid5nyERPSNBafG4GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Date Picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Include the overlay-component.css stylesheet -->
    <link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

    <!-- Include the overlay-component.js script -->
    <script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>
    <!-- Alpine Plugins -->
    <script src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <!-- Popperjs -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous">
    </script>
    <!-- Tempus Dominus JavaScript -->
    <script src="/plugins/tempus-dominusv6/js/tempus-dominus.js" crossorigin="anonymous"></script>

    <!-- Tempus Dominus Styles -->
    <link href="/plugins/tempus-dominusv6/css/tempus-dominus.css" rel="stylesheet" crossorigin="anonymous">


    <!--
                                                                                                                                                                                                                                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js"></script>

                                                                                                                                                                                                                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css" integrity="sha512-R+xPS2VPCAFvLRy+I4PgbwkWjw1z5B5gNDYgJN5LfzV4gGNeRQyVrY7Uk59rX+c8tzz63j8DeZPLqmXvBxj8pA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                                                                                                                                                                                                                                -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://unpkg.com/fullcalendar@5.11.0/main.js"></script>

    <style>
        .signature-pad {
            margin-top: 30px;
        }


        .calendar.show {
            max-height: 100% !important;
            transition: max-height 1s ease-in !important;
            visibility: visible;

        }

        .calendar {
            max-height: 0;
            transition: max-height 1s ease-out;
            overflow: hidden;
            visibility: hidden;

        }
    </style>

@stop

@section('content')
    @livewireStyles





    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Profile
                </h1>

            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">User Profile</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @php
                                    // $genderDetector = new \GenderDetector\GenderDetector();
                                    // $gender = $genderDetector->detect(strtok($user->name,' '));
                                @endphp
                                @if (!$user->profile_pic)
                                    {{--
                                        @if ($gender == 'male' || $gender == 'mostly_male')
                                            <img width="75px" src="/img/male{{rand(1,10)}}.jpg" alt="avatar" class="profile-user-img img-fluid img-circle" />


                                        @endif

                                        @if ($gender == 'female' || $gender == 'mostly_female')
                                            <img  width="75px" src="/img/female{{rand(1,10)}}.jpg" alt="avatar" class="profile-user-img img-fluid img-circle" />
                                        @endif

                                        @if ($gender == '' || $gender == 'unisex')
                                            <img height="100px" width="80px" src="/img/ws_icon.jpg" alt="avatar" class="profile-user-img img-fluid img-circle" />
                                        @endif
                                        --}}
                                    <img height="100px" width="100px" src="/img/default-avatar.png" alt="avatar"
                                        class="imaged rounded" />
                                @else
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="/storage/profile_pic/{{ substr($user->profile_pic, 20) }}"
                                        alt="User profile picture">
                                @endif

                            </div>

                            <h3 class="profile-username text-center">{{ $user->name }}

                                <div class="mb-0 mt-3">
                                    @livewire('profile-elements.active-toggle', ['model' => $user])
                                </div>

                                <div class="mb-0 mt-0">
                                    @livewire('profile-elements.on-hold-toggle', ['model' => $user])
                                </div>

                                @if ($user->getSignedInShift)
                                    <span class="badge bg-success">Signed In</span>
                                @else
                                    <span class="badge bg-red">Offline</span>
                                @endif
                            </h3>
                            <h6 class="text-center">{{ $user->get_user_type->name }}</h6>

                            {{--
                            <p class="text-muted text-center">Home - {{$child->get_home->name}}</p>
                               --}}
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Total Shifts</b> <a class="float-right show-calendar"
                                        href="#">{{ $user->getAllPublishedShifts->count() }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Children Assigned ({{ count($user->getAssignedChildren) }})</b>

                                    <div class="float-right">
                                        @if (count($user->getAssignedChildren) > 0)
                                            @foreach ($user->getAssignedChildren as $children)
                                                <a href="/children/{{ $children->id }}">{{ $children->initials }}</a><br />
                                            @endforeach
                                        @else
                                            No children assigned
                                        @endif
                                    </div>

                                </li>



                                <li class="list-group-item">Calendar Color
                                    <div class="float-right">
                                        @livewire('calendar-color-picker', ['userID' => $user->id])
                                    </div>
                                    {{--                                        {{$user->calendarColor ?? "Default [Blue]"}} --}}

                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                </div>
                <!-- /.col -->
                <div class="col-md-9">

                    @if (session('message'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('message') }}
                        </div>
                    @endif


                    <div class="card">
                        <div class="card-header p-2">
                            <ul id="myTab" class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#profile"
                                        data-toggle="tab">Profile</a></li>
                                @if (auth()->user()->user_type == '2.3')
                                    <li class="nav-item"><a class="nav-link" href="#FPAForm" data-toggle="tab">Foster Parent
                                            Application Form</a></li>
                                @endif
                                @if (auth()->user()->user_type == '1' ||
                                        auth()->user()->user_type == '3.3' ||
                                        (auth()->user()->user_type >= 4.0 && auth()->user()->user_type < 6) ||
                                        auth()->user()->user_type == 10)
                                    <li class="nav-item"><a class="nav-link" href="#CYSW" data-toggle="tab">CYSW
                                            Profile</a></li>
                                @endif
                                @if (auth()->user()->user_type == '2' ||
                                        auth()->user()->user_type == '3.3' ||
                                        (auth()->user()->user_type >= 4.0 && auth()->user()->user_type < 6) ||
                                        auth()->user()->user_type == 10)
                                    <li class="nav-item"><a class="nav-link" href="#child_salaries" data-toggle="tab">Child
                                            Salaries/Assignments</a></li>
                                @endif

                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
                                </li>

                                <span class="float-right text-success ml-3">

                                    <script>
                                        $userID = {{ $user->id }};
                                        $AuthUserID = {{ Auth::user()->id }}
                                    </script>
                                    <button type="button" class="btn btn-success"
                                        onclick="javascript:window.livewire.emit('modal.open', 'modals.case-manage.log-call-modal', {'userID':$userID,'AuthUserID':$AuthUserID}, {'size':'md'})">Log
                                        Call</button>
                                    <button type="button" class="btn btn-success"
                                        onclick="javascript:window.livewire.emit('modal.open', 'modals.case-manage.log-meeting-modal', {'userID':$userID,'AuthUserID':$AuthUserID}, {'size':'md'})">Log
                                        Meeting</button>

                                </span>

                            </ul>

                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="profile">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">

                                            <form action="{{ route('users_profile.edit') }}" method="post">
                                                {{ csrf_field() }}

                                                <input type="hidden" id="type" name="type" value="update">
                                                <input type="hidden" id="userID" name="userID"
                                                    value="{{ $user->id }}">

                                                {{-- Name field --}}
                                                <div class="input-group mb-3">
                                                    <input type="text" name="name"
                                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                        value="{{ old('name', $user->name) }}" placeholder="Name"
                                                        autofocus>


                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span
                                                                class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('name'))
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Email field --}}
                                                <div class="input-group mb-3">
                                                    <input type="email" name="email"
                                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                        value="{{ old('email', $user->email) }}"
                                                        placeholder="Email Address">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span
                                                                class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('email'))
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Address field --}}
                                                <div class="input-group mb-3">
                                                    <input type="address" name="address" id="streetAddressSearch"
                                                        class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                                        value="{{ old('address', $user->address) }}"
                                                        placeholder="Address">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span
                                                                class="fas fa-home {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('address'))
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $errors->first('address') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="input-group mb-3">
                                                    <input type="city" name="city" id="city"
                                                        class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                                        value="{{ old('city', $user->city) }}" placeholder="City">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span
                                                                class="fas fa-city {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('city'))
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $errors->first('city') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="input-group mb-3">
                                                    <input type="province" name="province" id="province"
                                                        class="form-control {{ $errors->has('province') ? 'is-invalid' : '' }}"
                                                        value="{{ old('province', $user->province) }}"
                                                        placeholder="Province">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span
                                                                class="fas fa-home {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('province'))
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $errors->first('province') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="input-group mb-3">
                                                    <input type="postal" name="postal" id="postal"
                                                        class="form-control text-uppercase {{ $errors->has('postal') ? 'is-invalid' : '' }}"
                                                        value="{{ old('postal', $user->postal) }}"
                                                        placeholder="Postal Code">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span
                                                                class="fas fa-home {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('postal'))
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $errors->first('postal') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="input-group mb-3">
                                                    <label for="drivers_license">Driver's License</label>
                                                    <p>

                                                        @if ($user->drivers_license)
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <a
                                                                        href="/storage/drivers_license/{{ substr($user->drivers_license, 23) }}"><img
                                                                            width="25%"
                                                                            src="/storage/drivers_license/{{ substr($user->drivers_license, 23) }}" /></a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12">
                                                                Attachment has not been uploaded.
                                                            </div>
                                                        @endif
                                                    </p>
                                                    <!--
                                                                                                                                                                                                                                                                                        <div>

                                                                                                                                                                                                                                                                                            <input type="file" name="drivers_license" id="drivers_license"
                                                                                                                                                                                                                                                                                                   data-url="{{ route('users_profile.edit') }}"
                                                                                                                                                                                                                                                                                                   class="form-control mt-3">
                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                        -->
                                                    @if ($errors->has('drivers_license'))
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $errors->first('drivers_license') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>


                                                <!--
                                                                                                                                                                                                                                                                                {{-- Password field --}}
                                                                                                                                                                                                                                                                            <div class="input-group mb-3">
                                                                                                                                                                                                                                                                                <input type="text" name="password"
                                                                                                                                                                                                                                                                                       class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                                                                                                                                                                                                                                                           placeholder="{{ __('adminlte::adminlte.password') }}">
                                                                                                                                                                                                                                                                                    <div class="input-group-append">
                                                                                                                                                                                                                                                                                        <div class="input-group-text">
                                                                                                                                                                                                                                                                            <span
                                                                                                                                                                                                                                                                                class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                    @if ($errors->has('password'))
    <div class="invalid-feedback">
                                                                                                                                                                                                                                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                                                                                                                                                                                                                                        </div>
    @endif
                                                                                                                                                                                                                                                                            </div>

                                                                                                                                                                                                                            {{-- Confirm password field --}}
                                                                                                                                                                                                                                                                            <div class="input-group mb-3">
                                                                                                                                                                                                                                                                                <input type="text" name="password_confirmation"
                                                                                                                                                                                                                                                                                       class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                                                                                                                                                                                                                                                                           placeholder="{{ __('adminlte::adminlte.retype_password') }}">
                                                                                                                                                                                                                                                                                    <div class="input-group-append">
                                                                                                                                                                                                                                                                                        <div class="input-group-text">
                                                                                                                                                                                                                                                                            <span
                                                                                                                                                                                                                                                                                class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                    @if ($errors->has('password_confirmation'))
    <div class="invalid-feedback">
                                                                                                                                                                                                                                                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                                                                                                                                                                                                                                                        </div>
    @endif
                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                            -->

                                                <div class="input-group mb-3">

                                                    <label for="signature">Signature</label> <br /><br /><br />
                                                    <div class="row">
                                                        <div class="row">
                                                            <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
                                                            <canvas id="signature-pad" class="signature-pad" width=330
                                                                height=200 style="border:1px solid blue;"></canvas>
                                                        </div>
                                                        <script>
                                                            var canvas = document.querySelector("canvas");

                                                            var signaturePad = new SignaturePad(canvas, {
                                                                //minWidth: 5,
                                                                //maxWidth: 10,
                                                                penColor: "blue"
                                                            });
                                                            signaturePad.off()
                                                            signaturePad.addEventListener("endStroke", () => {
                                                                //   console.log("Signature ended");
                                                                //   document.getElementById("signature").value = signaturePad.toDataURL();

                                                            }, {
                                                                once: true
                                                            })

                                                            @if ($user->signature)
                                                                signaturePad.fromDataURL('{{ $user->signature }}', {
                                                                    width: 330,
                                                                    height: 200
                                                                });
                                                            @endif
                                                        </script>
                                                    </div>
                                                </div>

                                                {{-- Register button --}}
                                                <button type="submit"
                                                    class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                                                    <span class="fas fa-save"></span>
                                                    Update User Profile
                                                </button>

                                            </form>


                                        </div>

                                        <!-- /.card -->

                                    </div>
                                </div>

                                <div class="tab-pane" id="timeline">
                                    <script>
                                        $(document).ready(function() {
                                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                            $.ajax({
                                                /* the route pointing to the post function */
                                                url: "{{ route('user.getTimelineData') }}",
                                                type: 'GET',
                                                /* send the csrf-token and the input to the controller */
                                                data: {
                                                    _token: CSRF_TOKEN,
                                                    page: 1,
                                                    UserID: {{ $user->id }}
                                                },
                                                //dataType: 'JSON',
                                                /* remind that 'data' is the response of the AjaxController */
                                                success: function(data) {
                                                    console.log(data);
                                                    $('#timeline').html(data);
                                                }
                                            });
                                        });
                                    </script>
                                </div>




                                <div class="tab-pane" id="CYSW">

                                    @livewire('c-y-s-w-profile', ['user' => $user])
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="child_salaries">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            @livewire('user-child-salaries', ['user' => $user])


                                        </div>

                                        <!-- /.card -->

                                    </div>
                                </div>

                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->



                    </div>

                    <!-- /.card -->
                </div>
                <div class="card card-primary card-outline calendar">

                    <div id='calendar'></div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        @livewire('modal-pro')
        @livewireScripts

        <script>
            $(function() {
                $(".show-calendar").on("click", function(e) {
                    $(".calendar").toggleClass("show");

                })
                var SITEURL = "{{ url('/') }}";


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

                        right: 'prevWeek,gotoWeekNumber,nextWeek'
                    },


                    customButtons: {
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

                    },

                    initialView: 'timeGridWeek',
                    // contentHeight: 800,
                    height: 'auto',
                    // aspectRatio: 1,



                    editable: false,
                    eventStartEditable: false,
                    selectable: false,


                    eventSources: [


                        {
                            url: SITEURL + "/calendar/getRecords?id={{ $user->id }}",

                            color: '{{ $user->calendarColor ?? 'blue' }}',
                        },


                    ],
                    progressiveEventRendering: true,

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


                    eventClassNames: function(arg) {


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























                var queryPairs = window.location.href.split('?').pop().split('&');
                for (var i = 0; i < queryPairs.length; i++) {
                    var pair = queryPairs[i].split('=');
                    if (pair[1] == 'AW') {
                        $('#myTab a[href="#activity"]').tab('show'); // Select tab by name

                        return;
                    }
                    if (pair[1] == 'SafetyPlan') {
                        $('#myTab a[href="#safety_plan"]').tab('show'); // Select tab by name

                        return;
                    }

                    if (pair[1] == 'Profile') {
                        $('#myTab a[href="#profile"]').tab('show'); // Select tab by name

                        return;
                    }
                }


                window.addEventListener('setToggleActiveStatus', data => {
                    if (data) {
                        $('#customSwitch1').prop('checked', true)
                    } else {
                        $('#customSwitch1').prop('checked', false)

                    }
                })

                window.addEventListener('setToggleOnHoldStatus', data => {
                    if (data) {
                        $('#customSwitch2').prop('checked', true)
                    } else {
                        $('#customSwitch2').prop('checked', false)

                    }
                })
                $(document).ready(function() {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $("#customSwitch1").on('change', function() {
                        console.log('change event', $(this).is(':checked'));
                        $.ajax({
                            /* the route pointing to the post function */
                            url: "{{ route('user.updateUserStatus', Auth::id()) }}",
                            type: 'POST',
                            /* send the csrf-token and the input to the controller */
                            data: {
                                _token: CSRF_TOKEN,
                                active: $(this).is(':checked'),
                                user: {{ $user->id }}
                            },
                            dataType: 'JSON',
                            /* remind that 'data' is the response of the AjaxController */
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    });

                    $("#customSwitch2").on('change', function() {
                        console.log('OnHold change event', $(this).is(':checked'));
                        $.ajax({
                            /* the route pointing to the post function */
                            url: "{{ route('user.updateUserHoldStatus', Auth::id()) }}",
                            type: 'POST',
                            /* send the csrf-token and the input to the controller */
                            data: {
                                _token: CSRF_TOKEN,
                                OnHold: $(this).is(':checked'),
                                user: {{ $user->id }}
                            },
                            dataType: 'JSON',
                            /* remind that 'data' is the response of the AjaxController */
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    });



                });

            });
        </script>


        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7gZgrs12bkKHrcUN5ySRN-UIOZorEV6U&libraries=places">
        </script>
        <script>
            google.maps.event.addDomListener(window, 'load', function() {
                const options = {

                    componentRestrictions: {
                        country: "ca"
                    },
                    //fields: ["address_components", "geometry", "icon", "name"],

                };

                function getAddressComponent(place, componentName, property) {
                    var comps = place.address_components.filter(function(component) {
                        return component.types.indexOf(componentName) !== -1;
                    });

                    if (comps && comps.length && comps[0] && comps[0][property]) {
                        return comps[0][property];
                    } else {
                        return null;
                    }
                }
                var places = new google.maps.places.Autocomplete(document.getElementById('streetAddressSearch'),
                    options);
                google.maps.event.addListener(places, 'place_changed', function() {
                    var place = places.getPlace();
                    var address = place.formatted_address;



                    if (place) {
                        // console.log (place);

                        var city = getAddressComponent(place, 'locality', 'long_name');
                        var province = getAddressComponent(place, 'administrative_area_level_1', 'long_name');
                        var postal = getAddressComponent(place, 'postal_code', 'short_name');
                        var country = getAddressComponent(place, 'country', 'long_name');


                        /*
                        var province = place.address_components[4].long_name;
                        var city = place.address_components[2].long_name;
                        var postal = place.address_components[6].long_name;
                        */
                        //document.getElementById('txtCountry').value = country;


                        document.getElementById('streetAddressSearch').value = place.name;
                        document.getElementById('city').value = city;
                        document.getElementById('province').value = province;
                        document.getElementById('postal').value = postal;
                    }


                });
            });
        </script>
    @stop
