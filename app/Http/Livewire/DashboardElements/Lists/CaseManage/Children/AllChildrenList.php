<?php

namespace App\Http\Livewire\DashboardElements\Lists\CaseManage\Children;

use App\Models\Child;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Models\User;

class AllChildrenList extends Component
{
    public $tmpChildren;
    public $search = '';
    public $isActive = true;
    public $users;
    public $FilterByCaseManager = "";
    public $unique_CaseManagers;

    public function mount()
    {
        $this->users = User::all();
        $this->tmpChildren = Child::where('WeSchedule', '==', '0')->get();
        $this->unique_CaseManagers = new Collection();
        foreach ($this->tmpChildren as $child) {
            if ($child->getCaseManageAssignedHome && $child->getCaseManageAssignedHomeCaseManager){
                $this->unique_CaseManagers->push($child->getCaseManageAssignedHome->getCaseManageAssignedHomeCaseManager);
            }
        }

        $this->unique_CaseManagers = $this->unique_CaseManagers->sortBy('name')->unique();

    }


    public function render()
    {

        if ($this->search != '') {

            $this->tmpChildren = Child::where('WeSchedule', '=', '0')->orderBy('initials', 'ASC')
                ->where('initials', 'like', "%{$this->search}%")
                ->get();
        } else {
            $this->tmpChildren = Child::where('WeSchedule', '=', '0')->orderBy('initials', 'ASC')
                ->get();
        }

        if ($this->FilterByCaseManager != '') {
            $tmpUser = User::where('id','=',$this->FilterByCaseManager)->first();
            //$tmpUser = User class for Case Manager
            //need to get all foster parents that are under this case manager
            $tmpFosterParents = User::where('fk_CaseManagerID','=',$tmpUser->id)->get();
            //tmpFosterParent = all of the foster parent homes managed by this case manager
            $tmpArrayChildren = new Collection();
            foreach ($tmpFosterParents as $FosterParent) {
               // dd($FosterParent);
                if (count($FosterParent->getCaseManageChildren) > 0) {
                    foreach ($FosterParent->getCaseManageChildren as $tmpChild) {
                        $tmpArrayChildren->push($tmpChild);
                    }

                }

            }
           // dd($tmpArrayChildren);
            $this->tmpChildren = $tmpArrayChildren;

        }


        $children = $this->tmpChildren->sortBy('initials');
        $users = $this->users;
        $unique_CaseManagers = $this->unique_CaseManagers;
        return view('livewire.DashboardElements.Lists.CaseManage.Children.all-children-list', compact('children', 'users', 'unique_CaseManagers'));

    }
}
