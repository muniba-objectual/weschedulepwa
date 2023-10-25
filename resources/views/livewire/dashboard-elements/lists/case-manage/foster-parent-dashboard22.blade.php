<div wire:poll.visible>
    SEARCH ALL MENTOR HOMES
    <!-- CSS Code: Place this code in the document's head (between the 'head' tags) -->
    <style>
        table.GeneratedTable {
            width: 100%;
            background-color: #ffffff;
            border-collapse: collapse;
            border-width: 2px;
            border-color: #28a745;
            border-style: solid;
            color: #000000;
        }

        table.GeneratedTable td, table.GeneratedTable th {
            border-width: 2px;
            border-color: #28a745;
            border-style: solid;
            padding: 3px;
        }

        table.GeneratedTable thead {
            background-color: #28a745;
        }
    </style>
    <br />
    <input wire:model="search" type="text" placeholder="Search..." />
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" {{ $isActive }} @if($isActive) checked  @endif wire:model="active">
        <label class="form-check-label" for="inlineCheckbox1">Active</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2" @if($inactive) checked  @endif wire:model="inactive">
        <label class="form-check-label" for="inlineCheckbox2">Inactive</label>
    </div>
    <br />
    <br /><br />
    <!-- HTML Code: Place this code in the document's body (between the 'body' tags) where the table should appear -->
    <table class="GeneratedTable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>City</th>
            <th>Active/Inactive</th>
        </tr>
        </thead>
        <tbody>
            @if(! $users->isEmpty())
                @foreach($users as $user)
            <tr>
                <td><a href="{{ url('/users/'.$user->id) }}">{{ $user->name }}</a></td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->city }}</td>

                <td>@if ($user->inactive == 0) Active @else Inactive @endif</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="5" class="text-center">
                <strong>Data Not Found!</strong>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
