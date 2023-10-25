<?php

namespace App\Http\Livewire\Modals\CaseManage;


use Illuminate\Support\Facades\Schema;
use App\Models\User;
use WireElements\Pro\Components\Modal\Modal;
use Livewire\WithFileUploads;
class CreateFosterParentModal extends Modal
{

    use WithFileUploads;

    public $drivers_license_photo;
    public $data;
    public $show;

    public $size;

    public User $tmpFosterParent;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'tmpFosterParent.name' => 'required|string|min:3',
        'tmpFosterParent.email' => 'required|unique:users,email|email',
        'tmpFosterParent.address' => 'nullable',
        'tmpFosterParent.city' => 'nullable',
        'tmpFosterParent.province' => 'nullable',
        'tmpFosterParent.postal' => 'nullable',
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

        $this->tmpFosterParent = new User();

    }


    public function createUser()
    {
        // Do Something With Your Modal

     $this->tmpFosterParent->password = bcrypt($this->password_confirmation);

            $this->validate();
        Schema::disableForeignKeyConstraints();

            $this->tmpFosterParent->user_type = 2.3;

           /* if ($this->drivers_license_photo) {
                $filename = $this->drivers_license_photo->store('/public/drivers_license/');
                $this->tmpFosterParent->drivers_license = $filename;
            }*/
            $this->tmpFosterParent->save();
        Schema::enableForeignKeyConstraints();

        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.create-foster-parent-modal');
    }
}
