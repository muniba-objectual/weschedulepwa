<?php

namespace App\Http\Livewire\DashboardElements\Lists\CaseManage\PlacingAgencies;

use App\Models\User;
use Livewire\Component;

class PlacingAgencyList extends Component
{
    public $tmpUsers;
    public $agency;
    public $search = '';
    public $isActive = true;

    public function mount(){
    }
    public function render()
    {
        if($this->search != ''){

            $this->tmpUsers = \App\Models\PlacingAgencyCaseWorker::orderBy('name', 'ASC')
                ->where('name','like', "%{$this->search}%")
                ->where('fk_PlacingAgencyID','=',$this->agency->id)

                ->get();
        }else{
            $this->tmpUsers = \App\Models\PlacingAgencyCaseWorker::orderBy('name', 'ASC')
                ->where('fk_PlacingAgencyID','=',$this->agency->id)
                ->get();
        }
        $users = $this->tmpUsers;
        return view('livewire.DashboardElements.Lists.CaseManage.PlacingAgencies.all-placing-agencies-list', compact('users'));
    }
}
