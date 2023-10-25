<?php

namespace App\Http\Livewire\DashboardElements\Text\CaseManage;
use App\Models\User;
use Livewire\Component;

class CaseManager extends Component
{
 public User $user;

 public function mount() {
 }
    public function render()
    {
        return <<<'blade'
            <div wire:poll.visible>
                 @if ($this->user->getCaseManager)
                    <a href="/users/{{$this->user->getCaseManager()->first()->id}}">{{$this->user->getCaseManager()->first()->name}}</a>
                @else
                    None
                @endif
            </div>
        blade;
    }
}
