<?php

namespace App\Http\Livewire\Modals\CaseManage;


use Illuminate\Support\Facades\Schema;
use App\Models\User;
use WireElements\Pro\Components\Modal\Modal;
class CreatePlacingAgencyModal extends Modal
{

    public $data;
    public $show;

    public $size;

    public \App\Models\PlacingAgency $tmpAgency;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'tmpAgency.name' => 'required|string|min:3',
        'tmpAgency.address' => 'nullable',
        'tmpAgency.city' => 'nullable',
        'tmpAgency.province' => 'nullable',
        'tmpAgency.postal' => 'nullable',
        'tmpAgency.notes' => 'nullable',
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

        $this->tmpAgency = new \App\Models\PlacingAgency();

    }


    public function createAgency()
    {
        // Do Something With Your Modal


            $this->validate();
        Schema::disableForeignKeyConstraints();



            $this->tmpAgency->save();
        Schema::enableForeignKeyConstraints();

        $this->dispatchBrowserEvent('refreshPage');
        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.create-placing-agency-modal');
    }
}
