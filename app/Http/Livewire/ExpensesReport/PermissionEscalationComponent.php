<?php

namespace App\Http\Livewire\ExpensesReport;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PermissionEscalationComponent extends Component
{
    public $systemUsers;
    public $user;

    public function mount(){
        $this->systemUsers =  User::query()
            ->whereBetween('user_type', ['3.0', '6.0'])
            ->where('inactive', 0)
            ->orderBy('name')
            ->get();

        $this->user = Auth::user();
    }

    public function render()
    {
        return view('livewire.expenses-report.permission-escalation-component', [
            'systemUsers' => $this->systemUsers
        ]);
    }
}
