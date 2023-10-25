<?php

namespace App\Http\Livewire\Forms\CaseManage\Temp\CarpeDiem;

use App\CustomClasses\UserFormComponent;
use Livewire\Component;

class AuthorizationForSupervisedActivities extends Component
{
    use UserFormComponent;

    public function render()
    {
        return view('livewire.forms.case-manage.temp.carpe-diem.authorization-for-supervised-activities');
    }
}
