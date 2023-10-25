<div wire:ingore>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Add Placing Agency Worker</x-slot>

        <form id="frmAddBankDeposit">

       {{-- TYPE field --}}
            <div class="form-group">
                <label for="type">Type</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-calendar text-blue"></span>
                        </div>
                    </div>
                    <select wire:model="type">
                        @foreach (\App\Models\PlacingAgencyWorkers::WORKER_TYPES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>

                    @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>



            {{-- NAME field --}}
            <div class="form-group">
                <label for="name">Name</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-list text-blue"></span>
                        </div>
                    </div>

                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror"  />

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            {{-- EMAIL field --}}
            <div class="form-group">
                <label for="name">Email</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-list text-blue"></span>
                        </div>
                    </div>

                    <input type="text" wire:model="email" class="form-control @error('email') is-invalid @enderror"  />

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            {{-- Telephone field --}}
            <div class="form-group">
                <label for="name">Telephone</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-list text-blue"></span>
                        </div>
                    </div>

                    <input type="text" wire:model="telephone" class="form-control @error('telephone') is-invalid @enderror"  />

                    @error('telephone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="submit()">
                Add Worker
                </button>
            </x-slot>


        </x-wire-elements-pro::bootstrap.modal>




</div>
