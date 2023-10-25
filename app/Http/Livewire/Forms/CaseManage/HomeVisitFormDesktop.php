<?php

namespace App\Http\Livewire\Forms\CaseManage;

use App\Models\HomeVisit;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class HomeVisitFormDesktop extends Component
{
    use LivewireAlert;
    public $show;
    public $size;

    public $homes;
    public $notes;
    public $user;
    public $selectedHome;
    public $selectedChildren = array();
    public $privacy;
    public $date;


    protected $rules = [
        'selectedHome' => 'required',
        'notes' => 'required',
        'selectedChildren' => 'nullable',
        'privacy' => 'required'
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

            $hv = new HomeVisit();

            $hv->fk_UserID = $this->user->id;
            $hv->fk_HomeID = $this->selectedHome;
            if (count($this->selectedChildren) > 0) {
                $data = [];
                foreach ($this->selectedChildren as $child)
                {
                    $data[] = [
                        'id' => (int)$child,

                    ];
                }
                $hv->fk_ChildID = json_encode($data);
            }
            $hv->notes = $this->notes;

            if ($this->privacy) {
                $hv->privacy = true;
            } else {
                $hv->privacy = false;
            }

            if ($this->date) {
                $hv->setUpdatedAt($this->date);
                $hv->setCreatedAt($this->date);
            }
            $hv->save();
            $this->alert('success', 'Home Visit Saved');

            $tmpHome = \App\Models\User::where('id','=',$this->selectedHome)->first();

            if (!$this->privacy) {

                activity('HomeVisit')
                    ->causedBy($this->user)
                    ->performedOn($tmpHome)
                    ->event("HomeVisit")
                    ->withProperties($tmpHome)
                    ->createdAt($this->date ? \DateTime::createFromFormat("Y-m-d H:i", $this->date) : new \DateTime('@'.strtotime('now')) )

                    ->log($this->notes);

                activity('HomeVisit')
                    ->causedBy($this->user)
                    ->performedOn($this->user)
                    ->event("HomeVisit")
                    ->withProperties($tmpHome)
                    ->createdAt($this->date ? \DateTime::createFromFormat("Y-m-d H:i", $this->date) : new \DateTime('@'.strtotime('now')) )

                    ->log($this->notes);

                if (count($this->selectedChildren)>0) {
                    foreach ($this->selectedChildren as $childID) {
                        $tmpChild = \App\Models\Child::where('id','=',$childID)->first();
                        activity('HomeVisit')
                            ->causedBy($this->user)
                            ->performedOn($tmpChild)
                            ->event("HomeVisit")
                            ->createdAt($this->date ? \DateTime::createFromFormat("Y-m-d H:i", $this->date) : new \DateTime('@'.strtotime('now')) )

                            ->withProperties($tmpHome)

                            ->log($this->notes);
                    }
                }
            } else {
                if (count($this->selectedChildren)>0) {
                    foreach ($this->selectedChildren as $childID) {
                        $tmpChild = \App\Models\Child::where('id','=',$childID)->first();
                        activity('PrivacyVisit')
                            ->causedBy($this->user)
                            ->performedOn($tmpChild)
                            ->event("PrivacyVisit")
                            ->createdAt($this->date ? \DateTime::createFromFormat("Y-m-d H:i", $this->date) : new \DateTime('@'.strtotime('now')) )

                            ->withProperties($tmpChild)

                            ->log($this->notes);

                    }
                }
            }
            }else {
            $this->alert('warning', 'Please select a home and fill out the note section before submitting.');


        }



    }

    public function mount() {
        $this->user = Auth::user();
        $this->notes = "";
        $this->homes = \App\Models\User::where('user_type','=','2.2')->get();
        $this->selectedHome = "";
        $this->selectedChildren =  array();
        $this->privacy = false;
    }

//    public function updated($field, $value) {
//        if ($field == "privacy") {
//            $this->privacy = true;
//        }
//    }
    public function render()
    {
        return <<<'blade'

            <div wire:ignore>


                <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
                <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
                <script>


                        $(document).ready(function() {

                                $('#toggle_privacy').change(function() {
                                  // $('#console-event').html('Toggle: ' + $(this).prop('checked'))
                                    Livewire.first().set('privacy', $(this).prop('checked'));

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
                                }

                                $('#drSizeSm').on('apply.daterangepicker', function(ev, picker) {
                                   console.log('date set');
                                    Livewire.first().set('date', $('#drSizeSm').val());


                                });
                                  $('#drSizeSm').on('hide.daterangepicker', function(ev, picker) {
                                   console.log('date set (after hide)');
                                    Livewire.first().set('date', $('#drSizeSm').val());


                                });
                        });


                </script>
               <form wire:submit.prevent="submit">
        @csrf
                 <!--<h6 class="card-title">CHILD PROFILES</h6>-->
                    <h3 class="m-1 p-1 d-flex justify-content-center">SELECT HOME FOR SITE VISIT</h3>

                    <div wire:ignore>
                        <x-adminlte-select2 name="selectHome" label="" label-class="text-lightblue"
                                            igroup-size="sm" data-placeholder="Select a Home..." data-allow-clear="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-home"></i>
                                </div>
                            </x-slot>
                            <option/>
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
                        </x-adminlte-select2>
                        </div>

                        <h3 class="m-1 p-1 d-flex justify-content-center">PRIVACY VISIT?</h3>
                        <div class="m-1 p-1 d-flex justify-content-center"><input type="checkbox" id="toggle_privacy" data-toggle="toggle"  data-on="YES" data-onstyle="success" data-off="NO" data-offstyle="danger">

                                                     </div>

                      <h3 class="m-1 p-1 d-flex justify-content-center">SELECT CHILDREN TO INCLUDE IN REPORT</h3>

                     <div wire:ignore>
                       @php
                       $configSelectedChildren = [
                        "placeholder" => "Select Children...",
                        "allowClear" => true,
                        ];
                         @endphp


                        <x-adminlte-select2 name="selectedChildren" label="" label-class="text-lightblue"
                                             :config="$configSelectedChildren" multiple >
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-child"></i>
                                </div>
                            </x-slot>

                            <option/>

                        </x-adminlte-select2>
                        </div>

                     @error('selectedChildren')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-3">
                    @php
                    $config = [
                        "singleDatePicker" => true,
                        "showDropdowns" => true,
                        "startDate" => "js:moment()",
                        "minYear" => 2000,
                        "maxYear" => "js:parseInt(moment().format('YYYY'),10)",
                        "timePicker" => true,
                        "timePicker24Hour" => false,
                        "timePickerSeconds" => false,
                        "cancelButtonClasses" => "btn-danger",
                        "locale" => ["format" => "YYYY-MM-DD HH:mm"],
                    ];
                    @endphp
                    <x-adminlte-date-range name="drSizeSm" label="Date/Time" igroup-size="sm" :config="$config">
                        <x-slot name="appendSlot">
                            <div class="input-group-text bg-dark">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </x-slot>

                    </x-adminlte-date-range>
                    </div>

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
