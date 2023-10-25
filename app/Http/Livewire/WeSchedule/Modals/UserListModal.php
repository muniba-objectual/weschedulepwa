<?php

namespace App\Http\Livewire\WeSchedule\Modals;

use WireElements\Pro\Components\Modal\Modal;

class UserListModal extends Modal
{
    public $userType;

    public function GetUser(int $userId)
    {
        return redirect()->route('we-schedule.users', $userId);
    }

    public function mount($userType)
    {
        $this->userType = $userType;
    }
    
    public function render()
    {
        return view('livewire.we-schedule.modals.user-list-modal');
    }
}
