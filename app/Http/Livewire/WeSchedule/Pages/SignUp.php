<?php

namespace App\Http\Livewire\WeSchedule\Pages;

use Livewire\Component;

class SignUp extends Component
{
    public function render()
    {
        return view('livewire.we-schedule.pages.sign-up')->layout('layouts.we-schedule-signin-signup');
    }
}
