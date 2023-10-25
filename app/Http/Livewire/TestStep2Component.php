<?php

namespace App\Http\Livewire;

use Spatie\LivewireWizard\Components\StepComponent;

class TestStep2Component extends StepComponent
{

    public function stepInfo(): array
    {
        return [
            'label' => 'Step 2'

        ];
    }
    public function render()
    {
        return view('livewire.forms.ExpensesForm_test_step2');
    }
}
