<?php

namespace App\Http\Livewire\Forms\CaseManage;

use App\Http\Livewire\TestStep1Component;
use App\Http\Livewire\TestStep2Component;
use Spatie\LivewireWizard\Components\WizardComponent;



class ExpensesForm extends WizardComponent
{



    protected $listeners = ['gotoStep' => 'gotoStep'];


    public function steps(): array
    {
        return [
//            ExpensesForm_UploadReceiptStepComponent::class,
//
//            ExpensesForm_ReviewStepComponent::class,
//
//            ExpensesForm_LinkingStepComponent::class,
//            ExpensesForm_SubmitStepComponent::class,
            TestStep1Component::class,
            TestStep2Component::class,
        ];
    }

    public function mount() {
//        $this->showStep('Review');

    }

public function gotoStep($step) {
        $this->showStep($step);
}


//    public function stateClass(): string
//    {
//        return ExpensesForm_State::class;
//    }



}
