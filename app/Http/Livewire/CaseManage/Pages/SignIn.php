<?php

namespace App\Http\Livewire\CaseManage\Pages;

use Livewire\Component;

class SignIn extends Component
{
    public function SignIn()
    {
        // Todo: User sign in functionality
        return redirect()->route('case-manage.dashboard');
    }

    public function render()
    {
        return view('livewire.case-manage.pages.sign-in')->layout('layouts.case-manage-signin-signup');
    }
}
