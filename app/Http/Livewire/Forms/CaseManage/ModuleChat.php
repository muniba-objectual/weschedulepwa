<?php

namespace App\Http\Livewire\Forms\CaseManage;

use App\Models\FosterParentApplication_Notes;

use Illuminate\Http\Client\Request;
use Livewire\Component;
use App\InsertTypes\UserInsert;

class ModuleChat extends Component
{
    public $user;
    public $UserID;
    public $model;
    public  $fk_ModelID;
    public  $chatNotes;
    public $rows;

    public $note;
    public $groupedNotes;
    public $tmpRequest;


    protected $listeners = [
        'addNote' => 'addNote',
        'refreshChatComponent' => '$refresh',
        'updateRows' => 'updateRows',
        'deleteChatMessage' => 'delete'
    ];




//    public function addNote() {
//
//        if ($this->note) {
//            $tmpNoteEntry = new ModuleChat();
//
//            $tmpNoteEntry->fk_UserID = $this->user->id;
//
//            $tmpNoteEntry->model = $this->model;
//            $tmpNoteEntry->fk_ModelID = $this->fk_ModelID;
//
////            if ($this->field == 'personal_information_notes')
////                $tmpNoteEntry->personal_information_notes = $$this->note;
////
////            if ($this->field == 'description_of_home_community')
////                $tmpNoteEntry->description_of_home_community = $this->note;
//
//            if ($this->note) {
//                $tmpNoteEntry->note = $this->note;
//                $tmpNoteEntry->save();
//
//
//            }
//
//            $this->emit('refreshChatComponent');
//
//
//        }
//
//
//
//
//    }

    public function boot() {
        // dd ($request->route('id'));

        //$this->tmpRequest = $request->route('id');

        //       $this->emit('refreshChatComponent');

    }
    public function mount() {
        // $this->field = $field;
//        dd ($this->fk_ModelID);

    }

    public function clickme() {
        //ray ($this);


        if ($this->model) {
            $tmpNoteEntry = new \App\Models\ModuleChat();

            $tmpNoteEntry->fk_UserID = $this->user->id;
            $tmpNoteEntry->model = $this->model;


            $tmpNoteEntry->fk_ModelID = $this->fk_ModelID;


            ray($tmpNoteEntry);
            /* if ($this->field == 'personal_information_notes')
                 $tmpNoteEntry->personal_information_notes = $$this->note;

             if ($this->field == 'description_of_home_community')
                 $tmpNoteEntry->description_of_home_community = $this->note;*/

            if ($this->note) {
                //$tmpNoteEntry->field = $this->note;



                //$tmpNoteEntry->{$this->field} = $this->note;
                $tmpNoteEntry->note = $this->note;
                $tmpNoteEntry->save();

                //detect if the note contains a mention (@)
                preg_match_all('/(^|\s)(@\w+)/', $tmpNoteEntry->note, $result);
                if ($result) {
                    //$result[2] contains array of each mention
                    foreach ($result[2] as $mention) {
                        $mentionUser = \App\Models\User::whereRaw('replace(name," ","") = ?', str_replace('@','',$mention))->where('user_type','>=','3.0')->where('user_type','<=','6.0')->first();
//                        dd ($mentionUser);
                        $notification = new \App\Models\Notifications;
                        $notification->fk_UserID = $mentionUser->id;
                        $notification->model = "Expenses";
                        $notification->fk_ModelID = $this->fk_ModelID;
                        $notification->active = true;
                        $notification->save();
                    }
                    //                    dd($result[2]);
                }
            }
            $this->note = "";
            $this->emit('refreshChatComponent');
            $this->dispatchBrowserEvent('ScrollMessageBoardToBottom', ['MessageBoardID' =>  $this->fk_ModelID]);

        }
    }

    public function delete($messageId) : void{
        if(auth()->user()->user_type == 10.0){
            \App\Models\ModuleChat::query()
                ->where([
                    'fk_ModelID' => $this->fk_ModelID,
                    'model' => $this->model,
                    'id' => $messageId,
                ])
                ->delete();
        }
    }

    public function render()
    {
        $this->chatNotes = \App\Models\ModuleChat::where('fk_ModelID','=',$this->fk_ModelID)->where('model','=',$this->model)->get();

//        $this->groupedNotes = \App\Models\FosterParentApplication_Notes::where('fk_foster_parent_applicationID','=',$this->FPAForm->id)->
//            groupBy('updated_at')->get();

        $this->groupedNotes = \App\Models\ModuleChat::where('fk_ModelID','=',$this->fk_ModelID)->where('model','=',$this->model)
            ->orderBy('updated_at', 'asc')
            ->get();

        //$this->groupedNotes = $groupedNotes->get();
        // ray($this->groupedNotes);
        //groupBy('updated_at')->get();

        return <<<'blade'
            <div wire:poll.visible class="form-group">
                <div wire:key="chat-for-{{$this->model}}-{{$this->fk_ModelID}}">
                    <script>
                        function add_Note_Entry() {
                            let $today = new Date().toLocaleString();
                            $tmpNote = prompt("Note Entry by {{$user->name}} @" + $today);
                            if ($tmpNote) {
                                Livewire.emit('addNote', $tmpNote);
                            }
                        }

                        $(document).ready(function(){
                            //alert ('ready');
                            //var $textarea = $('#FPA_Notes2');
                            //$textarea.scrollTop($textarea[0].scrollHeight);
                            //$('#FPA_Notes2').scrollTop($('#FPA_Notes2').scrollHeight);
                        });
                    </script>

                    {{-- <textarea readonly @if (isset($this->rows)) rows='{{$this->rows}}' @else rows="5" @endif cols="80" class="form-control" id="FPA_Notes2"> --}}
                    <div id="message_board_{{$this->fk_ModelID}}" class="message_board" style="height: {{$this->rows}}px !important;">
                        @php
                            $day = '';
                            $loginUser = \Auth::user();
                        @endphp

                        @foreach ($this->groupedNotes as $key=>$entries)

                            @php
                                $tmpUser = \App\Models\User::where('id','=',$entries->fk_UserID)->get()->first()->name;
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
                                $day = $tmpDay;
                            @endphp

                            @if($entries->fk_UserID == Auth::id())
                                <div class="current-user">
                                    @if($loginUser->user_type == 10.0)
                                        <a href="#" onclick="if(confirm('Are you sure you want to delete the message?')){ Livewire.emit('deleteChatMessage', {{$entries->id}}); Livewire.emit('refreshChatComponent'); }"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a>
                                    @endif
                                    <div class="inner_c_wrapper">
                                        <p class="message_text">{{$entries->note}}&#13;&#10;</p> <p class="info_text">You  <span>{{$tmpDate}}&#13;&#10;</span></p>
                                    </div>
                                </div>
                            @else
                                <div class="other-user">
                                    <div class="inner_o_wrapper">
                                        @php
                                            $tmpUser = \App\Models\User::where('id','=',$entries->fk_UserID)->get()->first()->name;
                                            $tmpDate = \Carbon\Carbon::parse($entries->updated_at)->format('@h:i A');
                                        @endphp
                                        <p class="message_text">{{$entries->note}}&#13;&#10;</p>
                                        <p class="info_text" style="text-align:right;">{{$tmpUser}}  <span>{{$tmpDate}}&#13;&#10;</span></p>
                                    </div>
                                    @if($loginUser->user_type == 10.0)
                                        <a href="#" onclick="if(confirm('Are you sure you want to delete the message?')){ Livewire.emit('deleteChatMessage', {{$entries->id}}); Livewire.emit('refreshChatComponent'); }"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                            @endif

                        @endforeach
                    </div>
                    {{-- </textarea> --}}

                    <div id="console_board" class="console_board"  >

                        <textarea {{ wep_insert(['user']) }} class="Notes" wire:ignore cols="45" rows="2" class="" wire:model="note" type="text" placeholder="Enter Note..." id="Notes_{{$this->model}}_{{$this->fk_ModelID}}"></textarea>
                        <!-- onclick="javascript:addFPA_Note_Entry();" -->
                        <div class="mt-2 text-center">
                            <span wire:click="clickme()" class="btn btn-primary">Add Note</span>
                        </div>
                    </div>
                </div>
            </div>
        blade;
    }
}
