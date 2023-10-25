<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Auth;
use App\Models\ChildSafetyPlan;

class LV_ChildSafetyPlan extends Component
{
    public $child;
    public $user;
    public $child_safety_plan;

    public  array $getStaff;

   // protected $listeners = ['editorChanged' => 'editorChanged'];

    protected $rules = [
        'child_safety_plan.Foster_Parent_Name' => 'nullable',
        'child_safety_plan.Foster_Parent_Address' => 'nullable',
        'child_safety_plan.Foster_Parent_Phone' => 'nullable|numeric',
        'child_safety_plan.Case_Manager' => 'nullable',

        'child_safety_plan.Name' => 'nullable',
        'child_safety_plan.DOB' => 'nullable',
        'child_safety_plan.DOA' => 'nullable',
        'child_safety_plan.Status' => 'nullable',
        'child_safety_plan.CSW' => 'nullable',
        'child_safety_plan.Branch' => 'nullable',

        'child_safety_plan.Health_Card' => 'nullable|alpha_dash',
        'child_safety_plan.Physician' => 'nullable',
        'child_safety_plan.Allergies' => 'nullable',
        'child_safety_plan.Food_Restrictions' => 'nullable',
        'child_safety_plan.Medical_Condition' => 'nullable',
        'child_safety_plan.Medication' => 'nullable',
        'child_safety_plan.PRNs' => 'nullable',
        'child_safety_plan.Diagnosed_With' => 'nullable',

        'child_safety_plan.Risk_of_Injury_Behaviour' => 'nullable',
        'child_safety_plan.Description_of_Specific_Behaviours' => 'nullable',
        'child_safety_plan.Triggers' => 'nullable',
        'child_safety_plan.Indicators' => 'nullable',
        'child_safety_plan.Non-Physical_Responses' => 'nullable',
        'child_safety_plan.Physical_Responses' => 'nullable',
        'child_safety_plan.Additional_Information' => 'nullable',
        //'post.content' => 'required|string|max:500',
    ];


    public function updated($name, $value)
 {
     $this->child_safety_plan->fk_ChildID = $this->child->id;
     $this->validate();
     $this->child_safety_plan->save();
     $this->dispatchBrowserEvent('autoResizeTextArea');
    }
    public function mount($child) {
        $this->child = $child;

        $this->child_safety_plan = \App\Models\ChildSafetyPlan::where('fk_ChildID','=',$this->child->id)->firstOrNew();
        $this->child_safety_plan->fk_ChildID = $child->id;
        $this->dispatchBrowserEvent('autoResizeTextArea');

        //old
        //$this->child_safety_plan = $child->child_safety_plan;

        /*
        //Use this for enumerating key/value pair for dynamic select box
        //enumerate getStaff to key/value pair
        $this->getStaff = $child->getAssignedUser->pluck('name','id')->toArray();
        */


        $this->user = Auth::user();
    }
    public function render()
    {

        return <<<'blade'

            <div>
 <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            //console.log("DOM fully loaded and parsed");
            autosize($('.autoResize'));
            //console.log ('after');

            Livewire.hook('message.received', (message, component) => {
                //console.log ('message.received');
                //console.log(message);
                autosize.update($('.autoResize'));
                //autosize($('.autoResize'));
            })

            Livewire.hook('element.initialized', (el, component) => {
                //console.log('element initialized');
                autosize($('.autoResize'));
            })
        });
    </script>

            <x-form class="form-group">
    @bind($child_safety_plan)
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">EMERGENCY CONTACT(S)</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <x-form-input name="child_safety_plan.Foster_Parent_Name" label="Foster Parent Name" class="form-control"/>
                <x-form-input name="child_safety_plan.Foster_Parent_Address" label="Foster Parent Address" class="form-control"/>
                <x-form-input name="child_safety_plan.Foster_Parent_Phone" label="Foster Parent Phone Number" class="form-control"/>
                <x-form-input name="child_safety_plan.Case_Manager" label="Case Manager" class="form-control"/>
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->


            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">IDENTIFYING INFORMATION</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <x-form-input name="child_safety_plan.Name" label="Name" class="form-control"/>
                    <x-form-input name="child_safety_plan.DOB" label="D.O.B." class="form-control"/>
                    <x-form-input name="child_safety_plan.DOA" label="D.O.A." class="form-control"/>
                    <x-form-input name="child_safety_plan.Status" label="Status" class="form-control"/>
                    <x-form-input name="child_safety_plan.CSW" label="C.S.W." class="form-control"/>
                    <x-form-input name="child_safety_plan.Branch" label="Branch" class="form-control"/>

              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">MEDICAL INFORMATION</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <x-form-input name="child_safety_plan.Health_Card" label="Health Card #" class="form-control"/>
                    <x-form-input name="child_safety_plan.Physician" label="Physician" class="form-control"/>
                    <x-form-textarea wire:ignore name="child_safety_plan.Allergies" label="Allergies" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.Food_Restrictions" label="Food Restrictions" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.Medical_Condition" label="Medical Condition (if applicable)" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.Medication" label="Medication (if applicable)" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.PRNs" label="PRN's" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.Diagnosed_With" label="Diagnosed With" class="form-control"/>

              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">OTHER INFORMATION</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <x-form-textarea wire:ignore  name="child_safety_plan.Risk_of_Injury_Behaviour" label="Risk of Injury/Behaviour (Purpose of safety plan)" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.Description_of_Specific_Behaviours" label="Description of Specific Behaviour(s)" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.Triggers" label="Triggers (Known factors that will increase the probability of impulsivity, anxiety, or aggressive behaviour)" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.Indicators" label="Indicators (Physical signs/cues that the youth is about to become aggressive or assaultive)" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.Non-Physical_Responses" label="Non-Physical Responses (Provide non-physical intervention/strategies to be used to de-escalate the youth & situation)" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.Physical_Responses" label="Physical Responses (Provide physical intervention/strategies to be used to de-escalate the youth & situation)" class="form-control"/>
                    <x-form-textarea wire:ignore  name="child_safety_plan.Additional_Information" label="Additional Information" class="form-control"/>

              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->


    @endbind


      {{--
      Use this for dynamic select with relationships
      <x-form-select name="getStaff[]" :options="$getStaff"  many-relation />
      --}}

</x-form>

              @if ($user->user_type == "2" || $user->user_type == "3" || $user->user_type == "4")

               @endif

                                </div>
blade;
    }


}
