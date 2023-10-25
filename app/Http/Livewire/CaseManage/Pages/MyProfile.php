<?php

namespace App\Http\Livewire\CaseManage\Pages;

use Livewire\Component;

class MyProfile extends Component
{
    public function render()
    {
        return view('livewire.case-manage.pages.my-profile')->layout('layouts.case-manage-app');
    }
}
