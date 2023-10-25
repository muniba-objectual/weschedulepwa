<?php

namespace App\Http\Livewire\Modals\CaseManage;


use Illuminate\Support\Facades\Schema;
use App\Models\User;
use WireElements\Pro\Components\Modal\Modal;
class CreateStaffModal extends Modal
{

    public $data;
    public $show;

    public $size;

    public User $tmpStaff;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'tmpStaff.user_type' => 'required',
        'tmpStaff.name' => 'required|string|min:3',
        'tmpStaff.email' => 'required|unique:users,email|email',
        'tmpStaff.address' => 'nullable',
        'tmpStaff.city' => 'nullable',
        'tmpStaff.province' => 'nullable',
        'tmpStaff.postal' => 'nullable',
        //'drivers_license_photo' => 'nullable',


        'password' => 'confirmed',


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

        $this->tmpStaff = new User();

    }


    public function createUser()
    {
        // Do Something With Your Modal

     $this->tmpStaff->password = bcrypt($this->password_confirmation);

            $this->validate();
        Schema::disableForeignKeyConstraints();


           /* if ($this->drivers_license_photo) {
                $filename = $this->drivers_license_photo->store('/public/drivers_license/');
                $this->tmpStaff->drivers_license = $filename;
            }*/
            $this->tmpStaff->save();
        Schema::enableForeignKeyConstraints();

        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.create-staff-modal');
    }
}
