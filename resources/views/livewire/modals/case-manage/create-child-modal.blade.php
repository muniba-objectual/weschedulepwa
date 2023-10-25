<div>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Create New Child</x-slot>

        <form id="frmNewChild">



            {{-- Name field --}}
            <div class="form-group">
            <label for="initials">Full Name</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-child text-blue"></span>
                        </div>
                    </div>
                    <input wire:model="tmpChild.initials" type="text" name="initials" class="form-control @error('tmpChild.initials') is-invalid @enderror"
                           value="{{ old('tmpChild.initials') }}" placeholder="Enter Full Name" autofocus>

                    @error('tmpChild.initials')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            {{-- DOB field --}}
            <div class="form-group">
                <label for="DOB">Date of Birth</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-calendar text-blue"></span>
                        </div>
                    </div>
                    <input wire:model="tmpChild.DOB" type="text" id="DOB" name="DOB" class="form-control @error('tmpChild.DOB') is-invalid @enderror"
                           value="{{ old('tmpChild.DOB') }}" placeholder="Enter Date of Birth" autofocus>

                    <script>
                        $('#DOB').datepicker({
                            format: 'yyyy-mm-dd',
                            autoclose: true,
                        });
                    </script>
                    @error('tmpChild.DOB')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>



            {{-- Foster Home field --}}
            <div class="form-group">
                <label for="CaseManager">Foster Home</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-home text-blue"></span>
                        </div>
                    </div>

                    <select wire:model="tmpChild.FosterHome_fk_UserID"  name="FosterHome" class="form-control @error('tmpChild.FosterHome_fk_UserID') is-invalid @enderror"
                            placeholder="Select Foster Home">
                        <option>Select Foster Home</option>
                        @php
                            $FosterHomes = DB::table('users')->where('user_type','=','2.2')
                            ->orWhere('user_type','=','2.1')
                            ->orWhere('user_type','=','2.4')
                            ->orderBy('name')
                            ->get();
                            foreach ($FosterHomes as $home) {
                                echo "<option value='" . $home->id . "' >" . $home->name . " [" . $home->user_type . "]</option>";
                            }
                        @endphp
                    </select>

                    @error('tmpChild.FosterHome_fk_UserID')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="createChild()">
                Create Child
                </button>
            </x-slot>


        </x-wire-elements-pro::bootstrap.modal>





</div>
