<?php

namespace App\Http\Livewire;

use App\Models\UserChildrenHistory;
use Livewire\Component;
use App\Models\Child;
use Auth;

class UserChildSalaries extends Component
{
    public $user;
    public $child;
    public $children;

    protected $listeners = [

        'updateSalary' => 'updateSalary'
    ];
    public function render()
    {
        $children = Child::all()->where('WeSchedule','=','1')->where('inactive','=','0')->sortBy('initials');
        return <<<'blade'
            <div wire:poll.visible>
               <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Child</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($children as $child)
                             @php
                                $contains = false;
                             @endphp
                             @if (count($child->getAssignedUser) > 0)

                                {{-- child has a user association --}}

                                @if ($child->getAssignedUser->contains($user))
                                    @php
                                        $salaryInstance = $child->getAssignedUser->find($user->id)->pivot;
                                        $updatedByUser = \App\Models\User::find($salaryInstance->updated_by);
                                    @endphp
                                    <tr>
                                        <td>{{$child->initials}}</td>
                                        <td><input type="text" title="updated by: {{$updatedByUser->name}} ({{$updatedByUser->email}})" id="salary_{{$child->id}}" name="salary_{{$child->id}}" value="{{$salaryInstance->salary}}" /></td>
                                        <td><span class="badge badge-success">Assigned</span></td>
                                        <td>
                                            <button wire:click="updateSalary('{{$child->id}}', $('#salary_{{$child->id}}').val())" class="btn-primary btn-sm">Modify Salary</button>
                                            <button wire:click="deactivateSalary('{{$child->id}}')" class="btn-primary btn-sm">Deactivate</button>
                                            <button wire:click="$emit('modal.open', 'modals.case-manage.user-child-salary-modal', { 'userId': {{$user->id}}, 'childId': {{$child->id}} })" class="btn-primary btn-sm">Salary History</button>
                                        </td>
                                    </tr>
                                    @php
                                        $contains = true;
                                    @endphp
                                @endif
                             @endif

                             @if (!$contains)
                                 <tr>
                                    <td>{{$child->initials}}</td>
                                    <td><input type="text" id="salary_{{$child->id}}" name="salary_{{$child->id}}" value="N/A" /></td>
                                    <td><span class="badge badge-danger">Not Assigned</span></td>
                                    <td>
                                        <button wire:click="createSalary('{{$child->id}}', $('#salary_{{$child->id}}').val())" class="btn-primary btn-sm">Activate & Assign Salary</button>
                                        <button wire:click="$emit('modal.open', 'modals.case-manage.user-child-salary-modal', { 'userId': {{$user->id}}, 'childId': {{$child->id}} })" class="btn-primary btn-sm">Salary History</button>
                                    </td>
                                 </tr>
                             @endif

                        @endforeach

                    </tbody>
               </table>
            </div>
        blade;
    }

    function updateSalary($childID, $salary) {

        $this->child = Child::findorfail($childID);

        //get active instance
        $activeSalaryInstance = $this->child->getAssignedUser->find($this->user->id)->pivot;

        //if no changes between current-salary and active-salary, then skip.
        if( !is_numeric($salary) || (float)$activeSalaryInstance->salary == (float)$salary ){
            return;
        }

        //update active salary-instance
        $this->child->getAssignedUser()->updateExistingPivot($this->user->id, [
            'salary'     => $salary,
            'updated_by' => auth()->id()
        ]);

        UserChildrenHistory::pushASalaryVersion($this->child, $this->user, $salary);

    }

    function createSalary($childID, $salary) {
        //skip non numeric data entries
        if(!is_numeric($salary))return;

        $this->child = Child::findorfail($childID);

        //create active salary-instance
        $this->child->getAssignedUser()->attach($this->user->id, [
            'salary'     => $salary,
            'updated_by' => auth()->id()
        ]);

        UserChildrenHistory::pushASalaryVersion($this->child, $this->user, $salary);

    }

    function deactivateSalary($childID) {

        $this->child = Child::findorfail($childID);

        //drop active salary-instance
        $this->child->getAssignedUser()->detach($this->user->id);

        UserChildrenHistory::deactivateLastSalary($this->child, $this->user);

    }

    public function mount($user) {
        //$userID = Auth::id();
        $this->user = $user;
        $this->children = Child::all()
            ->where('WeSchedule','=','1')
            ->where('inactive','=','0')
            ->sortBy('initials');

    }
}
