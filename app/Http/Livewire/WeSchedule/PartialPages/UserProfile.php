<?php

namespace App\Http\Livewire\WeSchedule\PartialPages;

use Livewire\Component;

class UserProfile extends Component
{
    public function render()
    {
        return view('livewire.we-schedule.partial-pages.user-profile')->layout('layouts.we-schedule-app');
    }
}
