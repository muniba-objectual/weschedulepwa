<div>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Create New Case Worker</x-slot>
        <form id="frmNewPlacingAgency">

            {{-- Name field --}}
            <div class="form-group">
            <label for="name">Full Name</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-building text-blue"></span>
                        </div>
                    </div>
                    <input wire:model="tmpCaseWorker.name" type="text" name="name" class="form-control @error('tmpCaseWorker.name') is-invalid @enderror"
                           value="{{ old('tmpCaseWorker.name') }}" placeholder="Enter Full Name" autofocus>

                    @error('tmpCaseWorker.name')
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
                    <input wire:model="tmpCaseWorker.email" type="text" name="email" class="form-control @error('tmpCaseWorker.email') is-invalid @enderror"
                           value="{{ old('tmpCaseWorker.email') }}" placeholder="Enter Email" autofocus>

                    @error('tmpCaseWorker.email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            {{-- Telephone field --}}
            <div class="form-group">
                <label for="telephone">Telephone</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-phone text-blue"></span>
                        </div>
                    </div>
                    <input wire:model="tmpCaseWorker.telephone" type="text" name="telephone" class="form-control @error('tmpCaseWorker.telephone') is-invalid @enderror"
                           value="{{ old('tmpCaseWorker.telephone') }}" placeholder="Enter Telephone" autofocus>

                    @error('tmpCaseWorker.telephone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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
                    <textarea wire:model="tmpCaseWorker.notes"  id="notes" name="notes" class="form-control @error('tmpCaseWorker.notes') is-invalid @enderror"
                              placeholder="Enter Notes" autofocus></textarea>

                    @error('tmpCaseWorker.notes')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="createCaseWorker()">
                Create Case Worker
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


                    @this.set('tmpCaseWorker.address', place.name);
                    @this.set('tmpCaseWorker.city', city);
                    @this.set('tmpCaseWorker.province', province);
                    @this.set('tmpCaseWorker.postal', postal);

                        //document.getElementById('address').value = place.name;
                        //document.getElementById('city').value = city;
                        //document.getElementById('province').value = province;
                        //document.getElementById('postal_code').value = postal;
                    }


                });


        })



    </script>


</div>
