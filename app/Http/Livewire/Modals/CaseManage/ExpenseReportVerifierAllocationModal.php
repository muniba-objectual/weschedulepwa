<?php

namespace App\Http\Livewire\Modals\CaseManage;


use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use App\Models\ExpensesVerifiers;

use App\Models\User;
use WireElements\Pro\Components\SlideOver\SlideOver;
use Auth;
class ExpenseReportVerifierAllocationModal extends SlideOver
{

    use ExpenseCore;
//    protected $listeners = ['showModal' => 'showModal'];

    public $verifiers;
    public $expenseOwner;
    public $allUsers;

    public static function attributes(): array
    {
        return [
            // Set the modal size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
            'size' => '7xl',

        ];
    }

    public function mount(int $userId) {
        $this->expenseOwner = User::findOrFail($userId);
        $this->initExpenseConfig();

        //all users assignable
        $this->allUsers = User::query()
                ->whereBetween('user_type', ['3.0', '6.0'])
                ->where('inactive', 0)
                ->orderBy('name')
                ->where('id', '!=', $this->expenseOwner->id) //you cant be your own verifier
                ->get();

        $this->verifiers = ExpensesVerifiers::where('expense_user_id', $userId)
            ->get()
            ->keyBy('verifier_user_id')
            ->toArray();
    }

    public function enablePermission(int $verifierUserId){
        User::findOrFail($verifierUserId); //avoid invalid user ID injection
        $expVrfyInstance = ExpensesVerifiers::query()->firstOrCreate([
            'verifier_user_id' => $verifierUserId,
            'expense_user_id' => $this->expenseOwner->id,
            'assigned_by_user_id' => auth()->id(),
        ]);
        $this->verifiers[$expVrfyInstance->verifier_user_id] = $expVrfyInstance;
    }

    public function disablePermission(int $verifierUserId){
        User::findOrFail($verifierUserId); //avoid invalid user ID injection

        ExpensesVerifiers::query()->where([
            'verifier_user_id' => $verifierUserId,
            'expense_user_id' => $this->expenseOwner->id,
        ])->delete();

        unset($this->verifiers[$verifierUserId]);
    }




    public function render()
    {
        return view('livewire.modals.case-manage.expense-report-verifier-allocation-modal');
    }
}
