<?php

namespace App\Http\Livewire;


use App\Models\User;
use Livewire\Component;
use Auth;
use \Carbon\Carbon;
use Illuminate\Support\Collection;
use DateTime;
class CarpeDiem extends Component
{
    public $child;

    public $key = "";

    public $CarpeDiem_Notes;
    protected $listeners = [

        'saveDateOfApprovedCarpeDiem' => 'saveDateOfApprovedCarpeDiem'
    ];

    protected $rules = [

        'child.DateOfApprovedCarpeDiem' => 'nullable'
        ];





    public function saveDateOfApprovedCarpeDiem($newDate) {
        if ($newDate) {
            $this->child->DateOfApprovedCarpeDiem = \Carbon\Carbon::parse($newDate)->format('Y-m-d');
            $this->child->save();
            $this->dispatchBrowserEvent('DateSavedCarpeDiem');
        }


        }


    public function submit(){


        }



    public function render()
    {
        return view('livewire.carpediem');
    }



    public function mount($child)
    {


    }

}
