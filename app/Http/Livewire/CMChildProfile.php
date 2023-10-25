<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CM_Child_Profile;
use App\Models\Child;


class CMChildProfile extends Component

{

    public $childID;
    public $CM_Child_Profile;

    protected $rules = [
        'CM_Child_Profile.legal_name' => 'nullable',
        'CM_Child_Profile.preferred_name' => 'nullable',
        'CM_Child_Profile.pronoun' => 'nullable',
        'CM_Child_Profile.gender' => 'nullable',
        'CM_Child_Profile.date_of_birth' => 'nullable',
        'CM_Child_Profile.health_card_number' => 'nullable',
        'CM_Child_Profile.green_shield_number' => 'nullable',
        'CM_Child_Profile.date_admitted_carpediem' => 'nullable',
        'CM_Child_Profile.date_admitted_fosterhome' => 'nullable',
        'CM_Child_Profile.date_readmitted_carpediem' => 'nullable',
        'CM_Child_Profile.legal_status' => 'nullable',
        'CM_Child_Profile.discharge_date' => 'nullable',
        'CM_Child_Profile.is_sibling_group' => 'nullable',
        'CM_Child_Profile.school_info' => 'nullable',



    ];

    public function mount()
    {
        $this->child = Child::where('id', '=', $this->childID)->firstOrFail();
        $this->CM_Child_Profile = CM_Child_Profile::where('fk_ChildID', '=', $this->child->id)->firstOrCreate(
            ['fk_ChildID' => $this->child->id],
            ['legal_name' => $this->child->initials]
        );

        if ($this->CM_Child_Profile->date_admitted_carpediem) {
            $this->CM_Child_Profile->date_admitted_carpediem = \Carbon\Carbon::createFromDate($this->CM_Child_Profile->date_admitted_carpediem)->toFormattedDateString('d/m/Y');
        }




    }

    public function updated($field, $value) {
        if ($value) {
            $this->CM_Child_Profile->fk_ChildID = $this->child->id;

            if ($field == "CM_Child_Profile.date_of_birth") {
                $this->CM_Child_Profile->date_of_birth = \Carbon\Carbon::parse($value)->toDateString();
            }

            if ($field == "CM_Child_Profile.date_admitted_carpediem") {
                $this->CM_Child_Profile->date_admitted_carpediem = \Carbon\Carbon::parse($value)->toDateString();
            }

            if ($field == "CM_Child_Profile.date_admitted_fosterhome") {
                $this->CM_Child_Profile->date_admitted_fosterhome = \Carbon\Carbon::parse($value)->toDateString();
            }

            if ($field == "CM_Child_Profile.date_readmitted_carpediem") {
                $this->CM_Child_Profile->date_readmitted_carpediem = \Carbon\Carbon::parse($value)->toDateString();
            }


            $this->CM_Child_Profile->save();

        }
    }

    public function render()
    {

//        if ($this->CM_Child_Profile->date_of_birth)
//        $this->CM_Child_Profile->date_of_birth = \Carbon\Carbon::parse($this->CM_Child_Profile->date_of_birth)->format('d/m/Y');
//
//        if ($this->CM_Child_Profile->date_admitted_carpediem)
//        $this->CM_Child_Profile->date_admitted_carpediem = \Carbon\Carbon::parse($this->CM_Child_Profile->date_admitted_carpediem)->format('d/m/Y');
//
//        if ($this->CM_Child_Profile->date_admitted_fosterhome)
//        $this->CM_Child_Profile->date_admitted_fosterhome = \Carbon\Carbon::parse($this->CM_Child_Profile->date_admitted_fosterhome)->format('d/m/Y');
//
//        if ($this->CM_Child_Profile->date_readmitted_carpediem)
//            $this->CM_Child_Profile->date_readmitted_carpediem = \Carbon\Carbon::parse($this->CM_Child_Profile->date_readmitted_carpediem)->format('d/m/Y');


        return <<<'blade'
            <div>
                <!-- form start -->
                                            <form>
                                                <div class="row mb-2">

                                                        <h5 class="text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Personal Information</h5>
                                                            <div class="col-4">
                                                                <label for="legal_name">Legal Name</label>
                                                                <input  type="text" class="form-control" id="legal_name"
                                                                       wire:model="CM_Child_Profile.legal_name" >
                                                                </div>

                                                            <div class="col-4">

                                                                <label for="preferred_name">Preferred Name</label>
                                                                <input  type="text" class="form-control" id="preferred_name"
                                                                       wire:model="CM_Child_Profile.preferred_name" >
                                                            </div>

                                                            <div class="col-2">
                                                                <label for="pronoun">Pronoun</label>
                                                                <input  type="text" class="form-control" id="pronoun"
                                                                       wire:model="CM_Child_Profile.pronoun" >
                                                            </div>

                                                         <div class="col-2">
                                                                <label for="gender">Gender</label>
                                                                <input  type="text" class="form-control" id="gender"
                                                                       wire:model="CM_Child_Profile.gender" >
                                                            </div>


                                                </div>

                                                <div class="row mb-2">

                                                    <div class="col-4">
                                                    <label for="legal_status">Legal Status</label>
                                                    <input  type="text" class="form-control" id="legal_status"
                                                           wire:model="CM_Child_Profile.legal_status" >
                                                  </div>

                                                    <div class="col-2">
                                                        <label for="DOB">Date of Birth</label>
                                                        <input type="text" class="form-control" id="DOB"
                                                        wire:model.lazy="CM_Child_Profile.date_of_birth" >
                                                    </div>


                                                <div class="col-3">
                                                    <label for="health_card_number">Health Card Number</label>
                                                    <input  type="text" class="form-control" id="health_card_number"
                                                           wire:model="CM_Child_Profile.health_card_number" >
                                                </div>

                                                  <div class="col-3">
                                                    <label for="green_shield_number">Green Shield Number</label>
                                                    <input  type="text" class="form-control" id="green_shield_number"
                                                           wire:model="CM_Child_Profile.green_shield_number" >
                                                </div>


                                            </div>

                                            <div class="row mb-2">
                                                 <h5 class="mt-3 text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Important Dates</h5>

                                            <div class="col-3">
                                                    <label for="date_admitted_carpediem" class="text-sm">Initial Admission (Carpé Diem)</label>
                                                    <input  type="text" class="form-control" id="date_admitted_carpediem"
                                                           wire:model.lazy="CM_Child_Profile.date_admitted_carpediem" >
                                                </div>

                                                  <div class="col-3">
                                                    <label for="date_admitted_carpediem" class="text-sm">Re-Admission (Carpé Diem)</label>
                                                    <input  type="text" class="form-control" id="date_readmitted_carpediem"
                                                           wire:model.lazy="CM_Child_Profile.date_readmitted_carpediem" >
                                                </div>

                                                 <div class="col-3">
                                                    <label for="date_admitted_fosterhome" class="text-sm">Admission (Foster Home)</label>
                                                    <input  type="text" class="form-control" id="date_admitted_fosterhome"
                                                           wire:model.lazy="CM_Child_Profile.date_admitted_fosterhome" >
                                                </div>

                                                  <div class="col-3">
                                                    <label for="discharge_date" class="text-sm">Discharged Date</label>
                                                    <input  type="text" class="form-control" id="date_discharged"
                                                           wire:model.lazy="CM_Child_Profile.discharge_date" >
                                                </div>

                                                </div>

                                                <div class="row mb-2">


                                                <!--                                                  <div class="col-4">-->
                                                <!--                                                    <label for="is_sibling_group">Sibling Group?</label>-->
                                                <!--                                                   <div class="form-check">-->
                                                <!--                                                      <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="YES">-->
                                                <!--                                                      <label class="form-check-label" for="inlineCheckbox1">YES</label>-->
                                                <!--                                                    </div>-->
                                                <!--                                                    <div class="form-check form-check-inline">-->
                                                <!--                                                      <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="NO">-->
                                                <!--                                                      <label class="form-check-label" for="inlineCheckbox2">NO</label>-->
                                                <!--                                                    </div>-->

                                                <!--                                                </div>-->

                                                <!--                                                <div class="form-group">-->
                                                <!--                                                    <label for="notes">Notes</label>-->
                                                <!--                                                    <textarea disabled type="notes" class="form-control"-->
                                                <!--                                                              id="notes">{{$child->notes}}</textarea>-->
                                                <!--                                                </div>-->


                                            </form>
                                                </div>
            </div>
        blade;
    }
}
