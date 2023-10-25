<?php

namespace App\Http\Livewire\WeSchedule\Pages;

use Livewire\Component;

class SignIn extends Component
{
    public function SignIn()
    {
        // Todo: User sign in functionality
        return redirect()->route('we-schedule.dashboard');
    }

    public function render()
    {
        return view('livewire.we-schedule.pages.sign-in')->layout('layouts.we-schedule-signin-signup');
    }
}
