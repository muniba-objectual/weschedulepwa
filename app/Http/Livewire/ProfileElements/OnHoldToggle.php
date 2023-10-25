<?php

namespace App\Http\Livewire\ProfileElements;

use Livewire\Component;
use App\Models\User;
use App\Models\Child;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class OnHoldToggle extends Component
{
    use LivewireAlert;

    public $model;
    public $toggleHold = false;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount() {
        //$this->user = Child::all()->where('Discharged','=','0');
        //$this->toggleActive = false;

    }

    public function updatedToggleHold($value) {
        if ($value) { //Show Deactivated

            $this->dispatchBrowserEvent('setToggleOnHoldStatus', ['OnHold' => $value]);
            // $this->children = Child::all()->where('Discharged','=','1');
            //  $this->emit('refreshComponent');
            //$this->alert('warning', "Showing Discharged Children");

        }

    }


    public function render()
    { //return $toggleActive;
        return <<<'blade'
            <div>

                <style>
                /* for sm */

                    .custom-switch.custom-switch-sm .custom-control-label {
                        padding-left: 1rem;
                        padding-bottom: 1rem;
                    }

                    .custom-switch.custom-switch-sm .custom-control-label::before {
                        height: 1rem;
                        width: calc(1rem + 0.75rem);
                        border-radius: 2rem;
                    }

                    .custom-switch.custom-switch-sm .custom-control-label::after {
                        width: calc(1rem - 4px);
                        height: calc(1rem - 4px);
                        border-radius: calc(1rem - (1rem / 2));
                    }

                    .custom-switch.custom-switch-sm .custom-control-input:checked ~ .custom-control-label::after {
                        transform: translateX(calc(1rem - 0.25rem));
                    }

                    /* for md */

                    .custom-switch.custom-switch-md .custom-control-label {
                        padding-left: 1rem;
                        padding-bottom: 1.5rem;
                        padding-top: 4px;
                    }

                    .custom-switch.custom-switch-md .custom-control-label::before {
                        height: 1.5rem;
                        width: calc(2rem + 0.75rem);
                        border-radius: 3rem;
                    }

                    .custom-switch.custom-switch-md .custom-control-label::after {
                        width: calc(1.5rem - 4px);
                        height: calc(1.5rem - 4px);
                        border-radius: calc(2rem - (1.5rem / 2));
                    }

                    .custom-switch.custom-switch-md .custom-control-input:checked ~ .custom-control-label::after {
                        transform: translateX(calc(1.5rem - 0.25rem));
                    }

                    /* for lg */

                    .custom-switch.custom-switch-lg .custom-control-label {
                        padding-left: 3rem;
                        padding-bottom: 2rem;
                    }

                    .custom-switch.custom-switch-lg .custom-control-label::before {
                        height: 2rem;
                        width: calc(3rem + 0.75rem);
                        border-radius: 4rem;
                    }

                    .custom-switch.custom-switch-lg .custom-control-label::after {
                        width: calc(2rem - 4px);
                        height: calc(2rem - 4px);
                        border-radius: calc(3rem - (2rem / 2));
                    }

                    .custom-switch.custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
                        transform: translateX(calc(2rem - 0.25rem));
                    }

                    /* for xl */

                    .custom-switch.custom-switch-xl .custom-control-label {
                        padding-left: 4rem;
                        padding-bottom: 2.5rem;
                    }

                    .custom-switch.custom-switch-xl .custom-control-label::before {
                        height: 2.5rem;
                        width: calc(4rem + 0.75rem);
                        border-radius: 5rem;
                    }

                    .custom-switch.custom-switch-xl .custom-control-label::after {
                        width: calc(2.5rem - 4px);
                        height: calc(2.5rem - 4px);
                        border-radius: calc(4rem - (2.5rem / 2));
                    }

                    .custom-switch.custom-switch-xl .custom-control-input:checked ~ .custom-control-label::after {
                        transform: translateX(calc(2.5rem - 0.25rem));
                    }
                </style>
                       <div class="custom-control custom-switch custom-switch-md custom-switch-off-danger custom-switch-on-success">

                       @isset($model->OnHold)
                            @if ($model->OnHold == 1)
                            <input @if (Auth::user()->id == 1 || Auth::user()->id == 2) @else readonly @endif wire:model="toggleHold"  type="checkbox" class="custom-control-input" id="customSwitch2"  @if(Auth::User()->get_user_type->type < '3.0') disabled @endif >
                            <label class="custom-control-label" for="customSwitch2">On Hold</label>
                             <script>
                            $(function()  {
                            $('#customSwitch2').prop('checked', true);
                            });
                            </script>
                            @else
                            <input @if (Auth::user()->id == 1 || Auth::user()->id == 2) @else readonly @endif wire:model="toggleHold"  type="checkbox" class="custom-control-input" id="customSwitch2"  @if(Auth::User()->get_user_type->type < '3.0') disabled @endif >
                            <label class="custom-control-label" for="customSwitch2">Not On Hold</label>
                            <script>
                            $(function()  {
                            $('#customSwitch2').prop('checked', false);
                            });
                            </script>

                            @endif

                        @endif


                        </div>


            </div>

        blade;
    }
}
