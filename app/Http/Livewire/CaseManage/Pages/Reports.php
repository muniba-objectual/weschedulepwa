<?php

namespace App\Http\Livewire\CaseManage\Pages;

use Livewire\Component;

class Reports extends Component
{
    public function render()
    {
        return view('livewire.case-manage.pages.reports')->layout('layouts.case-manage-app');
    }

    public function ShowExpensesReport()
    {
        return redirect()->route('case-manage.reports.expenses');
    }
    
    public function ShowBankDepositsReport()
    {
        return redirect()->route('case-manage.reports.bank-deposits');
    }
}
