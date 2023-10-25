<?php

namespace App\Http\Livewire\Placements;

use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;
use App\Models\Placements as modelPlacements;

class Placements extends Component
{

    public $child;
    public $placements;

    public $FosterFamilyUserIDNewEntryPermanent;
    public $FosterFamilyUserIDNewEntryRelief;

    protected $listeners = ['delete' => 'delete'];

    public function delete($id) {
        if ($id) {
            modelPlacements::find($id)->delete();
        }
    }
    public function mount() {

        $this->FosterFamilyUserIDNewEntryPermanent = "";
        $this->FosterFamilyUserIDNewEntryRelief = "";

    }

    public function render()
    {
        if ($this->child) {
            $this->placements = modelPlacements::query()
                ->with('getFosterHomeUser')
                ->where('fk_ChildID', $this->child->id)
                ->orderByDesc('from_date')
                ->get();
        }
        return <<<'blade'
            <div wire:poll.active>
                 <!-- Full Time Placements -->
                                    <div class="row mb-2">
                                        <h5 class="text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Permanent</h5>

                                        {{-- Setup data for datatables --}}
                                        @php
                                            $heads = [
                                                'Date From',
                                                'Date To',
                                                'Foster Family',
                                                'Actions'

                                            ];

                                            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                                        </button>';
                                            $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                                              <i class="fa fa-lg fa-fw fa-trash"></i>
                                                          </button>';
                                            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                                               <i class="fa fa-lg fa-fw fa-eye"></i>
                                                           </button>';

                                            $config = [
                                                'data' => [
                                                    ["01/01/2021", '05/09/2021', 'Paula Dukhan', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
                                                    ["05/09/2021", '', 'John Smith', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],

                                                ],
                                                'order' => [[1, 'asc']],
                                                'columns' => [null, null, ['orderable' => false]],
                                                'search' => [true]

                                            ];
                                        @endphp

                                        {{-- Minimal example / fill data using the component slot --}}
                                        <x-adminlte-datatable id="tblPermanent" :heads="$heads" head-theme="dark" striped hoverable>
                                            @foreach($placements as $row)
                                                @if ($row->type == "permanent")
                                                <tr>
                                                    <td>{{ $row->from_date }}</td>
                                                    <td>{{ $row->to_date }}</td>
                                                    <td>{{ $row->getFosterHomeUser()->first()->name }}</td>
                                                    <td x-data="{}">
                                                        <button x-on:click="window.livewire.emit('modal.open', 'placements.placement-form-modal', { 'placementId':{{$row->id}} }, {'size':'md'})" class="btn btn-xs btn-default text-warning mx-1 shadow" title="Edit">
                                                            <i class="fa fa-lg fa-fw fa-pencil"></i>
                                                        </button>
                                                        <button x-on:click=" confirm('Are you sure you want to delete this Placement Entry?') ? window.livewire.emitTo('placements.placements', 'delete', '{{$row->id}}') : false" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                                            <i class="fa fa-lg fa-fw fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </x-adminlte-datatable>
                                    </div>
                                    <!-- End of Full Time Placements -->

                                    <!-- Relief -->
                                    <div class="row mb-2">
                                        <h5 class="text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Relief</h5>

                                        {{-- Setup data for datatables --}}
                                        @php
                                            $heads = [
                                                'Date From',
                                                'Date To',
                                                'Foster Family',
                                                'Actions'

                                            ];

                                            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                                                            <i class="fa fa-lg fa-fw fa-pen"></i>
                                                        </button>';
                                            $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                                              <i class="fa fa-lg fa-fw fa-trash"></i>
                                                          </button>';
                                            $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                                                               <i class="fa fa-lg fa-fw fa-eye"></i>
                                                           </button>';

                                            $config = [
                                                'data' => [
                                                    ["01/01/2021", '05/09/2021', 'Paula Dukhan', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
                                                    ["05/09/2021", '', 'John Smith', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],

                                                ],
                                                'order' => [[1, 'asc']],
                                                'columns' => [null, null, ['orderable' => false]],
                                                'search' => [true]

                                            ];
                                        @endphp

                                        {{-- Minimal example / fill data using the component slot --}}
                                        <x-adminlte-datatable id="tblRelief" :heads="$heads" head-theme="dark" striped hoverable>
                                            @foreach($placements as $row)
                                                @if ($row->type == "relief")
                                                <tr>
                                                    <td>{{ $row->from_date }}</td>
                                                    <td>{{ $row->to_date }}</td>
                                                    <td>{{ $row->getFosterHomeUser()->first()->name }}</td>
                                                   <td x-data="{}">
                                                        <button x-on:click="window.livewire.emit('modal.open', 'placements.placement-form-modal', { 'placementId':{{$row->id}} }, {'size':'md'})" class="btn btn-xs btn-default text-warning mx-1 shadow" title="Edit">
                                                            <i class="fa fa-lg fa-fw fa-pencil"></i>
                                                        </button>
                                                        <button x-on:click=" confirm('Are you sure you want to delete this Placement Entry?') ? window.livewire.emitTo('placements.placements', 'delete', '{{$row->id}}') : false" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                                                              <i class="fa fa-lg fa-fw fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </x-adminlte-datatable>
                                    </div>
                                    <!-- End of Relief -->
            </div>
        blade;
    }
}
