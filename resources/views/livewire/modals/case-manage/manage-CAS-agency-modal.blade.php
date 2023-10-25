<div>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Manage Child's CAS Agency</x-slot>
        <form id="frmManageCaseMAnager">

            {{-- Case Maanager field --}}
            <div class="form-group">
                <label for="CaseManager">CAS Agency for {{$tmpChild->initials}}</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-user text-blue"></span>
                        </div>
                    </div>

                    <select wire:model="tmpChild.fk_CASAgencyID"  name="CAS_Agency" class="form-control @error('tmpChild.fk_CASAgencyID') is-invalid @enderror"
                            placeholder="Select CAS Agency">

                        <option value="">No CAS Agency Assigned</option>
                        @php
                            $agencies = \App\Models\PlacingAgency::all()->sortBy('name');
                            foreach ($agencies as $agency) {
                                echo "<option value='" . $agency->id . "' >" . $agency->name . "</option>";
                            }
                        @endphp
                    </select>

                    @error('tmpChild.fk_CASAgencyID')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="modify()">
                Update Child's CAS Agency
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
