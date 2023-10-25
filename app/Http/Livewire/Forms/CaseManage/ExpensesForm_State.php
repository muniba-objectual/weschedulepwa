<?php
namespace App\Http\Livewire\Forms\CaseManage;

use Spatie\LivewireWizard\Support\State;

class ExpensesForm_State extends State
{
        public function uploadReceipt(): array
    {
        $uploadReceiptState = $this->forStep('UploadReceipt');

        return [
        'receipt' => $uploadReceiptState['receipt'],
//        'address' => $deliveryStepState['address'],
//        'zip' => $deliveryStepState['zip'],
//        'city' => $deliveryStepState['city'],
        ];
    }
}
