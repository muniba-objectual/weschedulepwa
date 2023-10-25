<?php

namespace App\Http\Livewire\Modals\CaseManage;


use Illuminate\Support\Facades\Schema;
use App\Models\User;
use WireElements\Pro\Components\Modal\Modal;
class CreateCaseWorkerModal extends Modal
{

    public $agencyID;
    public $data;
    public $show;

    public $size;

    public \App\Models\PlacingAgencyCaseWorker $tmpCaseWorker;
    public \App\Models\PlacingAgency $tmpAgency;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'tmpCaseWorker.name' => 'required|string|min:3',
        'tmpCaseWorker.email' => 'nullable|email',
        'tmpCaseWorker.telephone' => 'nullable',
        'tmpCaseWorker.notes' => 'nullable',

        //'drivers_license_photo' => 'nullable',


    ];

    protected $listeners = ['showModal' => 'showModal'];

    public static function attributes(): array
    {
        return [
                // Set the modal size to 2xl, you can choose between:
                // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
                'size' => '7xl',

            ];
    }

    public function mount() {

        $this->tmpCaseWorker = new \App\Models\PlacingAgencyCaseWorker();

    }


    public function createCaseWorker()
    {
        // Do Something With Your Modal


            $this->validate();
        Schema::disableForeignKeyConstraints();


            $this->tmpCaseWorker->fk_PlacingAgencyID = $this->agencyID;
            $this->tmpCaseWorker->save();
        Schema::enableForeignKeyConstraints();

        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.create-case-worker-modal');
    }
}
