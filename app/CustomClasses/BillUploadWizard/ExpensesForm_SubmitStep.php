<?php

namespace App\CustomClasses\BillUploadWizard;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use App\Models\CreditCard;
use App\Models\Expenses;
use App\Models\VendorAccountPredictionList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Spatie\LivewireWizard\Components\StepComponent;


class ExpensesForm_SubmitStep extends StepComponent
{
    use LivewireAlert;
    use WithFileUploads;
    use ExpenseCore;

    public $user;
    public $homes;

    public $carpediemstaff;
    public $fosterparents;
    public $children;

    public $expenses;
    public $upload;

    public $receipt;
    public $receiptTmpPath;
    public $OCR_ResultID;

    protected $rules = [
        "expenses.notes" => "nullable"


    ];

    protected $listeners = [];


    public function stepInfo(): array
    {
        return [
            'label' => 'Submit',
//            'icon' => '',
        ];
    }

    public function submit() {

        $this->initExpenseConfig();

        $this->expenses->fk_UserID = Auth::user()->id;
        $this->expenses->description = $this->state()->forStep("Review")['expenses']['description']; //Merchant Name
        $this->expenses->datetime = Carbon::parse($this->state()->forStep("UploadReceipt")['expenses']['datetime'])->toDateTimeString();

        $paymentMethod = $this->state()->forStep("Review")['expenses']['payment_source'];
        if($paymentMethod == 0){
            $this->expenses->payment_type = Expenses::PAYMENT_METHOD__UNSPECIFIED;
        }else{
            $this->expenses->payment_type = Expenses::PAYMENT_METHOD__COMPANY_CREDIT_CARD;

            /**
             * Attach Card Details
             * @var CreditCard $card
             */
            $card = CreditCard::query()
                ->where('user_id', auth()->id()) //use 'user_id' relation filter for better security
                ->findOrFail($paymentMethod);

            $this->expenses->credit_card_id = $card->id;
            $this->expenses->last_four_digits = $card->last_four_digits;
        }

        $this->expenses->subtotal = $this->state()->forStep("Review")['expenses']['subtotal'];
        $this->expenses->HST = $this->state()->forStep("Review")['expenses']['HST'];
        $this->expenses->total = $this->state()->forStep("Review")['expenses']['total'];
        $this->expenses->line_items = json_encode($this->state()->forStep("Review")['expenses']['line_items'],JSON_HEX_APOS);

        /** LinkTo binding */
        if($this->mobileExpenseCreateFormStage3){
            //if stage 3 enabled take values from step wizard
            $this->expenses->linkTo = $this->state()->forStep("Linking")['expenses']['linkTo']??null; //if empty make it null
            $this->expenses->linkToID = $this->state()->forStep("Linking")['expenses']['linkToID']??null;  //if empty make it null

        }else{
            //if no step 3 either it can due to 1 option only active -OR- default:toOwnerOnly option

            //pick first option -OR- cast to null assuming as OwnerOnly
            $this->expenses->linkTo = array_key_first($this->dropDown1)??null;

            //cast to null assuming as OwnerOnly
            if(count($this->dropDown2[$this->expenses->linkTo]??[]) == 0){
                $this->expenses->linkToID = null;

            }else //pick first option (key)
            if( count($this->dropDown2[$this->expenses->linkTo]) == 1 ) {
                $this->expenses->linkToID = reset($this->dropDown2[$this->expenses->linkTo]);
            }
        }

        //Data corrections
        if($this->expenses->linkToID == ''){
            $this->expenses->linkToID = null;
        }
        if($this->expenses->linkTo == ''){
            $this->expenses->linkTo = null;
        }

        /** End linkTo binding */

        if (isset($this->state()->forStep("UploadReceipt")['receiptTmpPath'])) {
            //if file has been uplaoded, associate it to the model
            $tmpAssociateFile = $this->expenses->addMedia(storage_path('app') . "/" . $this->state()->forStep("UploadReceipt")['receiptTmpPath'])->toMediaCollection("Expenses");
            $this->expenses->attachment = $tmpAssociateFile->file_name;
        }

        $prediction = VendorAccountPredictionList::getBestVendor($this->expenses->description);
        if($prediction){
            $this->expenses->vendor_id      = $prediction->vendor->Id;
            $this->expenses->vendor_name    = $prediction->vendor->DisplayName;
            $this->expenses->vendor_was_predicted = true;
        }

        $this->expenses->save();

        $this->alert('success', 'Expense Saved Successfully', ['position' => 'center', 'timer' => 3000]);

        $this->redirect(session()->pull('expense.url.redirect-back') ?? "/mobileCM");

    }

    public function mount() {
//        $this->performOCR();
//        $this->getOCRResults();

        $this->expenses = new Expenses();
        $this->expenses->datetime = date('m/d/Y H:i');

    }


    public function render()
    {
          return view ('livewire.forms.ExpensesForm_step4');
    }


}
