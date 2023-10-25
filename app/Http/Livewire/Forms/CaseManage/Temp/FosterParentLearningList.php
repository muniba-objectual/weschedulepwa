<?php

namespace App\Http\Livewire\Forms\CaseManage\Temp;

use Livewire\Component;

class FosterParentLearningList extends Component
{
    public  $fosterUserId;

    public function mount($fosterUserId){
        $this->fosterUserId = $fosterUserId;
    }

    public function render()
    {
        return <<< 'blade'
            <div style="margin: 1em;">
                <?php
                    $fosterUser2 = \App\Models\User::find($this->fosterUserId);
                ?>
                @if($fosterUser2->fosterParentLearningForm && $fosterUser2->getFosterParentFormPivot->is_draft)
                    <a href="/TestFormBuilder/1/{{ $fosterUser2->fosterParentLearningForm->id }}/?back-text=Foster Parent (Primary) {{$fosterUser2->name}}&back-url={{urlencode("/users/{$fosterUser2->id}#foster_parent_learning")}}" class="btn btn-primary">New Learning Plan</a>
                    <br/>
                @endif

                <br/>
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Date Created</th>
                        <th>Date Updated</th>
                        <th>Description</th>
                        <th>Action</th>
                    <tr>
                    @if($fosterUser2->fosterParentLearningForm && !$fosterUser2->getFosterParentFormPivot->is_draft)
                        <tr>
                            <td>
                                {{$fosterUser2->fosterParentLearningForm->created_at->format('M jS Y')}}
                            </td>
                            <td>
                                {{$fosterUser2->fosterParentLearningForm->updated_at->format('M jS Y')}}
                            </td>
                            <td>
                                Saved
                            </td>
                            <td>
                                <a href="/TestFormBuilder/1/{{ $fosterUser2->fosterParentLearningForm->id }}/?back-text=Foster Parent (Primary) {{$fosterUser2->name}}&back-url={{urlencode("/users/{$fosterUser2->id}#foster_parent_learning")}}"
                                   class="btn btn-primary">
                                    Edit Draft
                                </a>
                            </td>
                        </tr>
                    @endif
                    @foreach($fosterUser2->fosterParentLearningFormHistory->sortByDesc('created_at')??[] as $historyForm)
                        <tr>
                            <td>
                                {{$historyForm->created_at->format('M jS Y')}}
                            </td>
                             <td>
                                {{$historyForm->updated_at->format('M jS Y')}}
                            </td>
                            <td>
                                Submitted
                            </td>
                            <td>
                                <a href="/TestFormBuilder/1/{{ $historyForm->id }}/?PDF=true&back-text=Foster Parent (Primary) {{$fosterUser2->name}}&back-url={{urlencode("/users/{$fosterUser2->id}#foster_parent_learning")}}" class="btn btn-primary">
                                    View PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        blade;
    }
}
