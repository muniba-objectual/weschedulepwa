<?php

namespace App\Http\Livewire\Mobile;

use Livewire\Component;
use App\Models\Shift_Form;
use App\Models\SRA_Shift_Form;
use App\Models\User;
use App\Models\Shift;
use App\Models\Child;
Use Auth;

class EndofshiftformComponent extends Component
{

    public Shift_Form $myshift_form;
    public SRA_Shift_Form $SRA_shift_form;
    public $shiftID;
    public $child;

    public $datetime;
    public $SRA_enabled = false;
    public $dietary = false;

    protected $listeners = ['loadShiftForm'];

    protected $rules = [

        'myshift_form.datetime' => 'nullable',
        'myshift_form.mood_upon_arrival' => 'nullable',
        'myshift_form.interaction_with_staff' => 'nullable',
        'myshift_form.general_observations' => 'nullable',
        'myshift_form.dietary_notes' => 'nullable',

        'myshift_form.SRA_datetime' => 'nullable',
        'myshift_form.SRA_activities' => 'nullable',
        'myshift_form.SRA_total_hours_worked' => 'nullable'

    ];

    public function loadShiftForm($shiftID) {

        $this->shiftID = $shiftID;

        $myshift = Shift::find($this->shiftID);

        $this->child = Child::find($myshift->fk_ChildID);
        if ($this->child->SRA) {
            $this->SRA_enabled = true;
        }
        if ($this->child->id == 3) {
            $this->dietary = true;
        }

        if ($myshift->fk_ShiftFormID) {
            $loadShiftForm = Shift_Form::find($myshift->fk_ShiftFormID);
            if ($loadShiftForm) {
                $this->myshift_form = Shift_Form::find($myshift->fk_ShiftFormID);
                $this->myshift_form->datetime = $loadShiftForm->datetime;
                if (!$this->myshift_form->datetime) {
                    $this->myshift_form->datetime =  date('Y-m-d H:i');
                }
                $this->myshift_form->mood_upon_arrival = $loadShiftForm->mood_upon_arrival;
                $this->myshift_form->interaction_with_staff = $loadShiftForm->interaction_with_staff;
                $this->myshift_form->general_observations = $loadShiftForm->general_observations;
                $this->myshift_form->dietary_notes = $loadShiftForm->dietary_notes;

                //IF SRA, load SRA form fields
                if ($this->child->SRA) {



                  //  $this->myshift_form->SRA_datetime = $loadShiftForm->SRA_datetime;
                  //  $this->myshift_form->SRA_activities = $loadShiftForm->SRA_activities;
                 //   $this->myshift_form->SRA_total_hours_worked = $loadShiftForm->SRA_total_hours_worked;
                }
            }
        } else {
            $this->myshift_form = New Shift_Form();
        }





    }

    public function save() {
        $this->myshift_form->datetime =  $this->myshift_form->created_at;
        $this->myshift_form->SRA_datetime =  $this->myshift_form->created_at;

        $this->validate();


        //$this->myshift = New Shift;
        $this->myshift = Shift::find($this->shiftID);

        //$this->child = New Child;
        $this->child = Child::where('id','=',$this->myshift->fk_ChildID)->get();

        if  ($this->SRA_enabled)  {
            $this->myshift_form->SRA_Enabled = "1";
        }

        if ($this->myshift->fk_ShiftFormID) {
            //if a shift_form exists for this shift, update it.

            $this->myshift_form->save();
        } else {

            //no longer necessary as the shift form has already been created during the sign-in process

//            //create a new shift_form for this shift
            $newShiftFormCreated = $this->myshift_form->save();
//          //CYSW has created a new Shift Form
//          //Add it to the Activity Log (only once instead of every update)
            activity('EndOfShiftForm')
                ->causedBy(Auth::user())
                ->performedOn($this->child->first())
                ->event("EndOfShiftForm")
                ->withProperties($this->myshift->id)
                ->log($this->myshift_form);
        }
        $this->myshift->fk_ShiftFormID = $this->myshift_form->id;
       // $this->myshift->status = "Ended - Pending Verification";




        $this->myshift->save();


        $this->dispatchBrowserEvent('close_end_of_shift_report_modal');
    }
    public function render()
    {
        return <<<'blade'
            <div>
            <form wire:submit.prevent="save">
              <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-CYC-1" data-bs-toggle="tab" data-bs-target="#nav-CYC" type="button" role="tab" aria-controls="nav-CYC" aria-selected="true">CYC Daily Report</button>
                    {{--
                    @if ($SRA_enabled)
                      <button id="SRA_button" class="nav-link" id="nav-SRA-1" data-bs-toggle="tab" data-bs-target="#nav-SRA" type="button" role="tab" aria-controls="nav-SRA" aria-selected="false">SRA Report</button>
                    @endif
                    --}}
                  </div>
            </nav>
                <div class="tab-content" id="nav-tabContent">
                  <div class="tab-pane fade show active" id="nav-CYC" role="tabpanel" aria-labelledby="nav-CYC-tab">
                          <br />
                          <div class="form-group">
                                        <label for="inputDescription">Date/Time</label>
                                        <input wire:model.defer="myshift_form.datetime" type="text" id="inputDateTime" class="form-control "
                                               >
                                        @error('myshift_form.datetime') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div><br />
                                    <div class="form-group">
                                        <label for="inputMood">Mood Upon Arrival</label>
                                        <textarea wire:model.defer="myshift_form.mood_upon_arrival" id="inputMood" class="form-control"
                                                  rows="4">{{ old('mood_upon_arrival') ?? $myshift->get_shiftform->mood_upon_arrival ?? '' }}</textarea>
                                        @error('myshift_form.mood_upon_arrival') <span class="text-danger">{{ $message }}</span> @enderror

                                    </div><br />

                                    <div class="form-group">
                                        <label for="inputInteraction"> @if ($SRA_enabled) Interaction with Staff (SRA) @else Interaction with Staff @endif</label>
                                        <textarea wire:model.defer="myshift_form.interaction_with_staff" id="inputInteraction" class="form-control"
                                                  rows="4">{{ old('interaction_with_staff') ?? $myshift->get_shiftform->interaction_with_staff ?? '' }}</textarea>
                                    @error('myshift_form.interaction_with_staff') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div><br />

                                    <div class="form-group">
                                        <label for="inputGeneral">General Observations</label>
                                        <textarea wire:model.defer="myshift_form.general_observations" id="inputGeneral" class="form-control"
                                                  rows="4">{{ old('general_observations') ?? $myshift->get_shiftform->general_observations ?? '' }}</textarea>
                                     @error('myshift_form.general_observations') <span class="text-danger">{{ $message }}</span> @enderror

                                    </div><br />

                                    @if($dietary)
                                  <div class="form-group">
                                        <label for="inputDietary">Dietary Notes</label>
                                        <textarea wire:model.defer="myshift_form.dietary_notes" id="inputDietary" class="form-control"
                                                  rows="4">{{ old('dietary_notes') ?? $myshift->get_shiftform->dietary_notes ?? '' }}</textarea>
                                    @error('myshift_form.dietary_notes') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div><br />
                                    @endif


                  </div>
                  <div class="tab-pane fade" id="nav-SRA" role="tabpanel" aria-labelledby="nav-SRA-tab">
                    <br />
                     <div class="form-group">
                                        <label for="inputDescription">Date/Time</label>
                                        <input wire:model.defer="myshift_form.SRA_datetime"  readonly type="text" id="inputDateTime_SRA" class="form-control "
                                               value="{{ date('Y-m-d H:i') ?? date('Y-m-d H:i') ?? date('Y-m-d H:i') }}">
                                    </div><br />
                                    <div class="form-group">
                                        <label for="inputMood">Activities spent in 1-1 time (please detail by hour, where the 1-1 time was provided & relatedness of activity to initial goal of SRA)</label>
                                        <textarea wire:model.defer="myshift_form.SRA_activities" id="inputActivities_SRA" class="form-control"
                                                  rows="4"></textarea>

                                    </div><br />

                                    <div class="form-group">
                                        <label for="inputInteraction">Total Hours Worked</label>
                                        <textarea wire:model.defer="myshift_form.SRA_total_hours_worked" id="inputHoursWorked_SRA" class="form-control"
                                                  rows="4"></textarea>

                                    </div><br />


                  </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="#" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</a>
                                            <input type="submit" value="Save Changes"
                                                  class="btn btn-success float-right">
                                        </div>
                                    </div>
                </div>

            </div>
        blade;
    }

function mount($myshift_form = null) {


    $this->myshift = Shift::find($this->shiftID);

    if ($this->myshift) {
        $this->loadShiftForm($this->myshift->id);
    }

//         $this->datetime = date('Y-m-d H:i');
//
//        $this->child = New Child;
//       // $this->SRA_enabled = false;
//
//        $this->myshift_form = New Shift_Form;
//        $this->myshift_form->datettime = date('Y-m-d H:i');

}
}
