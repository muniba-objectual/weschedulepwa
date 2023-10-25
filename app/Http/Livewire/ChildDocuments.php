<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ChildDocuments extends Component
{

    public $child;
    public $documents;
    public function mount() {

    }
    public function render()
    {
        if ($this->child) {
            $this->documents = \App\Models\ChildDocuments::where('fk_ChildID','=',$this->child->id)->get();

            foreach ($this->documents as $document) {
//                dd ($document->getMedia($document->type));
            }

        }

        return <<<'blade'


              <div wire:poll.active class="row mb-2">

                                        <h5 class="text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Non Recurring</h5>

                                <script>
                                    $childID = {{$child->id}};
                                </script>
                                        <b><a href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.add-child-documents-modal', {'childID':$childID}, {'size':'md'})" class="mt-2">Add Document</a></b>
                                        {{-- Setup data for datatables --}}
                                        @php
                                            $heads1 = [
                                                'Type',
                                                'Description',
                                                'Date',
                                                'Attachment',
                                                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
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
                                                    ["Admission Medical", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
                                                    ["Discharge Medical", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],


                                                ],
                                                'order' => [[1, 'asc']],
                                                'columns' => [null, null, null, ['orderable' => false]],
                                                'search' => [true]

                                            ];
                                        @endphp
                                        {{-- Minimal example / fill data using the component slot --}}
                                        <x-adminlte-datatable id="table1" :heads="$heads1" head-theme="dark" striped hoverable>

                                            @foreach($documents as $row)
                                                @if (!$row->recurring)
                                                <tr>
                                                    <td>{{$row->type}}</td>
                                                    <td>{{$row->description}}</td>
                                                    <td>{{$row->date}}</td>
                                                    <td><a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></td>

                                                </tr>
                                                @endif
                                            @endforeach
                                        </x-adminlte-datatable>

                                        <h5 class="text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Recurring</h5>


                                        {{-- Setup data for datatables --}}
                                        @php
                                            $heads = [
                                                'Type',
                                                'Description',
                                                'Date',
                                                'Renewal Date',
                                                'Attachment',
                                                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
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
                                                    ["Annual Medical", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
                                                    ["Dental", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
                                                    ["Optometrist", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
                                                    ["Auditory Testing", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
                                                    ["Social History", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
                                                    ["Privacy Visit", 'Sample', '01/01/2022', '01/01/2022', '[Attachment]', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],


                                                ],
                                                'order' => [[1, 'asc']],
                                                'columns' => [null, null, null, ['orderable' => false]],
                                                'search' => [true]

                                            ];
                                        @endphp

                                <style>

                                </style>
                                 <div wire:ignore>
                                    <b><a href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.add-child-documents-recurring-modal', {'childID':$childID}, {'size':'md'})" class="mt-2">Add Document</a></b>
                                   <ul id="tree2" class="mt-2">
                                    <li>Medical
                                        <ul>
                                            <li>2022
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Medical" && str_contains($row->date,"2022"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2023
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Medical" && str_contains($row->date,"2023"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2024
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Medical" && str_contains($row->date,"2024"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </li>

                                    <li>Dental
                                        <ul>
                                            <li>2022
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Dental" && str_contains($row->date,"2022"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2023
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Dental" && str_contains($row->date,"2023"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2024
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Dental" && str_contains($row->date,"2024"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </li>

                                    <li>Optometrist
                                        <ul>
                                            <li>2022
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Optometrist" && str_contains($row->date,"2022"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2023
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Optometrist" && str_contains($row->date,"2023"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2024
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Optometrist" && str_contains($row->date,"2024"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </li>

                                    <li>Auditory Testing
                                        <ul>
                                            <li>2022
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Auditory Testing" && str_contains($row->date,"2022"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2023
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Auditory Testing" && str_contains($row->date,"2023"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2024
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Medical" && str_contains($row->date,"2024"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </li>

                                    <li>Social History
                                        <ul>
                                            <li>2022
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Social History" && str_contains($row->date,"2022"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2023
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Social History" && str_contains($row->date,"2023"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2024
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Social History" && str_contains($row->date,"2024"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>

                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="mb-2">Privacy Visit
                                        <ul>
                                            <li>2022
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Privacy Visit" && str_contains($row->date,"2022"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2023
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Privacy Visit" && str_contains($row->date,"2023"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>

                                            <li>2024
                                                @foreach ($documents as $row)
                                                @if ($row->recurring && $row->type == "Privacy Visit" && str_contains($row->date,"2024"))
                                                <ul>
                                                    <li>Attachment: <a href="{{$row->getMedia($row->type)->first()->getUrl()}}">{{$row->getMedia($row->type)->first()->name}}</a></li>
                                                </ul>
                                                @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                    </li>

                                </ul>
                                        </div>

                                    </div>

                                    {{--                                    <div class="row mb-2">--}}
                                    {{--                                        <h5 class="text-white text-center col-12 bg-gradient-blue pt-1 pb-1">Plan of Cares</h5>--}}
                                    {{--                                        •	Plan of Cares (30, 60, 90, 180, Discharge) *Auto renew next date in the system--}}
                                    {{--                                    </div>--}}

                                    {{--                                    <div class="row mb-2">--}}
                                    {{--                                        <h5 class="text-white text-center col-12 bg-gradient-blue pt-1 pb-1">ISP's</h5>--}}
                                    {{--                                        *Auto renew in the system every 180 days once received--}}
                                    {{--                                    </div>--}}
        blade;
    }
}
