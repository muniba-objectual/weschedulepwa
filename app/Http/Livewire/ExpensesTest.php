<?php

namespace App\Http\Livewire;
use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_LinkingStepComponent;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_ReviewStepComponent;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_SubmitStepComponent;
use App\Http\Livewire\Forms\CaseManage\ExpensesForm_UploadReceiptStepComponent;
use Illuminate\Support\Facades\Auth;
use Spatie\LivewireWizard\Components\WizardComponent;

class ExpensesTest extends WizardComponent
{
    use  ExpenseCore;

    public $user;

    public function mount() {
        $this->user = Auth::user();
    }
    public function steps() : array
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
