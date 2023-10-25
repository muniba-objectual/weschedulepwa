<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CarpeDiem_Notes;
class CarpeDiemNotes extends Component
{
    public $user;
    public $child;
    public  $CarpeDiem_Notes;

    protected $listeners = [
        'addNote' => 'addNote'
    ];



    public function addNote($note) {

        if ($note) {
            $tmpNoteEntry = new CarpeDiem_Notes();

            $tmpNoteEntry->fk_UserID = $this->user->id;
            $tmpNoteEntry->fk_ChildID = $this->child->id;
            $tmpNoteEntry->entry_notes = $note;

            $tmpNoteEntry->save();
        }


    }

    public function mount(CarpeDiem_Notes $CarpeDiem_Notes) {
    }
    public function render()
    {
        return <<<'blade'
            <div wire:poll.visible class="form-group">

              <script>
                function addCarpeDiem_Note_Entry() {

                    let $today = new Date().toLocaleString();

                    $tmpNote = prompt("Carpe Diem Note Entry for {{$child->initials}} by {{$user->name}} @" + $today);
                    if ($tmpNote) {
                        Livewire.emit('addNote', $tmpNote);
                    }
                }
            </script>

            <label for="CarpeDiem_Notes">Financial Notes</label>
            <textarea readonly rows="8" cols="80" class="form-control" id="CarpeDiem_Notes2">@php $CarpeDiem_Notes = \App\Models\CarpeDiem_Notes::where('fk_ChildID','=',$child->id)->get();@endphp
        @foreach ($CarpeDiem_Notes as $entries)
        @php $tmpUser = \App\Models\User::where('id','=',$entries->fk_UserID)->get()->first()->name; $tmpDate = \Carbon\Carbon::parse($entries->updated_at)->format('M d, Y @h:i A'); @endphp {{$tmpUser}} posted on {{$tmpDate}}:&#13;&#10; {{$entries->entry_notes}}&#13;&#10;
        @endforeach</textarea>
            <input class="mt-2" type="button" onclick="javascript:addCarpeDiem_Note_Entry();" value="Add Note Entry" />



            </div>
        blade;
    }
}
