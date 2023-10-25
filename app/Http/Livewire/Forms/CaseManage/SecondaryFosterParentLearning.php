<?php

namespace App\Http\Livewire\Forms\CaseManage;

use Livewire\Component;

class SecondaryFosterParentLearning extends Component
{
    public $fosterUserId;
    public $secondary_foster;

    public function mount($user)
    {

        $this->fosterUserId = $user->id;
        $model = $user->getFosterParentFormPivot;

        $this->secondary_foster['has_form']          = $model->has_secondary_learning_form;
        $this->secondary_foster['full_name']         = $model->secondary_foster_parent_full_name;
        $this->secondary_foster['date_of_birth']     = $model->secondary_foster_parent_date_of_birth;
        $this->secondary_foster['email']             = $model->secondary_foster_parent_email;
        $this->secondary_foster['telephone']         = $model->secondary_foster_parent_telephone;
        $this->secondary_foster['relationship']      = $model->secondary_foster_parent_relationship_to_primary;
    }

    public function updated()
    {
        $data = [
            'has_secondary_learning_form'           => $this->secondary_foster['has_form'],
            'secondary_foster_parent_full_name'     => $this->secondary_foster['full_name'],
            'secondary_foster_parent_date_of_birth' => $this->secondary_foster['date_of_birth'],
            'secondary_foster_parent_email'         => $this->secondary_foster['email'],
            'secondary_foster_parent_telephone'     => $this->secondary_foster['telephone'],
            'secondary_foster_parent_relationship_to_primary'  => $this->secondary_foster['relationship'],
        ];

        \App\Models\User::find($this->fosterUserId)->getFosterParentFormPivot->update($data);
        $this->dispatchBrowserEvent('secondary-switch-state-changed');
    }

    public function render()
    {
        return <<<'blade'
            <div>
                <div class="col-md-12">

                    {{-- control switch --}}
                    <!-- <div class="form-group">
                        <label>Enable Secondary Learning Form</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" wire:model="secondary_foster.has_form" {{ $secondary_foster['has_form'] ? 'checked' : '' }}>
                            <label class="custom-control-label"></label>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label>Enable Secondary Learning Form</label>
                        <input type="checkbox" id="secondaryFosterParentLearningFormToggleSwitch" class="" wire:model="secondary_foster.has_form" {{ $secondary_foster['has_form'] ? 'checked' : '' }}>
                    </div>

                </div>

                @if( $secondary_foster['has_form'] )
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" placeholder="Enter full name" wire:model="secondary_foster.full_name">
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" wire:model="secondary_foster.date_of_birth">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" placeholder="Enter email" wire:model="secondary_foster.email">
                        </div>
                        <div class="form-group">
                            <label for="telephone">Telephone</label>
                            <input type="tel" class="form-control" placeholder="Enter telephone number" wire:model="secondary_foster.telephone">
                        </div>
                        <div class="form-group">
                            <label for="relationship">Relationship to Primary Foster Parent</label>
                            <input type="text" class="form-control" placeholder="Enter relationship" wire:model="secondary_foster.relationship">
                        </div>
                    </div>
                @endif
            </div>
        blade;

    }
}
