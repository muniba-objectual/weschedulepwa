<?php

namespace App\Http\Livewire\CaseManage\Pages;

use Livewire\Component;

class Dashboard extends Component
{
    public function GetUser(int $userId)
    {
        return redirect()->route('case-manage.users', $userId);
    }

    public function render()
    {
        return view('livewire.case-manage.pages.dashboard')->layout('layouts.case-manage-app');
    }
}
