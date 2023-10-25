<?php

namespace App\Http\Livewire\DashboardElements\Lists\CaseManage;

use App\Models\User;
use Livewire\Component;

class FosterParentApplicantsList extends Component
{
    public $tmpUsers;



    public function render()
    {
        $this->tmpUsers = User::orderBy('name', 'ASC')->get();
        $users = $this->tmpUsers;
        return view('livewire.DashboardElements.Lists.CaseManage.foster-parent-applicants-list', compact('users'));
    }
}
