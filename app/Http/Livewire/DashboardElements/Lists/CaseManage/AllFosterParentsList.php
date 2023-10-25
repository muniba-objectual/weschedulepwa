<?php

namespace App\Http\Livewire\DashboardElements\Lists\CaseManage;

use App\Models\User;
use Livewire\Component;

class AllFosterParentsList extends Component
{
    public $tmpUsers;
    public $search = '';
    public $isActive = true;

    public function mount(){
    }


    public function render()
    {
        if($this->search != ''){

            $this->tmpUsers = User::orderBy('name', 'ASC')
                ->where('name','like', "%{$this->search}%")
                ->where('user_type','>=', 2.1)
                ->where('user_type','<', 3)
                //->orWhere('user_type','=', 2.1)
                //->orWhere('user_type','=', 2.2)
                //->orWhere('user_type','=', 2.3)
                ->get();
        }else{
            $this->tmpUsers = User::orderBy('name', 'ASC')
                ->where('user_type','>=', 2.1)
                ->where('user_type','<', 3)
                ->get();
        }
        $users = $this->tmpUsers;
        return view('livewire.DashboardElements.Lists.CaseManage.all-foster-parent-applicants-list', compact('users'));
    }
}
