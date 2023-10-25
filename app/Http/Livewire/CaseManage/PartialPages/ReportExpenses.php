<?php

namespace App\Http\Livewire\CaseManage\PartialPages;

use Livewire\Component;

class ReportExpenses extends Component
{
    public function render()
    {
        return view('livewire.case-manage.partial-pages.report-expenses')->layout('layouts.case-manage-app');
    }
}
