<?php

namespace App\Http\Livewire;

use App\Models\Child;
use App\Models\Incident_Entry;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
//use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;


class IR extends Component
{
    use WithFileUploads;
    //use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public Incident_Entry $LW_incident_entry;

    public $photo;

    public $who_was_notified = [];
    public $child;
    public $childID;
    public $myshift;

    public $fk_ShiftID;
    public $shiftID;

    public $deleteID = "";

    protected $listeners = [
        'refresh' => '$refresh',
        'view' => 'view'
    ];
    protected $rules = [
        'LW_incident_entry.legal_guardian_name' => 'required',
        'LW_incident_entry.incident_type' => 'required',
        'LW_incident_entry.serious_occurence' => 'required_if:LW_incident_entry.incident_type,Serious Occurence',
        'LW_incident_entry.level1_serious_occurence' => 'required_if:LW_incident_entry.incident_type,Level 1 Serious Occurence',
        'LW_incident_entry.date_of_incident' => 'required',
        'LW_incident_entry.time_duration' => 'required',
        'LW_incident_entry.datetime_report_received' => 'required',
        'LW_incident_entry.location_of_incident' => 'required',
        'LW_incident_entry.antecedent_leading_to_incident' => 'required',
        'LW_incident_entry.description_of_incident' => 'required',
        'LW_incident_entry.action_taken' => 'required',
        'LW_incident_entry.who_was_notified' => 'required',
        'LW_incident_entry.physical_injuries' => 'required',
        'LW_incident_entry.property_damage' => 'required',
        'LW_incident_entry.comments' => 'required',



        /*
                'LW_medication_entry.dosage' => 'required',
                'LW_medication_entry.date_time' => 'required',
                'LW_medication_entry.compliance' => 'required',
                'LW_medication_entry.taken_with_food' => 'required|in:Yes,No',
                'LW_medication_entry.PRN' => 'required|in:Yes,No',
                //'LW_medication_entry.photo' => 'nullable|sometimes',
          */

    ];


    public function updated($propertyName) {

        $this->validateOnly($propertyName);
    }



    public function submit()
    {


        $this->LW_incident_entry->who_was_notified = implode(";",$this->who_was_notified);


        $validatedData = $this->validate();

        $this->LW_incident_entry->fk_ChildID = $this->child->id;
        $this->LW_incident_entry->save();

        /*
          Medication_Entry::create(
              [
                  'medication_type' => $validatedData['medication_type'],
                  'dosage' => $validatedData['dosage'],
                  'date_time' => $validatedData['date_time'],
                  'compliance' => $validatedData['compliance'],
                  'taken_with_food' => $validatedData['taken_with_food'],

                  'PRN' => $validatedData['PRN'],
                  'photo' => substr($filepath,7),
                  'fk_ChildID' => $this->child->id
              ]);
      } else {
          Medication_Entry::create(
              [
                  'medication_type' => $validatedData['medication_type'],
                  'dosage' => $validatedData['dosage'],
                  'date_time' => $validatedData['date_time'],
                  'compliance' => $validatedData['compliance'],
                  'taken_with_food' => $validatedData['taken_with_food'],

                  'PRN' => $validatedData['PRN'],
                  'fk_ChildID' => $this->child->id
              ]);
*/


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


        $this->dispatchBrowserEvent('SuccessMessage', ['alertText' => 'Incident Report has been created successfully.']);


        activity('IR')
            ->causedBy(Auth::user())
            ->performedOn($this->child)
            ->event("IR")
            ->withProperties($this->LW_incident_entry->id)
            ->log($this->LW_incident_entry->incident_type);


        //Reset Model
        $this->LW_incident_entry = new Incident_Entry();

        //$this->reset($LW_medication_entry);
        //$this->reset('LW_medication_entry.medication_type','LW_medication_entry.dosage', 'LW_medication_entry.date_time', 'LW_medication_entry.compliance', 'LW_medication_entry.taken_with_food', 'LW_medication_entry.PRN', 'LW_medication_entry.photo');
        $this->emit('refresh');
        $validatedData = "";


        return redirect()->back();
    }


    public function render()
    {
        //added livewire pagination -- https://laravel-livewire.com/docs/2.x/pagination
        $LW_incident_entries = Incident_Entry::where('fk_ChildID','=',$this->child->id)->orderBy('updated_at', 'DESC')->paginate(9999,['*'],'IRs');

        return view('livewire.IR', compact('LW_incident_entries'));
    }

    public function mount($child) {
        $this->LW_incident_entry = new Incident_Entry();
        //$this->medication_entries = $child->get_medicationentries;
        $this->child = $child;
        // $this->shiftID = $myshift->id;
    }


    public function view($id) {
        //$record = Medication_Entry::findOrFail($id);
        $this->LW_incident_entry = Incident_Entry::findOrFail($id);


        // get an array of ids
        $setOfIds = explode(";",$this->LW_incident_entry->who_was_notified);
        $this->LW_incident_entry->who_was_notified  = $setOfIds;
        $this->who_was_notified = $setOfIds;
        $this->dispatchBrowserEvent('viewIR');

    }

}
