@extends('layouts.mobileCM')
@section('header')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"   integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="   crossorigin="anonymous"></script>

    <script src="/blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
    <script src="/blueimp-file-upload/js/jquery.iframe-transport.js"></script>

    <script src="/blueimp-file-upload/js/jquery.fileupload.js"></script>

    <div class="appHeader bg-primary scrolled">
        <div class="left">
            <a href="#" class="headerButton" data-bs-toggle="offcanvas" data-bs-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            CaseManage.ca (My Profile)
        </div>
        <div class="right">
            <!--
            <a href="#" class="headerButton toggle-searchbox">
                <ion-icon name="search-outline"></ion-icon>
            </a>
            -->
        </div>
    </div>

@stop




@section ('content')
  <style>

    </style>
    @livewireStyles

    <div id="appCapsule" class="full-height">
        @if(session('message'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{session('message')}}
            </div>
        @endif
        <div class="section mt-2">
            <div class="profile-head">
                <div class="avatar">
                    @if (!$user->profile_pic)
                    <img src="/mobilekit/assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                    @else
                        <img src="/storage/profile_pic/{{substr($user->profile_pic,20)}}" alt="avatar" class="imaged w64 rounded">
                    @endif
                </div>
                <div class="in">
                    <h3 class="name">{{$user->name}} [{{$user->get_user_type->name}}]</h3>
                    <h3 class="subtext">

                    </h3>
                </div>
            </div>
        </div>


        <div class="section full mt-2 ">

            <ul class="nav nav-tabs capsuled" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#profile" role="tab">
                        <ion-icon name="person-circle"></ion-icon>MY PROFILE

                    </a>
                </li>


            </ul>

        </div>


        <!-- tab content -->
        <div class="section full  mt-0 mb-0">
            <div class="tab-content">

                <!-- Profile -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel">

                    <div class="wide-block pb-1 pt-2">
                        <div class="pb-4">
                            <form action="{{route('mobileCM_myprofile.edit')}}" method="post">
                                {{ csrf_field() }}

                                Upload Profile Picture
                            <input type="file" name="file_profile_pic" id="file_profile_pic"

                                   class="form-control">
                            </form>
                        </div>
                        <form id="frm_myprofile" action="{{route('mobileCM_myprofile.edit')}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" id="type" name="type" value="update">

                            <input type="hidden" id="signature" name="signature" value="">
                            {{-- Name field --}}
                            <div class="input-group mb-3">
                                <input type="text" name="name"
                                       class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       value="{{ old('name',$user->name) }}" placeholder="Name" autofocus>


                                <div class="input-group-append">
                                    <div class="input-group-text">
                                                <span
                                                    class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>

                            {{-- Email field --}}
                            <div class="input-group mb-3">
                                <input type="email" name="email"
                                       class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       value="{{ old('email',$user->email) }}" placeholder="Email Address">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                                <span
                                                    class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>

                            {{-- Address field --}}
                            <div class="input-group mb-3">
                                <input type="address" name="address"
                                       class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                       value="{{ old('address',$user->address) }}" placeholder="Address">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                                <span
                                                    class="fas fa-home {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                                @if($errors->has('address'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="input-group mb-3">
                                <input type="city" name="city"
                                       class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                       value="{{ old('city',$user->city) }}" placeholder="City">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                                <span
                                                    class="fas fa-city {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                                @if($errors->has('city'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="input-group mb-3">
                                <input type="province" name="province"
                                       class="form-control {{ $errors->has('province') ? 'is-invalid' : '' }}"
                                       value="{{ old('province',$user->province) }}" placeholder="Province">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                                <span
                                                    class="fas fa-home {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                                @if($errors->has('province'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('province') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="input-group mb-3">
                                <input type="postal" name="postal"
                                       class="form-control text-uppercase {{ $errors->has('postal') ? 'is-invalid' : '' }}"
                                       value="{{ old('postal',$user->postal) }}" placeholder="Postal Code">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                                <span
                                                    class="fas fa-home {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                                @if($errors->has('postal'))
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
                                            <a href="/storage/drivers_license/{{substr($user->drivers_license,23)}}"><img
                                                    width="50%"
                                                    src="/storage/drivers_license/{{substr($user->drivers_license,23)}}"/></a>
                                        </div>
                                    </div>
                                    @endif
                                    </p>
                                    <div>
                                        <input type="file" name="drivers_license" id="drivers_license"
                                               data-url="{{ route('mobileCM_myprofile.edit') }}"
                                               class="form-control mt-3">
                                    </div>
                                    @if($errors->has('drivers_license'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('drivers_license') }}</strong>
                                        </div>
                                    @endif
                            </div>


                            {{-- Password field --}}
                            <div class="input-group mb-3">
                                <input type="password" name="password"
                                       class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                       placeholder="{{ __('adminlte::adminlte.password') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                                <span
                                                    class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                                @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>

                            {{-- Confirm password field --}}
                            <div class="input-group mb-3">
                                <input type="password" name="password_confirmation"
                                       class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                       placeholder="{{ __('adminlte::adminlte.retype_password') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                                <span
                                                    class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                                @if($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="input-group mb-3">

                                <label for="signature">Signature</label>
                                <div class="row">

                                <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
                                <canvas id="signature-pad" class="signature-pad" width=330 height=200  style="border:1px solid blue;"></canvas>

                                <script>
                                    var canvas = document.querySelector("canvas");

                                    var signaturePad = new SignaturePad(canvas, {
                                        //minWidth: 5,
                                        //maxWidth: 10,
                                        penColor: "blue"
                                    });

                                    signaturePad.addEventListener("endStroke", () => {
                                     //   console.log("Signature ended");
                                     //   document.getElementById("signature").value = signaturePad.toDataURL();

                                    }, { once: true })

                                    @if ($user->signature)
                                        signaturePad.fromDataURL('{{$user->signature}}',{width: 330, height: 200});
                                    @endif

                                    function submit_form() {
                                        //console.log("Signature ended");
                                        document.getElementById("signature").value = signaturePad.toDataURL();
                                        document.getElementById("frm_myprofile").submit();
                                    }
                                </script>
                                <input type="button" onclick="javascript:signaturePad.clear();" value="Clear Signature" />
                            </div>
                            </div>

                            {{-- Register button --}}
                            <button type="button" onclick="submit_form();"
                                    class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                                <span class="fas fa-save"></span>
                                Update My Profile
                            </button>

                        </form>
                        <script>


                            $('#drivers_license').fileupload({
                                dataType: 'json',
                                formData: {
                                    type: 'AddDriversLicense',


                                    _token: '{{csrf_token()}}'
                                },

                                add: function (e, data) {
                                    $('#loading').text('Uploading...');

                                    data.submit();
                                },
                                done: function (e, data) {
                                    $.each(data.result.files, function (index, file) {
                                        // $('<p/>').html(file.name + ' (' + file.size + ' KB)').appendTo($('#files_list'));
                                        if ($('#file_ids').val() != '') {
                                            $('#file_ids').val($('#file_ids').val() + ',');
                                        }
                                        //   $('#file_ids').val($('#file_ids').val() + file.fileID);
                                    });
                                    // $('#loading').text('');

                                   location.reload();


                                    Toast.fire({
                                        type: 'success',
                                        //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                                        title: 'We-Schedule.ca | Driver\'s License has been added successfully.',
                                        //  icon: 'success',
                                        //  timerProgressBar: true,
                                    })
                                        .then((result) => {
                                            location.reload();
                                        });
                                }

                            });

                            $('#file_profile_pic').fileupload({
                                dataType: 'json',
                                formData: {
                                    type: 'AddProfilePic',


                                    _token: '{{csrf_token()}}'
                                },

                                add: function (e, data) {
                                    $('#loading').text('Uploading...');

                                    data.submit();
                                },
                                done: function (e, data) {
                                    $.each(data.result.files, function (index, file) {
                                        // $('<p/>').html(file.name + ' (' + file.size + ' KB)').appendTo($('#files_list'));
                                        if ($('#file_ids').val() != '') {
                                            $('#file_ids').val($('#file_ids').val() + ',');
                                        }
                                        //   $('#file_ids').val($('#file_ids').val() + file.fileID);
                                    });
                                    // $('#loading').text('');

                                            location.reload();

                                }

                            });


                        </script>

                    </div>
                </div>
                <!-- * Profile -->



            </div>
        </div>
        <!-- * tab content -->
        <!-- app footer -->
        <div class="appFooter pb-8 mt-0 ">
            <img src="/img/casemanage_logo_horz.png" height="50px" alt="icon" class=" mb-2">
            <div class="footer-title">
                Copyright © CaseManage.ca <span class="yearNow"></span>. All Rights Reserved.
            </div>
        </div>
        <!-- * app footer -->
    </div>


    <!-- toast top iconed -->
    <div id="toast-success" class="toast-box toast-top">
        <div class="in">
            <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
            <div class="text">
                <span id="toast-success-message" name="toast-success-message">Saved</span>
            </div>
        </div>
        <!--        <button type="button" class="btn btn-sm btn-text-success close-button">CLOSE</button>
           -->
    </div>
    <!-- * toast top iconed -->

    <!-- toast top iconed -->
    <div id="toast-warning" class="toast-box toast-top">
        <div class="in">
            <ion-icon name="alert-circle" class="text-warning"></ion-icon>
            <div class="text">
                <span id="toast-warning-message" name="toast-warning-message">Error</span>
            </div>
        </div>
        <!--        <button type="button" class="btn btn-sm btn-text-success close-button">CLOSE</button>
           -->
    </div>
    <!-- * toast top iconed -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>


    </script>


    @livewireScripts


@stop
