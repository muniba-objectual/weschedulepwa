<?php

namespace App\Http\Livewire\Forms\CaseManage;

use App\Models\User;
use Livewire\Component;
use App\Models\OnCallCYSW;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OnCallCYSWForm extends Component
{
    use LivewireAlert;


    public $notes;
    public $selectedCYSW;
    public $CYSWs;
    public $user;



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

        return redirect()->to('/mobileCM');

    }

    public function mount() {
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


                    <textarea wire:model="notes" rows="10" class="d-flex justify-content-center col-12" id="note" name="note"></textarea>

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
