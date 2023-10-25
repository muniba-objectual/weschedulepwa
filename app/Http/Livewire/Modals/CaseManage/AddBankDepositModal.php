<?php

namespace App\Http\Livewire\Modals\CaseManage;


use App\Models\BankDeposit;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use WireElements\Pro\Components\Modal\Modal;
use Carbon\Carbon;
use Auth;
class AddBankDepositModal extends Modal
{

     public $show;
     public $user;
    public $userID;
    public $AuthUserID;

    public $size;

   public $date;
   public $description;
   public $amount;
    public $tmpDate;

    protected $rules = [
        'date' => 'required',
        'description' => 'required',
        'amount' => 'required'



    ];

    protected $listeners = ['showModal' => 'showModal', 'updateBankDeposit' => 'updateBankDeposit'];

    public function updateBankDeposit($value) {
        if ($value) {
            //convert date/time to Carbon
            $this->tmpDate = Carbon::parse($value)->toDateTimeString();
        }
        $this->date = $value;



    }
    public static function attributes(): array
    {
        return [
                // Set the modal size to 2xl, you can choose between:
                // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
                'size' => '7xl',

            ];
    }

    public function mount() {

    //$this->callDateTime = "";
    $this->description = "";
    $this->amount = "0.00";
    $this->date = "";
    }


    public function submit()
    {
        // Do Something With Your Modal


            $this->validate();

            $this->user = User::where('id','=',$this->userID)->first();
        $bankDeposit = new BankDeposit();
        $bankDeposit->description = $this->description;
        $bankDeposit->amount = $this->amount;
        $bankDeposit->date = Carbon::parse($this->date)->format('Y-m-d');
        $bankDeposit->fk_UserID = $this->userID;
        $bankDeposit->save();


        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.add-bank-deposit-modal');
    }
}
