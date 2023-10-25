<?php

namespace App\Http\Livewire\WeSchedule\Pages;

use Livewire\Component;

class Dashboard extends Component
{
    public function GetUser(int $userId)
    {
        return redirect()->route('we-schedule.users', $userId);
    }

    public function render()
    {
        return view('livewire.we-schedule.pages.dashboard')->layout('layouts.we-schedule-app');
    }
}
