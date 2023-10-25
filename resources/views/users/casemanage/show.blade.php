@extends('adminlte::page')


@section('title', 'CaseManage.ca')

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

    <!-- Include the overlay-component.css stylesheet -->
    <link rel="stylesheet" href="{{ asset('vendor/wire-elements-pro/css/bootstrap-overlay-component.css') }}">

    <!-- Include the overlay-component.js script -->
    <script src="{{ asset('vendor/wire-elements-pro/js/overlay-component.js') }}"></script>
    <!-- Alpine Plugins -->
    <script src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>


    <style>
        .signature-pad {
            margin-top: 30px;
        }
    </style>

@stop

@section('content')
    @livewireStyles




    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Profile</h1>
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
                            </h3>
                            <h6 class="text-center"> @livewire('dashboard-elements.text.case-manage.user-type', ['user' => $user])
                            </h6>

                            {{--
                            <p class="text-muted text-center">Home - {{$child->get_home->name}}</p>
                               --}}
                            <ul class="list-group list-group-unbordered mb-3">

                                <li class="list-group-item">

                                    <script>
                                        $userID = {{ $user->id }};
                                    </script>
                                    @if ($user->user_type >= '2.0' && $user->user_type < '3.0')
                                        <b><a href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.manage-case-manager-modal', {'userID':$userID}, {'size':'md'})"
                                                class="mt-2">Case Manager</a></b>
                                        <!--
                                                 (show all users for Case Manager Assigned Popup)
                                                 -->
                                        <div class="float-right">
                                            @livewire('dashboard-elements.text.case-manage.case-manager', ['user' => $user])

                                        </div>
                                    @endif

                                    @if ($user->user_type >= '3.0' && $user->user_type <= '10.0')
                                        <b>Foster Parents</b>

                                        <div class="float-right">
                                            @livewire('dashboard-elements.text.case-manage.get-staff-from-case-manager', ['user' => $user])
                                        </div>
                                    @endif
                                </li>

                            </ul>
                            @if (session('impersonated_by'))
                                <a href="{{ route('users.leave-impersonate') }}" class="btn btn-success me-2">Leave
                                    Impersonation</a>
                            @endif
                            @if (auth()->user()->user_type == 10.0)


                                @if ($user->id != auth()->id())
                                    <a href="{{ route('users.impersonate', $user->id) }}"
                                        class="btn btn-warning btn-sm">Impersonate</a>
                                @endif

                                <a href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.change-user-type-modal', {'userID':$userID}, {'size':'md'})"
                                    class="btn btn-primary btn-sm">Change User Type</a>
                            @endif
                            @if ($user->user_type >= '2.0' && $user->user_type < '3.0')
                                <br />

                                <!--

                                    <a href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.manage-case-manager-modal', {'userID':$userID}, {'size':'md'})" class="btn btn-primary btn-sm mt-2"><i
                                            class="fas fa-user-circle"></i> Manage Case Manager</a>
                                   -->
                            @endif

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
                    <?php
                        $isFosterParent = in_array($user->user_type, \App\CustomClasses\DynamicExpenseBuilder\ExpenseConfig::roleMapping()['foster-parent']);
                    ?>


                        <div class="card">
                        <div class="card-header p-2">
                            <ul id="myTab" class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#profile"
                                        data-toggle="tab">Profile</a></li>
                                @if (auth()->user()->user_type == '2.3')
                                    <li class="nav-item"><a class="nav-link" href="#FPAForm" data-toggle="tab">Foster Parent
                                            Application Form</a></li>
                                @endif
                                @if (auth()->user()->user_type >= '3.0')
                                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
                                    </li>
                                @endif
                                @if(/*auth()->user()->user_type >= '10.0' &&*/ $isFosterParent)
                                    <li class="nav-item"><a class="nav-link" href="#foster_parent_learning" data-toggle="tab">Foster Parent Learning</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#secondary_foster_parent_learning" data-toggle="tab">Secondary Foster Parent Learning</a>
                                    </li>
                                @endif
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
                                                    <input @if (Auth::user()->id == 1 || Auth::user()->id == 2) @else readonly @endif
                                                        type="text" name="name"
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
                                                    <input @if (Auth::user()->id == 1 || Auth::user()->id == 2) @else readonly @endif
                                                        type="email" name="email"
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
                                                    <input @if (Auth::user()->id == 1 || Auth::user()->id == 2) @else readonly @endif
                                                        type="address" name="address" id="streetAddressSearch"
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
                                                    <input @if (Auth::user()->id == 1 || Auth::user()->id == 2) @else readonly @endif
                                                        type="city" name="city" id="city"
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
                                                    <input @if (Auth::user()->id == 1 || Auth::user()->id == 2) @else readonly @endif
                                                        type="province" name="province" id="province"
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
                                                    <input @if (Auth::user()->id == 1 || Auth::user()->id == 2) @else readonly @endif
                                                        type="postal" name="postal" id="postal"
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
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse ">


                                        @if ($timeline_data->count() > 0)
                                            {{-- $myshift_timeline --}}
                                            @foreach ($timeline_data as $key => $timeline)
                                                <div class="time-label">
                                                    <span class="bg-success">
                                                        {{ $key }}

                                                    </span>
                                                </div>


                                                @foreach ($timeline as $details)
                                                    <div>

                                                        @if ($details->event == 'IR')
                                                            <i class="fas fa-exclamation bg-red"></i>


                                                        @elseif ($details->event == 'Medication')
                                                            <i class="fas fa-prescription-bottle bg-green"></i>

                                                        @elseif ($details->event == 'EndOfShiftForm')
                                                            <i class="fas fa-business-time bg-blue"></i>


                                                        @elseif ($details->event == 'ShiftSignIn')
                                                            <i class="fas fa-hourglass-start bg-gradient-green"></i>


                                                        @elseif ($details->event == 'ShiftSignOut')
                                                            <i class="fas fa-hourglass-end bg-gradient-red"></i>


                                                        @elseif ($details->event == 'HomeVisit')
                                                            <i class="fas fa-home bg-gradient-yellow"></i>


                                                        @elseif ($details->event == 'OnCall')
                                                            <i class="fas fa-clipboard bg-gradient-orange"></i>


                                                        @elseif ($details->event == 'LogCall')
                                                            <i class="fas fa-phone bg-gradient-purple"></i>


                                                        @elseif ($details->event == 'LogMeeting')
                                                            <i class="fas fa-calendar bg-gradient-lightblue"></i>

                                                        @elseif ($details->event == 'PreAdmissionEmailed')
                                                            <i class="fa fa-solid fa-child bg-gradient-yellow"></i>
                                                        @endif

                                                        <div class="timeline-item">
                                                            <span class="time"><i class="far fa-clock"></i>
                                                                {{ $diff = Carbon\Carbon::parse($details->updated_at)->format('D M d @h:i A') }}</span>


                                                            @if ($details->event == 'IR')
                                                                <h3 class="timeline-header">
                                                                    {{ App\Models\User::getUser($details->causer_id)->name }}
                                                                    submitted an <span class="font-weight-bold"><a
                                                                            href="javascript:viewIR({{ $details->properties }});">Incident
                                                                            Report</a></span>
                                                                </h3>

                                                            @elseif ($details->event == 'Medication')
                                                                <h3 class="timeline-header">
                                                                    {{ App\Models\User::getUser($details->causer_id)->name }}
                                                                    submitted a <span class="font-weight-bold">Medication
                                                                        Entry</span>
                                                                </h3>

                                                            @elseif ($details->event == 'EndOfShiftForm')
                                                                <h3 class="timeline-header panel-heading"
                                                                    data-toggle="collapse" role="button"
                                                                    aria-expanded="true"
                                                                    aria-controls="#collapseddiv_{{ $details->id }}"
                                                                    data-target="#collapseddiv_{{ $details->id }}">
                                                                    {{ App\Models\User::getUser($details->causer_id)->name }}
                                                                    submitted an <span class="font-weight-bold">End of
                                                                        Shift Report</span>
                                                                </h3>

                                                            @elseif ($details->event == 'ShiftSignIn')
                                                                <h3 class="timeline-header">
                                                                    {{ App\Models\User::getUser($details->causer_id)->name }}
                                                                    <span class="font-weight-bold">Signed In</span>
                                                                </h3>

                                                            @elseif ($details->event == 'ShiftSignOut')
                                                                <h3 class="timeline-header">
                                                                    {{ App\Models\User::getUser($details->causer_id)->name }}
                                                                    <span class="font-weight-bold">Signed Out</span>
                                                                </h3>

                                                            @elseif ($details->event == 'HomeVisit')
                                                                <h3 class="timeline-header">
                                                                    {{ App\Models\User::getUser($details->causer_id)->name }}
                                                                    submitted a <span class="font-weight-bold">Home Site
                                                                        Visit Entry</span>
                                                                    @if ($details->properties->first())
                                                                        at <span
                                                                            class="font-weight-bold">{{ App\Models\User::getUser($details->properties->first())->name }}
                                                                            [{{ App\Models\User::getUser($details->properties->first())->address }}]</span>
                                                                    @endif
                                                                </h3>

                                                            @elseif ($details->event == 'LogCall')
                                                                <h3 class="timeline-header">
                                                                    {{ App\Models\User::getUser($details->subject_id)->name }}
                                                                    submitted a <span class="font-weight-bold">Log Call
                                                                        Entry for
                                                                        {{ App\Models\User::getUser($details->causer_id)->name }}</span>
                                                                </h3>

                                                            @elseif ($details->event == 'OnCall')
                                                                <h3 class="timeline-header">
                                                                    {{ App\Models\User::getUser($details->causer_id)->name }}
                                                                    submitted an <span class="font-weight-bold">On-Call
                                                                        Entry</span>
                                                                    @if ($details->properties->first())
                                                                        at <span
                                                                            class="font-weight-bold">{{ App\Models\User::getUser($details->properties->first())->name }}
                                                                            [{{ App\Models\User::getUser($details->properties->first())->address }}]</span>
                                                                    @endif
                                                                </h3>

                                                            @elseif ($details->event == 'LogMeeting')
                                                                <h3 class="timeline-header">
                                                                    {{ App\Models\User::getUser($details->subject_id)->name }}
                                                                    submitted a <span class="font-weight-bold">In-Person
                                                                        Meeting Entry for
                                                                        {{ App\Models\User::getUser($details->causer_id)->name }}</span>
                                                                </h3>

                                                            @elseif ($details->event == 'PreAdmissionEmailed')
                                                                <?php
                                                                    /** @var \App\Models\DocumentShare $documentShare */
                                                                    $documentShare = \App\Models\DocumentShare::find($details->subject_id);
                                                                ?>
                                                                <h3 class="timeline-header">
                                                                    {{ App\Models\User::getUser($details->causer_id)->name }} emailed a
                                                                    <span class="font-weight-bold">`Pre-Admission Form`</span> to
                                                                    <span class="font-weight-bold">`{{implode('`, `', $documentShare->email)}}`</span> on
                                                                    <span class="font-weight-bold">`{{$documentShare->email_sent_at}}`</span>
                                                                </h3>

                                                            @endif

                                                            @if (
                                                                $details->event == 'IR' ||
                                                                $details->event == 'Medication' ||
                                                                $details->event == 'EndOfShiftForm' ||
                                                                $details->event == 'HomeVisit' ||
                                                                $details->event == 'LogCall' ||
                                                                $details->event == 'OnCall' ||
                                                                $details->event == 'LogMeeting' ||
                                                                $details->event == 'PreAdmissionEmailed'
                                                            )
                                                                <div @if ($details->event == 'EndOfShiftForm') class="collapse" @endif id="collapseddiv_{{ $details->id }}">
                                                                    <div class="timeline-body" class="panel-heading">
                                                                        <p class="ml-2">
                                                                            @if ($details->event == 'EndOfShiftForm')
                                                                                @if ($shiftDetails = \App\Models\Shift::find($details->properties->first()))
                                                                                @endif

                                                                                @if ($shiftDetails)
                                                                                    @if ($shiftForm = \App\Models\Shift_Form::findOrFail($shiftDetails->fk_ShiftFormID))
                                                                                    @endif
                                                                                @else
                                                                                    @php
                                                                                        $shiftForm = null;
                                                                                    @endphp
                                                                                @endif

                                                                                @if ($shiftForm)
                                                                                    Date/Time: {{ $shiftForm['datetime'] }}
                                                                                    <br />
                                                                                    Mood Upon
                                                                                    Arrival:
                                                                                    {{ $shiftForm['mood_upon_arrival'] }}
                                                                                    <br />
                                                                                    Interaction with
                                                                                    Staff:
                                                                                    {{ $shiftForm['interaction_with_staff'] }}
                                                                                    <br />
                                                                                    General
                                                                                    Observations:
                                                                                    {{ $shiftForm['general_observations'] }}
                                                                                    <br />
                                                                                    Dietary
                                                                                    Notes: {{ $shiftForm['dietary_notes'] }}
                                                                                    <br />
                                                                                    <br />
                                                                                    *Last
                                                                                    Updated: {{ $shiftForm['updated_at'] }}
                                                                                @endif

                                                                                {{-- var_dump(json_decode($details->description, true)) --}}
                                                                            @elseif($details->event == 'PreAdmissionEmailed')
                                                                                    <?php
                                                                                    $form = new \App\Models\TempFormData();
                                                                                    $form->forceFill($details->properties['form-data']);
                                                                                    ?>
                                                                                <br/>
                                                                                <span><i class="fas fa-file-alt"></i></span>
                                                                                <a href="/TestFormBuilder/3/{{$form->id}}?back-text=Timeline">
                                                                                    {{$form->getVal('child_name', 'Un-named Child')}}'s pre-admission form
                                                                                </a>
                                                                            @else
                                                                                {{ $details->description }}
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <div class="timeline-footer"></div>
                                                        </div>
                                                    </div>
                                                    <!-- END timeline item -->
                                                @endforeach
                                                </ul>
                                                {{-- $timeline --}}
                                            @endforeach
                                        @endif
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                @if(/*auth()->user()->user_type >= '10.0' &&*/ $isFosterParent)
                                    <div class="tab-pane" id="foster_parent_learning">
                                        <div class="row">
                                            <div class="col-md-12">

                                                @livewire('forms.case-manage.temp.foster-parent-learning-list', [$user->id])

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="secondary_foster_parent_learning">
                                        <div class="row">

                                            @livewire('forms.case-manage.secondary-foster-parent-learning', [$user])

                                            <script>
                                                $(document).ready(function() {
                                                    var secondaryLearningForm = $('#secondaryFosterParentLearningForm');

                                                    handleSecondaryForm();

                                                    window.addEventListener('secondary-switch-state-changed', event => {
                                                        handleSecondaryForm();
                                                    });

                                                    function handleSecondaryForm(){
                                                        if( $('#secondaryFosterParentLearningFormToggleSwitch').prop('checked') ){
                                                            secondaryLearningForm.show();
                                                        }else{
                                                            secondaryLearningForm.hide();
                                                        }
                                                    }
                                                });
                                            </script>

                                            {{-- The secondary form --}}
                                            <div class="col-md-12" id="secondaryFosterParentLearningForm">
                                                <hr>

                                                <div class="col-md-12">

                                                    <table class="table table-bordered table-hover">
                                                        <tr>
                                                            <th>Date Created</th>
                                                            <th>Date Updated</th>
                                                            <th>Description</th>
                                                            <th>Action</th>
                                                        <tr>
                                                        <tr>
                                                            <td>
                                                                {{$user->fosterParentSecondaryLearningForm->created_at->format('M jS Y')}}
                                                            </td>
                                                            <td>
                                                                {{$user->fosterParentSecondaryLearningForm->updated_at->format('M jS Y')}}
                                                            </td>
                                                            <td>
                                                                @if($user->getFosterParentFormPivot->is_secondary_draft)
                                                                    Draft
                                                                @else
                                                                    Saved
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="/TestFormBuilder/1/{{ $user->fosterParentSecondaryLearningForm->id }}/?back-text=Foster Parent (Secondary) {{$user->name}}&back-url={{urlencode("/users/{$user->id}#secondaryFosterParentLearningForm")}}" class="btn btn-primary">
                                                                    Edit Draft
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @foreach($user->fosterParentSecondaryLearningFormHistory->sortByDesc('created_at')??[] as $historyForm)
                                                            <tr>
                                                                <td>
                                                                    {{$historyForm->created_at->format('M jS Y')}}
                                                                </td>
                                                                <td>
                                                                    {{$historyForm->updated_at->format('M jS Y')}}
                                                                </td>
                                                                <td>
                                                                    Submitted
                                                                </td>
                                                                <td>
                                                                    <a href="/TestFormBuilder/1/{{ $user->fosterParentSecondaryLearningForm->id }}/?PDF=true&back-text=Foster Parent (Secondary) {{$user->name}}&back-url={{urlencode("/users/{$user->id}#secondaryFosterParentLearningForm")}}" class="btn btn-primary">
                                                                        View PDF
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->

                                @endif

                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        @livewire('modal-pro')
        @livewireScripts

        <script>
            $(function() {

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
