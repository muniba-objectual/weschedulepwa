<?php

namespace App\Http\Livewire\WeSchedule\Pages;

use Livewire\Component;

class HomeManagement extends Component
{
    public function render()
    {
        return view('livewire.we-schedule.pages.home-management')->layout('layouts.we-schedule-app');
    }
}
