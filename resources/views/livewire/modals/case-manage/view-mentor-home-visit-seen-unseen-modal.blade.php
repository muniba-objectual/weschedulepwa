<div wire:ignore>

    <x-wire-elements-pro::bootstrap.slide-over on-submit="save" :content-padding="true">
        <x-slot name="title">Mentor Home Visit Viewed Status</x-slot>

        {{-- Setup data for datatables --}}
        @php
            $heads = [
                ['label' => 'Name', 'width' => 45],
                ['label' => 'Viewed?', 'width' => 15],
                ['label' => 'First Viewed', 'width' => 50],
            ];


            $config = [

                'order' => [[1, 'asc']],
                'columns' => [null, null, null],
            ];
        @endphp

        {{-- Minimal example / fill data using the component slot --}}
        <x-adminlte-datatable id="table1" :heads="$heads">
            @foreach($staff as $row)
                <tr>
                    <td>{{$row->name}}</td>
                    @if ($row->mentorHomeVisits->contains('id',$this->mentorHomeVisitID))
                        <td><i class="fa-solid fa-eye mr-0.5 text-green" style="font-size:14px"></i><i class="fa-solid fa-eye mr-2 text-green" style="font-size:14px"></i></td>
                        @foreach ($row->mentorHomeVisits as $mentorHomeVisit)
                            @if ($mentorHomeVisit->id == $this->mentorHomeVisitID)

                                <td>{{$mentorHomeVisit->seen_unseen->created_at}}</td>
                            @endif
                        @endforeach
                    @else
                        <td><i class="fa-solid fa-eye mr-0.5 text-primary" style="font-size:14px"></i><i class="fa-solid fa-eye mr-2 text-primary" style="font-size:14px"></i></td>
                        <td>N/A</td>
                    @endif
                </tr>
            @endforeach
        </x-adminlte-datatable>

    </x-wire-elements-pro::bootstrap.slide-over>

</div>
