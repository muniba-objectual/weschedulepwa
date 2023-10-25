<div>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Create New Foster Parent Applicant</x-slot>

        <form id="frmNewFosterParent">

            {{-- Name field --}}
            <div class="form-group">
            <label for="fullname">Full Name</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-user text-blue"></span>
                        </div>
                    </div>
                    <input wire:model="tmpFosterParent.name" type="text" name="fullname" class="form-control @error('tmpFosterParent.name') is-invalid @enderror"
                           value="{{ old('tmpFosterParent.name') }}" placeholder="Enter Full Name" autofocus>

                    @error('tmpFosterParent.name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            {{-- Email field --}}
            <div class="form-group">
                <label for="email">Email Address</label>

                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-envelope text-blue"></span>
                        </div>
                    </div>
                    <input wire:model="tmpFosterParent.email" type="text" name="email" class="form-control @error('tmpFosterParent.email') is-invalid @enderror"
                           value="{{ old('tmpFosterParent.email') }}" placeholder="Enter Email" autofocus>

                    @error('tmpFosterParent.email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            {{-- Address field --}}
            <div class="form-group">

                <label for="address">Address</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-location-arrow text-blue"></span>
                        </div>
                    </div>
                    <input wire:model="tmpFosterParent.address" type="text" id="address" name="address" class="form-control @error('tmpFosterParent.address') is-invalid @enderror"
                           value="{{ old('tmpFosterParent.address') }}" placeholder="Enter Address" autofocus>

                    @error('tmpFosterParent.address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>



            {{-- City field --}}
            <div class="form-row">
                <div class="col">
                        <label for="city">City</label>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <span class="fas fa-city text-blue"></span>
                                </div>
                            </div>
                            <input wire:model="tmpFosterParent.city" type="text" id="city" name="city" class="form-control @error('tmpFosterParent.city') is-invalid @enderror"
                                   value="{{ old('tmpFosterParent.city') }}" placeholder="Enter City" autofocus>

                            @error('tmpFosterParent.city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                <div class="col">
                    <label for="province">Province</label>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fas fa-location-arrow text-blue"></span>
                            </div>
                        </div>
                        <input wire:model="tmpFosterParent.province" type="text" id="province" name="province" class="form-control @error('tmpFosterParent.province') is-invalid @enderror"
                               value="{{ old('tmpFosterParent.province') }}" placeholder="Enter Province" autofocus>

                        @error('tmpFosterParent.province')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col">
                    <label for="postal">Postal Code</label>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fas fa-location-arrow text-blue"></span>
                            </div>
                        </div>
                        <input wire:model="tmpFosterParent.postal" type="text" id="postal" name="postal" class="form-control @error('tmpFosterParent.postal') is-invalid @enderror"
                               value="{{ old('tmpFosterParent.postal') }}" placeholder="Enter Postal Code" autofocus>

                        @error('tmpFosterParent.postal')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

            </div>


            {{-- Password field --}}
            <div class="form-group">
                <label for="password">Password</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-key text-blue"></span>
                        </div>
                    </div>
                    <input wire:model="password" type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                           value="{{ old('password') }}" placeholder="Enter Password" autofocus>
                    <input wire:model="password_confirmation" type="text" name="password_confirmation" class="form-control @error('password') is-invalid @enderror"
                           value="{{ old('password') }}" placeholder="Confirm Password" autofocus>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

           {{-- --}}{{-- Driver's License field --}}{{--
            <div class="form-group">

                <label for="drivers_license">Driver's License</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-id-card text-blue"></span>
                        </div>
                    </div>
                    <input type="file" wire:model="drivers_license_photo" class="form-control" @error('drivers_license_photo') is-invalid @enderror>

                    @error('drivers_license_photo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
--}}

        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="createUser()">
                Create User
                </button>
            </x-slot>


        </x-wire-elements-pro::bootstrap.modal>


    <script>

        $(document).ready(function() {
            console.log("It Works");

                const options = {

                    componentRestrictions: { country: "ca" },
                    //fields: ["address_components", "geometry", "icon", "name"],

                };
                console.log ('here');
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
                console.log (places);
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


                    @this.set('tmpFosterParent.address', place.name);
                    @this.set('tmpFosterParent.city', city);
                    @this.set('tmpFosterParent.province', province);
                    @this.set('tmpFosterParent.postal', postal);

                        //document.getElementById('address').value = place.name;
                        //document.getElementById('city').value = city;
                        //document.getElementById('province').value = province;
                        //document.getElementById('postal_code').value = postal;
                    }


                });


        })



    </script>


</div>
