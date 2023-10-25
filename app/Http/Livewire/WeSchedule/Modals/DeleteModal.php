<?php

namespace App\Http\Livewire\WeSchedule\Modals;

use WireElements\Pro\Components\Modal\Modal;

class DeleteModal extends Modal
{
    public function render()
    {
        return view('livewire.we-schedule.modals.delete-modal');
    }
}
