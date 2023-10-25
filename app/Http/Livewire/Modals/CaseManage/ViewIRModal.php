<?php

namespace App\Http\Livewire\Modals\CaseManage;


use App\Models\Edited_Incident_Entry;
use App\Models\Incident_Entry;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use WireElements\Pro\Components\SlideOver\SlideOver;
use App\Models\Child;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class ViewIRModal extends SlideOver
{
    use LivewireAlert;


    public $IRid;
    public $LW_incident_entry;

    public $LW_incident_entry_revisions;
    public $LW_incident_entryCurrentRevision;
    public $revisions;
    public $tmpNewID;

    public $childID;
    public $child;

    public $who_was_notified = [];
    public $who_was_notifiedCurrentRevision = [];

    public $loadedRevision = null;

    public $currentAction = "Create New Revision";
    public $field;

    public $IR_UserEditHistory;
    public $approvedBy = [];


    public static function behavior(): array
    {
          return [
              // Close the slide-over if the escape key is pressed
              'close-on-escape' => false,
              // Close the slide-over if someone clicks outside the slide-over
              'close-on-backdrop-click' => true,
              // Trap the users focus inside the slide-over (e.g. input autofocus and going back and forth between input fields)
              'trap-focus' => false,
              // Remove all unsaved changes once someone closes the slide-over
              'remove-state-on-close' => false,
        ];
}

//    protected $listeners = ['refreshComponent' => 'getDBLock'];
        protected $listeners = ['echo:IR,.newMessage' => 'notifyNewOrder'];
//    public function getListeners()
//     {
//         return [
//             "echo:IR,newMessage" => 'notifyNewOrder',
//        ];
//    }

public function closeAndRelease() {
    $this->close(true);
}
    public function notifyNewOrder($var)
    {
//        dd($var);
        Debugbar::info('new order');
    }

    public function getDBLock() {
        $lockField = DB::table('IR_locks')->first();
        $this->mount();
    }
    protected $rules = [
//        'tmpChild.fk_CASAgencyID' => 'nullable',

//        'LW_incident_entry.placing_agency' => 'required',
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

        'LW_incident_entryCurrentRevision.legal_guardian_name' => 'required',
        'LW_incident_entryCurrentRevision.incident_type' => 'required',
        'LW_incident_entryCurrentRevision.serious_occurence' => 'required_if:LW_incident_entry.incident_type,Serious Occurence',
        'LW_incident_entryCurrentRevision.level1_serious_occurence' => 'required_if:LW_incident_entry.incident_type,Level 1 Serious Occurence',
        'LW_incident_entryCurrentRevision.date_of_incident' => 'required',
        'LW_incident_entryCurrentRevision.time_duration' => 'required',
        'LW_incident_entryCurrentRevision.datetime_report_received' => 'required',
        'LW_incident_entryCurrentRevision.location_of_incident' => 'required',
        'LW_incident_entryCurrentRevision.antecedent_leading_to_incident' => 'required',
        'LW_incident_entryCurrentRevision.description_of_incident' => 'required',
        'LW_incident_entryCurrentRevision.action_taken' => 'required',
        'LW_incident_entryCurrentRevision.who_was_notified' => 'required',
        'LW_incident_entryCurrentRevision.physical_injuries' => 'required',
        'LW_incident_entryCurrentRevision.property_damage' => 'required',
        'LW_incident_entryCurrentRevision.comments' => 'required',
    ];

    public static function attributes(): array
    {
        return [
                // Set the modal size to 2xl, you can choose between:
                // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
                'size' => '7xl',

            ];
    }

    public function updating($name, $value) {
        $lockField = DB::table('IR_locks')->first();
        if ($name == "LW_incident_entryCurrentRevision.legal_guardian_name" && $lockField->field =="legal_guardian" && $lockField->fk_UserID != Auth::user()->id) {

            //            DB::delete('delete from IR_locks where id = 1;');
//            DB::update('update IR_locks set id = "1", field = "legal_guardian", fk_UserID = ' . '"' . Auth::user()->id . '"' );
//            $this->LW_incident_entryCurrentRevision->save();
            DB::update("update edited_incident_entries set legal_guardian_name = '" . $value . "' where id = '" . $this->loadedRevision . "'" );

        }
        //       $this->LW_incident_entryCurrentRevision->save();
    }

    public function updated($name, $value) {

        $this->LW_incident_entryCurrentRevision->save();
        DB::insert("insert into IR_UserEditHistory (fk_EditedIncidentEntry, fk_UserID, date) values ('" . $this->LW_incident_entry->id . "'" . ", " . "'" . Auth::user()->id . "'" . ", '" . date('c') . "')");

//        $lockField = DB::table('IR_locks')->first();
//        if(($lockField->field == "legal_guardian") && ($name == "LW_incident_entryCurrentRevision.legal_guardian_name")) {
////                dd("locked");
////                return (false);
////            DB::delete('update IR_locks set id = "1", field = "N/A"');
//        } else {
////            $this->LW_incident_entryCurrentRevision->save();
//        }
    }


    public function mount()
    {



            $lockField = DB::table('IR_locks')->first();

    $this->LW_incident_entry = Incident_Entry::where('id','=',$this->IRid)->first();

        //check to see if this user has "seen" this IR yet
        // Only send update for the first time it is viewed
        $tmpUser = User::where('id','=',Auth::user()->id)->with('IRs')->first();
        $checkIfUserViewedIR = $tmpUser->IRs->contains('id', $this->LW_incident_entry->id);

        if (!$checkIfUserViewedIR) {
            DB::insert('insert into ir_user (ir_id, user_id, created_at, updated_at) values (?, ?, ?, ?)', [$this->LW_incident_entry->id, Auth::user()->id, date('c'), date('c')]);
        }


    $this->revisions = Edited_Incident_Entry::with('get_user')->where('fk_IncidentEntryID','=',$this->LW_incident_entry->id)->get();

//    $this->revisions = DB::table("IR_UserEditHistory")->where('fk_IncidentEntry','=',$this->LW_incident_entry->id)->get();

        $this->child = Child::where('id','=',$this->childID)->first();

        if (count($this->revisions) == 0) {
            //no revisions exist for this IR, create new
            $this->LW_incident_entryCurrentRevision = new Edited_Incident_Entry();
            $this->tmpNewID = $this->LW_incident_entry->replicateTo(Edited_Incident_Entry::class,null,array("type"));

            $this->LW_incident_entryCurrentRevision = $this->tmpNewID;
//            dd($this->LW_incident_entryCurrentRevision->approvedBy);

//    $this->LW_incident_entryCurrentRevision = $this->LW_incident_entry;
//    $this->LW_incident_entryCurrentRevision = $this->LW_incident_entry->replicate();
        } else {
            //load revision (should only be 1 per IR)
        $this->LoadRevision($this->revisions->first());

        }

//        $this->LW_incident_entryCurrentRevision->approvedBy = $this->approvedBy;
    }

    public function LoadRevision($revision) {
        if ($revision) {

            $this->LW_incident_entryCurrentRevision = Edited_Incident_Entry::with('get_user')->where('id','=',$revision->id)->first();


            if ($this->LW_incident_entryCurrentRevision->who_was_notified != null) {

                $setOfIds = explode(";",$this->LW_incident_entryCurrentRevision->who_was_notified);
                $this->LW_incident_entryCurrentRevision->who_was_notified  = $setOfIds;
                $this->who_was_notifiedCurrentRevision = $setOfIds;
            } else {
                $this->LW_incident_entryCurrentRevision->who_was_notified  = null;
                $this->who_was_notifiedCurrentRevision = null;
            }
            // get an array of ids

            $this->loadedRevision = $revision;
            $this->currentAction = "Update Revision";
            Debugbar::addMessage("Loaded Revision: " . $revision);
            $this->render();

        }
    }

//    public function modify()
//    {
//        // Do Something With Your Modal
//
//        $this->validate();
//
//            $this->IR->save();
//
//        // Close Modal After Logic
//        $this->close();
//
//
//    }

public function CreateNewRevision() {
    $this->LW_incident_entryCurrentRevision = new Edited_Incident_Entry();
    $this->tmpNewID = $this->LW_incident_entry->replicateTo(Edited_Incident_Entry::class,null,array("type"));

    $this->LW_incident_entryCurrentRevision = $this->tmpNewID;
//    $this->LW_incident_entryCurrentRevision = $this->LW_incident_entry;
//    $this->LW_incident_entryCurrentRevision = $this->LW_incident_entry->replicate();
    $this->child = Child::where('id','=',$this->childID)->first();
    $this->loadedRevision = null;
    $this->currentAction = "Create New Revision";
    $this->render();
}

    public function SaveRevision() {
//        $this->LW_incident_entry_CurrentRevision = new Edited_Incident_Entry();
        $tmpNewCurrentRevision = new Edited_Incident_Entry();

        if ($this->loadedRevision) {
            $this->LW_incident_entryCurrentRevision->id = $this->loadedRevision->id;
        } else {

                $this->LW_incident_entryCurrentRevision->id = $this->tmpNewID->id;

        }


        $this->LW_incident_entryCurrentRevision->fk_UserID = Auth::user()->id;
        $this->LW_incident_entryCurrentRevision->fk_IncidentEntryID = $this->LW_incident_entry->id;
        if ($this->LW_incident_entryCurrentRevision->who_was_notified) {
            $this->LW_incident_entryCurrentRevision->who_was_notified = implode(";",$this->who_was_notifiedCurrentRevision);
        }

        $this->LW_incident_entryCurrentRevision->fk_ChildID = $this->child->id;
        $this->LW_incident_entryCurrentRevision->save();

        DB::insert("insert into IR_UserEditHistory (fk_EditedIncidentEntry, fk_UserID, date) values ('" . $this->LW_incident_entry->id . "'" . ", " . "'" . Auth::user()->id . "'" . ", '" . date('c') . "')");
        $this->alert('success', 'IR Revision Saved Successfully!', [
//                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        $this->render();
    }

    public function ViewApprovals() {
        if($this->LW_incident_entryCurrentRevision->approvedBy) {
           $message = "<p>The following users have approved this IR:</p";
           $message .= "<ul>";
           foreach ($this->LW_incident_entryCurrentRevision->approvedBy as $user) {
           $message .= " <li>" . \App\Models\User::where('id','=',$user)->first()->name . "</li>";
           }
           $message .= "</ul>";
        } else {
            $message = "<p>No approvals have been submitted for this IR.";
        }

        $this->alert('info', $message, [
//                'position' => 'center',
                'timer' => 10000,
                'toast' => true,
//                'timerProgressBar' => true,
            ]);
        }




    public function toggleApprove() {
        if (in_array(Auth::user()->id,$this->approvedBy)) {
           $this->approvedBy = array_diff($this->approvedBy, [Auth::user()->id]);
        } else {
            array_push($this->approvedBy,Auth::user()->id);
        }

        if (!$this->approvedBy) {
        $this->LW_incident_entryCurrentRevision->approvedBy = null;
        } else {
            $this->LW_incident_entryCurrentRevision->approvedBy = $this->approvedBy;

        }
        $this->LW_incident_entryCurrentRevision->save();
        DB::insert("insert into IR_UserEditHistory (fk_EditedIncidentEntry, fk_UserID, date) values ('" . $this->LW_incident_entry->id . "'" . ", " . "'" . Auth::user()->id . "'" . ", '" . date('c') . "')");
        $this->alert('success', 'IR Approval Updated Successfully!',[
//            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);

    }
    public function render()
    {
//        $this->LW_incident_entryCurrentRevision = Edited_Incident_Entry::where('fk_IncidentEntryID','=',$this->LW_incident_entry->id)->get();

//        dd("select * from  IR_UserEditHistory where fk_EditedIncidentEntry = " . "'" . $this->LW_incident_entry->id . "'");
        $this->IR_UserEditHistory = DB::table('IR_UserEditHistory')->where('fk_EditedIncidentEntry','=',$this->LW_incident_entry->id)->orderBy('date','desc')->get()->unique('fk_UserID');
//        ddd($this->IR_UserEditHistory);
//        $lockField = DB::table('IR_locks')->first();
////        $this->LW_incident_entry->fresh();
//
         /*   if ($this->loadedRevision) {
                $this->LW_incident_entryCurrentRevision = Edited_Incident_Entry::with('get_user')->where('id','=',$this->loadedRevision)->first();

            } else {
                        $this->LW_incident_entryCurrentRevision = Edited_Incident_Entry::with('get_user')->where('fk_IncidentEntryID','=',$this->LW_incident_entry->id)->first();

            }*/

//        $this->LW_incident_entry = Incident_Entry::where('id','=',$this->IRid)->first();
        $this->LW_incident_entryCurrentRevision = Edited_Incident_Entry::with('get_user')->where('fk_IncidentEntryID','=',$this->LW_incident_entry->id)->first();

        ;
        return view('livewire.modals.case-manage.view-IR-modal');
//        return view('livewire.modals.case-manage.view-IR-modal', compact('lockField'));
    }
}
