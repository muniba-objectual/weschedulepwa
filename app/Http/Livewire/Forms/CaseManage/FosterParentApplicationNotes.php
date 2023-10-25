<?php

namespace App\Http\Livewire\Forms\CaseManage;

use App\Models\FosterParentApplication_Notes;
use App\Models\FosterParentApplicationForm;
use Illuminate\Http\Client\Request;
use Livewire\Component;

class FosterParentApplicationNotes extends Component
{
    public $user;
    public $UserID;
    public $FPAFormID;
    public  $FPAForm;
    public  $FPA_Notes;
    public $field;
    public $rows;

    public $note;
    public $groupedNotes;
    public $tmpRequest;


    protected $listeners = [
        'addNote' => 'addNote',
        'refreshComponent' => '$refresh',
        'updateRows' => 'updateRows'
    ];


    public function updateRows($field, $height) {

//        if ($field == "personal_information_notes") {
//            dd ('stop');
//            $this->rows = ($height - 217);
//        } elseif ($field == "family_composition_notes") {
//
//            $this->rows = ($height - 100);
//        }

        if ($field == $this->field)
                //personal_information_notes
        $this->rows = ($height - 220);
//    //dd($height);
    }

    public function addNote() {

        if ($this->note) {
            $tmpNoteEntry = new FosterParentApplication_Notes();

            $tmpNoteEntry->fk_UserID = $this->user->id;


            $tmpNoteEntry->fk_foster_parent_applicationID = $this->FPAForm->id;

//            if ($this->field == 'personal_information_notes')
//                $tmpNoteEntry->personal_information_notes = $$this->note;
//
//            if ($this->field == 'description_of_home_community')
//                $tmpNoteEntry->description_of_home_community = $this->note;

            if ($this->field) {
                $tmpNoteEntry->$this->field = $this->note;
                $tmpNoteEntry->save();

            }

            $this->emit('refreshComponent');


        }




    }

    public function boot() {
        // dd ($request->route('id'));

        //$this->tmpRequest = $request->route('id');

        //       $this->emit('refreshComponent');
    }
    public function mount($field) {
        // $this->field = $field;
    }

    public function clickme() {
        //ray ($this);


        if ($this->FPAForm) {
            $tmpNoteEntry = new FosterParentApplication_Notes();

            $tmpNoteEntry->fk_UserID = $this->user->id;


            $tmpNoteEntry->fk_foster_parent_applicationID = $this->FPAForm->id;


            ray($tmpNoteEntry);
            /* if ($this->field == 'personal_information_notes')
                 $tmpNoteEntry->personal_information_notes = $$this->note;

             if ($this->field == 'description_of_home_community')
                 $tmpNoteEntry->description_of_home_community = $this->note;*/

            if ($this->note) {
                //$tmpNoteEntry->field = $this->note;

                $field = $this->field;

                $tmpNoteEntry->section = $this->field;

                //$tmpNoteEntry->{$this->field} = $this->note;
                $tmpNoteEntry->note = $this->note;
                $tmpNoteEntry->save();
            }
            $this->note = "";
            $this->emit('refreshComponent');
            $this->dispatchBrowserEvent('ScrollMessageBoardToBottom', ['MessageBoardID' =>  $this->field]);

        }
    }
    public function render()
    {



        $this->FPA_Notes = \App\Models\FosterParentApplication_Notes::where('fk_foster_parent_applicationID','=',$this->FPAForm->id)->get();

//        $this->groupedNotes = \App\Models\FosterParentApplication_Notes::where('fk_foster_parent_applicationID','=',$this->FPAForm->id)->
//            groupBy('updated_at')->get();

        $this->groupedNotes = \App\Models\FosterParentApplication_Notes::where('fk_foster_parent_applicationID','=',$this->FPAForm->id)
            ->orderBy('updated_at', 'asc')
            ->get();
        //$this->groupedNotes = $groupedNotes->get();
        // ray($this->groupedNotes);
        //groupBy('updated_at')->get();

        return <<<'blade'
            <div wire:poll.visible class="form-group">

              <script>
                function addFPA_Note_Entry() {

                    let $today = new Date().toLocaleString();

                    $tmpNote = prompt("Note Entry by {{$user->name}} @" + $today);
                    if ($tmpNote) {
                        Livewire.emit('addNote', $tmpNote, '{{$field}}');


                    }
                }

                   $(document).ready(function(){
                  //alert ('ready');
                  //    var $textarea = $('#FPA_Notes2');

                  //$textarea.scrollTop($textarea[0].scrollHeight);
                 //   $('#FPA_Notes2').scrollTop($('#FPA_Notes2').scrollHeight);



                });
            </script>

            {{-- <textarea readonly @if (isset($this->rows)) rows='{{$this->rows}}' @else rows="5" @endif cols="80" class="form-control" id="FPA_Notes2"> --}}
        <div id="message_board_{{$field}}" class="message_board" style="height: {{$this->rows}}px !important;">
        @php
            $day   =   '';
        @endphp
        @foreach ($this->groupedNotes as $key=>$entries)
        @if ($entries->section == $field)
            @php $tmpUser = \App\Models\User::where('id','=',$entries->fk_UserID)->get()->first()->name;
            $carbonFormat   =   \Carbon\Carbon::parse($entries->updated_at);
            $tmpDay = \Carbon\Carbon::parse($entries->updated_at)->format('d');
            $tmpFullDay = \Carbon\Carbon::parse($entries->updated_at)->format('F d, Y');
            $tmpDate = \Carbon\Carbon::parse($entries->updated_at)->format('h:i A');

            if($tmpDay != $day){
                echo '<div class="date-box">';
                if($carbonFormat->isToday()){
                    echo '<p class="chat-date">Today</p>';
                }elseif($carbonFormat->isYesterday()){
                    echo '<p class="chat-date">Yesterday</p>';
                }else{
                    echo '<p class="chat-date">'.$tmpFullDay.'</p>';
                }
                echo '</div>';
            }
            $day    =   $tmpDay;
            @endphp
            @if($entries->fk_UserID == Auth::id())

                <div class="current-user">
                <div class="inner_c_wrapper">

                    <p class="message_text">{{$entries->note}}&#13;&#10;</p> <p class="info_text">You  <span>{{$tmpDate}}&#13;&#10;</span></p>

                    </div>
                </div>
            @else

                <div class="other-user">
                <div class="inner_o_wrapper">
                    @php $tmpUser = \App\Models\User::where('id','=',$entries->fk_UserID)->get()->first()->name; $tmpDate = \Carbon\Carbon::parse($entries->updated_at)->format('@h:i A'); @endphp <p class="message_text">{{$entries->note}}&#13;&#10;</p> <p class="info_text" style="text-align:right;">{{$tmpUser}}  <span>{{$tmpDate}}&#13;&#10;</span></p>
                    </div>
                </div>

            @endif
        @endif

        @endforeach
        </div>
        {{-- </textarea> --}}
        <div id="console_board" class="console_board"  >

        <textarea class="FPA_Notes" wire:ignore cols="45" rows="2" class="" wire:model="note" type="text" placeholder="Enter Note..." id="FPA_Notes_{{$field}}"></textarea>
        <!-- onclick="javascript:addFPA_Note_Entry();" -->
        <input class="" type="button"  wire:click="clickme()"  value="Add Note" />
        </div>



            </div>
        blade;
    }
}
