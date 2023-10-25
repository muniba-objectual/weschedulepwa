<?php

namespace App\Http\Livewire\Forms\CaseManage;

use Livewire\Component;
use App\Models\OnCall;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OnCallForm extends Component
{
    use LivewireAlert;

    public $homes;
    public $notes;
    public $user;
    public $selectedHome;
    public $selectedChildren = array();


    protected $rules = [
        'selectedHome' => 'required',
        'notes' => 'required',
        'selectedChildren' => 'nullable'
    ];

    protected $listeners = ['AddToSelectedChildren', 'RemoveFromSelectedChildren'];

    public function AddToSelectedChildren($item) {
        if ($item) {
           $this->selectedChildren += [$item => $item];
            //array_push($this->selectedChildren, $item);
        }
    }

    public function RemoveFromSelectedChildren($item) {
        if ($item) {
            if (($key = array_search("$item", $this->selectedChildren)) !== false) {
                unset($this->selectedChildren[$key]);
            }

        }
    }


    public function submit() {



        if ($this->selectedHome && ($this->notes)) {

            $onCall = new OnCall();

            $onCall->fk_UserID = $this->user->id;
            $onCall->fk_HomeID = $this->selectedHome;
            if (count($this->selectedChildren) > 0) {
                $data = [];
                foreach ($this->selectedChildren as $child)
                {
                    $data[] = [
                        'id' => (int)$child,

                    ];
                }
                $onCall->fk_ChildID = json_encode($data);
            }

            //$hv->fk_ChildID = null;
            $onCall->notes = $this->notes;

            $onCall->save();
            $this->alert('success', 'On-Call Saved');

            $tmpHome = \App\Models\User::where('id','=',$this->selectedHome)->first();
            activity('OnCall')
                ->causedBy($this->user)
                ->performedOn($tmpHome)
                ->event("OnCall")
                ->withProperties($tmpHome)
                ->log($this->notes);

            activity('OnCall')
                ->causedBy($this->user)
                ->performedOn($this->user)
                ->event("OnCall")
                ->withProperties($tmpHome)

                ->log($this->notes);

            if (count($this->selectedChildren)>0) {
                foreach ($this->selectedChildren as $childID) {
                    $tmpChild = \App\Models\Child::where('id','=',$childID)->first();
                    activity('OnCall')
                        ->causedBy($this->user)
                        ->performedOn($tmpChild)
                        ->event("OnCall")
                        ->withProperties($tmpHome)

                        ->log($this->notes);
                }
            }
        } else {
            $this->alert('warning', 'Please select a home and fill out the note section before submitting.');


        }

        return redirect()->to('/mobileCM');

    }

    public function mount() {
        $this->notes = "";
        $this->homes = \App\Models\User::where('user_type','=','2.2')->get();
        $this->selectedHome = "";
        $this->selectedChildren =  array();
    }
    public function render()
    {
        return <<<'blade'

            <div wire:ignore>

               <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                <script>


                        $(document).ready(function() {

                            //Initialize Select2 Elements
                        $('#selectHome').select2({
                            theme: 'classic',
                            placeholder: "Please select..."

                        });

                            //Initialize Select2 Elements
                        $('#selectedChildren').select2({
                            theme: 'classic',
                           // tags: true,
                            disabled: true,
                            placeholder: "Please select..."
                        });

                        $('#selectHome').on('select2:select', function (e) {
                            //on select, clear selectedChildren dropdown
                            $('#selectedChildren').val(null).trigger('change');
                            $tmp = "";

                            var data = e.params.data;
                            console.log(data);
                           Livewire.first().set('selectedHome', data.id);
                            $tmp = getAssociatedChildrenFromFosterParentHome(data.id)
                             console.log ($tmp);

                        });

                         $('#selectedChildren').on('select2:select', function (e) {
                           $tmp = $('#selectedChildren').select2('data');
                               if ($tmp.length >0) {
                                   $tmp.forEach(setSelectedChildren);
                               }
                        });


                          $('#selectedChildren').on('select2:unselect', function (e) {
                                var data = e.params.data;
                               if (data) {
                                   Livewire.first().emit('RemoveFromSelectedChildren', data.id);

                               }


                        });




                          function setSelectedChildren(item, index, arr) {
                            Livewire.first().emit('AddToSelectedChildren', item.id);

                              }

                          function getAssociatedChildrenFromFosterParentHome(selectedHomeID) {
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    /* the route pointing to the post function */
                                    url: "{{route('user.getAssociatedChildrenFromFosterParentHome')}}",
                                    type: 'GET',
                                    /* send the csrf-token and the input to the controller */
                                    data: {_token: CSRF_TOKEN, FosterParentHomeID: selectedHomeID},
                                    //dataType: 'JSON',
                                    /* remind that 'data' is the response of the AjaxController */
                                    success: function (data) {
                                        console.log(data);
                                        if (data != "-1") {

                                            $('#selectedChildren').select2('enable');
                                            //on select, clear selectedChildren dropdown
                                            $("#selectedChildren").empty();
                                            data.forEach(AddToSelectedChildren);

                                            return (data);
                                        }  else {
                                            //$('#selectedChildren').val('No Children Found');
                                            $('#selectedChildren').attr('disabled', 'disabled');
                                            return (-1);
                                         }


                                        //$('#timeline').html(data);
                                    }
                                });
                                }

                                function AddToSelectedChildren(item, index, arr) {
                                             var newOption = new Option(item.initials, item.id, true, false);
                                            $('#selectedChildren').append(newOption).trigger('change');
                                            //$('#selectedChildren').append(new Option("None",0,true,false)).trigger('change');
                                }

                        });


                </script>
               <form wire:submit.prevent="submit">
        @csrf
                 <!--<h6 class="card-title">CHILD PROFILES</h6>-->
                    <h3 class="m-1 p-1 d-flex justify-content-center">SELECT HOME FOR ON-CALL</h3>

                    <select wire:ignore wire:model="selectedHome" class="select2-blue d-flex justify-content-center col-1" id="selectHome" data-dropdown-css-class="select2-blue"  style="width:100%;" name="selectHome">
                        <option value="">Please select...</option>

                        @php
                            $FosterHomes = DB::table('users')->where('user_type','=','2.2')
                         ->orWhere('user_type','=','2.1')
                         ->orWhere('user_type','=','2.4')
                         ->orderBy('name')
                         ->get();
                         foreach ($FosterHomes as $home) {
                             echo "<option value='" . $home->id . "' >" . $home->name . " - " . $home->address . ", " . $home->city . " [" . $home->user_type . "]</option>";
                         }
                        @endphp

                    </select>
                     @error('selectedHome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                      <h3 class="m-1 p-1 d-flex justify-content-center">SELECT CHILDREN TO INCLUDE IN REPORT (OPTIONAL)</h3>

                    <select wire:ignore  class="select2-blue d-flex justify-content-center col-1" id="selectedChildren" data-dropdown-css-class="select2-blue"  multiple style="width:100%;" name="selectedChildren">


                    </select>
                     @error('selectedChildren')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <h3 class="m-1 p-1 d-flex justify-content-center">ENTER NOTES</h3>

                    <textarea wire:model="notes" rows="10" class="d-flex justify-content-center col-12" id="note" name="note"></textarea>

                    <div class="section mt-3 d-flex justify-content-center">
                    <button id="btnSubmit" type="submit" class="btn btn-primary btn me-1 mb-1 ">
                            SUBMIT
                        </button>
                    </div>



                        {{--<ul class="listview image-listview">
                        @foreach ($homes as $home)

                            <li>
                                <a href="/mobileCM-home_visit_select_home?id={{$home->id}}" class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="home"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{$home->name}}
                                            <span class="text-center">- {{$home->address}}, {{$home->city}}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>

                        @endforeach


                    </ul>--}}
                                            </form>

            </div>
        blade;
    }
}
