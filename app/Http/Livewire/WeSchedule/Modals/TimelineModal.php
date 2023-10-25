<?php

namespace App\Http\Livewire\WeSchedule\Modals;

use WireElements\Pro\Components\Modal\Modal;

class TimelineModal extends Modal
{
    public function render()
    {
        return view('livewire.we-schedule.modals.timeline-modal');
    }
}
