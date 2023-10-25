<?php

namespace App\Http\Livewire\Modals\CaseManage;


use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use WireElements\Pro\Components\Modal\Modal;
use Carbon\Carbon;
use Auth;
class LogMeetingModal extends Modal
{

     public $show;
     public $user;
    public $userID;
    public $AuthUserID;

    public $size;

   public $callDateTime;
   public $notes;
    public $tmpCallDateTime;

    protected $rules = [
        'callDateTime' => 'required',
        'notes' => 'required',


    ];

    protected $listeners = ['showModal' => 'showModal', 'updateCallDateTime' => 'updateCallDateTime'];

    public function updateCallDateTime($value) {
        if ($value) {
            //convert date/time to Carbon
            $this->tmpCallDateTime = Carbon::parse($value)->toDateTimeString();
        }
        $this->callDateTime = $value;
    }
    public static function attributes(): array
    {
        return [
                // Set the modal size to 2xl, you can choose between:
                // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
                'size' => '7xl',

            ];
    }

    public function mount() {

    //$this->callDateTime = "";
    $this->notes = "";
    }


    public function submit()
    {
        // Do Something With Your Modal


            $this->validate();

            $this->user = User::where('id','=',$this->userID)->first();

            //Log to intended User's Timeline
        activity('LogMeeting')
            ->causedBy(Auth::user())
            ->performedOn($this->user)
            ->event("LogMeeting")
            //->withProperties($tmpHome)

            ->log($this->notes);

        //Log to Auth User's Timeline
        activity('LogMeeting')
            ->causedBy($this->user)
            ->performedOn(Auth::user())
            ->event("LogMeeting")
            //->withProperties($tmpHome)

            ->log($this->notes);
        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.log-meeting-modal');
    }
}
