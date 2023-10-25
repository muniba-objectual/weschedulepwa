<x-wire-elements-pro::tailwind.modal on-submit="save" :content-padding="true">
    <x-slot name="title">Salary History (Child: {{$childInitials}})</x-slot>

    <div>
        @if($salaries->count())
            <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>From-To</th>
                    <th>Assigned By</th>
                    <th>Unassigned By</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salaries as $salaryRecord)
                    <tr>
                        <td>
                            {{ $salaryRecord->created_at?$salaryRecord->created_at->toDayDateTimeString():'Origin' }} -
                            {{ $salaryRecord->expired_at?$salaryRecord->expired_at->toDayDateTimeString():"NOW" }}
                        </td>
                        <td>{{ $salaryRecord->assignedBy->name }} (<em>{{$salaryRecord->assignedBy->email}}</em>)</td>
                        <td>
                            @if($salaryRecord->unAssignedBy)
                                {{ $salaryRecord->unAssignedBy->name }} (<em>{{$salaryRecord->unAssignedBy->email}}</em>
                            @else
                                -
                            @endif
                        </td>
                        <td style="text-align: right;">{{ number_format( $salaryRecord->salary, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <h5 style="text-align: center;">You don't have any history yet!</h5>
        @endif
    </div>

    <x-slot name="buttons">
        <button type="button" class="btn btn-sm btn-danger pull-right" wire:click="$emit('modal.close')">
            Close
        </button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
