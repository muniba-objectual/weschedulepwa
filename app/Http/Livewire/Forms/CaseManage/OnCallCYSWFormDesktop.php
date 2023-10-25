<?php

namespace App\Http\Livewire\Forms\CaseManage;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\OnCallCYSW;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OnCallCYSWFormDesktop extends Component
{
    use LivewireAlert;


    public $notes;
    public $selectedCYSW;
    public $CYSWs;
    public $user;
    public $date;


    protected $rules = [
        'selectedCYSW' => 'required',
        'notes' => 'required',
    ];




    public function submit() {



        if ($this->selectedCYSW && ($this->notes)) {

            $onCall = new OnCallCYSW();

            $onCall->fk_UserID = $this->user->id;
            $onCall->fk_CYSWID = $this->selectedCYSW;

            $onCall->notes = $this->notes;

            $onCall->save();
            $this->alert('success', 'On-Call Saved');

            $tmpSelectedCYSW = User::where('id','=',$this->selectedCYSW)->first();


            activity('OnCallCYSW')
                ->causedBy($this->user)
                ->performedOn($tmpSelectedCYSW)
                ->event("OnCallCYSW")
                ->log($this->notes);


            activity('OnCallCYSW')
                ->causedBy($tmpSelectedCYSW)
                ->performedOn($this->user)
                ->event("OnCallCYSW")
                ->withProperties($tmpSelectedCYSW)

                ->log($this->notes);

        } else {
            $this->alert('warning', 'Please select a CYSW and fill out the note section before submitting.');


        }

//        return redirect()->to('/mobileCM');

    }

    public function mount() {
        $this->user = Auth::user();
        $this->notes = "";
        $this->selectedCYSW = "";
    }
    public function render()
    {
        return <<<'blade'

            <div wire:ignore>

               <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script>


                        $(document).ready(function() {

                            //Initialize Select2 Elements
                        $('#selectCYSW').select2({
                            theme: 'classic',
                            placeholder: "Please select..."

                        });


                        $('#selectCYSW').on('select2:select', function (e) {
                            //on select, clear selectedChildren dropdown


                            var data = e.params.data;
                            console.log(data);
                           Livewire.first().set('selectedCYSW', data.id);

                        });

                         $('#drSizeSm').on('apply.daterangepicker', function(ev, picker) {
                                   console.log('date set');
                                    Livewire.first().set('date', $('#drSizeSm').val());


                                });

                          $('#drSizeSm').on('hide.daterangepicker', function(ev, picker) {
                                   console.log('date set (after hide)');
                                    Livewire.first().set('date', $('#drSizeSm').val());


                                });
                });


                </script>
               <form wire:submit.prevent="submit" mt-0>
        @csrf
                 <!--<h6 class="card-title">CHILD PROFILES</h6>-->
                    <h3 class="d-flex justify-content-center">SELECT CYSW</h3>

                    <select wire:ignore wire:model="selectedCYSW" class="select2-blue d-flex justify-content-center col-1" id="selectCYSW" data-dropdown-css-class="select2-blue"  style="width:100%;" name="selectCYSW">
                        <option value="">Please select...</option>

                        @php

                        $CYSWs = \App\Models\User::where('user_type','=','1.0')->where('inactive','=','0')->orderBy('name')->get();
                         foreach ($CYSWs as $cysw) {
                             echo "<option value='" . $cysw->id . "' >" . $cysw->name . "</option>";
                         }
                        @endphp

                    </select>
                     @error('selectedCYSW')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror


                    <div class="mt-3">
                    @php
                    $config = [
                           "autoUpdateInput" => true,
                        "singleDatePicker" => true,
                        "showDropdowns" => true,
                        "startDate" => "js:moment()",
                        "minYear" => 2000,
                        "maxYear" => "js:parseInt(moment().format('YYYY'),10)",
                        "timePicker" => true,
                        "timePicker24Hour" => false,
                        "timePickerSeconds" => false,
                        "cancelButtonClasses" => "btn-danger",
                        "locale" => ["format" => "YYYY-MM-DD HH:mm"],
                    ];
                    @endphp
                    <x-adminlte-date-range name="drSizeSm" label="Date/Time" igroup-size="sm" :config="$config">
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>

                    </x-adminlte-date-range>
                    </div>

                    <textarea wire:model="notes" rows="10" class="d-flex justify-content-center col-12 mt-2" id="note" name="note"></textarea>

                    <div class="section mt-3 d-flex justify-content-center">
                    <button id="btnSubmit" type="submit" class="btn btn-primary btn me-1 mb-1 ">
                            SUBMIT
                        </button>
                    </div>



                                            </form>

            </div>
        blade;
    }
}
