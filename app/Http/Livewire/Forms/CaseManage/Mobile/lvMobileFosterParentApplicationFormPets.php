<?php

namespace App\Http\Livewire\Forms\CaseManage\Mobile;

use App\Models\FosterParentApplicationForm;
use Livewire\Component;


class lvMobileFosterParentApplicationFormPets extends Component
{


    public FosterParentApplicationForm $FPAForm;
    public $pets = [];

    protected $listeners = [];

    protected $rules = [
        'pets' => 'nullable',
        'pets.*.name' => 'nullable',
        'pets.*.type' => 'nullable',
        'pets.*.picture' => 'nullable',
        'pets.*.vaccination_certificate' => 'nullable'
    ];

    public function mount()
    {
       $this->pets = $this->FPAForm->family_pets;
    }

    public function updated($name, $value) {
        $this->FPAForm->family_pets = $this->pets;
        $this->FPAForm->save();
        $this->dispatchBrowserEvent('refreshPB');

    }

    public function add() {
        $tmpArray = [
            'name' => '',
            'type'=> '',
            'picture' => '',
            'vaccination_certificate' => ''
        ];

        array_push($this->pets ,$tmpArray);
        $this->FPAForm->family_pets = $this->pets;
        $this->FPAForm->save();
        $this->dispatchBrowserEvent('family_composition_change');

        $this->dispatchBrowserEvent('pets_change');

        $this->dispatchBrowserEvent('refreshPB');

        //dd($this->pets);

    }


    public function remove($i)
    {

        unset($this->pets[$i]);
        $this->FPAForm->family_pets = $this->pets;
        $this->FPAForm->save();
//        $this->dispatchBrowserEvent('family_composition_change');
        $this->dispatchBrowserEvent('pets_change');

        $this->dispatchBrowserEvent('refreshPB');

    }
    public function render()
    {

        //dd($this->pets);
        return <<<'blade'

            <div>


                        @if ($this->pets)
                            @foreach ($this->pets as $key => $value)

                                    <div class="row mb-3">

                                            <label>Name of Pet</label>
                                            <input  class="countme_family_pets" type="text" wire:model="pets.{{$key}}.name" placeholder="Pet Name"  name="family-pets-{{$key}}-name" class="form-control" />
                                        </div>

                                        <div class="row mb-3">
                                             <label>Type of Pet</label>
                                            <input class="countme_family_pets " type="text" id="family-pets-{{$key}}-type" wire:model="pets.{{$key}}.type" placeholder="Type of Pet" name="pets-{{$key}}-type" key="{{$key}}" class="form-control" value="{{ old('pets['.$key.'][type]') }}" >
                                        </div>

                               <div class="card card-primary">
                                    <div class="card-header pb-2 mb-0 border-0 ">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#petAttachments" aria-expanded="false" aria-controls="collapseExample">
                                            View Attachments
                                        </button>
                                    </div>
                                    <div class="card-body collapse" id="petAttachments">
                                                    @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'multiple' => true, 'key' => "family_pets_picture_" . $key, 'section'=>'Family Pet Pictures'], key("family_pets_picture_" . $key))

                                                    @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'multiple' => true, 'key' => "family_pets_vaccination_certificate_" . $key, 'section'=>'Family Pet Vaccination Certificates'], key("family_pets_vaccination_certificates_" . $key))



                                </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-danger mb-3" wire:click.prevent="remove({{$key}})">REMOVE PET</button>
                                </div>




                                @endforeach
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary mb-3" wire:click.prevent="add()">+ PET</button>
                                </div>
                                @else
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary mb-3" wire:click.prevent="add()">+ PET</button>
                                </div>
                                @endif
                         </div>
            blade;

        $this->dispatchBrowserEvent('refreshPB');

    }




}
