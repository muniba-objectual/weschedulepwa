<?php

namespace App\Http\Livewire\Modals\CaseManage;


use App\Models\BankDeposit;
use App\Models\PlacingAgencyWorkers;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use WireElements\Pro\Components\Modal\Modal;
use Carbon\Carbon;
use Auth;
class AddPlacingAgencyWorkersModal extends Modal
{

     public $show;

    public $agencyID;
    public $AuthUserID;

    public $size;

   public $type;
   public $name;
   public $email;
    public $telephone;

    protected $rules = [
        'type' => 'required',
        'name' => 'required',
        'email' => 'nullable',
        'telephone' => 'nullable',



    ];

    protected $listeners = ['showModal' => 'showModal', 'update' => 'update'];

    public function update($value) {




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
    $this->name = "";
    $this->type = "Finance Worker";
    $this->email = "";
    $this->telephone = "";
    }


    public function submit()
    {
        // Do Something With Your Modal


            $this->validate();

        $newWorker = new PlacingAgencyWorkers();
        $newWorker->name = $this->name;
        $newWorker->type = $this->type;
        $newWorker->telephone = $this->telephone;
        $newWorker->email = $this->email;
        $newWorker->fk_PlacingAgencyID = $this->agencyID;

        $newWorker->save();


        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.add-placing-agency-workers-modal');
    }
}
