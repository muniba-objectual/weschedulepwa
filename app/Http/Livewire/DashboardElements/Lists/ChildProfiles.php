<?php

namespace App\Http\Livewire\DashboardElements\Lists;

use Livewire\Component;
use App\Models\Child;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class ChildProfiles extends Component
{
    use LivewireAlert;

    public $children;
   public  $toggleActive;
   public $toggleChildActive = true;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount() {
        $this->children = Child::all()->where('inactive','=','0')->where('WeSchedule','=','1')->sortBy('initials');
        //$this->toggleActive = false;

   }

    public function updatedToggleChildActive($value) {
        if (!$value) { //Show Deactivated
            $this->children = Child::all()->where('inactive','=','1')->where('WeSchedule','=','1')->sortBy('initials');
            //  $this->emit('refreshComponent');
            //$this->alert('warning', "Showing Discharged Children");

        } else {
            $this->children = Child::all()->where('inactive','=','0')->where('WeSchedule','=','1')->sortBy('initials');
        }

    }

    public function render()
    {
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
             <!-- Child Profiles -->
                    <div class="container-fluid mt-3 mb-3">
                        <div class="d-flex justify-content-start">
                        <div class="col-10">CHILD PROFILES</div>
                        <div class="col-2 custom-control custom-switch custom-switch-md custom-switch-off-danger custom-switch-on-success">
                        <input wire:model="toggleChildActive" type="checkbox" class="custom-control-input" id="customSwitch1" @if ($toggleChildActive) checked @endif>
                        <label class="custom-control-label" for="customSwitch1">@if ($toggleChildActive) Showing Active @else Showing Inactive @endif</label>
                        </div>
                    </div>
                        <div class="row gx-4 gx-lg-5 row-cols-6 row-cols-md-6 row-cols-xl-6 mt-2 justify-content-center">
                            @foreach ($children as $child)
                                <div class="col-xl-2 col-md-2 mb-4">
                                    <div class="card border-0 shadow">

                                                <!--                                        <img src="https://images.unsplash.com/photo-1516240562813-7d658edb7239?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80" class="card-img-top" alt="...">-->
                                        <img src="/img/child_avatar_bev_grad.jpg" class="card-img-top" alt="...">

                                        @if ($child->SRA)<span class="badge bg-success mt-0">SRA</span>@endif
                                        @if ($child->PFA)<span class="badge bg-gradient-yellow mt-0">PFA</span>@endif
                                        @if ($child->ISA)<span class="badge bg-gradient-indigo mt-0">ISA</span>@endif
                                        @if ($child->CARPE_DIEM)<span class="badge bg-gradient-navy mt-0">CARP&Eacute; DIEM</span>@endif
                                        @if (!$child->SRA && !$child->PFA && !$child->ISA && !$child->CARPE_DIEM)<span class="badge" style="margin-bottom:1.3px !important;"><br /></span>@endif
                                        <div class="card-body text-center">
                                            <h6 class="mb-0 text-sm text-center @php
                                                if (strlen($child->initials) >15)
                                                    echo "child-small text-truncate";
                                            @endphp">                      <br />{{$child->initials}}</h6>
                                            <div class="card-text text-black-50">                                            <div class="button mt-2 d-flex flex-row align-items-center"> <button onclick="viewChildProfile('{{$child->id}}')" class="btn btn-sm btn-primary w-100">Profile</button> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                    <!-- *Child Profiles -->


            </div>

        blade;
    }
}
