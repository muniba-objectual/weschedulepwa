<?php

namespace App\Http\Livewire\Mobile;

use App\Models\Child;
use App\Models\Medication_Entry;
use App\Models\Medication_Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Auth;
use Spatie\Activitylog\Models\Activity;


class Medication extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public Medication_Entry $LW_medication_entry;
    public  $medication_Profile;

    public $photo;

    public $child;
    public $childID;
    public $myshift;

    public $fk_ShiftID;
    public $shiftID;

    public $deleteID = "";

    protected $listeners = [
        'refresh' => '$refresh',
        'setMedicationType',
        'setMedication'
    ];
    protected $rules = [
        'LW_medication_entry.medication_type' => 'required',
        'LW_medication_entry.dosage' => 'required',
        'LW_medication_entry.date_time' => 'required',
        'LW_medication_entry.compliance' => 'required',
        'LW_medication_entry.taken_with_food' => 'required|in:0,1',
        'LW_medication_entry.PRN' => 'required|in:0,1',
        //'LW_medication_entry.photo' => 'nullable|sometimes',
    ];


    public function updated($propertyName) {

        $this->validateOnly($propertyName);
    }

    public function setMedicationType($MedType) {
        if ($MedType) {
            $this->LW_medication_entry->medication_type = $MedType;
            $this->LW_medication_entry->dosage = "";

            $this->LW_medication_entry->PRN = 1;
            $this->LW_medication_entry->compliance = "Yes";
            $this->LW_medication_entry->date_time = date(now());



        }
    }

    public function setMedication($item, $id) {
        if ($item) {
            $this->LW_medication_entry->medication_type = $item;
        }

        if ($id) {
            $tmpMedication = Medication_Profile::where('id','=',$id)->first();
            $this->LW_medication_entry->dosage = $tmpMedication->dosage;
            $this->LW_medication_entry->PRN = 0;
            $this->LW_medication_entry->compliance = "Yes";
            $this->LW_medication_entry->date_time = date(now());
        }
    }

    public function submit()
    {

        try {
            $validatedData = $this->validate();
            if (isset($this->photo)) {
                $filepath = $this->photo->store('public/medication_images');
                $this->LW_medication_entry->photo = $filepath;

            }
            //Medication_Entry::create($validatedData->LW_medication_entry);
            $this->LW_medication_entry->fk_ChildID = $this->child->id;
            $this->LW_medication_entry->fk_UserID = Auth::id();

            $this->LW_medication_entry->save();

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

            activity('Medication')
                ->causedBy(Auth::user())
                ->performedOn($this->child)
                ->event("Medication")
                ->withProperties($this->LW_medication_entry->id)
                ->log($this->LW_medication_entry->medication_type);


            $this->dispatchBrowserEvent('closeAddMedicationModal');

            //Reset Model
            $this->LW_medication_entry = new Medication_Entry();

            //$this->reset($LW_medication_entry);
            //$this->reset('LW_medication_entry.medication_type','LW_medication_entry.dosage', 'LW_medication_entry.date_time', 'LW_medication_entry.compliance', 'LW_medication_entry.taken_with_food', 'LW_medication_entry.PRN', 'LW_medication_entry.photo');
            $this->emit('refresh');
            $validatedData = "";
            session()->flash('message', 'Medication added successfully.');

           // return Redirect::back()->with('message','Operation Successful !');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Use $e->errors() to find the validationerrors
            // Add your custom logic here.
            ray ($e->errors());
            // Re-throw the exception once done
            $this->dispatchBrowserEvent('error_in_addMedication', ['tmpErrors'=>$e->errors()]);
        }

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
        //added livewire pagination -- https://laravel-livewire.com/docs/2.x/pagination
        //$LW_medication_entries = Medication_Entry::where('fk_ChildID','=',$this->child->id)->paginate(25,['*'],'Meds');
        $LW_medication_entries = Medication_Entry::where('fk_ChildID','=',$this->child->id)->orderByDesc('date_time')->paginate(20,['*'],'Meds');
        return view('livewire.mobile.medication', compact('LW_medication_entries'));
    }

    public function mount($child) {
        $this->LW_medication_entry = new Medication_Entry();
         //$this->medication_entries = $child->get_medicationentries;
        $this->child = $child;
         // $this->shiftID = $myshift->id;
        $this->medication_Profile = Medication_Profile::where('fk_ChildID','=',$this->child->id)->get()->toArray();

    }


    public function view($id) {
        //$record = Medication_Entry::findOrFail($id);
        $this->LW_medication_entry = Medication_Entry::findOrFail($id);
        $this->dispatchBrowserEvent('viewMedicationModal');

    }

}
