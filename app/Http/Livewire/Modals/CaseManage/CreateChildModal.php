<?php

namespace App\Http\Livewire\Modals\CaseManage;


use Illuminate\Support\Facades\Schema;
use App\Models\Child;
use WireElements\Pro\Components\Modal\Modal;
class CreateChildModal extends Modal
{

    public $data;
    public $show;

    public $size;

    public Child $tmpChild;


    protected $rules = [
        'tmpChild.initials' => 'required|string|min:3',
        'tmpChild.DOB' => 'nullable|date',
//        'tmpChild.CAS_fk_UserID' => 'nullable',
        'tmpChild.FosterHome_fk_UserID' => 'required'

    ];

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "tmpChild.initials" => "The child's name is required.",
            "tmpChild.FosterHome_fk_UserID" => "The Foster Home is required.",
        ];
    }

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

        $this->tmpChild = new Child();

    }


    public function createChild()
    {
        // Do Something With Your Modal


            $this->validate();
        Schema::disableForeignKeyConstraints();


           /* if ($this->drivers_license_photo) {
                $filename = $this->drivers_license_photo->store('/public/drivers_license/');
                $this->tmpChild->drivers_license = $filename;
            }*/
            $this->tmpChild->status = "Pending";
            $this->tmpChild->save();
        Schema::enableForeignKeyConstraints();

        // Close Modal After Logic
        $this->close();


    }

    public function render()
    {
        return view('livewire.modals.case-manage.create-child-modal');
    }
}
