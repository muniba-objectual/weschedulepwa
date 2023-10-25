<div wire:poll.visible>
    SEARCH ALL PLACING AGENCIES
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

    <input wire:model="search" type="text" placeholder="Search..." /> <br />
    <br />

    <!-- HTML Code: Place this code in the document's body (between the 'body' tags) where the table should appear -->
    <table class="GeneratedTable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>City</th>
            <th>Telephone</th>
        </tr>
        </thead>
        <tbody>
        @if(! $placingAgencies->isEmpty())
            @foreach($placingAgencies as $agency)
                <tr>
                    <td><a href="/placingAgency/{{$agency->id}}">{{ $agency->name }}</a></td>
                    <td>
{{--                        @php--}}
{{--                        $tmpAgency = \App\Models\PlacingAgency::where('id','=',$user->fk_PlacingAgencyID)->first();--}}
{{--                        if ($tmpAgency) {--}}
{{--                            echo $tmpAgency->name;--}}
{{--                        }--}}
{{--                        @endphp--}}
                        {{$agency->address}}
                    </td>
                    <td>{{$agency->city}}</td>
                    <td>{{$agency->telephone}}</td>

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


    <script>
        function viewUserProfile($id) {
            window.location.href = "/users/" + $id;
        }
    </script>
</div>

