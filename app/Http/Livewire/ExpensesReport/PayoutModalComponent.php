<?php

namespace App\Http\Livewire\ExpensesReport;

use App\Http\Controllers\Qb\QbResourceController;
use App\Models\ExpensePayout;
use App\Models\Expenses;
use WireElements\Pro\Components\Modal\Modal;

/**
 * @property ExpensePayout $payout
 */
class PayoutModalComponent extends Modal
{

    public $payout;

    public $listeners = [
        'payoutNow' => 'payoutNow',
    ];
    public $otherTotal;
    public $companyCardTotal;

    public function mount(ExpensePayout $payout){
       $this->payout = $payout;
       $this->payout->amount = $this->payout->expenses->sum('total');
       $this->payout->expenses->sum('total');

       $this->companyCardTotal =  $this->payout
           ->expenses
           ->where('payment_type', Expenses::PAYMENT_METHOD__COMPANY_CREDIT_CARD)
           ->sum('total');

       $this->otherTotal = $this->payout
            ->expenses
            ->where('payment_type', Expenses::PAYMENT_METHOD__UNSPECIFIED)
            ->sum('total');
    }

    public function payoutNow(){
        $this->payout->paid_at = now();
        $this->payout->paid_by_user_id = auth()->id();
        $this->payout->status = ExpensePayout::STATUS__PAID;
        $this->updateQBRecordsForCreditCardPayments();
        $this->payout->save();
        $this->close();
    }

    public function updateQBRecordsForCreditCardPayments(): void
    {
        set_time_limit(600); //set the timeout to 10 mins,
        $controller = new QbResourceController();

        /**  @var Expenses $record */
        $records = $this->payout->expenses->where('payment_type', Expenses::PAYMENT_METHOD__COMPANY_CREDIT_CARD);
        foreach ($records as $record){

            if(empty($record->qb_payment_id)){
                $controller->purchase($record);
            }

            //handling attachment separately, so that if the first fails, you can still re-try
            if( $record->qb_payment_id && empty($record->qb_attachment_id) ){
                //will set qb_attachment_id, if upload is a success.
                $controller->uploadPurchaseBillAsAttachment($record);
            }
        }
    }

    public function render()
    {
        return view('livewire.expenses-report.payout-modal-component', ['payout' => $this->payout]);
    }
}
