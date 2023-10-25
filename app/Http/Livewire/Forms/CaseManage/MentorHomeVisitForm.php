<?php

namespace App\Http\Livewire\Forms\CaseManage;

use Livewire\Component;
use App\Models\MentorHomeVisit;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MentorHomeVisitForm extends Component
{
    use LivewireAlert;

    public $homes;
    public $notes;
    public $user;
    public $selectedHome;


    protected $rules = [
        'selectedHome' => 'required',
        'notes' => 'required',
    ];

    public function submit() {

        if ($this->selectedHome && ($this->notes)) {

            $mentorHomeVisit = new MentorHomeVisit();

            $mentorHomeVisit->fk_UserID = $this->user->id;
            $mentorHomeVisit->fk_HomeID = $this->selectedHome;


            $mentorHomeVisit->notes = $this->notes;

            $mentorHomeVisit->save();
            $this->alert('success', 'Mentor Home Visit Saved');

//            $tmpHome = \App\Models\User::where('id','=',$this->selectedHome)->first();
//            activity('MentorHomeVisit')
//                ->causedBy($this->user)
//                ->performedOn($tmpHome)
//                ->event("MentorHomeVisit")
//                ->withProperties($tmpHome)
//                ->log($this->notes);
//
//            activity('MentorHomeVisit')
//                ->causedBy($this->user)
//                ->performedOn($this->user)
//                ->event("MentorHomeVisit")
//                ->withProperties($tmpHome)
//
//                ->log($this->notes);
        } else {
            $this->alert('warning', 'Please select a home and fill out the note section before submitting.');


        }

        return redirect()->to('/mobileCM');

    }

    public function mount() {
        $this->notes = "";
        $this->homes = \App\Models\MentorHome::all();
        $this->selectedHome = "";
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
                        $('#selectHome').select2({
                            theme: 'classic',
                            placeholder: "Please select..."

                        });


                        $('#selectHome').on('select2:select', function (e) {
                            var data = e.params.data;
                            Livewire.first().set('selectedHome', data.id);
                        });

                    });

               </script>

               <form wire:submit.prevent="submit">
                    @csrf
                    <h3 class="m-1 p-1 d-flex justify-content-center">SELECT MENTOR HOME</h3>

                    <select wire:ignore wire:model="selectedHome" class="select2-blue d-flex justify-content-center col-1" id="selectHome" data-dropdown-css-class="select2-blue"  style="width:100%;" name="selectHome">
                        <option value="">Please select...</option>

                        @php
                            foreach ($homes as $home) {
                                 echo "<option value='" . $home->id . "' >" . $home->name . "</option>";
                            }
                        @endphp

                    </select>
                    @error('selectedHome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror


                    <h3 class="m-1 p-1 d-flex justify-content-center">ENTER NOTES</h3>

                    <textarea wire:model="notes" rows="10" class="d-flex justify-content-center col-12" id="note" name="note"></textarea>

                    <p><br />
                        <!--                        *Multiple Image Upload Component &#45;&#45; will be pushed in next update.-->
                    </p>
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
