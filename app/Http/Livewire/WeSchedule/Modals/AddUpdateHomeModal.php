<?php

namespace App\Http\Livewire\WeSchedule\Modals;

use WireElements\Pro\Components\Modal\Modal;

class AddUpdateHomeModal extends Modal
{
    public $methed;

    public function mount($methed)
    {
        $this->methed = $methed;
    }

    public function render()
    {
        return view('livewire.we-schedule.modals.add-update-home-modal');
    }
}
