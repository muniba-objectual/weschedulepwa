<?php

namespace App\Http\Livewire\WeSchedule\Pages;

use Livewire\Component;

class MyProfile extends Component
{
    public function render()
    {
        return view('livewire.we-schedule.pages.my-profile')->layout('layouts.we-schedule-app');
    }
}
