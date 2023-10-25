<?php

namespace App\Http\Livewire\Mobile\Expense;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_LinkingStepComponent;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_ReviewStepComponent;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_SubmitStepComponent;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_UploadReceiptStepComponent;
use App\Models\Expenses;
use Illuminate\Support\Facades\Auth;
use Spatie\LivewireWizard\Components\WizardComponent;

class Creation extends WizardComponent
{
    use ExpenseCore;

    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        session()->put('expense.url.redirect-back', request()->url());
    }

    public function steps(): array
    {
        $this->initExpenseConfig();

        $steps = [
            ExpensesForm_UploadReceiptStepComponent::class,
            ExpensesForm_ReviewStepComponent::class,
        ];

        //add step 3 conditionally
        if($this->mobileExpenseCreateFormStage3){
            $steps[] = ExpensesForm_LinkingStepComponent::class;
        }

        //add step 4
        $steps[] = ExpensesForm_SubmitStepComponent::class;


        return $steps;
    }
}
