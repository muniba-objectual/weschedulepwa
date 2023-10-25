<div  wire:poll.visible>
    <style>
        table.GeneratedTable {
            width: 100%;
            background-color: #ffffff;
            border-collapse: collapse;
            border-width: 2px;
            border-color: #f012be;
            border-style: solid;
            color: #000000;
        }

        table.GeneratedTable td, table.GeneratedTable th {
            border-width: 2px;
            border-color: #f012be;
            border-style: solid;
            padding: 3px;
        }

        table.GeneratedTable thead {
            background-color: #f012be;
        }
    </style>
<div class="row">
    <div class="col-3">SEARCH ALL CHILDREN
    <!-- CSS Code: Place this code in the document's head (between the 'head' tags) -->

    <input wire:model="search" type="text" placeholder="Search..." />
    </div>

    <div class="col-3">(OR) FILTER BY CASE MANAGER
    <select wire:model="FilterByCaseManager" >
        <option value="">Select Case Manager...</option>

        @if (count($unique_CaseManagers) >0)
            @foreach ($unique_CaseManagers->sortBy('name') as $CM)

                <option value="{{$CM['id']}}">{{$CM['name']}}</option>
            @endforeach
        @endif



    </select>
    </div>

</div>

    <div class="row">
    <!-- HTML Code: Place this code in the document's body (between the 'body' tags) where the table should appear -->
    <table class="GeneratedTable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Case Manager</th>
            <th>Foster Home</th>
        </tr>
        </thead>
        <tbody>
        @if(count($children)>0)
            @foreach($children as $child)
                <tr>
                    <td><a href="{{ url('/children/'.$child->id) }}"> @if ($child->getMedia('Child_Profile')->first())
                                <img class="rounded-circle" src="{{$child->getMedia('Child_Profile')->first()->getUrl()}}" width="50">
                                <span class="ml-2">{{ $child->initials }}</span>
                        @else
                                <img class="rounded-circle" src="https://ui-avatars.com/api/?background=random&rounded=true&name={{substr($child->initials,0,1)}}" width="50">
                                <span class="ml-2">{{ $child->initials }}</span>
                            @endif
                        </a>
                    </td>
                    <td>@if ($child->getCaseManageAssignedHome && $child->getCaseManageAssignedHome->getCaseManageAssignedHomeCaseManager)<a href='/users/{{$child->getCaseManageAssignedHome->getCaseManageAssignedHomeCaseManager->id}}'>{{$child->getCaseManageAssignedHome->getCaseManageAssignedHomeCaseManager->name}}</a>@else N/A @endif</td>
                    <td>@if ($child->getCaseManageAssignedHome)<a href='/users/{{$child->getCaseManageAssignedHome->id}}'>{{$child->getCaseManageAssignedHome->name}}</a>@else N/A @endif</td>
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
</div>
