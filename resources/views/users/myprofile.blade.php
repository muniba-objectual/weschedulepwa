@extends('adminlte::page')


@section('title', 'We-Schedule')

@section('content_header')
    @livewireStyles

    <!-- Bootstrap 5 -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- *Bootstrap 5 -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"
            integrity="sha512-jTgBq4+dMYh73dquskmUFEgMY5mptcbqSw2rmhOZZSJjZbD2wMt0H5nhqWtleVkyBEjmzid5nyERPSNBafG4GQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7gZgrs12bkKHrcUN5ySRN-UIOZorEV6U&libraries=places"></script>

    <script>
        $(document).ready(function () {
// Javascript to enable link to tab
            var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#'+url.split('#')[1]+'"]').tab('show') ;
            }

// With HTML5 history API, we can easily prevent scrolling!
            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                if(history.pushState) {
                    history.pushState(null, null, e.target.hash);
                } else {
                    window.location.hash = e.target.hash; //Polyfill for old browsers
                }
            })

  //  $(":input").inputmask();
                //Livewire.on('refreshme', () => {
            //})

            Livewire.on('$refresh', () => {
     alert ("CYSW Record Updated Successfully.")


            })

        });



        google.maps.event.addDomListener(window, 'load', function () {
            const options = {

                componentRestrictions: { country: "ca" },
                //fields: ["address_components", "geometry", "icon", "name"],

            };

            function getAddressComponent(place, componentName, property) {
                var comps = place.address_components.filter(function(component) {
                    return component.types.indexOf(componentName) !== -1;
                });

                if(comps && comps.length && comps[0] && comps[0][property]) {
                    return comps[0][property];
                } else {
                    return null;
                }
            }
            var places = new google.maps.places.Autocomplete(document.getElementById('address'),options);
            google.maps.event.addListener(places, 'place_changed', function () {
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


                    document.getElementById('address').value = place.name;
                    document.getElementById('city').value = city;
                    document.getElementById('province').value = province;
                    document.getElementById('postal').value = postal;
                }


            });


        });

    </script>
    <h1 class="m-0 text-dark">My Profile</h1>
    @unless (Auth::check())
        You are not signed in.
    @endunless


@stop

@section('content')
    @if ($updateValue ?? '')
        <script>

            $(document).ready(function () {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });


                Toast.fire({
                    type: 'success',
                    //title: 'We-Schedule.ca | Shift Form updated successfully.<br /> (' + data.success + "|" + data.message + ')',
                    title: 'We-Schedule.ca | User Profile has been updated successfully.',
                    icon: 'success',
                    timerProgressBar: true,


                })


            });

        </script>
    @endif

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-lg-6 col-sm-6 ">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="myprofile-tab" data-toggle="pill" href="#myprofile"
                                   role="tab" aria-controls="myprofile-tab" aria-selected="true">My Profile</a>
                            </li>
                            @if ($user->user_type == 1)
                                <li class="nav-item">
                                    <a class="nav-link" id="cysw-profile-tab" data-toggle="pill" href="#cysw-profile"
                                       role="tab" aria-controls="cysw-profile-tab" aria-selected="true">CYSW Profile</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="tabcontent">
                            <div class="tab-pane fade active show" id="myprofile" role="tabpanel"
                                 aria-labelledby="myprofile-tab">
                                <form action="{{route('users_myprofile.edit')}}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="type" name="type" value="update">
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
                                        <input type="address" name="address" id="address"
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
                                        <input type="city" name="city" id="city"
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
                                        <input type="province" name="province" id="province"
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
                                        <input type="postal" name="postal" id="postal"
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

                                    <label class="mb-0" for="drivers_license">Driver's License</label>

                                    <div class="input-group mt-0 pl-0 mb-3">
                                        <p>

                                        @if ($user->drivers_license)
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <a href="/storage/drivers_license/{{substr($user->drivers_license,23)}}"><img
                                                            width="25%"
                                                            src="/storage/drivers_license/{{substr($user->drivers_license,23)}}"/></a>
                                                </div>
                                            </div>
                                            @endif
                                            </p>
                                            <div>
                                                <input type="file" name="drivers_license" id="drivers_license"
                                                       data-url="{{ route('users_myprofile.edit') }}"
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


                                    {{-- Register button --}}
                                    <button type="submit"
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

                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 3000
                                            });


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

                                </script>
                            </div>
                            <div class="tab-pane fade" id="cysw-profile" role="tabpanel"
                                 aria-labelledby="cysw-profile-tab">
                                @if ($user->user_type == 1)
                                @livewire('c-y-s-w-profile', ['user' => $user])

                                @endif
                            </div>

                        </div>


                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>
    @livewireScripts









@stop

