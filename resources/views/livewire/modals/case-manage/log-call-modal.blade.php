<div wire:ingore>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Log Call</x-slot>

        <form id="frmLogCall">

       {{-- DOB field --}}
            <div class="form-group">
                <label for="callDateTime">Date/Time</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-calendar text-blue"></span>
                        </div>
                    </div>
                    <input wire:ignore wire:model="callDateTime" type="text" id="callDateTime" name="callDateTime" class="form-control @error('callDateTime') is-invalid @enderror"
                           value="{{ old('callDateTime') }}" placeholder="Enter Call Date/Time" autofocus>

                    <script>
                        $( document ).ready(function() {
                            $New_FD = new tempusDominus.TempusDominus(document.getElementById('callDateTime'),
                                {
                                    display: {
                                        sideBySide: true,
                                    },
                                    useCurrent: true,

                                    //promptTimeOnDateChange:true
                                    keepInvalid: false,
                                    hooks: {
                                        inputFormat: (context, date) => {
                                            livewire.emit('updateCallDateTime',moment(date).format('MM/DD/YYYY hh:mm A'));
                                            return moment(date).format('MM/DD/YYYY hh:mm A')
                                        },
                                        inputParse: (context, value) => {
                                            if (!isDate(value)) {
                                                return new tempusDominus.DateTime(new Date())
                                            } else {
                                                return new tempusDominus.DateTime(value)
                                            }
                                        }

                                    }

                                }
                            );
                        });

                    </script>
                    @error('callDateTime')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>


            {{-- Notes field --}}
            <div class="form-group">
                <label for="Notes">Call Notes</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-list text-blue"></span>
                        </div>
                    </div>

                    <textarea rows="5" wire:ignore wire:model="notes" class="form-control @error('notes') is-invalid @enderror" placeholder="Enter Call Notes"></textarea>

                    @error('notes')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="submit()">
                Log This Call
                </button>
            </x-slot>


        </x-wire-elements-pro::bootstrap.modal>




</div>
