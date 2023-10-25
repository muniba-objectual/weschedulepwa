<?php

namespace App\Http\Livewire;


use App\Models\User;
use Livewire\Component;
use Auth;
use \Carbon\Carbon;
use Illuminate\Support\Collection;
use DateTime;
class ISA extends Component
{
    public $child;

    public $key = "";

    public $ISA_Notes;
    protected $listeners = [

        'saveDateOfApprovedISA' => 'saveDateOfApprovedISA'
    ];

    protected $rules = [

        'child.DateOfApprovedISA' => 'nullable'
        ];





    public function saveDateOfApprovedISA($newDate) {
        if ($newDate) {
            $this->child->DateOfApprovedISA = \Carbon\Carbon::parse($newDate)->format('Y-m-d');
            $this->child->save();
            $this->dispatchBrowserEvent('DateSavedISA');
        }


        }


    public function submit(){


        }



    public function render()
    {
        return view('livewire.i-s-a');
    }



    public function mount($child)
    {


    }

}
