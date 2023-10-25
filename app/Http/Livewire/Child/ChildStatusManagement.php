<?php

namespace App\Http\Livewire\Child;

use App\Models\Child;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class ChildStatusManagement extends Component
{
    use LivewireAlert;

    public bool $modelDisabledFlag;
    public $child;
    public $model = [
        'status' => '',
    ];

    protected $rules = [
        'model.status' => 'required',
    ];

    public function mount($child, bool $disabledStatus): void
    {
        $this->modelDisabledFlag = $disabledStatus;
        $this->child = $child;
        $this->model['status'] = $child->status;
    }

    public function updateStatus()
    {
        $this->validate();

        // Update the 'status' column in the Child model
        $this->child->status = $this->model['status'];
        switch ($this->child->status){
            case Child::STATUS__ACTIVE:
            case Child::STATUS__PENDING: $this->child->inactive = 0;break;
            case Child::STATUS__DISCHARGED: $this->child->inactive = 1;break;
        }
        $this->child->save();
    }

    public function render()
    {
        return <<<'blade'
            <h3 class="profile-username text-center">
                {{$child->initials}}

                <div class="mb-0 mt-3" style="margin-bottom:-10px !important;">
                    <div class="">
                        <label for="status">Status:</label>
                        <select wire:model="model.status" class="select2" id="model-status" wire:change="updateStatus" @if($this->modelDisabledFlag) disabled @endif >
                            <option value="Pending">Pending</option>
                            <option value="Active">Active</option>
                            <option value="Discharged">Discharged</option>
                        </select>
                    </div>
                </div>
            </h3>

            <p class="text-muted text-center">
                @if($model['status'] == "Pending")
                    <b style="color:orange !important;">PENDING</b>
                @endif
                @if($model['status'] == "Active")
                    <b style="color:green !important;">ACTIVE</b>
                @endif
                @if($model['status'] == "Discharged")
                    <b style="color:red !important;">DISCHARGED</b>
                @endif
            </p>
        blade;
    }
}
