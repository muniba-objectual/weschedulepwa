<div>
    <x-wire-elements-pro::bootstrap.slide-over on-submit="save" :content-padding="true">
        <x-slot name="title">Expense Verifiers</x-slot>

        {{-- Setup data for datatables --}}
        @php
            $heads = [
                ['label' => 'Name', 'width' => 45],
                ['label' => 'Can Manage?', 'width' => 15],
            ];
        @endphp

        {{-- Minimal example / fill data using the component slot --}}
        <x-adminlte-datatable id="table1" :heads="$heads">
            @foreach($allUsers as $systemUser)
                <tr>
                    <td>{{$systemUser->name}} (<em>{{$systemUser->name}}</em>)</td>
                    <td>
                    @if(isset($verifiers[$systemUser->id]))

                            <span type="button" style="cursor: pointer;" wire:click="disablePermission('{{$systemUser->id}}')">
                                <i class="fa-solid fa-eye mr-0.5 text-green" style="font-size:14px"></i>
                                <i class="fa-solid fa-eye mr-2 text-green" style="font-size:14px"></i>
                            </span>
                        @else
                            <span type="button" style="cursor: pointer;" wire:click="enablePermission('{{$systemUser->id}}')">
                                <i class="fa-solid fa-eye mr-0.5 text-gray" style="font-size:14px"></i>
                                <i class="fa-solid fa-eye mr-2 text-gray" style="font-size:14px"></i>
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach

        </x-adminlte-datatable>

    </x-wire-elements-pro::bootstrap.slide-over>
</div>
