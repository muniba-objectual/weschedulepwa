<?php

namespace App\Http\Livewire;

use App\Models\Child;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;



class ActivityWall extends Component
{
    use WithFileUploads;
      use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public Activity $activities;

    public $message;
    public $photo;

    public $child;
    public $childID;
    public $user;




    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public function updatedPhoto() {
        if (isset($this->photo)) {

            $filename = $this->photo->store('public/activities_photos');
        }

        activity('Wall')
            ->causedBy($this->user)
            ->performedOn($this->child)
            ->event("Photo")
            ->log($filename);
        //$photos[] = $filename;

        $this->dispatchBrowserEvent('SuccessMessage', ['alertText' => 'Photo has been added to the Activity Wall']);

    }
    public function submitPhoto() {


    }

    public function submitMessage()
    {
        $message = $this->message;

        activity('Wall')
            ->causedBy($this->user)
            ->performedOn($this->child)
            ->event("Message")
            ->log($message);

        $this->dispatchBrowserEvent('SuccessMessage', ['alertText' => 'Message has been added to the Activity Wall']);
        $this->message = "";
        $message = "";

        //return response()->json(['success' => true, 'message' => 'Posted to wall']);




        //$this->dispatchBrowserEvent('closeAddMedicationModal');

        //Reset Model
        //$this->LW_medication_entry = new Medication_Entry();

        //$this->reset($LW_medication_entry);
        //$this->reset('LW_medication_entry.medication_type','LW_medication_entry.dosage', 'LW_medication_entry.date_time', 'LW_medication_entry.compliance', 'LW_medication_entry.taken_with_food', 'LW_medication_entry.PRN', 'LW_medication_entry.photo');
        $this->emit('refresh');


        // return redirect()->back();
    }


    public function render()
    {
        $child = $this->child;
        $activities_data = Activity::where('subject_type','=','App\Models\Child')->where('subject_id','=', $this->child->id)
            ->where(function ($query) {
                $query->where('event', '=', 'Message')
                    ->orWhere('event', '=', 'Photo');
            })
            ->orderBy('updated_at', 'DESC')->simplePaginate(10);

        $user = Auth::user();
        return view('livewire.activitywall', compact('activities_data', 'user', 'child'));
    }

    public function mount($child) {
        $this->activities = New Activity;
        //$this->activities = Activity::where('subject_type','=','App\Models\Child')->where('subject_id','=', $child->id)->orderBy('updated_at', 'DESC')->paginate(5);
        $this->user = Auth::user();
        $this->photo = "";

        $this->child = $child;
        $this->message = "";

    }



}

