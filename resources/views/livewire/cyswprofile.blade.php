<div>
    <script src="/mobilekit/assets/js/lib/bootstrap.min.js"></script>

    @if(session('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{session('message')}}
        </div>
    @endif

    <form action="{{route('users_mycysw-profile.edit')}}" method="post" wire:submit.prevent="save">
        {{ csrf_field() }}
        <input type="hidden" id="type" name="type" value="update">

        <div class="card card-primary">
            <div class="card-header pb-0 mb-0 ">
                <h6>Personal Information</h6>
            </div>
            <div class="card-body">

                {{-- Title field --}}
                <div class="input-group mb-3">

                    <select name="title" class="form-control" wire:model="title">
                        <option value="">Select Title</option>
                        <option value="Mr.">Mr.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Ms.">Ms.</option>
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                {{-- legal_name field --}}
                <div class="input-group mb-3">

                    <input type="text" name="legal_name"

                           class="form-control"
                           placeholder="Legal Name" wire:model="legal_name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                {{-- preferred_name field --}}
                <div class="input-group mb-3">

                    <input type="text" name="preferred_name"

                           class="form-control"
                           placeholder="Preferred Name" wire:model="preferred_name">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                {{-- SIN field --}}
                <div class="input-group mb-3">

                    <input type="text" name="SIN"

                           class="form-control"
                           placeholder="Social Insurance Number" wire:model="SIN">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                {{-- Cellular field --}}
                <div class="input-group mb-3">

                    <input type="text" name="cellular"
                           data-inputmask="'mask': '(999) 999-9999'"
                           class="form-control"
                           placeholder="Cell Phone" wire:model="cellular">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                {{-- Availability field --}}
                <div class="input-group mb-0 table-responsive p-0 m-0">
                    <h6>Availability</h6>
                    <table class="table table-striped table-bordered text-nowrap"  id="tblAvailability" name="tblAvailability">
                       <tr>
                           <th>Mon</th>
                           <th>Tues</th>
                           <th>Wed</th>
                           <th>Thurs</th>
                           <th>Fri</th>
                           <th>Sat</th>
                           <th>Sun</th>
                       </tr>
                       <tr>
                           <td>
                               <fieldset>
                                   <input type="checkbox" name="monday" value="DAY" wire:model="monday" @if(in_array("DAY",$monday)) checked @endif> DAY<br>
                                   <input type="checkbox" name="monday" value="NIGHT" wire:model="monday" @if(in_array("NIGHT",$monday)) checked @endif> NIGHT<br>
                                   <input type="checkbox" name="monday" value="OVERNIGHT" wire:model="monday" @if(in_array("OVERNIGHT",$monday)) checked @endif> OVERNIGHT<br>
                    {{--<div> @json($monday)</div>--}}
                               </fieldset>
                           </td>
                           <td>
                               <fieldset>
                                   <input type="checkbox" name="tuesday" value="DAY" wire:model="tuesday" @if(in_array("DAY",$tuesday)) checked @endif> DAY<br>
                                   <input type="checkbox" name="tuesday" value="NIGHT" wire:model="tuesday" @if(in_array("NIGHT",$tuesday)) checked @endif> NIGHT<br>
                                   <input type="checkbox" name="tuesday" value="OVERNIGHT" wire:model="tuesday" @if(in_array("OVERNIGHT",$tuesday)) checked @endif> OVERNIGHT<br>
                               </fieldset>
                           </td>
                           <td>
                               <fieldset>
                                   <input type="checkbox" name="wednesday" value="DAY" wire:model="wednesday" @if(in_array("DAY",$wednesday)) checked @endif> DAY<br>
                                   <input type="checkbox" name="wednesday" value="NIGHT" wire:model="wednesday" @if(in_array("NIGHT",$wednesday)) checked @endif> NIGHT<br>
                                   <input type="checkbox" name="wednesday" value="OVERNIGHT" wire:model="wednesday" @if(in_array("OVERNIGHT",$wednesday)) checked @endif> OVERNIGHT<br>
                               </fieldset>
                           </td>
                           <td>
                               <fieldset>
                                   <input type="checkbox" name="thursday" value="DAY" wire:model="thursday" @if(in_array("DAY",$thursday)) checked @endif> DAY<br>
                                   <input type="checkbox" name="thursday" value="NIGHT" wire:model="thursday" @if(in_array("NIGHT",$thursday)) checked @endif> NIGHT<br>
                                   <input type="checkbox" name="thursday" value="OVERNIGHT" wire:model="thursday" @if(in_array("OVERNIGHT",$thursday)) checked @endif> OVERNIGHT<br>
                               </fieldset>
                           </td>
                           <td>
                               <fieldset>
                                   <input type="checkbox" name="friday" value="DAY" wire:model="friday" @if(in_array("DAY",$friday)) checked @endif> DAY<br>
                                   <input type="checkbox" name="friday" value="NIGHT" wire:model="friday" @if(in_array("NIGHT",$friday)) checked @endif> NIGHT<br>
                                   <input type="checkbox" name="friday" value="OVERNIGHT" wire:model="friday" @if(in_array("OVERNIGHT",$friday)) checked @endif> OVERNIGHT<br>
                               </fieldset>
                           </td>
                           <td>
                               <fieldset>
                                   <input type="checkbox" name="saturday" value="DAY" wire:model="saturday" @if(in_array("DAY",$saturday)) checked @endif> DAY<br>
                                   <input type="checkbox" name="saturday" value="NIGHT" wire:model="saturday" @if(in_array("NIGHT",$saturday)) checked @endif> NIGHT<br>
                                   <input type="checkbox" name="saturday" value="OVERNIGHT" wire:model="saturday" @if(in_array("OVERNIGHT",$saturday)) checked @endif> OVERNIGHT<br>
                               </fieldset>
                           </td>
                           <td>
                               <fieldset>
                                   <input type="checkbox" name="sunday" value="DAY" wire:model="sunday" @if(in_array("DAY",$sunday)) checked @endif> DAY<br>
                                   <input type="checkbox" name="sunday" value="NIGHT" wire:model="sunday" @if(in_array("NIGHT",$sunday)) checked @endif> NIGHT<br>
                                   <input type="checkbox" name="sunday" value="OVERNIGHT" wire:model="sunday" @if(in_array("OVERNIGHT",$sunday)) checked @endif> OVERNIGHT<br>
                               </fieldset>
                           </td>

                   </table>
                </div>



                <div class="input-group mt-1 mb-3">
                    <label for="resume">Resume</label>
                    <p>

                    @if ($resume_attachment)
                        <div class="col-md-12 pb-3">
                            <div class="row">

                                @if (!str_contains($resume_attachment,"/var/folders"))

                                    <a href="{{asset('/storage/' . substr($resume_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($resume_attachment,7))}}?{{ rand() }}"></a>
                                @endif


                                <br />
                            </div>
                        </div>
                        @endif
                        </p>
                        <div>
                            <input type="file" class="mt-3" name="resume_attachment"
                                   id="resume_attachment"

                                   class="form-control"  wire:model="resume_attachment">
                        </div>

                </div>
            </div>
        </div>


            <div class="card card-primary">
                <div class="card-header pb-0 mb-0 ">
                    <h6>References</h6>
                </div>
                <div class="card-body">
                    {{-- Reference 1 field --}}
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#accordion01">
                                    <h6>Reference #1</h6>
                                </button>
                            </h2>
                            <div id="accordion01" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="input-group mb-3">
                                        <input type="text" name="reference_1_name"
                                               class="form-control" placeholder="Name"
                                               wire:model="reference_1_name" >
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                            <span
                                                                class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>
                                </div>

                                    {{-- reference_1_phone field --}}
                                    <div class="input-group mb-3">

                                        <input type="tel" name="reference_1_phone"
                                               data-inputmask="'mask': '(999) 999-9999'"
                                               class="form-control"
                                               placeholder="Telephone" wire:model="reference_1_phone">

                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                            <span
                                                                class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- reference_1_email field --}}
                                    <div class="input-group mb-3">
                                        <input type="text" name="reference_1_email"
                                               class="form-control" placeholder="Email"
                                               wire:model="reference_1_email" >
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                            <span
                                                                class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>
                                        @if($errors->has('reference_1_email'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('reference_1_email') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- reference_1_attachment field --}}
                                    <div  class="input-group mb-3">
                                        <label for="resume">Attachment</label>
                                        <p>

                                        @if ($reference_1_attachment)
                                            <div class="col-md-12">
                                                <div class="row">
                                                    @if (!str_contains($reference_1_attachment,"/var/folders"))

                                                        <a href="{{asset('/storage/' . substr($reference_1_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($reference_1_attachment,7))}}?{{ rand() }}"></a>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            </p>
                                            <div wire:poll.visible>
                                                <input type="file" class="mt-3" name="reference_1_attachment"
                                                       id="reference_1_attachment"
                                                       wire:model="reference_1_attachment">

                                            </div>


                                    </div>
                                </div>





                    </div>
                        </div>
                    </div>
                    <!-- /.card -->

                    {{-- Reference 2 field --}}
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#accordion02">
                                    <h6>Reference #2</h6>
                                </button>
                            </h2>
                            <div id="accordion02" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="input-group mb-3">
                                        <input type="text" name="reference_2_name"
                                               class="form-control" placeholder="Name"
                                               wire:model="reference_2_name" >
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                            <span
                                                                class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- reference_2_phone field --}}
                                    <div class="input-group mb-3">

                                        <input type="tel" name="reference_2_phone"
                                               data-inputmask="'mask': '(999) 999-9999'"
                                               class="form-control"
                                               placeholder="Telephone" wire:model="reference_2_phone">

                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                            <span
                                                                class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- reference_2_email field --}}
                                    <div class="input-group mb-3">
                                        <input type="text" name="reference_2_email"
                                               class="form-control" placeholder="Email"
                                               wire:model="reference_2_email" >
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                            <span
                                                                class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>
                                        @if($errors->has('reference_2_email'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('reference_2_email') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- reference_2_attachment field --}}
                                    <div  class="input-group mb-3">
                                        <label for="resume">Attachment</label>
                                        <p>

                                        @if ($reference_2_attachment)
                                            <div class="col-md-12">
                                                <div class="row">
                                                    @if (!str_contains($reference_2_attachment,"/var/folders"))

                                                        <a href="{{asset('/storage/' . substr($reference_2_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($reference_2_attachment,7))}}?{{ rand() }}"></a>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            </p>
                                            <div wire:poll.visible>
                                                <input type="file" class="mt-3" name="reference_2_attachment"
                                                       id="reference_2_attachment"
                                                       wire:model="reference_2_attachment">

                                            </div>


                                    </div>
                                </div>





                            </div>
                        </div>
                    </div>

                    <!-- /.card -->

                    {{-- Reference 3 field --}}
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#accordion03">
                                    <h6>Reference #3</h6>
                                </button>
                            </h2>
                            <div id="accordion03" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="input-group mb-3">
                                        <input type="text" name="reference_3_name"
                                               class="form-control" placeholder="Name"
                                               wire:model="reference_3_name" >
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                            <span
                                                                class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- reference_3_phone field --}}
                                    <div class="input-group mb-3">

                                        <input type="tel" name="reference_3_phone"
                                               data-inputmask="'mask': '(999) 999-9999'"
                                               class="form-control"
                                               placeholder="Telephone" wire:model="reference_3_phone">

                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                            <span
                                                                class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- reference_3_email field --}}
                                    <div class="input-group mb-3">
                                        <input type="text" name="reference_3_email"
                                               class="form-control" placeholder="Email"
                                               wire:model="reference_3_email" >
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                            <span
                                                                class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                            </div>
                                        </div>
                                        @if($errors->has('reference_3_email'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('reference_3_email') }}</strong>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- reference_3_attachment field --}}
                                    <div  class="input-group mb-3">
                                        <label for="resume">Attachment</label>
                                        <p>

                                        @if ($reference_3_attachment)
                                            <div class="col-md-12">
                                                <div class="row">
                                                    @if (!str_contains($reference_3_attachment,"/var/folders"))

                                                        <a href="{{asset('/storage/' . substr($reference_3_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($reference_3_attachment,7))}}?{{ rand() }}"></a>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            </p>
                                            <div wire:poll.visible>
                                                <input type="file" class="mt-3" name="reference_3_attachment"
                                                       id="reference_3_attachment"
                                                       wire:model="reference_3_attachment">

                                            </div>


                                    </div>
                                </div>





                            </div>
                        </div>
                    </div>

                    <!-- /.card -->


            </div>
            </div>


            <div class="card card-primary">
                <div class="card-header pb-0 mb-0 ">
                    <h6>Diplomas & Certificates</h6>
                </div>
                <div class="card-body">

                        {{-- Diploma/Cert 1 field --}}
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#accord_dipcert1">
                                    <h6>Diploma/Certificate #1</h6>
                                </button>
                            </h2>
                            <div id="accord_dipcert1" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <label for="resume">Attachment</label>
                                            <p>

                                            @if ($diploma_certificate_1_attachment)
                                                <div class="col-md-12 pb-3">
                                                    <div class="row">

                                                        @if (!str_contains($diploma_certificate_1_attachment,"/var/folders"))

                                                            <a href="{{asset('/storage/' . substr($diploma_certificate_1_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($diploma_certificate_1_attachment,7))}}?{{ rand() }}"></a>
                                                        @endif
                                                        <br />
                                                    </div>
                                                </div>
                                                @endif
                                                </p>
                                                <div>
                                                    <input type="file" class="mt-3" name="diploma_certificate_1_attachment"
                                                           id="diploma_certificate_1_attachment"

                                                           class="form-control"  wire:model="diploma_certificate_1_attachment">
                                                </div>

                                        </div>

                                    </div>
                            </div>

                            </div>
                        </div>
                    </div>
                    {{-- *Diploma/Cert 1 field --}}


                    {{-- Diploma/Cert 2 field --}}
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#accord_dipcert_2">
                                    <h6>Diploma/Certificate #2</h6>
                                </button>
                            </h2>
                            <div id="accord_dipcert_2" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <label for="resume">Attachment</label>
                                            <p>

                                            @if ($diploma_certificate_2_attachment)
                                                <div class="col-md-12 pb-3">
                                                    <div class="row">

                                                        @if (!str_contains($diploma_certificate_2_attachment,"/var/folders"))

                                                            <a href="{{asset('/storage/' . substr($diploma_certificate_2_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($diploma_certificate_2_attachment,7))}}?{{ rand() }}"></a>
                                                        @endif
                                                        <br />
                                                    </div>
                                                </div>
                                                @endif
                                                </p>
                                                <div>
                                                    <input type="file" class="mt-3" name="diploma_certificate_2_attachment"
                                                           id="diploma_certificate_2_attachment"

                                                           class="form-control"  wire:model="diploma_certificate_2_attachment">
                                                </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- *Diploma/Cert 2 field --}}



                    {{-- Diploma/Cert 3 field --}}
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#accord_dipcert_3">
                                    <h6>Diploma/Certificate #3</h6>
                                </button>
                            </h2>
                            <div id="accord_dipcert_3" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <label for="resume">Attachment</label>
                                            <p>

                                            @if ($diploma_certificate_3_attachment)
                                                <div class="col-md-12 pb-3">
                                                    <div class="row">

                                                        @if (!str_contains($diploma_certificate_3_attachment,"/var/folders"))

                                                            <a href="{{asset('/storage/' . substr($diploma_certificate_3_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($diploma_certificate_3_attachment,7))}}?{{ rand() }}"></a>
                                                        @endif
                                                        <br />
                                                    </div>
                                                </div>
                                                @endif
                                                </p>
                                                <div>
                                                    <input type="file" class="mt-3" name="diploma_certificate_3_attachment"
                                                           id="diploma_certificate_3_attachment"

                                                           class="form-control"  wire:model="diploma_certificate_3_attachment">
                                                </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- *Diploma/Cert 3 field --}}


                    {{-- Diploma/Cert_4 field --}}
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#accord_dipcert_4">
                                    <h6>Diploma/Certificate #4</h6>
                                </button>
                            </h2>
                            <div id="accord_dipcert_4" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <label for="resume">Attachment</label>
                                            <p>

                                            @if ($diploma_certificate_4_attachment)
                                                <div class="col-md-12 pb-3">
                                                    <div class="row">

                                                        @if (!str_contains($diploma_certificate_4_attachment,"/var/folders"))

                                                            <a href="{{asset('/storage/' . substr($diploma_certificate_4_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($diploma_certificate_4_attachment,7))}}?{{ rand() }}"></a>
                                                        @endif
                                                        <br />
                                                    </div>
                                                </div>
                                                @endif
                                                </p>
                                                <div>
                                                    <input type="file" class="mt-3" name="diploma_certificate_4_attachment"
                                                           id="diploma_certificate_4_attachment"

                                                           class="form-control"  wire:model="diploma_certificate_4_attachment">
                                                </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- *Diploma/Cert_4 field --}}

                        {{-- Diploma/Cert 5 field --}}
                    {{-- Diploma/Cert_5 field --}}
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#accord_dipcert_5">
                                    <h6>Diploma/Certificate #5</h6>
                                </button>
                            </h2>
                            <div id="accord_dipcert_5" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <label for="resume">Attachment</label>
                                            <p>

                                            @if ($diploma_certificate_5_attachment)
                                                <div class="col-md-12 pb-3">
                                                    <div class="row">

                                                        @if (!str_contains($diploma_certificate_5_attachment,"/var/folders"))

                                                            <a href="{{asset('/storage/' . substr($diploma_certificate_5_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($diploma_certificate_5_attachment,7))}}?{{ rand() }}"></a>
                                                        @endif
                                                        <br />
                                                    </div>
                                                </div>
                                                @endif
                                                </p>
                                                <div>
                                                    <input type="file" class="mt-3" name="diploma_certificate_5_attachment"
                                                           id="diploma_certificate_5_attachment"

                                                           class="form-control"  wire:model="diploma_certificate_5_attachment">
                                                </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                {{-- *Diploma/Cert_5 field --}}

                    </div>
            </div>



            <div class="card card-primary">
                <div class="card-header pb-0 mb-0 ">
                    <h5 >Criminal Reference Checks</h6>
                </div>
                <div class="card-body">
                   <!-- CrimRef_1 -->
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#crim_1">
                                    <h6>Criminal Reference Check #1</h6>

                                </button>
                            </h2>
                            <div id="crim_1" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="card-body">

                                        <div class="input-group mb-3">
                                          <label for="resume">Attachment</label>
                                <p>

                                @if ($criminal_reference_1_attachment)
                                    <div class="col-md-12 pb-3">
                                        <div class="row">

                                            @if (!str_contains($criminal_reference_1_attachment,"/var/folders"))

                                                <a href="{{asset('/storage/' . substr($criminal_reference_1_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($criminal_reference_1_attachment,7))}}?{{ rand() }}"></a>
                                            @endif
                                                <br />
                                        </div>
                                    </div>
                                    @endif
                                    </p>
                                    <div>
                                        <input type="file" class="mt-3" name="criminal_reference_1_attachment"
                                               id="criminal_reference_1_attachment"

                                               class="form-control"  wire:model="criminal_reference_1_attachment">
                                    </div>

                            </div>

                        </div>

                                </div>
                    </div>
                        </div>
                    </div>
                    <!-- *CrimRef_1 -->

                    <!-- CrimRef_2 -->
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#crim_2">
                                    <h6>Criminal Reference Check #2</h6>

                                </button>
                            </h2>
                            <div id="crim_2" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="card-body">

                                        <div class="input-group mb-3">
                                            <label for="resume">Attachment</label>
                                            <p>

                                            @if ($criminal_reference_2_attachment)
                                                <div class="col-md-12 pb-3">
                                                    <div class="row">

                                                        @if (!str_contains($criminal_reference_2_attachment,"/var/folders"))

                                                            <a href="{{asset('/storage/' . substr($criminal_reference_2_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($criminal_reference_2_attachment,7))}}?{{ rand() }}"></a>
                                                        @endif
                                                        <br />
                                                    </div>
                                                </div>
                                                @endif
                                                </p>
                                                <div>
                                                    <input type="file" class="mt-3" name="criminal_reference_2_attachment"
                                                           id="criminal_reference_2_attachment"

                                                           class="form-control"  wire:model="criminal_reference_2_attachment">
                                                </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- *CrimRef_2 -->

                </div>
            </div>

        {{-- Carpe Diem --}}
        <div class="card card-primary">
            <div class="card-header pb-0 mb-0 ">
                <h6>Carpe Diem</h6>
            </div>
            <div class="card-body">
                {{-- Proof of Covid 19 Vaccination --}}
                <div class="accordion" wire:ignore>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#covid19">
                                <h6>Proof of COVID-19 Vaccination</h6>

                            </button>
                        </h2>
                        <div id="covid19" class="accordion-collapse collapse" data-bs-parent="">
                            <div class="accordion-body">
                                <div class="card-body">

                                    <div class="input-group mb-3">
                                        <label for="resume">Attachment</a>
                                        </label>
                                        <p>

                                        @if ($covid19_proof_of_vaccination)
                                            <div class="col-md-12">
                                                <div class="row">

                                                    @if (!str_contains($covid19_proof_of_vaccination,"/var/folders"))

                                                        <a href="{{asset('/storage/' . substr($covid19_proof_of_vaccination,7))}}"><img height="120px" src="{{asset('/storage/' . substr($covid19_proof_of_vaccination,7))}}?{{ rand() }}"></a>
                                                    @endif
                                                    <br />
                                                </div>
                                            </div>
                                            @endif
                                            </p>
                                            <div>
                                                <input type="file" class="mt-3"
                                                       name="covid19_proof_of_vaccination"
                                                       id="covid19_proof_of_vaccination"
                                                       class="form-control" wire:model="covid19_proof_of_vaccination">
                                            </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- *Proof of Covid 19 Vaccination --}}

                {{-- Banking Information --}}
                <div class="accordion" wire:ignore>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#bank">
                                <h6>Banking Information</h6>
                            </button>
                        </h2>
                        <div id="bank" class="accordion-collapse collapse" data-bs-parent="">
                            <div class="accordion-body">
                                <div class="input-group mb-3">
                                    <input type="text" name="bank_name"
                                           class="form-control" placeholder="Name of Bank"
                                           wire:model="bank_name" >
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                            <span
                                                                class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- reference_1_phone field --}}
                                <div class="input-group mb-3">
                                    <input type="text" name="transit"
                                           class="form-control" placeholder="Transit Number"
                                           wire:model="transit" >
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                            <span
                                                                class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- reference_1_email field --}}
                                <div class="input-group mb-3">
                                    <input type="text" name="institution"
                                           class="form-control" placeholder="Institution Number"
                                           wire:model="institution" >
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                            <span
                                                                class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- reference_1_attachment field --}}
                                <div class="input-group mb-3">
                                    <input type="text" name="account_number"
                                           class="form-control" placeholder="Account Number"
                                           wire:model="account_number" >
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                            <span
                                                                class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label for="resume">Attachment</a>
                                    </label>
                                    <p>

                                    @if ($banking_attachment)
                                        <div class="col-md-12">
                                            <div class="row">

                                                @if (!str_contains($banking_attachment,"/var/folders"))

                                                    <a href="{{asset('/storage/' . substr($banking_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($banking_attachment,7))}}?{{ rand() }}"></a>
                                                @endif
                                                <br />
                                            </div>
                                        </div>
                                        @endif
                                        </p>
                                        <div>
                                            <input type="file" class="mt-3"
                                                   name="banking_attachment"
                                                   id="banking_attachment"
                                                   class="form-control" wire:model="banking_attachment">
                                        </div>

                                </div>
                            </div>





                        </div>
                    </div>
                </div>
                {{-- *Banking Information --}}

                {{-- Carpe Diem Confidentiality Agreement field --}}
                    <div class="accordion" wire:ignore>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#confidentiality">
                                    <h6>Confidentiality Agreement</h6>

                                </button>
                            </h2>
                            <div id="confidentiality" class="accordion-collapse collapse" data-bs-parent="">
                                <div class="accordion-body">
                                    <div class="card-body">

                                        <div class="input-group mb-3">
                                            <label for="resume"><a href="/reference_attachments/STATEMENT OF CONFIDENTIALITY.doc">Confidentiality Agreement</a>
                                            </label>
                                            <p>

                                            @if ($carpe_diem_confidentiality_attachment)
                                                <div class="col-md-12">
                                                    <div class="row">

                                                        @if (!str_contains($carpe_diem_confidentiality_attachment,"/var/folders"))

                                                            <a href="{{asset('/storage/' . substr($carpe_diem_confidentiality_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($reference_1_attachment,7))}}?{{ rand() }}"></a>
                                                        @endif
                                                        <br />
                                                    </div>
                                                </div>
                                                @endif
                                                </p>
                                                <div>
                                                    <input type="file" class="mt-3"
                                                           name="carpe_diem_confidentiality_attachment"
                                                           id="carpe_diem_confidentiality_attachment"
                                                           class="form-control" wire:model="carpe_diem_confidentiality_attachment">
                                                </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                {{-- *Carpe Diem Confidentiality Agreement field --}}

                {{-- carpe_diem_release_information_attachment field --}}
                <div class="accordion" wire:ignore>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#release">
                                <h6>Release Information</h6>

                            </button>
                        </h2>
                        <div id="release" class="accordion-collapse collapse" data-bs-parent="">
                            <div class="accordion-body">
                                <div class="card-body">

                                    <div class="input-group mb-3">
                                        <label for="resume"><a href="/reference_attachments/CHILDWELFAREAGENCYRECORDCHECK[1].doc">Release Information</a></label>
                                        <p>

                                        @if ($carpe_diem_release_information_attachment)
                                            <div class="col-md-12">
                                                <div class="row">
                                                    @if (!str_contains($carpe_diem_release_information_attachment,"/var/folders"))

                                                        <a href="{{asset('/storage/' . substr($carpe_diem_release_information_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($carpe_diem_release_information_attachment,7))}}?{{ rand() }}"></a>
                                                    @endif
                                                    <br />
                                                </div>
                                            </div>
                                            @endif
                                            </p>
                                            <div>
                                                <input type="file" class="mt-3"
                                                       name="carpe_diem_release_information_attachment"
                                                       id="carpe_diem_release_information_attachment"
                                                       class="form-control" wire:model="carpe_diem_release_information_attachment">
                                            </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- *carpe_diem_release_information_attachment field --}}

                {{-- child_welfare_check_attachment field --}}
                <div class="accordion" wire:ignore>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#childwelfare">
                                <h6>Child Welfare Check</h6>

                            </button>
                        </h2>
                        <div id="childwelfare" class="accordion-collapse collapse" data-bs-parent="">
                            <div class="accordion-body">
                                <div class="card-body">

                                    <div class="input-group mb-3">
                                        <label for="resume"><a href="/reference_attachments/Child Welfare Record Check Consent Form - Employee Record Check.docx">Child Welfare Check</a></label>
                                        <p>

                                        @if ($child_welfare_check_attachment)
                                            <div class="col-md-12">
                                                <div class="row">
                                                    @if (!str_contains($child_welfare_check_attachment,"/var/folders"))

                                                        <a href="{{asset('/storage/' . substr($child_welfare_check_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($child_welfare_check_attachment,7))}}?{{ rand() }}"></a>
                                                    @endif
                                                    <br />
                                                </div>
                                            </div>
                                            @endif
                                            </p>
                                            <div>
                                                <input type="file" class="mt-3" name="child_welfare_check_attachment"
                                                       id="child_welfare_check_attachment"
                                                       class="form-control"  wire:model="child_welfare_check_attachment">
                                            </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- *child_welfare_check_attachment field --}}
            </div>





        </div>



        {{-- Driver/Vehicle Information --}}

        <div class="card card-primary">
            <div class="card-header pb-0 mb-0 ">
                <h5 >Driver/Vehicle Information</h6>
            </div>
            <div class="card-body">
                <!-- Driver's License -->
                <div class="accordion" wire:ignore>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#drivers">
                                <h6>Driver's License</h6>

                            </button>
                        </h2>
                        <div id="drivers" class="accordion-collapse collapse" data-bs-parent="">
                            <div class="accordion-body">
                                <div class="card-body">

                                            <div class="input-group mb-3">
                                                <label for="resume">Front Attachment</label>
                                                <p>

                                                @if ($drivers_license_front_attachment)
                                                    <div class="col-md-12 pb-3">
                                                        <div class="row">

                                                            @if (!str_contains($drivers_license_front_attachment,"/var/folders"))

                                                                <a href="{{asset('/storage/' . substr($drivers_license_front_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($drivers_license_front_attachment,7))}}?{{ rand() }}"></a>
                                                            @endif
                                                            <br />
                                                        </div>
                                                    </div>
                                                    @endif
                                                    </p>
                                                    <div>
                                                        <input type="file" class="mt-3" name="drivers_license_front_attachment"
                                                               id="drivers_license_front_attachment"

                                                               class="form-control"  wire:model="drivers_license_front_attachment">
                                                    </div>

                                            </div>
                                            <div class="input-group mb-3">
                                                <label for="resume">Back Attachment</label>
                                                <p>

                                                @if ($drivers_license_back_attachment)
                                                    <div class="col-md-12 pb-3">
                                                        <div class="row">

                                                            @if (!str_contains($drivers_license_back_attachment,"/var/folders"))

                                                                <a href="{{asset('/storage/' . substr($drivers_license_back_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($drivers_license_back_attachment,7))}}?{{ rand() }}"></a>
                                                            @endif
                                                            <br />
                                                        </div>
                                                    </div>
                                                    @endif
                                                    </p>
                                                    <div>
                                                        <input type="file" class="mt-3" name="drivers_license_back_attachment"
                                                               id="drivers_license_back_attachment"

                                                               class="form-control"  wire:model="drivers_license_back_attachment">
                                                    </div>

                                            </div>
                                        </div>






                            </div>
                        </div>
                    </div>
                </div>
                <!-- *Driver's License -->

                <!-- Photo ID #2 -->
                <div class="accordion" wire:ignore>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#second_photo_id">
                                <h6>Photo ID #2</h6>

                            </button>
                        </h2>

                        <div id="second_photo_id" class="accordion-collapse collapse" data-bs-parent="">
                            <div class="accordion-body">
                                <div class="card-body">

                                         <div class="input-group mb-3">
                                                <label for="resume">Front Attachment</label>
                                                <p>

                                                @if ($photo_id_2_front_attachment)
                                                    <div class="col-md-12 pb-3">
                                                        <div class="row">

                                                            @if (!str_contains($photo_id_2_front_attachment,"/var/folders"))

                                                                <a href="{{asset('/storage/' . substr($photo_id_2_front_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($photo_id_2_front_attachment,7))}}?{{ rand() }}"></a>
                                                            @endif
                                                            <br />
                                                        </div>
                                                    </div>
                                                    @endif
                                                    </p>
                                                    <div>
                                                        <input type="file" class="mt-3" name="photo_id_2_front_attachment"
                                                               id="photo_id_2_front_attachment"

                                                               class="form-control"  wire:model="photo_id_2_front_attachment">
                                                    </div>

                                            </div>
                                            <div class="input-group mb-3">
                                                <label for="resume">Back Attachment</label>
                                                <p>

                                                @if ($photo_id_2_back_attachment)
                                                    <div class="col-md-12 pb-3">
                                                        <div class="row">

                                                            @if (!str_contains($photo_id_2_back_attachment,"/var/folders"))

                                                                <a href="{{asset('/storage/' . substr($photo_id_2_back_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($photo_id_2_back_attachment,7))}}?{{ rand() }}"></a>
                                                            @endif
                                                            <br />
                                                        </div>
                                                    </div>
                                                    @endif
                                                    </p>
                                                    <div>
                                                        <input type="file" class="mt-3" name="photo_id_2_back_attachment"
                                                               id="photo_id_2_back_attachment"

                                                               class="form-control"  wire:model="photo_id_2_back_attachment">
                                                    </div>

                                            </div>
                                        </div>




                                    </div>
                                </div>

                            </div>
                        </div>

                <!-- *Photo ID #2 -->

                <!-- Insurance -->
                <div class="accordion" wire:ignore>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#insurance">
                                <h6>Insurance</h6>

                            </button>
                        </h2>
                        <div id="insurance" class="accordion-collapse collapse" data-bs-parent="">
                            <div class="accordion-body">
                                <div class="card-body">

                                      <div class="input-group mb-3">
                                                <label for="resume">Front Attachment</label>

                                                <p>

                                                @if ($auto_insurance_front_attachment)
                                                    <div class="col-md-12 pb-3">
                                                        <div class="row">

                                                            @if (!str_contains($auto_insurance_front_attachment,"/var/folders"))

                                                                <a href="{{asset('/storage/' . substr($auto_insurance_front_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($auto_insurance_front_attachment,7))}}?{{ rand() }}"></a>
                                                            @endif
                                                            <br />
                                                        </div>
                                                    </div>
                                                    @endif
                                                    </p>
                                                    <div>
                                                        <input type="file" class="mt-3" name="auto_insurance_front_attachment"
                                                               id="auto_insurance_front_attachment"

                                                               class="form-control"  wire:model="auto_insurance_front_attachment">
                                                    </div>

                                            </div>

                                            <div class="input-group mb-3">
                                                <label for="resume">Back Attachment</label>
                                                <p>

                                                @if ($auto_insurance_back_attachment)
                                                    <div class="col-md-12 pb-3">
                                                        <div class="row">

                                                            @if (!str_contains($auto_insurance_back_attachment,"/var/folders"))

                                                                <a href="{{asset('/storage/' . substr($auto_insurance_back_attachment,7))}}"><img height="120px" src="{{asset('/storage/' . substr($auto_insurance_back_attachment,7))}}?{{ rand() }}"></a>
                                                            @endif
                                                            <br />
                                                        </div>
                                                    </div>
                                                    @endif
                                                    </p>
                                                    <div>
                                                        <input type="file" class="mt-3" name="auto_insurance_back_attachment"
                                                               id="auto_insurance_back_attachment"

                                                               class="form-control"  wire:model="auto_insurance_back_attachment">
                                                    </div>

                                            </div>

                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>

                <!-- *Insurance -->

                <!-- Vehicle Information -->
                <div class="accordion" wire:ignore>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#vehicle">
                                <h6>Vehicle Information</h6>

                            </button>
                        </h2>
                        <div id="vehicle" class="accordion-collapse collapse" data-bs-parent="">
                            <div class="accordion-body">

                                        <div class="card-body">
                                            {{-- auto_year field --}}
                                            <div class="input-group mb-3">
                                                <input type="text" name="auto_year"
                                                       class="form-control" placeholder="Year"
                                                       wire:model="auto_year" >

                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span
                                                            class="fas fa-car {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                    </div>
                                                </div>

                                            </div>

                                            {{-- auto_make field --}}
                                            <div class="input-group mb-3">
                                                <input type="text" name="auto_make"
                                                       class="form-control" placeholder="Make"
                                                       wire:model="auto_make" >

                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span
                                                            class="fas fa-car {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                    </div>
                                                </div>

                                            </div>


                                            {{-- auto_model field --}}
                                            <div class="input-group mb-3">
                                                <input type="text" name="auto_model"
                                                       class="form-control" placeholder="Model"
                                                       wire:model="auto_model" >

                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span
                                                            class="fas fa-car {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                    </div>
                                                </div>

                                            </div>

                                            {{-- auto_liability field --}}
                                            <div class="input-group mb-3">
                                                <input type="text" name="auto_liability"
                                                       class="form-control" placeholder="Amount of Liability"
                                                       wire:model="auto_liability" >

                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span
                                                            class="fas fa-dollar-sign {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>

                <!-- *Vehicle Information -->
            </div>
        </div>

        {{-- Register button --}}
        <button type="submit"
                class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-save"></span>
            Update My CYSW Profile
        </button>

    </form>
</div>
