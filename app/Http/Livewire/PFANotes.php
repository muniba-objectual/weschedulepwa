<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PFA_Notes;
class PFANotes extends Component
{
    public $user;
    public $child;
    public  $PFA_Notes;

    protected $listeners = [
        'addNote' => 'addNote'
    ];



    public function addNote($note) {

        if ($note) {
            $tmpNoteEntry = new PFA_Notes();

            $tmpNoteEntry->fk_UserID = $this->user->id;
            $tmpNoteEntry->fk_ChildID = $this->child->id;
            $tmpNoteEntry->entry_notes = $note;

            $tmpNoteEntry->save();
        }


    }

    public function mount(PFA_Notes $PFA_Notes) {
    }
    public function render()
    {
        return <<<'blade'
            <div wire:poll.visible class="form-group">

              <script>
                function addPFA_Note_Entry() {

                    let $today = new Date().toLocaleString();

                    $tmpNote = prompt("PFA Note Entry for {{$child->initials}} by {{$user->name}} @" + $today);
                    if ($tmpNote) {
                        Livewire.emit('addNote', $tmpNote);
                    }
                }
            </script>

            <label for="PFA_Notes">Financial Notes</label>
            <textarea readonly rows="8" cols="80" class="form-control" id="PFA_Notes2">@php $PFA_Notes = \App\Models\PFA_Notes::where('fk_ChildID','=',$child->id)->get();@endphp
        @foreach ($PFA_Notes as $entries)
        @php $tmpUser = \App\Models\User::where('id','=',$entries->fk_UserID)->get()->first()->name; $tmpDate = \Carbon\Carbon::parse($entries->updated_at)->format('M d, Y @h:i A'); @endphp {{$tmpUser}} posted on {{$tmpDate}}:&#13;&#10; {{$entries->entry_notes}}&#13;&#10;
        @endforeach</textarea>
            <input class="float-right mt-2" type="button" onclick="javascript:addPFA_Note_Entry();" value="Add Note Entry" />



            </div>
        blade;
    }
}
