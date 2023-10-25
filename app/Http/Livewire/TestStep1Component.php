<?php

namespace App\Http\Livewire;

use Spatie\LivewireWizard\Components\StepComponent;

class TestStep1Component extends StepComponent
{

    public function stepInfo(): array
    {
        return [
            'label' => 'Step 1'

        ];
    }

    public function render()
    {
        return view('livewire.forms.ExpensesForm_test_step1');
    }
}
