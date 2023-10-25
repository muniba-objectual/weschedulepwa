<div wire:poll.visible>
    SEARCH ALL FOSTER PARENTS
    <!-- CSS Code: Place this code in the document's head (between the 'head' tags) -->
    <style>
        table.GeneratedTable {
            width: 100%;
            background-color: #ffffff;
            border-collapse: collapse;
            border-width: 2px;
            border-color: #ffcc00;
            border-style: solid;
            color: #000000;
        }

        table.GeneratedTable td, table.GeneratedTable th {
            border-width: 2px;
            border-color: #ffcc00;
            border-style: solid;
            padding: 3px;
        }

        table.GeneratedTable thead {
            background-color: #ffcc00;
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
            <th>Case Manager</th>
            <th>User Type</th>
        </tr>
        </thead>
        <tbody>
        @if(! $users->isEmpty())
            @foreach($users as $user)
                <tr>
                    <td><a href="{{ url('/users/'.$user->id) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->address }}</td>
                    <td>
                        @php
                            if ($user->getCaseManager) {

                                          echo "<a href='/users/{$user->getCaseManager()->first()->id}'>" . $user->getCaseManager()->first()->name . "</a>";
                                       }

                        @endphp
                    </td>
                    <td>{{$user->user_type}}</td>
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
<script>
    function viewUserProfile($id) {
        window.location.href = "/users/" + $id;
    }
</script>
