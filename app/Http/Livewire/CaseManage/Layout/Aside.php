<?php

namespace App\Http\Livewire\CaseManage\Layout;

use Livewire\Component;

class Aside extends Component
{
    public function render()
    {
        return view('livewire.case-manage.layout.aside')->layout('layouts.case-manage-app');
    }
}
