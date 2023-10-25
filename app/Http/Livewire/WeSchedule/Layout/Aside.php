<?php

namespace App\Http\Livewire\WeSchedule\Layout;

use Livewire\Component;

class Aside extends Component
{
    public function render()
    {
        return view('livewire.we-schedule.layout.aside')->layout('layouts.we-schedule-app');
    }
}
