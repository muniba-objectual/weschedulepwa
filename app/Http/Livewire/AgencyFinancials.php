<?php

namespace App\Http\Livewire;


use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;
use App\Models\PlacingAgency;
use App\Models\PlacingAgencyWorkers;
use Illuminate\Support\Str;



class AgencyFinancials extends Component

{

    public $placingAgencyID;
    public $placingAgency;

    protected $rules = [

        'placingAgency.per_diem_rate' => 'nullable',
        'placingAgency.ISA_PFA_rate' => 'nullable',
        'placingAgency.outside_respite_rate' => 'nullable',
        'placingAgency.holding_rate' => 'nullable',
        'placingAgency.mileage_rate' => 'nullable',
        'placingAgency.mileage_terms' => 'nullable',




    ];

    public function mount()
    {



    }

    public function updated($field, $value) {
       if ($value) {

            $this->placingAgency->save();

    }


    }

    public function render()
    {

        $this->placingAgency = PlacingAgency::where('id', '=', $this->placingAgencyID)->firstOrFail();

        return <<<'blade'
            <div wire:poll.active>
                 <div class="row mb-2">
                                        <h5 class="mt-3 text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Rates</h5>

                                        <div class="col-2">
                                            <label for="" class="text-sm">Per Diem Rate</label>
                                            <input type="text" class="form-control"
                                                   wire:model="placingAgency.per_diem_rate">
                                        </div>
                                        <div class="col-2">
                                            <label for="" class="text-sm">ISA/PFA Rate</label>
                                            <input  type="text" class="form-control"
                                                    wire:model="placingAgency.ISA_PFA_rate" >
                                        </div>
                                        <div class="col-2">
                                            <label for="" class="text-sm">Outside Resp. Rate</label>
                                            <input  type="text" class="form-control"
                                                    wire:model="placingAgency.outside_respite_rate" >
                                        </div>
                                        <div class="col-2">
                                            <label for="" class="text-sm">Holding Rate</label>
                                            <input  type="text" class="form-control"
                                                    wire:model="placingAgency.holding_rate" >
                                        </div>
                                        <div class="col-2">
                                            <label for="" class="text-sm">Mileage Rate</label>
                                            <input  type="text" class="form-control"
                                                    wire:model="placingAgency.mileage_rate" >
                                        </div>
                                        <div class="col-2">
                                            <label for="" class="text-sm">Mileage Terms</label>
                                            <input  type="text" class="form-control"
                                                    wire:model="placingAgency.mileage_terms" >
                                        </div>

                                    </div>

              </div>
        blade;
    }
}
