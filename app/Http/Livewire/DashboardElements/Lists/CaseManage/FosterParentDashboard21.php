<?php

namespace App\Http\Livewire\DashboardElements\Lists\CaseManage;

use Livewire\Component;
use App\Models\User;

class FosterParentDashboard21 extends Component
{
    public $tmpUsers;
    public $search = '';
    public $isActive = true;
    public $active = true;
    public $inactive = false;
    public $isInActive  =   false;


    public function render()
    {
        if($this->active == true && $this->inactive == true){
            $this->tmpUsers = User::orderBy('name', 'ASC')
                                    ->where('user_type','=', 2.1)
                                    ->where('name','like', "%{$this->search}%")
                                    ->get();
        }elseif($this->active == true && $this->inactive == false){
            $this->tmpUsers = User::orderBy('name', 'ASC')
                                    ->where('inactive','=', '0')
                                    ->where('user_type','=', 2.1)
                                    ->where('name','like', "%{$this->search}%")
                                    ->get();
        }elseif($this->active == false && $this->inactive == true){
            $this->tmpUsers = User::orderBy('name', 'ASC')
                                    ->where('user_type','=', 2.1)
                                    ->where('name','like', "%{$this->search}%")
                                    ->where('inactive','=', '1')
                                    ->get();
        }elseif($this->active == false && $this->inactive == false){
            $this->tmpUsers = User::orderBy('name', 'ASC')
                                    ->where('user_type','=', 2.1)
                                    ->where('name','like', "%{$this->search}%")
                                    ->get();
        }else{
            $this->tmpUsers = User::orderBy('name', 'ASC')
                                    ->where('user_type','=', 2.1)
                                    ->where('name','like', "%{$this->search}%")
                                    ->get();
        }
        $isActive   =   $this->isActive;
        $users = $this->tmpUsers;
        $data   =   [
            'users'     =>  $users,
            'isActive'  =>  $isActive
        ];
        return view('livewire.dashboard-elements.lists.case-manage.foster-parent-dashboard21',$data);
    }
}
