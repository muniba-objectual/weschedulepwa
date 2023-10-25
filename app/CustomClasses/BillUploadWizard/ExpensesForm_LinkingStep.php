<?php

namespace App\CustomClasses\BillUploadWizard;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use App\Models\Expenses;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;
use App\Models\Child;
use Livewire\WithFileUploads;
use Spatie\LivewireWizard\Components\StepComponent;

class ExpensesForm_LinkingStep extends StepComponent
{
    use LivewireAlert;
    use WithFileUploads;
    use ExpenseCore;

    public $user;
    public $homes;

    public $expenses;
    public $upload;

    public $receipt;


    protected $rules = [
        'expenses.linkTo' => 'required',
        'expenses.linkToID' => 'nullable',
    ];

    protected $listeners = [];
    public array $mainOptions;
    public ?array $subOptions;

    public function stepInfo(): array
    {
        return [
            'label' => 'Linking',
//            'icon' => '',
        ];
    }



    public function mount() {
        $this->initExpenseConfig();

        $this->user = Auth::user();
        $this->expenses = new Expenses();
        $this->expenses->datetime = date('m/d/Y H:i');

        $this->expenses =  $this->expenses->fill($this->state()->forStep("Review")['expenses']);
        $this->mainOptions = $this->dropDown1;
    }



    public function render()
    {
        $this->initExpenseConfig();
        $this->subOptions = $this->dropDown2[$this->expenses->linkTo];

        //where there is not no sub-options, reset value
        if(!$this->subOptions){
            $this->expenses->linkToID = null;
        }
//        dd(
//            self::getLoginRoleLevel(),
//            $this->expenses->linkTo, $this->mainOptions,
//            $this->expenses->linkToID, $this->subOptions);

        clock()->info($this->state()->all());

        return view ('livewire.forms.ExpensesForm_step3');

    }

}
