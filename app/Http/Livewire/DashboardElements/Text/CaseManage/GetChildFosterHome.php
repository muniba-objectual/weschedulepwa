<?php

namespace App\Http\Livewire\DashboardElements\Text\CaseManage;
use App\Models\Child;
use Livewire\Component;
use Auth\Auth;

class GetChildFosterHome extends Component
{
public Child $child;
 public function mount() {
 //$this->child = Child::where('id','=',$this->childID)->first();

 }
    public function render()
    {
        return <<<'blade'
            <div wire:poll.visible class="text-center">
                 @if ($this->child->getCaseManageFosterHome)
                    @if ((Auth::user()->user_type >= "5.0" && Auth::user()->user_type <= "6.0") || Auth::user()->user_type == "10.0")
                        <a href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.manage-child-foster-home-modal', {'childID':$childID}, {'size':'md'})" class="mt-2">Foster Home</a> - <a href="/users/{{$child->getCaseManageFosterHome->id}}">{{$this->child->getCaseManageFosterHome->name}}</a>
                    @else
                        Foster Home - <a href="/users/{{$child->getCaseManageFosterHome->id}}">{{$this->child->getCaseManageFosterHome->name}}</a>
                    @endif
                 @else
                @if ((Auth::user()->user_type >= "5.0" && Auth::user()->user_type <= "6.0") || Auth::user()->user_type == "10.0"))                        <a href="javascript:window.livewire.emit('modal.open', 'modals.case-manage.manage-child-foster-home-modal', {'childID':$childID}, {'size':'md'})" class="mt-2">No Foster Home Assigned</a>
                    @else
                        No Foster Home Assigned
                        @endif
                 @endif

            </div>
        blade;
    }
}
