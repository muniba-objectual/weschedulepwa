<div>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Create New Placing Agency</x-slot>

        <form id="frmNewPlacingAgency">


            {{-- Name field --}}
            <div class="form-group">
            <label for="name">Agency Name</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-building text-blue"></span>
                        </div>
                    </div>
                    <input wire:model="tmpAgency.name" type="text" name="name" class="form-control @error('tmpAgency.name') is-invalid @enderror"
                           value="{{ old('tmpAgency.name') }}" placeholder="Enter Agency Name" autofocus>

                    @error('tmpAgency.name')
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
                    <input wire:model="tmpAgency.address" type="text" id="address" name="address" class="form-control @error('tmpAgency.address') is-invalid @enderror"
                           value="{{ old('tmpAgency.address') }}" placeholder="Enter Address" autofocus>

                    @error('tmpAgency.address')
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
                            <input wire:model="tmpAgency.city" type="text" id="city" name="city" class="form-control @error('tmpAgency.city') is-invalid @enderror"
                                   value="{{ old('tmpAgency.city') }}" placeholder="Enter City" autofocus>

                            @error('tmpAgency.city')
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
                        <input wire:model="tmpAgency.province" type="text" id="province" name="province" class="form-control @error('tmpAgency.province') is-invalid @enderror"
                               value="{{ old('tmpAgency.province') }}" placeholder="Enter Province" autofocus>

                        @error('tmpAgency.province')
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
                        <input wire:model="tmpAgency.postal" type="text" id="postal" name="postal" class="form-control @error('tmpAgency.postal') is-invalid @enderror"
                               value="{{ old('tmpAgency.postal') }}" placeholder="Enter Postal Code" autofocus>

                        @error('tmpAgency.postal')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- Notes field --}}
            <div class="form-group">

                <label for="notes">Notes</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-clipboard text-blue"></span>
                        </div>
                    </div>
                    <textarea wire:model="tmpAgency.notes"  id="notes" name="notes" class="form-control @error('tmpAgency.notes') is-invalid @enderror"
                           placeholder="Enter Notes" autofocus></textarea>

                    @error('tmpAgency.notes')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>



        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="createAgency()">
                Create Agency
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


                    @this.set('tmpAgency.address', place.name);
                    @this.set('tmpAgency.city', city);
                    @this.set('tmpAgency.province', province);
                    @this.set('tmpAgency.postal', postal);

                        //document.getElementById('address').value = place.name;
                        //document.getElementById('city').value = city;
                        //document.getElementById('province').value = province;
                        //document.getElementById('postal_code').value = postal;
                    }


                });


        })



    </script>


</div>
