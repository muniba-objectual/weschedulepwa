<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SRA_Notes;
class SRANotes extends Component
{
    public $user;
    public $child;
    public  $SRA_Notes;

    protected $listeners = [
        'addNote' => 'addNote'
    ];



    public function addNote($note) {

        if ($note) {
            $tmpNoteEntry = new SRA_Notes();

            $tmpNoteEntry->fk_UserID = $this->user->id;
            $tmpNoteEntry->fk_ChildID = $this->child->id;
            $tmpNoteEntry->entry_notes = $note;

            $tmpNoteEntry->save();
        }


    }

    public function mount(SRA_Notes $SRA_Notes) {
    }
    public function render()
    {
        return <<<'blade'
            <div wire:poll.visible class="form-group">

              <script>
                function addSRA_Note_Entry() {

                    let $today = new Date().toLocaleString();

                    $tmpNote = prompt("SRA Note Entry for {{$child->initials}} by {{$user->name}} @" + $today);
                    if ($tmpNote) {
                        Livewire.emit('addNote', $tmpNote);
                    }
                }
            </script>

            <label for="SRA_Notes">Financial Notes</label>
            <textarea readonly rows="8" cols="80" class="form-control" id="SRA_Notes2">@php $SRA_Notes = \App\Models\SRA_Notes::where('fk_ChildID','=',$child->id)->get();@endphp
        @foreach ($SRA_Notes as $entries)
        @php $tmpUser = \App\Models\User::where('id','=',$entries->fk_UserID)->get()->first()->name; $tmpDate = \Carbon\Carbon::parse($entries->updated_at)->format('M d, Y @h:i A'); @endphp {{$tmpUser}} posted on {{$tmpDate}}:&#13;&#10; {{$entries->entry_notes}}&#13;&#10;
        @endforeach</textarea>
            <input class="float-right mt-2" type="button" onclick="javascript:addSRA_Note_Entry();" value="Add Note Entry" />



            </div>
        blade;
    }
}
