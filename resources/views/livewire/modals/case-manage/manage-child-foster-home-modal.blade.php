<div>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Manage Child Foster Home</x-slot>
        <form id="frmManageChildFosterHome">

            {{-- Case Maanager field --}}
            <div class="form-group">
                <label for="CaseManager">Foster Home for {{$tmpChild->initials}}</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-user text-blue"></span>
                        </div>
                    </div>

                    <select wire:model="tmpChild.FosterHome_fk_UserID"  name="FosterHome" class="form-control @error('tmpChild.FosterHome_fk_UserID') is-invalid @enderror"
                            placeholder="Select Foster Home">

                        <option value="">No Foster Home Assigned</option>
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

                    @error('tmpUser.tmpChild.FosterHome_fk_UserID')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="ModifyChildFosterHome()">
                Update Foster Home
                </button>
            </x-slot>


        </x-wire-elements-pro::bootstrap.modal>


    <script>

        $(document).ready(function() {


        });



    </script>


</div>
