<?php

namespace App\Http\Livewire\Modals\CaseManage;


use Illuminate\Support\Facades\Schema;
use App\Models\User;
use WireElements\Pro\Components\Modal\Modal;
class ManageCaseManagerModal extends Modal
{


    public $userID;

    protected $rules = [
        'tmpUser.fk_CaseManagerID' => 'required',
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

    $this->tmpUser = User::where('id','=',$this->userID)->first();

    }


    public function ModifyCaseManager()
    {
        // Do Something With Your Modal

        $this->validate();

            $this->tmpUser->save();

        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.manage-case-manager-modal');
    }
}
