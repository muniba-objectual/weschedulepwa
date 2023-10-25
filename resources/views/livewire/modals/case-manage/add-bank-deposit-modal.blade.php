<div wire:ingore>

    <x-wire-elements-pro::bootstrap.modal on-submit="save" :content-padding="true">
        <x-slot name="title">Add Bank Deposit</x-slot>

        <form id="frmAddBankDeposit">

       {{-- DOB field --}}
            <div class="form-group">
                <label for="date">Date</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-calendar text-blue"></span>
                        </div>
                    </div>
                    <input wire:ignore wire:model="date" type="text" id="date" name="date" class="form-control @error('date') is-invalid @enderror"
                           value="{{ old('date') }}" placeholder="Enter Date of Deposit" autofocus>

                    <script>
                        $( document ).ready(function() {
                            $New_FD = new tempusDominus.TempusDominus(document.getElementById('date'),
                                {
                                    display: {
                                        sideBySide: false,
                                    },
                                    useCurrent: true,

                                    //promptTimeOnDateChange:true
                                    keepInvalid: false,
                                    hooks: {
                                        inputFormat: (context, date) => {
                                            livewire.emit('updateBankDeposit',moment(date).format('MM/DD/YYYY'));
                                            return moment(date).format('MM/DD/YYYY')
                                        },
                                        inputParse: (context, value) => {
                                            if (!isDate(value)) {
                                                return new tempusDominus.Date(new Date())
                                            } else {
                                                return new tempusDominus.Date(value)
                                            }
                                        }

                                    }

                                }
                            );
                        });

                    </script>
                    @error('date')
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

                    <input type="text" wire:ignore wire:model="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter Deposit Description" />

                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            {{-- Amount field --}}
            <div class="form-group">
                <label for="amount">Deposit Amount $</label>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fas fa-list text-blue"></span>
                        </div>
                    </div>

                    <input type="text" wire:ignore wire:model="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="0.00" />

                    @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </form>



        <x-slot name="buttons">

            <button type="button" class="btn-primary" wire:click.prevent="submit()">
                Add This Deposit
                </button>
            </x-slot>


        </x-wire-elements-pro::bootstrap.modal>




</div>
