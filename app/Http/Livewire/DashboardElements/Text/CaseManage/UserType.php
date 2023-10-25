<?php

namespace App\Http\Livewire\DashboardElements\Text\CaseManage;
use App\Models\User;
use Livewire\Component;

class UserType extends Component
{
 public User $user;

 public function mount() {
 }
    public function render()
    {
        return <<<'blade'
            <div wire:poll.visible>
                 @if ($this->user)
                    {{$user->get_user_type->name}}
                @else
                    None
                @endif
            </div>
        blade;
    }
}
