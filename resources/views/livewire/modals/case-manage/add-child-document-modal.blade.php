<div wire:ingore>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Add Child Document</x-slot>

        <form id="frmAddChildDocument">


            {{-- Description field --}}
            <div class="form-group">
                <label for="type">Type</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-list text-blue"></span>
                        </div>
                    </div>

                    <select wire:ignore wire:model="type" class="form-control">
                        <option value="Admission - Medical">Admission - Medical</option>
                        <option value="Discharge - Medical">Discharge - Medical</option>

                    </select>

                    @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            {{-- Description field --}}
            <div class="form-group">
                <label for="Notes">Description</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-list text-blue"></span>
                        </div>
                    </div>

                    <input type="text" wire:ignore wire:model="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Document Description" />

                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
       {{-- DATE field --}}
            <div class="form-group">
                <label for="date">Date</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-calendar text-blue"></span>
                        </div>
                    </div>
                    <input wire:ignore wire:model="date" type="text" id="date" name="date" class="form-control @error('date') is-invalid @enderror"
                            placeholder="Enter Date" autofocus>

                    <script>
                        $( document ).ready(function() {
                            $('#date').datepicker({
                                format: 'mm/dd/yyyy'
                            });


                                            // livewire.emit('updateDocument',moment(date).format('MM/DD/YYYY'));
                                            // return moment(date).format('MM/DD/YYYY')

                        });

                    </script>
                    @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <x-media-library-attachment name="myUpload" />
            </div>





        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="submit()">
                Add This Entry
                </button>
            </x-slot>


        </x-wire-elements-pro::bootstrap.modal>




</div>
