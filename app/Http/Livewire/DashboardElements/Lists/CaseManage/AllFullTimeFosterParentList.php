<?php

namespace App\Http\Livewire\DashboardElements\Lists\CaseManage;

use App\Models\User;
use Livewire\Component;

class AllFullTimeFosterParentList extends Component
{
    public $tmpUsers;
    public $search = '';
    public $isActive = true;
    public $active = true;
    public $inactive = false;
    public $isInActive  =   false;



    public function render()
    {
        // $this->tmpUsers = User::orderBy('name', 'ASC')->get();
        // if($this->active){
        //     $this->tmpUsers = User::orderBy('name', 'ASC')
        //                             ->where('inactive','=', '1')
        //                             ->where('name','like', "%{$this->search}%")
        //                             ->get();
        // }else{
        //     $this->tmpUsers = User::orderBy('name', 'ASC')
        //                             ->where('inactive','=', '0')
        //                             ->where('name','like', "%{$this->search}%")
        //                             ->get();
        // }
        // if($this->inactive){
        //     $this->tmpUsers = User::orderBy('name', 'ASC')
        //                             ->where('inactive','=', '0')
        //                             ->where('name','like', "%{$this->search}%")
        //                             ->get();
        // }else{
        //     $this->tmpUsers = User::orderBy('name', 'ASC')
        //                             ->where('inactive','=', '1')
        //                             ->where('name','like', "%{$this->search}%")
        //                             ->get();
        // }
        if($this->active == true && $this->inactive == true){
            $this->tmpUsers = User::orderBy('name', 'ASC')
                ->where('user_type','=', 2.0)
                ->where('name','like', "%{$this->search}%")
                ->get();
        }elseif($this->active == true && $this->inactive == false){
            $this->tmpUsers = User::orderBy('name', 'ASC')
                ->where('inactive','=', '0')
                ->where('user_type','=', 2.0)
                ->where('name','like', "%{$this->search}%")
                ->get();
        }elseif($this->active == false && $this->inactive == true){
            $this->tmpUsers = User::orderBy('name', 'ASC')
                ->where('user_type','=', 2.0)
                ->where('inactive','=', '1')
                ->where('name','like', "%{$this->search}%")
                ->get();
        }elseif($this->active == false && $this->inactive == false){
            $this->tmpUsers = User::orderBy('name', 'ASC')
                ->where('user_type','=', 2.0)
                ->where('name','like', "%{$this->search}%")
                ->get();
        }else{
            $this->tmpUsers = User::orderBy('name', 'ASC')
                ->where('user_type','=', 2.0)
                ->where('name','like', "%{$this->search}%")
                ->get();
        }
        $isActive   =   $this->isActive;
        $users = $this->tmpUsers;
        return view('livewire.DashboardElements.Lists.CaseManage.all-full-time-foster-parent-list', compact('users','isActive'));
    }
}
