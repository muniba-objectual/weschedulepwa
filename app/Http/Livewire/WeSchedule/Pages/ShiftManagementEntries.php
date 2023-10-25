<?php

namespace App\Http\Livewire\WeSchedule\Pages;

use Livewire\Component;

class ShiftManagementEntries extends Component
{
    public function render()
    {
        return view('livewire.we-schedule.pages.shift-management-entries')->layout('layouts.we-schedule-app');
    }
}
