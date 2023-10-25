<?php
/** @var \App\Models\User[] $systemUsers */
?>

<style type="text/css">
    #system-user-table.table td, #system-user-table.table th {
        vertical-align: middle;
        padding-left: 3em;
    }

    #system-user-table .profile-picture{
        width: 2.5em;
    }
</style>

<div class="ml-2">
    <h5 class="mb-2">Verify Permission Escalation</h5>

    <br/>

    <table id="system-user-table" class="table table-responsive">
        <tr>
            <th>Name</th>
            <th>E-Mail</th>
            <th>Role</th>
            <th>#</th>
        </tr>
        @foreach($systemUsers as $systemUser)
            <tr>
                <td>
                    <img
                        src="{{$systemUser->profile_pic ? "/storage/" . substr($user->profile_pic,7) : sprintf('https://ui-avatars.com/api/?name=%s', urlencode($systemUser->name))}}"
                        alt="Profile Picture"
                        class="rounded-circle profile-picture"
                    >
                    &nbsp;
                    {{$systemUser->name}}
                </td>
                <td>{{$systemUser->email}}</td>
                <td>{{$systemUser->user_type}}</td>
                <td>
                    <span style="cursor: pointer; float:right;"
                          title="Manage Verifiers"
                          onclick="Livewire.emit('slide-over.open', 'modals.case-manage.expense-report-verifier-allocation-modal', {'userId': {{$systemUser->id}} },{'size':'lg'})"
                    >
                        <i class="fa-solid fa-eye mr-0.5 text-danger" style="font-size:14px"></i>
                        <i class="fa-solid fa-eye mr-2 text-danger" style="font-size:14px"></i>
                    </span>
                </td>
            </tr>
        @endforeach
    </table>
</div>
