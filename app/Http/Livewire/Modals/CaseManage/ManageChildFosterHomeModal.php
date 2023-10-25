<?php

namespace App\Http\Livewire\Modals\CaseManage;


use Illuminate\Support\Facades\Schema;
use App\Models\Child;
use WireElements\Pro\Components\Modal\Modal;
class ManageChildFosterHomeModal extends Modal
{


    public $childID;

    protected $rules = [
        'tmpChild.FosterHome_fk_UserID' => 'nullable',
    ];

    public static function attributes(): array
    {
        return [
                // Set the modal size to 2xl, you can choose between:
                // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
                'size' => '7xl',

            ];
    }

    public function mount() {

    $this->tmpChild = Child::where('id','=',$this->childID)->first();

    }


    public function ModifyChildFosterHome()
    {
        // Do Something With Your Modal

        $this->validate();

            $this->tmpChild->save();

        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.manage-child-foster-home-modal');
    }
}
