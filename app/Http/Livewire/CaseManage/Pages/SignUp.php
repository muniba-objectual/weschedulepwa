<?php

namespace App\Http\Livewire\CaseManage\Pages;

use Livewire\Component;

class SignUp extends Component
{
    public function render()
    {
        return view('livewire.case-manage.pages.sign-up')->layout('layouts.case-manage-signin-signup');
    }
}
