<?php

namespace App\Http\Livewire;

use App\Models\Child;
use App\Models\Incident_Entry;
use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
//use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\ErrorHandler\Debug;
use App\Events\IR_Field_Update_Status;


class IR_Report extends Component
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

    public $selectedChild = [];
    public $selectedFosterHome = [];
    public $selectedCM = [];
    public $selectedCAS = [];


    public $filterSD;
    public $filterED;

    public $tmpUser;

    protected $listeners = [
        'refresh' => '$refresh',
        'view' => 'view',
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
//        $LW_incident_entries = Incident_Entry::where('fk_ChildID','=',$this->child->id)->orderBy('updated_at', 'DESC')->paginate(9999,['*'],'IRs');
        $this->child = new Child();

        if ($this->childID) {
            $this->child = Child::where('id', '=', $this->childID)->first();
        }

        //get all entries
//        $LW_incident_entries = Incident_Entry::with('get_child')->orderBy('updated_at', 'DESC')->get()->groupBy('type');
        $LW_incident_entries = Incident_Entry::with('get_child', 'get_child.getCaseManageAssignedHome','EditedRevisions', 'users')->orderBy('updated_at', 'DESC')->get();

        //filter by date range
//        if ($this->filterSD || $this->filterED) {
//            $filterByDateRange = $LW_incident_entries->where('updated_at', '>=', $this->filterSD)->where('updated_at', '<=', $this->filterED);
//        } else {
//            $filterByDateRange = $LW_incident_entries->where('updated_at', '>=', \Carbon\Carbon::now()->firstOfMonth()->toDateString())->where('updated_at', '<=', \Carbon\Carbon::now()->lastOfMonth()->toDateString());
//        }

        //filter by Child
        if ($this->selectedChild) {
//            dd (json_encode($this->selectedChild));
            $new_array = array_column($this->selectedChild, 'id');
//            dd($new_array);
            $filterByChild = $LW_incident_entries->whereIn('fk_ChildID', $new_array);
        } else {
            $filterByChild = $LW_incident_entries;
        }


        //search by foster homes (independently from the filtered child list)
        if ($this->selectedFosterHome) {

            //            dd (json_encode($this->selectedChild));
            $new_array = array_column($this->selectedFosterHome, 'id');
//      dd($new_array);
            $filterByFosterHome = $LW_incident_entries->whereIn('get_child.FosterHome_fk_UserID', $new_array);
//            dd ($filterByFosterHome);
            $merge = $LW_incident_entries->merge($filterByFosterHome);
            $filterByFosterHome = $merge;
        } else {
            $filterByFosterHome = $filterByChild;
        }

        //search by CM (independently from the filtered Foster Home List)
        if ($this->selectedCM) {
            $new_array = array_column($this->selectedCM, 'id');
//            dd($new_array);
            $filterByCM = $LW_incident_entries->whereIn('get_child.getCaseManageAssignedHome.fk_CaseManagerID', $new_array);
//            dd ($filterByFosterHome);
            $merge = $filterByFosterHome->merge($filterByCM);
            $filterByCM = $merge;
        } else {
            $filterByCM = $filterByChild;
        }

//        $LW_incident_entries = $filterByCM->groupBy('type');

//        $this->dispatchBrowserEvent('table-updated');

        $tmpArray[] = array();
        $i = 0;
        foreach ($LW_incident_entries as $entry) {
            $tmpArray[$i] = array(

                "id" => $entry->id,
                "date_received_created" => $entry->created_at->toDateTimeString(),
                "child_name" => $entry->get_child->initials ? $entry->get_child->initials : "",
                "childID" => $entry->get_child->id,
                "foster_home" => $entry->get_child->getCaseManageAssignedHome ? $entry->get_child->getCaseManageAssignedHome->name : null,
                "fosterHomeID" => $entry->get_child->getCaseManageAssignedHome ? $entry->get_child->getCaseManageAssignedHome->id : null,
               "RevisionApproved" => $entry->EditedRevisions ? $entry->EditedRevisions->approvedBy : null

        );

            if ($entry->get_child->getCaseManageAssignedHome) {
                if ($entry->get_child->getCaseManageAssignedHome->getCaseManager) {
                    $tmpArray[$i]["case_manager"] =  $entry->get_child->getCaseManageAssignedHome->getCaseManager->name;
                    $tmpArray[$i]["caseManagerID"] =  $entry->get_child->getCaseManageAssignedHome->getCaseManager->id;

                } else {
                    $tmpArray[$i]["case_manager"] = null;
                    $tmpArray[$i]["caseManagerID"] =  null;
                }
            }

            $tmpArray[$i]['incident_type'] = $entry->incident_type;

            //detect if user has viewed this IR and change its type
            $tmpListOfIRs = Auth::user()->with('IRs')->first()->IRs->pluck('id');

            $IR_Users = $entry->users;

            $containsEntry = false;
            if ($IR_Users->contains('id', Auth::user()->id)) {
                //$IR_Users contain this user
                foreach ($IR_Users as $user) {
                    if ($user->seen_unseen->ir_id == $entry->id) {
                        //User has seen this IR entry before; set the status as worked
                        $containsEntry = true;
                    }
                }
            }

            if ($containsEntry)
                {
                    $tmpArray[$i]['type'] = "Working";
                } else {
                    $tmpArray[$i]['type'] = $entry->type;
            }

            //detect if media is present on Edited IR, if so, the IR has been previously sent.
            if ($entry->EditedRevisions) {
//                DebugBar::addMessage("Sent: " .$entry->EditedRevisions->getMedia("Sent_IRs"));

                if ($entry->EditedRevisions->getMedia("Sent_IRs")->first()) {
//                    dd($entry->EditedRevisions->getMedia("Sent_IRs"));
                    $tmpArray[$i]['type'] = "Sent";
//                    DebugBar::addMessage("Sent: " .$entry->EditedRevisions->getMedia("Sent_IRs"));
                }

            }


            $tmpArray[$i]['CASID'] = $entry->get_child->fk_CASAgencyID;
            $i++;

        }
//        dd(json_encode($tmpArray,JSON_PRETTY_PRINT));

//        dd($LW_incident_entries->pluck('created_at', '')->toJson());
        return view('livewire.IR_Reports', compact('LW_incident_entries', 'tmpArray'));
    }

    public function mount() {
        $this->LW_incident_entry = new Incident_Entry();
        //$this->medication_entries = $child->get_medicationentries;
//        $this->child = Child::where('id','=','3')->first();
        $this->child = new Child();

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
