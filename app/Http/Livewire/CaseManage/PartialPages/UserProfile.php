<?php

namespace App\Http\Livewire\CaseManage\PartialPages;

use Livewire\Component;

class UserProfile extends Component
{
    public function render()
    {
        return view('livewire.case-manage.partial-pages.user-profile')->layout('layouts.case-manage-app');
    }
}
