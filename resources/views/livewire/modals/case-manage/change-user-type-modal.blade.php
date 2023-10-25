<div>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Change User Type</x-slot>

        <form id="frmChangeUserType">

            {{-- User Type field --}}
            <div class="form-group">
                <label for="fullname">User Type</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-list text-blue"></span>
                        </div>
                    </div>

                    <select wire:model="tmpStaff.user_type"  name="userType" class="form-control @error('tmpStaff.user_type') is-invalid @enderror"
                            placeholder="Select User Type">
                        <option value="">Select User Type</option>
                        @php
                            $userTypes = App\Models\User_Type::all()->where('type','>=','2.0')->where('type','<=','10.0')->sortBy('type');
                            foreach ($userTypes as $type) {
                                echo "<option value='" . $type->type . "' >" . $type->name . " [" . $type->type . "]</option>";
                            }
                        @endphp
                    </select>

                    @error('tmpStaff.user_type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="updateUser()">
                Update User
                </button>
            </x-slot>


        </x-wire-elements-pro::bootstrap.modal>




</div>
