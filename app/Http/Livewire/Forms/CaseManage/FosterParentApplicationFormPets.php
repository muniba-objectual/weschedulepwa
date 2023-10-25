<?php

namespace App\Http\Livewire\Forms\CaseManage;

use App\Models\FosterParentApplicationForm;
use Livewire\Component;


class FosterParentApplicationFormPets extends Component
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

                                    <div class="d-flex justify-content-start mb-3">

                                        <div class="col">
                                            <label>Name of Pet</label>
                                            <input  class="countme_family_pets" type="text" wire:model="pets.{{$key}}.name" placeholder="Pet Name"  name="family-pets-{{$key}}-name" class="form-control" />
                                        </div>

                                        <div class="col">
                                             <label>Type of Pet</label>
                                            <input class="countme_family_pets " type="text" id="family-pets-{{$key}}-type" wire:model="pets.{{$key}}.type" placeholder="Type of Pet" name="pets-{{$key}}-type" key="{{$key}}" class="form-control" value="{{ old('pets['.$key.'][type]') }}" >
                                        </div>
                                        </div>
                                <x-adminlte-card class="attachments_pets" title="Attachments" theme="secondary" theme-mode="" icon="fas fa-lg fa-file-circle-plus"
                                                 collapsible="collapsed" header-class="mt-0">

                                                    @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'multiple' => true, 'key' => "family_pets_picture_" . $key, 'section'=>'Family Pet Pictures'], key("family_pets_picture_" . $key))

                                                    @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'multiple' => true, 'key' => "family_pets_vaccination_certificate_" . $key, 'section'=>'Family Pet Vaccination Certificates'], key("family_pets_vaccination_certificates_" . $key))



                                </x-adminlte-card>
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
