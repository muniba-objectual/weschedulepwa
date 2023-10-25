<?php

namespace App\Http\Livewire;

use App\Models\Shift;
use App\Models\Shift_Form;
use App\Models\User;
use Livewire\Component;
use Auth;
use \Carbon\Carbon;
use Illuminate\Support\Collection;
use DateTime;
class PFA extends Component
{
    public $child;

    public $key = "";

    public $PFA_Notes;
    protected $listeners = [

        'saveDateOfApprovedPFA' => 'saveDateOfApprovedPFA'
    ];

    protected $rules = [

        'child.DateOfApprovedPFA' => 'nullable'
        ];





    public function saveDateOfApprovedPFA($newDate) {
        if ($newDate) {
            $this->child->DateOfApprovedPFA = \Carbon\Carbon::parse($newDate)->format('Y-m-d');
            $this->child->save();
            $this->dispatchBrowserEvent('DateSavedPFA');
        }


        }


    public function submit(){


        }



    public function render()
    {
        return view('livewire.p-f-a');
    }



    public function mount($child)
    {


    }

}
