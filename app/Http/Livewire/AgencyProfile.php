<?php

namespace App\Http\Livewire;


use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;
use App\Models\PlacingAgency;
use App\Models\PlacingAgencyWorkers;
use Illuminate\Support\Str;



class AgencyProfile extends Component

{

    public $placingAgencyID;
    public $placingAgency;
    public  $placingAgencyWorkers = [];

    protected $rules = [
        'placingAgency.name' => 'nullable',
        'placingAgency.address' => 'nullable',
        'placingAgency.city' => 'nullable',
        'placingAgency.province' => 'nullable',
        'placingAgency.postal' => 'nullable',

        'placingAgency.telephone' => 'nullable',
        'placingAgency.notes' => 'nullable',

        'placingAgency.direct_deposit_ID' => 'nullable',

        'placingAgencyWorkers.*.name' => 'nullable',
        'placingAgencyWorkers.*.telephone' => 'nullable',
        'placingAgencyWorkers.*.email' => 'nullable',




//        'placingAgency.finance_worker_name' => 'nullable',
//        'placingAgency.finance_worker_phone' => 'nullable',
//        'placingAgency.finance_worker_invoicing_email_address' => 'nullable',
//
//        'placingAgency.children_service_worker_name' => 'nullable',
//        'placingAgency.children_service_worker_email_address' => 'nullable',
//        'placingAgency.children_service_worker_phone' => 'nullable',
//
//        'placingAgency.family_service_worker_name' => 'nullable',
//        'placingAgency.family_service_worker_email_address' => 'nullable',
//        'placingAgency.family_service_worker_phone' => 'nullable',




    ];

    public function mount()
    {



    }

    public function updated($field, $value) {
       if ($value) {
//            $this->CM_Child_Profile->fk_ChildID = $this->child->id;
//
//            if ($field == "CM_Child_Profile.date_of_birth") {
//                $this->CM_Child_Profile->date_of_birth = \Carbon\Carbon::parse($value)->toDateString();
//            }
//
//            if ($field == "CM_Child_Profile.date_admitted_carpediem") {
//                $this->CM_Child_Profile->date_admitted_carpediem = \Carbon\Carbon::parse($value)->toDateString();
//            }
//
//            if ($field == "CM_Child_Profile.date_admitted_fosterhome") {
//                $this->CM_Child_Profile->date_admitted_fosterhome = \Carbon\Carbon::parse($value)->toDateString();
//            }
//
//            if ($field == "CM_Child_Profile.date_readmitted_carpediem") {
//                $this->CM_Child_Profile->date_readmitted_carpediem = \Carbon\Carbon::parse($value)->toDateString();
//            }
//
//
            $this->placingAgency->save();

           if (Str::contains($field, 'placingAgencyWorkers.')) {
               //PlacingAgencyWorkers::where('fk_PlacingAgencyID','=',$this->placingAgency->id)->delete();
               foreach ($this->placingAgencyWorkers as $type=>$workers) {
                   foreach ($workers as $worker) {
                       $tmpWorker = PlacingAgencyWorkers::find($worker['id']);
                       $tmpWorker->type = $worker['type'];
                       $tmpWorker->name = $worker['name'];
                       $tmpWorker->telephone = $worker['telephone'];
                       $tmpWorker->email = $worker['email'];
                       $tmpWorker->save();
                   }


               }


           }
    }


    }

    public function render()
    {

        $this->placingAgency = PlacingAgency::where('id', '=', $this->placingAgencyID)->firstOrFail();
//        $this->placingAgencyWorkers = PlacingAgencyWorkers::where('fk_PlacingAgencyID','=',$this->placingAgency->id)->get()->groupBy('type');
        $this->placingAgencyWorkers = PlacingAgencyWorkers::where('fk_PlacingAgencyID','=',$this->placingAgency->id)->get()->sortBy('name')->groupBy('type')->toArray();
        Debugbar::info($this->placingAgencyWorkers);

        return <<<'blade'
            <div wire:poll.active>
                <!-- form start -->
                                            <form>
                                                <div class="row mb-2">

                                                        <h5 class="text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Agency Information</h5>
                                                            <div class="col-4">
                                                                <label for="legal_name">Name</label>
                                                                <input  type="text" class="form-control" id="name"
                                                                       wire:model="placingAgency.name" >
                                                                </div>

                                                            <div class="col-2">
                                                                <label for="legal_name">Telephone</label>
                                                                <input  type="text" class="form-control" id="telephone"
                                                                       wire:model="placingAgency.telephone" >
                                                                </div>

                                                            <div class="col-2">
                                                                <label for="direct_deposit">Direct Deposit ID</label>
                                                                <input  type="text" class="form-control" id="direct_deposit"
                                                                       wire:model="placingAgency.direct_deposit_ID" >
                                                                </div>


                                                </div>

                                                <div class="row mb-2">

                                                    <div class="col-3">
                                                    <label for="legal_status">Address</label>
                                                    <input  type="text" class="form-control" id="address"
                                                           wire:model="placingAgency.address" >
                                                  </div>

                                                    <div class="col-3">
                                                        <label for="DOB">City</label>
                                                        <input type="text" class="form-control" id="city"
                                                        wire:model="placingAgency.city" >
                                                    </div>


                                                <div class="col-3">
                                                    <label for="health_card_number">Province</label>
                                                    <input  type="text" class="form-control" id="province"
                                                           wire:model="placingAgency.province" >
                                                </div>

                                                  <div class="col-2">
                                                    <label for="green_shield_number">Postal Code</label>
                                                    <input  type="text" class="form-control" id="postal"
                                                           wire:model="placingAgency.postal" >
                                                </div>
                                                </div>


                                                <div class="row mt-2">

                                                    <div class="col-12">
                                                    <label for="green_shield_number">Notes</label>
                                                    <textarea rows=5 class="form-control" id="notes"
                                                           wire:model="placingAgency.notes"></textarea>

                                                </div>
                                                </div>


                                            <div class="row mb-2">
                                              <script>
                                                $agencyID = {{$placingAgency->id}};
                                            </script>
                                                 <h5 class="mt-3 text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Workers
                                                    <span class="float-right"><b><a class="text-white text-small" href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.add-placing-agency-workers-modal', {'agencyID':$agencyID}, {'size':'md'})" class="mt-2">[+]</a></b></span>

                                                </h5>
                                                @foreach ($this->placingAgencyWorkers as $type=>$workers)
                                                    @foreach ($workers as $worker)
                                                            @if ($type == "Finance Worker")
                                                                <div  class="col-3">
                                                                    <label for="" class="text-sm">Type</label>
                                                                    <select class="form-control" wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.type">
                                                                        @foreach (\App\Models\PlacingAgencyWorkers::WORKER_TYPES as $key => $value)
                                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-3">
                                                                        <label for="" class="text-sm">Name</label>
                                                                        <input  type="text" class="form-control"
                                                                               wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.name" >
                                                                    </div>
                                                                <div class="col-3">
                                                                    <label for="" class="text-sm">Invoicing Email Address</label>
                                                                    <input  type="text" class="form-control"
                                                                           wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.email" >
                                                                </div>
                                                                <div class="col-3">
                                                                    <label for="" class="text-sm">Telephone</label>
                                                                    <input  type="text" class="form-control"
                                                                           wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.telephone" >
                                                                </div>
                                                                @endif

                                                            @if ($type == "Children Service Worker")
                                                                 <div class="col-3 mt-2">
                                                                    <label for="" class="text-sm">Type</label>
                                                                    <select class="form-control" wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.type">
                                                                        @foreach (\App\Models\PlacingAgencyWorkers::WORKER_TYPES as $key => $value)
                                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                 <div class="col-3 mt-2">
                                                                            <label for="" class="text-sm">Name</label>
                                                                            <input type="text" class="form-control"
                                                                                   wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.name" >
                                                                        </div>
                                                                 <div class="col-3 mt-2">
                                                                        <label for="" class="text-sm">Email Address</label>
                                                                        <input  type="text" class="form-control"
                                                                               wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.email" >
                                                                    </div>
                                                                 <div class="col-3 mt-2">
                                                                        <label for="" class="text-sm">Telephone</label>
                                                                        <input  type="text" class="form-control"
                                                                               wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.telephone" >
                                                                    </div>

                                                            @endif

                                                            @if ($type == "Family Service Worker")
                                                                     <div class="col-3 mt-2">
                                                                        <label for="" class="text-sm">Type</label>
                                                                        <select class="form-control" wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.type">
                                                                            @foreach (\App\Models\PlacingAgencyWorkers::WORKER_TYPES as $key => $value)
                                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-3 mt-2">
                                                                            <label for="" class="text-sm">Name</label>
                                                                           <input  type="text" class="form-control"
                                                                               wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.name" >
                                                                    </div>
                                                                    <div class="col-3 mt-2">
                                                                        <label for="" class="text-sm">Email Address</label>
                                                                         <input  type="text" class="form-control"
                                                                               wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.email" >
                                                                    </div>
                                                                    <div class="col-3 mt-2">
                                                                        <label for="" class="text-sm">Telephone</label>
                                                                         <input  type="text" class="form-control"
                                                                               wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.telephone" >
                                                                    </div>
                                                            @endif

                                                            @if ($type == "Placement Worker")
                                                                     <div class="col-3 mt-2">
                                                                        <label for="" class="text-sm">Type</label>
                                                                        <select class="form-control" wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.type">
                                                                            @foreach (\App\Models\PlacingAgencyWorkers::WORKER_TYPES as $key => $value)
                                                                                <option value="{{ $key }}">{{ $value }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-3 mt-2">
                                                                            <label for="" class="text-sm">Name</label>
                                                                           <input  type="text" class="form-control"
                                                                               wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.name" >
                                                                    </div>
                                                                    <div class="col-3 mt-2">
                                                                        <label for="" class="text-sm">Email Address</label>
                                                                         <input  type="text" class="form-control"
                                                                               wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.email" >
                                                                    </div>
                                                                    <div class="col-3 mt-2">
                                                                        <label for="" class="text-sm">Telephone</label>
                                                                         <input  type="text" class="form-control"
                                                                               wire:model="placingAgencyWorkers.{{$type}}.{{$loop->index}}.telephone" >
                                                                    </div>
                                                            @endif

                                                    @endforeach

                                                @endforeach













                                            </form>
                                                </div>

                                         </div>
        blade;
    }
}
