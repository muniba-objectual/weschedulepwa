<?php

namespace App\Http\Livewire\DashboardElements\Text\CaseManage;
use App\Models\User;
use Livewire\Component;

class GetStaffFromCaseManager extends Component
{
 public User $user;

 public function mount() {
 }
    public function render()
    {
        return <<<'blade'
            <div wire:poll.visible>
                 @if ($user->getStaffFromCaseManager)

                    @foreach ($user->getStaffFromCaseManager as $staff)
                        <br /><a href="/users/{{$staff->id}}">{{$staff->name}}</a><br />
                    @endforeach

                 @endif
            </div>
        blade;
    }
}
