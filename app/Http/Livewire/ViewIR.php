<?php

namespace App\Http\Livewire;


use App\Models\Edited_Incident_Entry;
use App\Models\Incident_Entry;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Child;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Pusher\Pusher;
use App\Mail\SendIR_Mail;


class ViewIR extends Component
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
    public $onlineUsers = [];


    public $emailTo;
    public $emailSubject;
    public $emailMessage;

    protected function getListeners()
    {
      return [
            'echo:IR,.newMessage' => 'notifyNewOrder',
            "echo-presence:IR.{$this->LW_incident_entry->id},here" => 'refreshOnlineUsers',            // Here
            "echo-presence:IR.{$this->LW_incident_entry->id},leaving" => 'userLeft',            // Leaving
            "echo-presence:IR.{$this->LW_incident_entry->id},joining" => 'userJoin',            // Leaving
            "sendIR_Email" => "sendIR_Email"

        ];
    }
//    public function getListeners()
//     {
//         return [
//             "echo:IR,newMessage" => 'notifyNewOrder',
//        ];
//    }

    public function notifyNewOrder($var)
    {
//        dd($var);
        Debugbar::info('new order');
    }

    /**
     * @throws \Pusher\PusherException
     * @throws \Pusher\ApiErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refreshOnlineUsers($users)
    {
        if ($users) {

            foreach ($users as $user) {
                if (is_array($user)) {
                   $tmpProfilePic = User::where('id','=',$user['id'])->first()->profile_pic;

                    array_push($this->onlineUsers,[
                        "name" => strtok($user['name'],' '),
                        "id" => $user['id'],
                        "profilePic" => $tmpProfilePic
                    ]);
                }

            }
        }
        //        dd($var);
//        print_r($var);
//        Debugbar::addMessage($var);
//        $this->onlineUsers = $var;


    }

    public function userLeft($user)
    {
      if ($user) {
//          $this->onlineUsers = array_diff($user['id']);
          $getNames = array_column($this->onlineUsers, 'name');
        $key = array_search(strtok($user['name'],' '), array_column($this->onlineUsers, 'name'));
        if ($key) {
            unset($this->onlineUsers[$key]);
        }



      }

    }

    public function userJoin($user)
    {

        //check to see if this user is already listed
        $getNames = array_column($this->onlineUsers, 'name');
        $key = array_search(strtok($user['name'],' '), array_column($this->onlineUsers, 'name'));

        //if the user is not found in the list, add it
        if ($key === false) {
            if (is_array($user)) {
                $tmpProfilePic = User::where('id','=',$user['id'])->first()->profile_pic;

                array_push($this->onlineUsers,[
                    "name" => strtok($user['name'],' '),
                    "id" => $user['id'],
                    "profilePic" => $tmpProfilePic
                ]);
            }

        }

    }

    public function sendIR_Email() {
//        Mail::to($request->user())->send(new OrderShipped($order));

        if ($this->emailTo && $this->emailSubject && $this->emailMessage) {

            $emailAddresses = null;
            //detect if email contains multiple recipients
            if (strpos($this->emailTo,",")) {
                $emailAddresses = explode(",",$this->emailTo);
            } else {
                $emailAddresses = $this->emailTo;
            }

            if (is_array($emailAddresses)) {
                foreach ($emailAddresses as $emailAddress) {
                   try {
                       $mail_status = Mail::to($emailAddress)->send(new SendIR_Mail($this->IRid, $this->emailSubject, $this->emailMessage));
                   }
                   catch(\Exception $e){
                       // Get error here
//                       print $e->getMessage();
//                       exit;

                       $this->alert('error', 'Error sending message to: ' . $emailAddress, [
//                'position' => 'center',
                           'timer' => 3000,
                           'toast' => true,
                           'timerProgressBar' => true,
                       ]);
                                              exit;

                   }

                   }
            } else {
                try {
                    Mail::to($emailAddresses)->send(new SendIR_Mail($this->IRid, $this->emailSubject, $this->emailMessage));
                }
                catch(\Exception $e){
                    // Get error here
//                    print $e->getMessage();
//                    exit;
                    $this->alert('error', 'Error sending message to: ' . $emailAddresses, [
//                'position' => 'center',
                        'timer' => 3000,
                        'toast' => true,
                        'timerProgressBar' => true,
                    ]);
                                           exit;

                }


                }

            $this->alert('success', 'Email Sent Successfully', [
//                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
            $this->dispatchBrowserEvent('hideSpinner');
            $this->LW_incident_entryCurrentRevision->addMedia(storage_path() . '/app/public/tmp/IR_Report/IR_Report.pdf')->toMediaCollection("Sent_IRs");

        }
//        Mail::to('blair.lewis@carpediem.ca')->send(new SendIR_Mail($this->IRid));

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

        //override
        'LW_incident_entryCurrentRevision.override_name_of_child' => 'nullable',
        'LW_incident_entryCurrentRevision.override_date_of_birth' => 'nullable',
        'LW_incident_entryCurrentRevision.override_date_of_placement' => 'nullable',
        'LW_incident_entryCurrentRevision.override_foster_home' => 'nullable',
        'LW_incident_entryCurrentRevision.override_placing_agency' => 'nullable',

        //email
        'emailTo' => 'nullable',
        'emailSubject' => 'nullable',
        'emailMessage' => 'nullable'
    ];


    public function updating($name, $value) {

//        DebugBar::addMessage("Updating... " . $name . ":" . $value);

        //       $this->LW_incident_entryCurrentRevision->save();
    }

    public function updated($name, $value) {
        if ($name == "who_was_notifiedCurrentRevision") {

//            $this->who_was_notifiedCurrentRevision = implode(";",$value);
            $this->LW_incident_entryCurrentRevision->who_was_notified = implode(";",$value);
        } else {
            DebugBar::addMessage("Updated... " . $name . ":" . $value);

        }


        $this->LW_incident_entryCurrentRevision->save();
        DB::insert("insert into IR_UserEditHistory (fk_EditedIncidentEntry, fk_UserID, date) values ('" . $this->LW_incident_entry->id . "'" . ", " . "'" . Auth::user()->id . "'" . ", '" . date('c') . "')");


    }


    public function mount($IRid)
    {




            $lockField = DB::table('IR_locks')->first();

    $this->LW_incident_entry = Incident_Entry::where('id','=',$this->IRid)->first();
        $this->who_was_notified = explode(";",$this->LW_incident_entry->who_was_notified);

        //check to see if this user has "seen" this IR yet
        // Only send update for the first time it is viewed
        $tmpUser = User::where('id','=',Auth::user()->id)->with('IRs')->first();
        $checkIfUserViewedIR = $tmpUser->IRs->contains('id', $this->LW_incident_entry->id);

        if (!$checkIfUserViewedIR) {
            DB::insert('insert into ir_user (ir_id, user_id, created_at, updated_at) values (?, ?, ?, ?)', [$this->LW_incident_entry->id, Auth::user()->id, date('c'), date('c')]);
        }


    $this->revisions = Edited_Incident_Entry::with('get_user')->where('fk_IncidentEntryID','=',$this->LW_incident_entry->id)->get();

//    $this->revisions = DB::table("IR_UserEditHistory")->where('fk_IncidentEntry','=',$this->LW_incident_entry->id)->get();

        $this->child = Child::where('id','=',$this->LW_incident_entry->fk_ChildID)->first();

        if (count($this->revisions) == 0) {
            //no revisions exist for this IR, create new
            $this->LW_incident_entryCurrentRevision = new Edited_Incident_Entry();
            $this->tmpNewID = $this->LW_incident_entry->replicateTo(Edited_Incident_Entry::class,null,array("type"));

            $this->LW_incident_entryCurrentRevision = $this->tmpNewID;
            $this->LW_incident_entryCurrentRevision->who_was_notified = $this->who_was_notified;
            $this->SaveRevision();
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

            $this->approvedBy = $this->loadedRevision->approvedBy;
            $this->render();

        }
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
            $this->LW_incident_entryCurrentRevision->who_was_notified = implode(";",$this->who_was_notified);
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
        if (!$this->approvedBy) {
            $this->approvedBy = array();
            $this->LW_incident_entryCurrentRevision->approvedBy = $this->approvedBy;

        }

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

        $this->revisions = Edited_Incident_Entry::with('get_user')->where('fk_IncidentEntryID','=',$this->LW_incident_entry->id)->get();


//        $this->LW_incident_entry = Incident_Entry::where('id','=',$this->IRid)->first();
        if (count($this->revisions) == 0) {
            $this->tmpNewID = $this->LW_incident_entry->replicateTo(Edited_Incident_Entry::class,null,array("type"));
            $this->LW_incident_entryCurrentRevision = $this->tmpNewID;
            $this->approvedBy = $this->LW_incident_entryCurrentRevision->approvedBy;
            DebugBar::addMessage('No revisions, creating new');
        } else {
            $this->LW_incident_entryCurrentRevision = Edited_Incident_Entry::with('get_user')->where('fk_IncidentEntryID', '=', $this->LW_incident_entry->id)->first();
            $this->approvedBy = $this->LW_incident_entryCurrentRevision->approvedBy;

            if ($this->LW_incident_entryCurrentRevision->who_was_notified != null) {

                $setOfIds = explode(";", $this->LW_incident_entryCurrentRevision->who_was_notified);
                $this->LW_incident_entryCurrentRevision->who_was_notified = $setOfIds;
            }

            DebugBar::addMessage('Found revisions, loading #' . $this->LW_incident_entry->id);
        }


//        dd ($this->LW_incident_entryCurrentRevision->getFirstMedia("Sent_IRs"));
//        if ($this->LW_incident_entryCurrentRevision->getFirstMedia("Sent_IRs")) {
//            dd ("IR has been sent");
//        }

        if ($this->LW_incident_entryCurrentRevision->getFirstMedia("Sent_IRs")) {
            return view ('livewire.view-IR-sent')
                ->layout('layouts.ViewIR');
        }
        return view('livewire.view-IR')
            ->layout('layouts.ViewIR');
        //        return view('livewire.modals.case-manage.view-IR-modal', compact('lockField'));
    }
}
