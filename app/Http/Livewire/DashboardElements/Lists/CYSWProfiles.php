<?php

namespace App\Http\Livewire\DashboardElements\Lists;

use App\Models\User;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CYSWProfiles extends Component
{
    use LivewireAlert;
    public $users;
    public  $toggleActive;
    public  $toggleChildActive = true;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount() {
        $this->users = User::all()
            ->where('user_type','=','1')
            ->where('inactive','=','0')
            ->sortBy('name');

    }
    public function updatedToggleChildActive($value) {
        if (!$value) { //Show Deactivated
            $this->users = User::all()
                                ->where('user_type','=','1')
                                ->where('inactive','=','1')
                                ->sortBy('name');
        } else {
            $this->users = User::all()
                                ->where('user_type','=','1')
                                ->where('inactive','=','0')
                                ->sortBy('name');
        }
    }
    public function render()
    {
        return <<<'blade'
            <div>

                <style>
                /* for sm */

                    .custom-switch.custom-switch-sm .custom-control-label {
                        padding-left: 1rem;
                        padding-bottom: 1rem;
                    }

                    .custom-switch.custom-switch-sm .custom-control-label::before {
                        height: 1rem;
                        width: calc(1rem + 0.75rem);
                        border-radius: 2rem;
                    }

                    .custom-switch.custom-switch-sm .custom-control-label::after {
                        width: calc(1rem - 4px);
                        height: calc(1rem - 4px);
                        border-radius: calc(1rem - (1rem / 2));
                    }

                    .custom-switch.custom-switch-sm .custom-control-input:checked ~ .custom-control-label::after {
                        transform: translateX(calc(1rem - 0.25rem));
                    }

                    /* for md */

                    .custom-switch.custom-switch-md .custom-control-label {
                        padding-left: 1rem;
                        padding-bottom: 1.5rem;
                        padding-top: 4px;
                    }

                    .custom-switch.custom-switch-md .custom-control-label::before {
                        height: 1.5rem;
                        width: calc(2rem + 0.75rem);
                        border-radius: 3rem;
                    }

                    .custom-switch.custom-switch-md .custom-control-label::after {
                        width: calc(1.5rem - 4px);
                        height: calc(1.5rem - 4px);
                        border-radius: calc(2rem - (1.5rem / 2));
                    }

                    .custom-switch.custom-switch-md .custom-control-input:checked ~ .custom-control-label::after {
                        transform: translateX(calc(1.5rem - 0.25rem));
                    }

                    /* for lg */

                    .custom-switch.custom-switch-lg .custom-control-label {
                        padding-left: 3rem;
                        padding-bottom: 2rem;
                    }

                    .custom-switch.custom-switch-lg .custom-control-label::before {
                        height: 2rem;
                        width: calc(3rem + 0.75rem);
                        border-radius: 4rem;
                    }

                    .custom-switch.custom-switch-lg .custom-control-label::after {
                        width: calc(2rem - 4px);
                        height: calc(2rem - 4px);
                        border-radius: calc(3rem - (2rem / 2));
                    }

                    .custom-switch.custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
                        transform: translateX(calc(2rem - 0.25rem));
                    }

                    /* for xl */

                    .custom-switch.custom-switch-xl .custom-control-label {
                        padding-left: 4rem;
                        padding-bottom: 2.5rem;
                    }

                    .custom-switch.custom-switch-xl .custom-control-label::before {
                        height: 2.5rem;
                        width: calc(4rem + 0.75rem);
                        border-radius: 5rem;
                    }

                    .custom-switch.custom-switch-xl .custom-control-label::after {
                        width: calc(2.5rem - 4px);
                        height: calc(2.5rem - 4px);
                        border-radius: calc(4rem - (2.5rem / 2));
                    }

                    .custom-switch.custom-switch-xl .custom-control-input:checked ~ .custom-control-label::after {
                        transform: translateX(calc(2.5rem - 0.25rem));
                    }
                    .productImage {
                        position: relative;
                        float: left;
                        display: inline-block;
                    }
                    .productImage {
                        width: 100%;
                    }
                    .productImage:after {
                        padding-top: 100%;
                        display: block;
                        content:'';
                    }
                    .img-wrapper {
                        padding: 10px;
                        position: absolute;
                        top: 0;
                        bottom: 0;
                        right: 0;
                        left: 0;
                        /*fill parent*/
                    }
                    .img-wrapper .thumb {
                        height:100%;
                    }
                    .img-project, .thumb {
                        display: block;

                    }
                    .img-project img, .thumb img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        object-position: 50% 10%;
                        display: block;
                    }
                </style>
             <!-- CYSW Profiles -->
                    <div class="container-fluid mt-3 mb-3">
                        <div class="d-flex justify-content-start">
                            <div class="col-10">CYSW PROFILES</div>
                            <div class="col-2 custom-control custom-switch custom-switch-md custom-switch-off-danger custom-switch-on-success">
                            <input wire:model="toggleChildActive" type="checkbox" class="custom-control-input" id="customSwitch2" @if ($toggleChildActive) checked @endif>
                            <label class="custom-control-label" for="customSwitch2">@if ($toggleChildActive) Showing Active @else Showing Inactive @endif</label>
                            </div>
                        </div>

                        @if(!$users->isEmpty())
                        <div class="row gx-4 gx-lg-5 row-cols-6 row-cols-md-6 row-cols-xl-6 mt-2 justify-content-center">
                                @foreach ($users as $user)
                                    <div class="col-xl-2 col-md-2 mb-4">
                                        <div class="card border-0 shadow">

                                            <!-- On Hold Ribbon -->
                                            @if ($user->OnHold)
                                             <div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon bg-red">
                                                  On Hold
                                                </div>
                                              </div>
                                              @endif
                                            @if (!$user->profile_pic)

                                                    <div class="productImage">
                                                        <div class="img-wrapper">
                                                            <a class="thumb" href="javascript:viewUserProfile('{{$user->id}}')">
                                                                <img height="150px" src="/img/default-avatar.png" alt="avatar" class="card-img-top" />
                                                                </a>
                                                                </div>
                                                                </div>
                                            @else
                                                @php
                                                    // @ray ($user->name);
                                                     //@ray (storage_path('app/public/profile_pic/') . substr($user->profile_pic,20));



                                                         //$img = Image::make(storage_path('app/public/profile_pic/') . substr($user->profile_pic,20))->orientate()->fit(142, 116, function ($constraint) {
                                                        //$constraint->upsize();
                                                        //});



                                                    //$img->save(storage_path('app/public/profile_pic/') . substr($user->profile_pic,20));
                                                //echo $img->response('jpg');

                                                @endphp
                                                    <div class="productImage">
                                                        <div class="img-wrapper">
                                                            <a class="thumb" href="javascript:viewUserProfile('{{$user->id}}')">
                                                                <img height="150px" src="/storage/profile_pic/{{substr($user->profile_pic,20)}}" alt="avatar" class="">
                                                            </a>
                                                        </div>
                                                    </div>

                                            @endif
                                                @if ($user->getSignedInShift)
                                                    <span class="badge bg-success mt-0">Signed In</span>
                                                @else
                                                    <span class="badge bg-red mt-0">Offline</span>

                                                @endif
                                            <div class="card-body text-center">
                                                <h6 class="mb-0 text-center text-sm @php
                                                    if (strlen($user->name) >15)
                                                        echo "child-small text-truncate ";
                                                @endphp">                      <br />{{$user->name}}
                                                <br />
                                                @php
                                                $CYSW_Profile =\App\Models\CYSW_Profile_Model::where('fk_UserID','=',$user->id)->first();
                                                @endphp
                                                @if ($CYSW_Profile)
                                                @php
                                                    $raw_phone = preg_replace('/\D/', '', $CYSW_Profile->cellular);
                                                    $temp = str_split($raw_phone);
                                                    $phone_number = "";
                                                    for ($x=count($temp)-1;$x>=0;$x--) {
                                                        if ($x === count($temp) - 5 || $x === count($temp) - 8 || $x === count($temp) - 11) {
                                                            $phone_number = "-" . $phone_number;
                                                        }

                                                        $phone_number = $temp[$x] . $phone_number;
                                                    }
                                                    if ($phone_number == "") {
                                                    $phone_number = "N/A";
                                                    }

                                                    echo "<i class='mt-2 text-success fas fa-phone fa-xs'></i>&nbsp;" . $phone_number;
                                                    @endphp

                                                @endif

                                                </h6>
                                                <div class="card-text text-black-50">                                            <div class="button mt-2 d-flex flex-row align-items-center"> <button onclick="viewUserProfile('{{$user->id}}')" class="btn btn-sm btn-primary w-100">Profile</button> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                        </div>
                        @else
                            <div class="row">
                                <div class=" col-md-12 text-center">
                                    <h5> No Inactive CYSW Profiles </h5>
                                </div>
                            </div>
                            @endif
                    </div>
                    <!-- *CYSW Profiles -->


            </div>

        blade;
        //return view('livewire.c-y-s-w-dashboard-profiles');
    }
}
