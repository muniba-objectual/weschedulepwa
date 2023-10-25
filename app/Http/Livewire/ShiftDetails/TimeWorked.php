<?php

namespace App\Http\Livewire\ShiftDetails;

use Livewire\Component;

class TimeWorked extends Component
{
    public $myshift;

    public function mount($myshift) {

    //    $this->medication_entries = $myshift->get_medicationentries;
    //    $this->shiftID = $myshift->id;
$this->shift = $myshift;
    }

    public function render()
    {
        return <<<'blade'
            <div wire:poll.visible >
              {{$myshift->calculateActiveShiftHours()}}
            </div>
        blade;
    }
}
