<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ISA_Notes;
class ISANotes extends Component
{
    public $user;
    public $child;
    public  $ISA_Notes;

    protected $listeners = [
        'addNote' => 'addNote'
    ];



    public function addNote($note) {

        if ($note) {
            $tmpNoteEntry = new ISA_Notes();

            $tmpNoteEntry->fk_UserID = $this->user->id;
            $tmpNoteEntry->fk_ChildID = $this->child->id;
            $tmpNoteEntry->entry_notes = $note;

            $tmpNoteEntry->save();
        }


    }

    public function mount(ISA_Notes $ISA_Notes) {
    }
    public function render()
    {
        return <<<'blade'
            <div wire:poll.visible class="form-group">

              <script>
                function addISA_Note_Entry() {

                    let $today = new Date().toLocaleString();

                    $tmpNote = prompt("ISA Note Entry for {{$child->initials}} by {{$user->name}} @" + $today);
                    if ($tmpNote) {
                        Livewire.emit('addNote', $tmpNote);
                    }
                }
            </script>

            <label for="ISA_Notes">Financial Notes</label>
            <textarea readonly rows="8" cols="80" class="form-control" id="ISA_Notes2">@php $ISA_Notes = \App\Models\ISA_Notes::where('fk_ChildID','=',$child->id)->get();@endphp
        @foreach ($ISA_Notes as $entries)
        @php $tmpUser = \App\Models\User::where('id','=',$entries->fk_UserID)->get()->first()->name; $tmpDate = \Carbon\Carbon::parse($entries->updated_at)->format('M d, Y @h:i A'); @endphp {{$tmpUser}} posted on {{$tmpDate}}:&#13;&#10; {{$entries->entry_notes}}&#13;&#10;
        @endforeach</textarea>
            <input class="float-right mt-2" type="button" onclick="javascript:addISA_Note_Entry();" value="Add Note Entry" />



            </div>
        blade;
    }
}
