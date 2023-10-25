<?php

namespace App\Http\Livewire\DashboardElements\Lists\CaseManage\PlacingAgencies;

use App\Models\User;
use Livewire\Component;

class AllPlacingAgenciesList extends Component
{
    public $placingAgencies;
    public $search = '';
    public $isActive = true;

    public function mount(){
    }
    public function render()
    {
        if($this->search != ''){

            $this->placingAgencies = \App\Models\PlacingAgency::orderBy('name', 'ASC')
                ->where('name','like', "%{$this->search}%")

                ->get();
        }else{
            $this->placingAgencies = \App\Models\PlacingAgency::orderBy('name', 'ASC')

                ->get();
        }
        $placingAgencies = $this->placingAgencies;
        return view('livewire.DashboardElements.Lists.CaseManage.PlacingAgencies.all-placing-agencies-list', compact('placingAgencies'));
    }
}
