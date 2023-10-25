<?php

namespace App\Http\Livewire;

use App\Models\Child;
use App\Models\Incident_Entry;
use Livewire\Component;
use Livewire\WithFileUploads;

class Incident extends Component
{
    use WithFileUploads;

    public $child;
    public $childID;
    public $myshift;
    public $legal_guardian_name;
    public $incident_type;
    public $serious_occurence;
    public $level1_serious_occurence;

    public $date_of_incident;
    public $timme_duration;
    public $datetime_report_received;
    public $location_of_incident;
    public $antecedent_leading_to_incident;
    public $description_of_incident;
    public $action_taken;
    public $who_was_notified;
    public $physical_injuries;
    public $property_damage;
    public $comments;


    public $fk_ShiftID;
    public $shiftID;

    public $deleteID = "";

    protected $listeners = [
        'refresh' => '$refresh'
    ];
    protected $rules = [
        'legal_guardian_name' => 'required',
        'incident_type' => 'required',

    ];

    public function updated($propertyName) {

        $this->validateOnly($propertyName);
    }

    public function submit()
    {

        $validatedData = $this->validate();

            Incident_Entry::create(
                [
                    'legal_guardian_name' => $validatedData['legal_guardian_name'],
                    'incident_type' => $validatedData['incident_type'],
                    'serious_occurence' => $this->serious_occurence,
                    'level1_serious_occurence' => $this->level1_serious_occurence,
                    'date_of_incident' => $this->date_of_incident,
                    'time_duration' => $this->time_duration,
                    'datetime_report_received' => $this->datetime_report_received,
                    'location_of_incident' => $this->location_of_incident,
                    'antecedent_leading_to_incident' => $this->antecedent_leading_to_incident,
                    'description_of_incident' => $this->description_of_incident,
                    'action_taken' => $this->action_taken,
                    'who_was_notified' => $this->who_was_notified,
                    'physical_injuries' => $this->physical_injuries,
                    'property_damage' => $this->property_damage,
                    'comments' => $this->comments,

                    'fk_ChildID' => $this->child->id
                ]);



        //$validatedData;

        /* $insert = $myshift->get_medicationentries()->Create(
             [
                 'medication' => $request->medication,
                 'dosage' => $request->dosage,
                 'time_to_be_administered' => $request->time_to_be_administered,
                 'time_administered' => $request->time_administered,
                 'fk_ShiftID' => $myshift->id
             ]);
         */

        //ddd ($this->photo);



        $this->dispatchBrowserEvent('closeAddIncidentModal');
        $this->reset('medication_type','dosage', 'date_time', 'compliance', 'taken_with_food', 'PRN', 'photo');
        $this->emit('refresh');
        $validatedData = "";

        return redirect()->back();
    }

    public function setDeleteID($id) {
        $this->deleteID = $id;
    }
    public function deleteRecord() {

        $del = Medication_Entry::find($this->deleteID)->delete();
        $this->emit('refresh');
        //$this->dispatchBrowserEvent('contentChanged');
        return $del;

    }
    public function render()
    {
        return view('livewire.medication');
    }

    public function mount($child) {

        $this->medication_entries = $child->get_medicationentries;
        $this->child = $child;
        // $this->shiftID = $myshift->id;
    }



}
