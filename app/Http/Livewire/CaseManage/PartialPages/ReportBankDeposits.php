<?php

namespace App\Http\Livewire\CaseManage\PartialPages;

use Livewire\Component;

class ReportBankDeposits extends Component
{
    public function render()
    {
        return view('livewire.case-manage.partial-pages.report-bank-deposits')->layout('layouts.case-manage-app');
    }
}
