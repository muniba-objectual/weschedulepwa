<div class="container-fluid">
    <script src="/mobilekit/assets/js/lib/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/4.0.5/jquery.inputmask.bundle.min.js" integrity="sha512-WqFqsIEivpngtX91GcAfg1BcmlPLAG4s0SnPeNm0T5imigMK7yWD+DwDqJXwGXem06vZVK1cd1nd5CnWb/kxsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet"/>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <!-- add to document <head> -->

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

    <link
        href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet"
    />

    <!-- add before </body> -->

    <script src="https://unpkg.com/filepond-plugin-pdf-preview@1.0.4/dist/filepond-plugin-pdf-preview.min.js"></script>
    <link href="https://unpkg.com/filepond-plugin-pdf-preview@1.0.4/dist/filepond-plugin-pdf-preview.min.css" rel="stylesheet">

    <script src="/filepond-plugin-get-file-1.0.3/dist/filepond-plugin-get-file.js"></script>
    <link
        href="/filepond-plugin-get-file-1.0.3/dist/filepond-plugin-get-file.css"
        rel="stylesheet"
    />
    <script src="/filepond-plugin-image-overlay-master/dist/filepond-plugin-image-overlay.js"></script>
    <link
        href="/filepond-plugin-image-overlay-master/dist/filepond-plugin-image-overlay.css"
        rel="stylesheet"
    />


    {{--   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js" integrity="sha512-jTgBq4+dMYh73dquskmUFEgMY5mptcbqSw2rmhOZZSJjZbD2wMt0H5nhqWtleVkyBEjmzid5nyERPSNBafG4GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  --}}
{{--    <script src="/AnnotatorJS/annotator-full.min.js"></script>--}}
{{--    <link rel="stylesheet" href="/AnnotatorJS/annotator.min.css">--}}

@if(session('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{session('message')}}
        </div>
    @endif

    <style>
        .current-user {
            /* text-align: right; */
            /* background-color: #ccc; */
            display: flex;
            flex-wrap: wrap;
            justify-content: end;
            margin-bottom: 20px;
            align-items: center;
        }
        .inner_c_wrapper {
            margin-left: 10px;
            margin-right: 10px;
            background: #248bf5;
            border: 0px solid;
            padding: 5px 15px 20px;
            min-width: 40%;
            display: block;
            flex-wrap: wrap;
            flex-direction: column;
            position: relative;
            /* align-items: center; */
            justify-content: unset;
            border-radius: 14px;
        }
        p.message_text {
            font-size: 16px;
            line-height: 16px;
        }
        p.info_text {
            font-size: 10px;
            margin-bottom: 0px;
            position: absolute;
            bottom: 5px;
            right: 10px;
            font-weight:700;
        }
        .message_board {
            height: 350px;
            overflow-y: scroll;
            padding-top: 10px;
            background: #fff;
        }
        .other-user {
            display: flex;
            flex-wrap: wrap;
            justify-content: start;
            margin-bottom: 20px;
            align-items: center;
        }
        .inner_o_wrapper {
            margin-left: 10px;
            margin-right: 10px;
            border: 0px solid;
            /* width: auto; */
            padding: 5px 15px 20px;
            min-width: 40%;
            /* height: 48px; */
            display: block;
            flex-wrap: wrap;
            flex-direction: column;
            position: relative;
            /* align-items: center; */
            justify-content: unset;
            background: #e5e5ea;
            border-radius: 14px;
        }
        .inner_o_wrapper .info_text {
            left: 10px;
        }
        .inner_c_wrapper p {
            color: #fff;
        }
        .inner_c_wrapper::after {
            content: "p";
            position: absolute;
            bottom: 2px;
            right: 0px;
            width: 10px;
            height: 10px;
            font-size: 0px;
            background: #248bf5;
            transform: rotate(79deg);

        }
        .inner_o_wrapper::after {
            content: "p";
            position: absolute;
            bottom: 2px;
            left: -1px;

            width: 10px;

            height: 10px;
            font-size: 0px;
            background: #e5e5ea;
            transform: rotate(96deg);

        }
        .console_board input {
            background: #34b7f1;
            border: 0px solid;
            color: #fff;
            padding: 5px 37px;
            font-size: 13px;
            width: 100%;
        }
        .console_board textarea {
            width: 100%;
            border: 0px;
            padding: 10px;
        }
        .console_board {
            background: #e5e5ea;
            padding: 10px;
        }
        .chat-date {
            background-color: #e5e5ea;
            text-align: center;
            color: #000;
            border-radius: 5px;
            font-size: 12px;
            padding: 5px 0px;
        }
        .date-box{
            width:25%;
            margin:auto;
            border-radius:20px;
        }

        filepond--item {
            width: calc(50% - 0.5em);
        }

        .filepond--root {
            /*max-height: 10em;*/
        }

        .main-sidebar {
            z-index: auto !important;
        }
    </style>


    {{--
        <form method="POST" action="" wire:submit.prevent="submitImages">
            @csrf

            <x-media-library-collection
                name="images"
                :model="$FPAForm"
                collection="images"
            />



            <button type="submit">Submit</button>
        </form>
        --}}



        <input type="hidden" id="type" name="type" value="update" required>

    <div class="row">
            <div class="col-6">
        <div class="card card-primary" id="box_personal_information" >

            <div id='hdr_countme_personal_information' class="card-header pb-0 mb-0 ">
                <h6>Primary Foster Parent</h6>
            </div>
            <div class="card-body" style="margin-bottom:0px !important;">
                <div class="progress countme_personal_information  mb-2" style="height: 20px" >
                    <div wire:ignore class="progress-bar countme_personal_information" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>


                {{-- primary_caregiver_fullname field --}}

                <label for="primary_caregiver_fullname">Full Name (As appears on Applicant's Driver's License)</label>

                <div class="input-group mb-3">

                    <input type="text" name="primary_caregiver_fullname"
                            id="primary_caregiver_fullname"
                           class="form-control countme_personal_information"
                           placeholder="Applicant's Full Name" wire:model="FPAForm.primary_caregiver_fullname">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                {{-- preferred_name field --}}
                <label for="mailing_address">Mailing Address</label>

                <div class="input-group mb-3">

                    <input type="text" name="mailing_address" id="address"

                           class="form-control countme_personal_information"
                           placeholder="Mailing Address" wire:model="FPAForm.mailing_address">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-address-book {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                {{-- City field --}}
                <label for="city">City</label>
                <div class="input-group mb-3">

                    <input type="text" name="city" id="city"

                           class="form-control countme_personal_information"
                           placeholder="City" wire:model="FPAForm.city">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-address-book {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                {{-- Province field --}}
                <label for="province">Province</label>
                <div class="input-group mb-3">

                    <input type="text" name="province" id="province"

                           class="form-control countme_personal_information"
                           placeholder="Province" wire:model="FPAForm.province">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-address-book {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                {{-- Postal Code field --}}
                <label for="postal_code">Postal Code</label>

                <div class="input-group mb-3">

                    <input type="text" name="postal_code" id="postal_code"
                          class="form-control countme_personal_information"
                           placeholder="Postal Code" wire:model="FPAForm.postal_code">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-map-marker-alt {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                {{-- Email  field --}}
                <label for="email">Email Address</label>

                <div class="input-group mb-3">

                    <input type="text" name="email" id="email"
                           class="form-control countme_personal_information"
                           placeholder="Email Address" wire:model.lazy="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>


                {{-- Telephone  field --}}
                <label for="telephone">Telephone Number</label> <button class="btn-sm btn-primary mb-3" wire:click.prevent="addAdditionalTelephoneNumber()">+ Additional Telephone Number</button>


                    <div class="input-group mb-3">

                    <input type="text" name="telephone" id="telephone"
                           class="form-control countme_personal_information"
                           placeholder="Phone Number" wire:model="telephone">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>

                @foreach ($additional_telephone_numbers as $key=>$additional)
                    <div class="d-flex justify-content-center mb-3">

                        <div class="col">

                            <label>Telephone Number</label>
                            <input type="text" name="telephone" id="telephone"
                                   class="form-control countme_personal_information additional_telephone"
                                   placeholder="Phone Number" wire:model="FPAForm.additional_telephone_numbers.{{$key}}.telephone" key="{{$key}}">
                        </div>

                        <div class="col">
                            <label>Type</label>
                            <select name="additional_telephone_type" id="additional_telephone_type"
                                    class="form-control countme_personal_information" wire:model="FPAForm.additional_telephone_numbers.{{$key}}.type">
                                <option value="">Please Select...</option>

                                <option value="Home">Home</option>
                                <option value="Office">Office</option>
                                <option value="Cell">Cell</option>
                                <option value="Other">Other</option>

                            </select>
                        </div>


                    </div>

                        <div class="d-flex justify-content-center">
                                <button class="btn btn-sm btn-danger mb-3" wire:click.prevent="removeAdditionalTelephoneNumber({{$key}})">REMOVE TELEPHONE NUMBER</button>
                        </div>


                @endforeach


                {{-- Type of Family  field --}}
                <label for="type_of_family">Type of Family</label>

                <div class="input-group mb-3">

                    <select name="type_of_family"
                           class="form-control countme_personal_information"
                           placeholder="Type of Family" wire:model="FPAForm.type_of_family">
                        <option value="">Please Select...</option>
                        <option value="Single">Single</option>
                        <option value="Couple">Couple</option>
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-info {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>


                {{-- Country of Birth  field --}}
                <label for="country_of_birth">Country of Birth</label>

                <div class="input-group mb-3">

                    <input type="text" name="country_of_birth"
                           class="form-control countme_personal_information"
                           placeholder="Country of Birth" wire:model="FPAForm.country_of_birth">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-info {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>


                {{-- City of Birth  field --}}
                <label for="city_of_birth">City of Birth</label>

                <div class="input-group mb-3">

                    <input type="text" name="city_of_birth"
                           class="form-control countme_personal_information"
                           placeholder="City of Birth" wire:model="FPAForm.city_of_birth">
                    <div class="input-group-append">
                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-info {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                </div>


            </div>
        </div>
        </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header" style="margin-bottom: 0px !important;">
                        <h6>Primary Foster Parent - Notes</h6>
                    </div>
                    <div class="card-body">
                    @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'personal_information_notes', 'FPAForm' => $FPAForm, 'rows' => 745])
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary" id="box_family_composition">
                <div class="card-header pb-0 mb-0" id="hdr_countme_family_composition">
                    <h6>Family Composition <!--(Select number of family members:) <select id="numberFamilyMembers" name="numberFamilyMembers">
                            <option value="1">1</option>
                            <option selected value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>

                        </select>--></h6>
                </div>
                <div class="card-body" style="margin-bottom:13px !important;">

                    <div class="progress countme_family_composition  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_family_composition" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>




                    {{-- Add Form --}}
                    <h5 class="text-primary">PRIMARY FOSTER PARENT</h5>
                    @if ($inputs)
                        @foreach ($inputs as $key => $value)

                            @if ($key == 0)

                                <div class="d-flex justify-content-start mb-3">

                                    <div class="col-6">
                                        <label for="family_members-{{$key}}-surname_given_name">Name</label>
                                        <input disabled class="countme_family_composition form-control" type="text" wire:model="FPAForm.family_members.{{$key}}.surname_given_name" placeholder="Full Name"  name="family_members-{{$key}}-surname_given_name" />
                                    </div>
                                    <div class="col-4">
                                        <label for="family_members-{{$key}}-age_DOB">Date of Birth</label>
                                        <input class="countme_family_composition DOB form-control" type="text" id="family_members-{{$key}}-age_DOB" wire:model.lazy="FPAForm.family_members.{{$key}}.age_DOB" placeholder="Date of Birth" name="family_members-{{$key}}-age_DOB" key="{{$key}}" value="{{ old('family_members['.$key.'][age_DOB]') }}"  size="12">
                                    </div>
                                    <div class="col-2">
                                        <label for="DOB_ageCalc_{{$key}}">Age</label>
                                        <input class="form-control" disabled type="text" id="DOB_ageCalc_{{$key}}" wire:model="DOB_ageCalc.{{$key}}" size="2" />
                                    </div>

                                </div>
                                    <div class="col-6 mt-3 mb-3">
                                    {{-- Relationship  field --}}
                                    <label for="relationship">Relationship to Family Unit</label>



                                        <select name="relationship"
                                                class="form-control countme_personal_information"
                                                placeholder="Relationship" wire:model="FPAForm.relationship">
                                            <option value="">Please Select...</option>
                                            <option value="Mother">Mother</option>
                                            <option value="Grandmother">Grandmother</option>
                                            <option value="Father">Father</option>
                                            <option value="Grandfather">Grandfather</option>
                                            <option value="Daughter">Daughter</option>
                                            <option value="Son">Son</option>
                                            <option value="Uncle">Uncle</option>
                                            <option value="Aunt">Aunt</option>
                                            <option value="Cousin">Cousin</option>
                                            <option value="Other">Other</option>
                                        </select>




                                </div>
                                <x-adminlte-card class="attachments" title="Attachments" theme="secondary" theme-mode="" icon="fas fa-lg fa-file-circle-plus"
                                                 collapsible="collapsed" header-class="mt-0" id="family_composition_primary_attachments">

                                        @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'multiple' => false, 'key' => "child_welfare_check_" . "primary", 'familyMemberID' => '', 'section'=>'Child Welfare Record Check'], key("child_welfare_record_check_" . "primary"))

                                    <div class="row">

                                        @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "criminal_record_check_" . "primary", 'section'=>'Criminal Record Check with VSS'], key("criminal_reference_check_" . "primary"))
                                    </div>

                                    <div class="row">

                                        @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "medical_" . "primary", 'section'=>'Medical'], key("medical_" . "primary"))
                                    </div>
                                </x-adminlte-card>


                            @endif

                        @endforeach
                            <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary mb-3" wire:click.prevent="addSecondary()">+ SECONDARY FAMILY MEMBER</button>

                                </div>


                        @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))

                            <h5 class="text-primary mt-3">SECONDARY FOSTER PARENT</h5>
                            @foreach ($inputs as $key => $value)
                                @if ($key > 0 && $value['role'] == "secondary")
                                    <div class="row mb-3">

                                        <div class="d-flex justify-content-start">

                                            <div class="col-6">
                                                <label for="family_members-{{$key}}-surname_given_name">Name</label>
                                                <input  class="countme_family_composition form-control" type="text" wire:model="FPAForm.family_members.{{$key}}.surname_given_name" placeholder="Full Name"  name="family_members-{{$key}}-surname_given_name" />
                                            </div>
                                            <div class="col-4">
                                                <label for="family_members-{{$key}}-age_DOB">Date of Birth</label>
                                                <input class="countme_family_composition DOB form-control" type="text" id="family_members-{{$key}}-age_DOB" wire:model.lazy="FPAForm.family_members.{{$key}}.age_DOB" placeholder="Date of Birth" name="family_members-{{$key}}-age_DOB" key="{{$key}}" value="{{ old('family_members['.$key.'][age_DOB]') }}"  size="12">
                                            </div>
                                            <div class="col-2">
                                                <label for="DOB_ageCalc_{{$key}}">Age</label>
                                                <input class="form-control" disabled type="text" id="DOB_ageCalc_{{$key}}" wire:model="DOB_ageCalc.{{$key}}" size="2" />
                                            </div>
                                        </div>

                                        <div class="row mt-3">

                                        <div class="d-flex justify-content-start mb-3">

                                                    <div class="col-5">
                                                        <label for="family_members-{{$key}}-secondary-email">E-mail Address</label>

                                                        <input class="countme_family_composition secondary_email" type="text" id="family_members-{{$key}}-secondary_email_address" wire:model.lazy="FPAForm.family_members.{{$key}}.secondary_email" placeholder="Email Address" name="family_members-{{$key}}-secondary_email" key="{{$key}}" class="form-control" value="{{ old('family_members['.$key.'][secondary_email]') }}"  size="20">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="family_members-{{$key}}-secondary_telephone">Telephone Number</label>

                                                        <input class="countme_family_composition secondary_telephone" type="text" id="family_members-{{$key}}-secondary_telephone" wire:model.lazy="FPAForm.family_members.{{$key}}.secondary_telephone" placeholder="Telephone Number" name="family_members-{{$key}}-secondary_telephone" key="{{$key}}" class="form-control" value="{{ old('family_members['.$key.'][secondary_telephone]') }}"  size="20">
                                                    </div>
                                            </div>



                                                </div>

                                            </div>

                                        @if ($DOB_ageCalc[$key] >= 18)
                                            {{--                                                        {{Debugbar::info($DOB_ageCalc)}}--}}
                                            {{--                                                        {{Debugbar::info($key . " is " . $DOB_ageCalc[$key])}}--}}


                                            <x-adminlte-card class="attachments" title="Attachments" theme="secondary"  icon="fas fa-lg fa-file-circle-plus"
                                                             collapsible="collapsed">

                                                @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "child_welfare_check_" . $key, 'familyMemberID' => $FPAForm->family_members[$key]['id'], 'section'=>'Child Welfare Record Check'], key("child_welfare_record_check_" . $key))

                                                <div class="row">
                                                    @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "criminal_record_check_" . $key, 'familyMemberID' => $FPAForm->family_members[$key]['id'], 'section'=>'Criminal Record Check with VSS'], key("criminal_reference_check_" . $key))

                                                </div>

                                                <div class="row">
                                                    @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "medical_" . $key, 'familyMemberID' => $FPAForm->family_members[$key]['id'], 'section'=>'Medical'], key("medical_" . $key))
                                                </div>
                                            </x-adminlte-card>
                                        @endif

                                    <div class="d-flex mx-auto">
                                        <div class="col">
                                            <button class="btn btn-sm btn-danger mb-3" wire:click.prevent="remove({{$key}})">REMOVE FAMILY MEMBER</button>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-sm btn-success mb-3" wire:click.prevent="removeFromSecondary({{$key}})">REMOVE FROM SECONDARY</button>
                                        </div>
                                    </div>
                                @endif



                            @endforeach
                        @endif
                            <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary mb-3" wire:click.prevent="addOther()">+ OTHER FAMILY MEMBER</button>

                            </div>

                        @if (count($inputs) > 1 && in_array("other",array_column($inputs, "role")))
                            <h5 class="text-primary mt-3">OTHER FAMILY MEMBERS</h5>
                                @foreach ($inputs as $key => $value)
                                    @if ($key > 0 && $value['role'] == "other")



                                            <div class="d-flex justify-content-start mb-3">

                                                <div class="col-6">
                                                    <label for="family_members-{{$key}}-surname_given_name">Name</label>
                                                    <input  class="countme_family_composition form-control" type="text" wire:model="FPAForm.family_members.{{$key}}.surname_given_name" placeholder="Full Name"  name="family_members-{{$key}}-surname_given_name" />
                                                </div>
                                                <div class="col-4">
                                                    <label for="family_members-{{$key}}-age_DOB">Date of Birth</label>
                                                    <input class="countme_family_composition DOB form-control" type="text" id="family_members-{{$key}}-age_DOB" wire:model.lazy="FPAForm.family_members.{{$key}}.age_DOB" placeholder="Date of Birth" name="family_members-{{$key}}-age_DOB" key="{{$key}}" value="{{ old('family_members['.$key.'][age_DOB]') }}"  size="12">
                                                </div>
                                                <div class="col-2">
                                                    <label for="DOB_ageCalc_{{$key}}">Age</label>
                                                    <input class="form-control" disabled type="text" id="DOB_ageCalc_{{$key}}" wire:model="DOB_ageCalc.{{$key}}" size="2" />
                                                </div>
                                            </div>
{{--                                                {{DebugBar::info($DOB_ageCalc[$key])}}--}}
                                            @if ($DOB_ageCalc[$key])
                                                @if ($DOB_ageCalc[$key] >= 18)
{{--                                                    {{Debugbar::info($DOB_ageCalc)}}--}}
{{--                                                    {{Debugbar::info($key . " is " . $DOB_ageCalc[$key])}}--}}

                                                    <x-adminlte-card class="attachments" title="Attachments" theme="secondary"  icon="fas fa-lg fa-file-circle-plus"
                                                                     collapsible="collapsed">

                                                        @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "child_welfare_check_" . $key, 'familyMemberID' => $FPAForm->family_members[$key]['id'], 'section'=>'Child Welfare Record Check'], key("child_welfare_record_check_" . $key))

                                                        <div class="row">
                                                            @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "criminal_record_check_" . $key, 'familyMemberID' => $FPAForm->family_members[$key]['id'], 'section'=>'Criminal Record Check with VSS'], key("criminal_reference_check_" . $key))

                                                        </div>

                                                        <div class="row">
                                                            @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "medical_" . $key, 'familyMemberID' => $FPAForm->family_members[$key]['id'], 'section'=>'Medical'], key("medical_" . $key))
                                                        </div>
                                                    </x-adminlte-card>


                                                @endif
                                                @endif
                                        <div class="d-flex mx-auto">
                                            <div class="col">
                                                <button class="btn btn-sm btn-danger mb-3" wire:click.prevent="remove({{$key}})">REMOVE FAMILY MEMBER</button>
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-sm btn-success mb-3" wire:click.prevent="changeToSecondary({{$key}})">CHANGE TO SECONDARY</button>
                                            </div>


                                        </div>




                                        @endif


                       @endforeach
                    @endif
                     @endif


                  {{--  @for ($i=0; $i <= 4; $i++)

                        <div class="row mb-3">
                            <div class="col-md-6" style="margin-bottom: 4px;">
                                <input class="countme_family_composition" type="text" wire:model="family_members.{{$i}}.surname_given_name" placeholder="Full Name"  name="family_members-{{$i}}-surname_given_name" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                <div class="col">
                                <input class="countme_family_composition DOB" type="text" id="family_members-{{$i}}-age_DOB" wire:model.lazy="family_members.{{$i}}.age_DOB" placeholder="Date of Birth" name="family_members-{{$i}}-age_DOB" class="form-control" value="{{ old('family_members['.$i.'][age_DOB]') }}" size="12">
                                </div>
                                <div class="col">
                                <input readonly class="input-group-append" type="text" id="DOB_ageCalc_{{$i}}" wire:model="DOB_ageCalc_{{$i}}" size="8" />
                                </div>
                                </div>
                                </div>
                        </div>
                    @endfor--}}
                    {{-- family_pets  field --}}




                </div>


            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1 ">
                        <h6>Family Composition - Notes</h6>
                    </div>
                    <div class="card-body">
                       <script>
                           //$wire.set('$box', $('#box_family_composition').height());
                       </script>
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'family_composition_notes', 'FPAForm' => $FPAForm, 'rows' => 600 ])
                    </div>
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-6">
            <div class="card card-primary" id="box_family_pets">
                <div class="card-header pb-0 mb-0" id="hdr_countme_family_pets">
                    <h6>Family Pets</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">
                    <div class="progress countme_family_pets  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_family_pets" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    @livewire('forms.case-manage.foster-parent-application-form-pets', ['FPAForm' => $this->FPAForm])


                </div>
            </div>
        </div>



        <div class="col-6">
            <div class="card card-secondary" >
                <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 1px !important;">
                    <h6>Family Pets - Notes</h6>
                </div>
                <div class="card-body">
                    @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'family_pets_notes', 'FPAForm' => $FPAForm, 'rows' => 335])
                </div>
            </div>
        </div>

    </div>



    <div class="row">
            <div class="col-6">
                <div class="card card-primary" id="box_home_community">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_home_community">
                    <h6>Description of Home and Community</h6>
                </div>
                <div class="card-body">

                    <div class="progress countme_home_community  mb-2" >
                        <div class="progress-bar countme_home_community" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    {{-- describe_home field --}}
                    <div class="input-group mb-3">
                        Physically describe the home: (one or two storey; how many bedrooms, garage (single or double), or car port?
                        <textarea name="describe_home"

                                  class="form-control countme_home_community" rows=5 wire:model="FPAForm.describe_home"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-home {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    {{-- describe_backyard field --}}
                    Describe the backyard?
                    <div class="input-group mb-3">

                    <textarea name="describe_backyard"  rows=5

                              class="form-control countme_home_community" wire:model="FPAForm.describe_backyard"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-home {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    {{-- basement_apartment field --}}
                    <div class="input-group mb-3">
                        If there is a basement apartment? All residents need safety checks and whether children/youth would have access to it?
                        <textarea name="basement_apartment"  rows=5

                                  class="form-control countme_home_community" wire:model="FPAForm.basement_apartment"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-home {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    Local schools, public, secondary, any other options, ie private?

                    {{-- describe_schools field --}}
                    <div class="input-group mb-3">
                    <textarea name="describe_schools" rows=5

                              class="form-control countme_home_community" wire:model="FPAForm.describe_schools"></textarea>
                        <div class="input-group-append ">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-school {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>
                </div>
                    @php
                    $key = 0;
                    @endphp
                    <x-adminlte-card class="attachments_home_community" title="Attachments" theme="secondary" theme-mode="" icon="fas fa-lg fa-file-circle-plus"
                                     collapsible="collapsed" header-class="mt-0">

                        @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "photos_of_front_of_house_from_street", 'section'=>'Photo of Front of House from the street'], key("photos_of_home_" . $key))

                        <div class="row">

                            @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "photos_of_backyard", 'section'=>'Photo of Backyard'], key("photos_of_home2_" . $key))
                        </div>

                        <div class="row">

                            @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "photos_of_bedroom1", 'section'=>'Bedroom 1'], key("photos_of_home3" . $key))
                        </div>

                        <div class="row">

                            @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "photos_of_bedroom2", 'section'=>'Bedroom 2'], key("photos_of_home4" . $key))
                        </div>

                        <div class="row">

                            @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "photos_of_bedroom3", 'section'=>'Bedroom 3'], key("photos_of_home5" . $key))
                        </div>

                        <div class="row">

                            @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "photos_of_bedroom4", 'section'=>'Bedroom 4'], key("photos_of_home6" . $key))
                        </div>

                        <div class="row">

                            @livewire('forms.case-manage.file-uploader', ['model' => $FPAForm, 'key' => "photos_of_bedroom5" . $key, 'section'=>'Bedroom 5 (optional)'], key("photos_of_home7" . $key))
                        </div>


                    </x-adminlte-card>



            </div>
            </div>






            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1">
                        <h6>Description of Home and Community - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'description_of_home_community_notes', 'FPAForm' => $FPAForm, 'rows' => 641])
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_physical_personality">
                    <h6>Description of Family Members</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">
                    <div class="progress countme_physical_personality  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_physical_personality" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    {{-- describe_physical_personality_applicants field --}}
                    <div class="input-group mb-3">
                        Describe all family members including children and other significant adults. (Include race, ethnicity, health, lifestyle habits, ie smoking (cigarettes and cannabis), alcohol, medications?
                        <textarea name="describe_physical_personality_applicants" rows=14

                                  class="form-control countme_physical_personality" wire:model="FPAForm.describe_physical_personality_applicants"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 1px !important;">
                        <h6>Description of Family Members - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'physical_description_personality_notes', 'FPAForm' => $FPAForm, 'rows' => 335])
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary" id="box_personal_history">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_personal_history">
                    <h6>Personal History of Each Applicant</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">
                    <div class="progress countme_personal_history  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_personal_history" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                    Date and place of birth, their place in the family, siblings, their relationship to their siblings?

                    {{-- personal_history_applicants field --}}
                    <div class="input-group mb-3">
                    <textarea name="personal_history_applicants" rows=7

                              class="form-control countme_personal_history" wire:model="FPAForm.personal_history_applicants"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                        @foreach ($inputs as $key => $value)
                            @if ($key > 0 && $value['role'] == "secondary")
                                <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />

                                Date and place of birth, their place in the family, siblings, their relationship to their siblings?

                                {{-- personal_history_applicants field --}}
                                <div class="input-group mb-3">
                    <textarea name="personal_history_applicants_secondary" rows=7

                              class="form-control countme_personal_history" wire:model="FPAForm.personal_history_secondary"></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                </div>

                            @endif
                        @endforeach
                    @endif


                    <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                    Describe your parents, their marital relationship, style of parenting, present relationship?

                    {{-- describe_parents field --}}
                    <div class="input-group mb-3">
                    <textarea name="describe_parents" rows=7

                              class="form-control countme_personal_history" wire:model="FPAForm.describe_parents"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                        @foreach ($inputs as $key => $value)
                            @if ($key > 0 && $value['role'] == "secondary")

                                <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />
                                Describe your parents, their marital relationship, style of parenting, present relationship?

                                {{-- describe_parents field --}}
                                <div class="input-group mb-3">
                    <textarea name="describe_parents" rows=7

                              class="form-control countme_personal_history" wire:model="FPAForm.describe_parents_secondary"></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                </div>

                            @endif
                        @endforeach
                    @endif

                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 8px !important;">
                        <h6>Personal History of Each Applicant - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'personal_history_applicant_notes', 'FPAForm' => $FPAForm, 'rows' => 385])
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary" id="box_education_employment">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_education_employment">
                    <h6>Education and Employment History of Applicants</h6>
                </div>
                <div class="card-body" >
                    <div class="progress countme_education_employment  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_education_employment" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                    {{-- primary_caregiver_education field --}}
                    What type of formal education do you have?

                    <div class="input-group mb-3">
                    <textarea name="primary_caregiver_education" rows=7

                              class="form-control countme_education_employment" wire:model="FPAForm.primary_caregiver_education"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-school {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                        @foreach ($inputs as $key => $value)
                            @if ($key > 0 && $value['role'] == "secondary")

                                <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />
                                What type of formal education do you have?

                                <div class="input-group mb-3">
                    <textarea name="primary_caregiver_education" rows=7

                              class="form-control countme_education_employment" wire:model="FPAForm.secondary_caregiver_education"></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-school {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    @endif


                                {{-- primary_caregiver_employment field --}}
                                <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                                Are you currently employed? Company name? Location?

                    <div class="input-group mb-3">
                    <textarea name="primary_caregiver_employment" rows=7

                              class="form-control countme_education_employment" wire:model="FPAForm.primary_caregiver_employment"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-building {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>


                                @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                                    @foreach ($inputs as $key => $value)
                                        @if ($key > 0 && $value['role'] == "secondary")

                                            <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />

                                            Are you currently employed? Company name? Location?

                                            <div class="input-group mb-3">
                    <textarea name="primary_caregiver_employment" rows=7

                              class="form-control countme_education_employment" wire:model="FPAForm.secondary_caregiver_employment"></textarea>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span
                                                            class="fas fa-building {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 8px !important;">
                        <h6>Education/Employment History - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'education_and_employment_history_notes', 'FPAForm' => $FPAForm, 'rows' => 335 ])
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_relationship_partner">
                    <h6>Relationship with Partner</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">
                    <div class="progress countme_relationship_partner  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_relationship_partner" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    {{-- primary_caregiver_education field --}}
                    Do you have a partner? If so, how did you meet?

                    <div class="input-group mb-3">
                    <textarea name="partner_describe_relationship" rows=8

                              class="form-control countme_relationship_partner" wire:model="FPAForm.partner_describe_relationship"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    {{-- partner_length_of_relationship field --}}
                    Length of relationship?

                    <div class="input-group mb-3">
                    <textarea name="partner_length_of_relationship" rows=8

                              class="form-control countme_relationship_partner" wire:model="FPAForm.partner_length_of_relationship"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 8px !important;">
                        <h6>Relationship with Partner - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'relationship_with_partner_notes', 'FPAForm' => $FPAForm, 'rows' => 384 ])
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary" id="box_previous_marriage">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_previous_marriage">
                    <h6>Previous Marriage / Relationship</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">

                    <div class="progress countme_previous_marriage  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_previous_marriage" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                    {{-- describe_previous_marriage field --}}
                    Have you been married previously?

                    <div class="input-group mb-3">
                    <textarea name="describe_previous_marriage" rows=8

                              class="form-control countme_previous_marriage" wire:model="FPAForm.describe_previous_marriage"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                        @foreach ($inputs as $key => $value)
                            @if ($key > 0 && $value['role'] == "secondary")

                                <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />

                                {{-- describe_previous_marriage field --}}
                                Have you been married previously?

                                <div class="input-group mb-3">
                    <textarea name="describe_previous_marriage" rows=8

                              class="form-control countme_previous_marriage" wire:model="FPAForm.secondary_describe_previous_marriage"></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    @endif


                    <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                    {{-- describe_previous_partner_contact field --}}
                    Do you still have contact with your previous partner?

                    <div class="input-group mb-3">
                    <textarea name="describe_previous_partner_contact" rows=8

                              class="form-control countme_previous_marriage" wire:model="FPAForm.describe_previous_partner_contact"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                        @foreach ($inputs as $key => $value)
                            @if ($key > 0 && $value['role'] == "secondary")

                                <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />
                                {{-- describe_previous_partner_contact field --}}
                                Do you still have contact with your previous partner?
                                <div class="input-group mb-3">
                    <textarea name="describe_previous_partner_contact" rows=8

                              class="form-control countme_previous_marriage" wire:model="FPAForm.secondary_describe_previous_partner_contact"></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                        @endif

                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 8px !important;">
                        <h6>Previous Marriage/Relationship - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'previous_marriage_relationship_notes', 'FPAForm' => $FPAForm, 'rows'=>384 ])
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_management_children">
                    <h6>Management of Children / Parenting Style (if applicable)</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">

                    <div class="progress countme_management_children  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_management_children" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    {{-- describe_discipline field --}}
                    <div class="input-group mb-3">
                        What type of discipline have you used in the past?
                        <br /><i>Carpe Diem is a LGBQT2S friendly agency and services the needs of all children and youth regardless of race, religion and sexual orientation or gender.</i>
                        <textarea name="describe_discipline" rows=12

                                  class="form-control countme_management_children" wire:model="FPAForm.describe_discipline"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-pen {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>



                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 0px !important;">
                        <h6>Management of Children/Parenting Style - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'management_of_children_parenting_style_notes', 'FPAForm' => $FPAForm, 'rows'=>313 ])
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_communication">
                    <h6>Communication</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">

                    How do family members communicate, adult to adult, adult to children?
                    <div class="progress countme_communication  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_communication" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    {{-- describe_communication field --}}
                    <div class="input-group mb-3">

                    <textarea name="describe_communication" rows=14

                              class="form-control countme_communication" wire:model="FPAForm.describe_communication"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-comment {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>



                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 1px !important;">
                        <h6>Communication - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'communication_notes', 'FPAForm' => $FPAForm, 'rows'=>312 ])
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_problem_solving">
                    <h6>Problem Solving</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">

                    <div class="progress countme_problem_solving  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_problem_solving" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    {{-- describe_problem_solving field --}}
                    How are problems identified and solved?

                    <div class="input-group mb-3">

                    <textarea name="describe_problem_solving" rows=7

                              class="form-control countme_problem_solving" wire:model="FPAForm.describe_problem_solving"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-exclamation-circle {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    {{-- problem_solving_example field --}}
                    Please provide a concrete example of a problem and how it was resolved?

                    <div class="input-group mb-3">

                    <textarea name="problem_solving_example" rows=7

                              class="form-control countme_problem_solving" wire:model="FPAForm.problem_solving_example"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-exclamation-circle {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>



                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 8px !important;">
                        <h6>Problem Solving - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'problem_solving_notes', 'FPAForm' => $FPAForm, 'rows'=>359])
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_family_functioning">
                    <h6>Current Family Functioning</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">
                    <div class="progress countme_family_functioning  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_family_functioning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    What is the pattern of daily living, routines, schedules, rituals?

                    {{-- pattern_daily_living field --}}
                    <div class="input-group mb-3">

                    <textarea name="pattern_daily_living" rows=15

                              class="form-control countme_family_functioning" wire:model="FPAForm.pattern_daily_living"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 1px !important;">
                        <h6>Current Family Functioning - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'current_family_functioning_notes', 'FPAForm' => $FPAForm, 'rows'=>311 ])
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_cultural">
                    <h6>Cultural Issues</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">
                    <div class="progress countme_cultural  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_cultural" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    {{-- describe_experience_cultures field --}}
                    Awareness of other cultural beliefs and practices

                    <div class="input-group mb-3">

                    <textarea name="describe_experience_cultures" rows=14

                              class="form-control countme_cultural" wire:model="FPAForm.describe_experience_cultures"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-pen {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 1px !important;">
                        <h6>Cultural Issues - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'cultural_issues_notes', 'FPAForm' => $FPAForm, 'rows'=>287 ])
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary" id="box_religious_beliefs">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_religious">
                    <h6>Religious Beliefs and Practices</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">
                    <div class="progress countme_religious  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_religious" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>


                    <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                    {{-- primary_religious_affiliation field --}}
                    Do you have a religious affiliation?

                    <div class="input-group mb-3">

                    <textarea name="primary_religious_affiliation" rows=7

                              class="form-control countme_religious" wire:model="FPAForm.primary_religious_affiliation"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-pen {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                        @foreach ($inputs as $key => $value)
                            @if ($key > 0 && $value['role'] == "secondary")

                                <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />
                                Do you have a religious affiliation?
                                <div class="input-group mb-3">

                    <textarea name="primary_religious_affiliation" rows=7

                              class="form-control countme_religious" wire:model="FPAForm.secondary_religious_affiliation"></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-pen {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    @endif


                                <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                                {{-- primary_spiritual_practices field --}}
                    If so, to what degree is their religion practiced in their home / lifestyle?

                    <div class="input-group mb-3">

                    <textarea name="primary_spiritual_practices" rows=7

                              class="form-control countme_religious" wire:model="FPAForm.primary_spiritual_practices"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-pen {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                                @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                                    @foreach ($inputs as $key => $value)
                                        @if ($key > 0 && $value['role'] == "secondary")

                                            <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />
                                            If so, to what degree is their religion practiced in their home / lifestyle?

                                            <div class="input-group mb-3">

                    <textarea name="primary_spiritual_practices" rows=7

                              class="form-control countme_religious" wire:model="FPAForm.secondary_spiritual_practices"></textarea>
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span
                                                            class="fas fa-pen {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                    @endforeach
                                @endif


                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 8px !important;">
                        <h6>Religious Beliegs and Practices - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'religious_beliefs_practices_notes', 'FPAForm' => $FPAForm, 'rows'=>359])
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_special_skills">
                    <h6>Special Skills</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">
                        <div class="progress countme_special_skills  mb-2" style="height: 20px" >
                            <div class="progress-bar countme_special_skills" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>

                    Are there any special talents or skills that would be brought into the fostering equation?

                    {{-- special_skills field --}}
                    <div class="input-group mb-3">

                    <textarea name="special_skills" rows=15

                              class="form-control countme_special_skills" wire:model="FPAForm.special_skills"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 25px !important;">
                        <h6>Special Skills - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'special_skills_notes', 'FPAForm' => $FPAForm, 'rows'=>311 ])
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_motivation_foster">
                    <h6>Motivation to Foster</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">
                    <div class="progress countme_motivation_foster  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_motivation_foster" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>

                    {{-- describe_pursuing_fostering field --}}
                    Why are you pursuing fostering?

                    <div class="input-group mb-3">

                    <textarea name="describe_pursuing_fostering" rows=15

                              class="form-control countme_motivation_foster" wire:model="FPAForm.describe_pursuing_fostering"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-pen {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 2px !important;">
                        <h6>Motivation to Foster - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'motivation_to_foster_notes', 'FPAForm' => $FPAForm, 'rows'=>310  ])
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary" id="box_financial">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_financial">
                    <h6>Financial Profile</h6>
                </div>
                <div class="card-body">
                        <div class="progress countme_financial  mb-2" style="height: 20px" >
                            <div class="progress-bar countme_financial" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>


                    <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                    {{-- primary_income_source field --}}
                    What is your income source?

                    <div class="input-group mb-3">
                    <textarea name="primary_income_source" rows=5

                              class="form-control countme_financial" wire:model="FPAForm.primary_income_source"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-usd {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                        @foreach ($inputs as $key => $value)
                            @if ($key > 0 && $value['role'] == "secondary")

                                <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />
                                What is your income source?

                                <div class="input-group mb-3">
                    <textarea name="primary_income_source" rows=5

                              class="form-control countme_financial" wire:model="FPAForm.secondary_income_source"></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-usd {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    @endif


                    <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                    {{-- primary_debt_management field --}}
                    Are you currently in any debt and if so, how is it managed?

                    <div class="input-group mb-3">

                    <textarea name="primary_debt_management" rows=5

                              class="form-control countme_financial" wire:model="FPAForm.primary_debt_management"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-usd {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                        @foreach ($inputs as $key => $value)
                            @if ($key > 0 && $value['role'] == "secondary")

                                <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />
                                Are you currently in any debt and if so, how is it managed?

                                <div class="input-group mb-3">

                    <textarea name="primary_debt_management" rows=5

                              class="form-control countme_financial" wire:model="FPAForm.secondary_debt_management"></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-usd {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    @endif


                    <b>Primary:</b> {{$this->FPAForm->family_members[0]['surname_given_name']}} <br />

                    {{-- primary_bill_management field --}}
                    Who manages the bills?

                    <div class="input-group mb-3">

                    <textarea name="primary_bill_management" rows=5

                              class="form-control countme_financial" wire:model="FPAForm.primary_bill_management"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-usd {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>

                    @if (count($inputs) > 1 && in_array("secondary",array_column($inputs, "role")))
                        @foreach ($inputs as $key => $value)
                            @if ($key > 0 && $value['role'] == "secondary")

                                <b>Secondary:</b> {{$this->FPAForm->family_members[$key]['surname_given_name']}} <br />
                                Who manages the bills?

                                <div class="input-group mb-3">

                    <textarea name="primary_bill_management" rows=5

                              class="form-control countme_financial" wire:model="FPAForm.secondary_bill_management"></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                        <span
                                                            class="fas fa-usd {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    @endif

                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 14px !important;">
                        <h6>Financial Profile - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'financial_profile_notes', 'FPAForm' => $FPAForm, 'rows'=>408 ])
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_relief_fulltime">
                    <h6>Refief / Full Time</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">
                    <div class="progress countme_relief_fulltime  mb-2" style="height: 20px" >
                        <div class="progress-bar countme_relief_fulltime" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    Are you interested in fulltime fostering? Part time fostering?

                    {{-- fulltime_parttime field --}}
                    <div class="input-group mb-3">

                    <textarea name="fulltime_parttime" rows=15

                              class="form-control countme_relief_fulltime" wire:model="FPAForm.fulltime_parttime"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 2px !important;">
                        <h6>Relief/Full-Time - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'relief_fulltime_notes', 'FPAForm' => $FPAForm, 'rows'=>310  ])
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card card-primary">
                <div class="card-header pb-0 mb-0 " id="hdr_countme_strengths">
                    <h6>Strengths</h6>
                </div>
                <div class="card-body" style="margin-bottom:0px !important;">

                        <div class="progress countme_strengths  mb-2" style="height: 20px" >
                            <div class="progress-bar countme_strengths" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    {{-- list_strengths field --}}
                    List your strengths that could be beneficial to fostering?

                    <div class="input-group mb-3">

                    <textarea name="list_strengths" rows=15

                              class="form-control countme_strengths" wire:model="FPAForm.list_strengths"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                                        <span
                                                            class="fas fa-plus-circle {{ config('adminlte.classes_auth_icon', '') }}"></span>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary" >
                    <div id='hdrPersonalInformation' class="card-header pb-0 mb-1" style="margin-bottom: 2px !important;">
                        <h6>Strengths - Notes</h6>
                    </div>
                    <div class="card-body">
                        @livewire('forms.case-manage.foster-parent-application-notes', ['user' => Auth::user(), 'field'=>'strengths_notes', 'FPAForm' => $FPAForm, 'rows'=>311  ])
                    </div>
                </div>
            </div>

        </div>



        The following documents are required for your file: <br />


            @if ($FPAForm->type_of_family == "Single")

            <x-adminlte-card class="attachments" title="Reference Letters - Please Provide 3" theme="secondary" theme-mode="" icon="fas fa-lg fa-file-circle-plus"
                             collapsible="collapsed" header-class="mt-0">

                @livewire('forms.case-manage.file-uploader', ['omitTitle' => true, 'model' => $FPAForm, 'multiple' => true, 'key' => "references" . $key, 'familyMemberID' => '', 'section'=>'References'], key("references" . $key))

            </x-adminlte-card>

            @else
                <x-adminlte-card class="attachments" title="Reference Letters - Please Provide 5" theme="secondary" theme-mode="" icon="fas fa-lg fa-file-circle-plus"
                                 collapsible="collapsed" header-class="mt-0">

                    @livewire('forms.case-manage.file-uploader', ['omitTitle' => true, 'model' => $FPAForm, 'multiple' => true, 'key' => "references" . $key, 'familyMemberID' => '', 'section'=>'References'], key("references" . $key))

                </x-adminlte-card>

            @endif

            <x-adminlte-card class="attachments" title="Confidentiality Statement" theme="secondary" theme-mode="" icon="fas fa-lg fa-file-circle-plus"
                             collapsible="collapsed" header-class="mt-0">

                @livewire('forms.case-manage.file-uploader', ['omitTitle' => true, 'model' => $FPAForm, 'multiple' => false, 'key' => "confidentiality" . $key, 'familyMemberID' => '', 'section'=>'confidentiality'], key("confidentiality" . $key))

            </x-adminlte-card>

            <x-adminlte-card class="attachments" title="Checklist - Physical Plant and Safety" theme="secondary" theme-mode="" icon="fas fa-lg fa-file-circle-plus"
                             collapsible="collapsed" header-class="mt-0">

                @livewire('forms.case-manage.file-uploader', ['omitTitle' => true, 'model' => $FPAForm, 'multiple' => false, 'key' => "checklist" . $key, 'familyMemberID' => '', 'section'=>'Checklist - Physical Plant and Safety'], key("checklist" . $key))

            </x-adminlte-card>

            <x-adminlte-card class="attachments" title="Insurance Coverage" theme="secondary" theme-mode="" icon="fas fa-lg fa-file-circle-plus"
                             collapsible="collapsed" header-class="mt-0">

                @livewire('forms.case-manage.file-uploader', ['omitTitle' => true, 'model' => $FPAForm, 'multiple' => true, 'key' => "insurance" . $key, 'familyMemberID' => '', 'section'=>'Insurance'], key("insurance" . $key))

            </x-adminlte-card>

            <x-adminlte-card class="attachments" title="Fire Evacuation Plan" theme="secondary" theme-mode="" icon="fas fa-lg fa-file-circle-plus"
                             collapsible="collapsed" header-class="mt-0">

                @livewire('forms.case-manage.file-uploader', ['omitTitle' => true, 'model' => $FPAForm, 'multiple' => true, 'key' => "fire_evacuation" . $key, 'familyMemberID' => '', 'section'=>'Fire Evacuation Plan'], key("fire_evacuation" . $key))

            </x-adminlte-card>


        <b><i>{{$FPAForm->primary_caregiver_fullname}}</i></b> is aware that their home study will be shared with CAS within Ontario.  This may occur through CAS CPIN program or another form of online data base sharing.  Their signatures below indicate that they give consent for their home study to be shared on a provincial level.
<br />
        Acceptance: <input type="checkbox" /> [View Disclaimer]


        {{--AUTO-SAVE IS ON, REMOVE BUTTON}}
     {{--   <div class="text-center">
        --}}{{-- Register button --}}{{--
        <button type="submit"
                class="btn btn mt-3 {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-save"></span>
            Submit/Update Application
        </button>
        </div>--}}



   <script>

       $( document ).ready(function() {

           refreshAllProgressBars();

           Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_composition_notes', $('#box_family_composition').height() );
           Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'personal_history_applicant_notes', $('#box_personal_history').height() );
           Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'education_and_employment_history_notes', $('#box_education_employment').height() );
           Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'religious_beliefs_practices_notes', $('#box_religious_beliefs').height() );
           Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'financial_profile_notes', $('#box_financial').height() );
           Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'previous_marriage_relationship_notes', $('#box_previous_marriage').height() );
           Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_pets_notes', $('#box_family_pets').height() );


           $('.attachments').on('expanded.lte.cardwidget', function () {
               //alert('shown');
               setTimeout(function(){
                   Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_composition_notes', $('#box_family_composition').height());
               },500);


           });

           $('.attachments').on('collapsed.lte.cardwidget', function () {
              // alert('collapsed');

               setTimeout(function(){
                   Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_composition_notes', $('#box_family_composition').height());
               },500);

           });

           $('.attachments_pets').on('expanded.lte.cardwidget', function () {
               //alert('shown');
               setTimeout(function(){
                   Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_pets_notes', $('#box_family_pets').height());
               },500);


           });

           $('.attachments_pets').on('collapsed.lte.cardwidget', function () {

               setTimeout(function(){
                   Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_pets_notes', $('#box_family_pets').height());
               },500);

           });


           $('.attachments_home_community').on('expanded.lte.cardwidget', function () {
               //alert('shown');
               setTimeout(function(){
                   Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'description_of_home_community_notes', $('#box_home_community').height());
               },500);


           });

           $('.attachments_home_community').on('collapsed.lte.cardwidget', function () {

               setTimeout(function(){
                   Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'description_of_home_community_notes', $('#box_home_community').height());
               },500);

           });


           // Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'personal_information_notes', $('#box_personal_information').height());
           //
           // Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_composition_notes', $('#box_family_composition').height());

           //detect when height changes for family_composition
           // $('#box_personal_information').bind('resize', function(){
           //     alert( 'Height changed to' + $(this).height() );
           //     Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'personal_information_notes', $('#box_personal_information').height() );
           // });


           window.addEventListener('personal_information_change', event => {
              // alert( 'personal_info - Height changed to' + $('#box_family_composition').height() );
               Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'personal_information_notes', $('#box_personal_information').height() );


           })


           window.addEventListener('family_composition_change', event => {
               //alert( 'Height changed to' + $('#box_family_composition').height() );
               Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_composition_notes', $('#box_family_composition').height() );
               Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'personal_history_applicant_notes', $('#box_personal_history').height() );
               Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'education_and_employment_history_notes', $('#box_education_employment').height() );
               Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'religious_beliefs_practices_notes', $('#box_religious_beliefs').height() );
               Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'financial_profile_notes', $('#box_financial').height() );
               Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'previous_marriage_relationship_notes', $('#box_previous_marriage').height() );

           });

           window.addEventListener('pets_change', event => {
               // alert( 'personal_info - Height changed to' + $('#box_family_composition').height() );
               Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_pets_notes', $('#box_family_pets').height() );


           })


           // let resize_family_composition = new ResizeObserver(() => {
           //     //alert ('resize');
           //     console.log ('family_composition resize');
           //     Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'family_composition_notes', $('#box_family_composition').height());
           //
           // });
           //
           // let resize_personal_information = new ResizeObserver(() => {
           //     //alert ('resize');
           //     console.log ('personal_information resize');
           //     Livewire.emitTo('forms.case-manage.foster-parent-application-notes', 'updateRows', 'personal_information_notes', $('#box_personal_information').height());
           //
           // });
           //
           // resize_personal_information.observe($("#box_personal_information")[0]);
           //
           // resize_family_composition.observe($("#box_family_composition")[0]);

       });
       function refreshAllProgressBars() {
           var $AllTotalFields = 0;
           var  $AllTotalFilled = 0;

           $section = [
               "countme_personal_information",
               "countme_family_composition",
               "countme_family_pets",
               "countme_home_community",
               "countme_physical_personality",
               "countme_personal_history",
               "countme_education_employment",
               "countme_relationship_partner",
               "countme_previous_marriage",
               "countme_management_children",
               "countme_communication",
               "countme_problem_solving",
               "countme_family_functioning",
               "countme_cultural",
               "countme_religious",
               "countme_special_skills",
               "countme_motivation_foster",
               "countme_financial",
               "countme_relief_fulltime",
               "countme_strengths"

           ];

           $section.forEach(function ($item) {
               var el = $('#progress>span');
               var totalFields =$(':input.' + $item).length;
               var filledFields;

               el.html('0');
               filledFields =0

               $(':input.' + $item).each(function() {
                   if (this.value) filledFields++;

               });

               // totalFields ... 3 ... 100%
               // filledFields ... 1 ... x%



               el.html(Math.round(filledFields*100/totalFields));
               $('.progress-bar.' + $item).css('width', Math.round(filledFields*100/totalFields)+'%').attr('aria-valuenow', Math.round(filledFields*100/totalFields));
               $('.progress-bar.' + $item).text('Completed Section: ' + Math.round(filledFields*100/totalFields)+'%');
               if (Math.round(filledFields*100/totalFields) == 100) {
                   $('.progress-bar.' +  $item).css('background-color', 'green');
                   $('#hdr_' + $item).css('background-color','green');
               } else {
                   $('.progress-bar.' + $item).css('background-color','#007bff');
                   $('#hdr_' + $item).css('background-color','#007bff');

               }

               $AllTotalFields = $AllTotalFields + totalFields;

               $AllTotalFilled = $AllTotalFilled + filledFields;
           });


           //update main progress bar
           $('#totalComplete').html((Math.round($AllTotalFilled * 100)/$AllTotalFields)+'%').attr('aria-valuenow',Math.round($AllTotalFilled*100/$AllTotalFields));
           $('#totalComplete').css('width', Math.round($AllTotalFilled*100/$AllTotalFields)+'%').attr('aria-valuenow', Math.round($AllTotalFilled*100/$AllTotalFields));
           $('#totalComplete').text('Total Sections Completed: ' + Math.round($AllTotalFilled*100/$AllTotalFields)+'%');
           if (Math.round($AllTotalFilled*100/$AllTotalFields) == 100) {
               $('#totalComplete').css('background-color', 'green');
           } else {
               $('#totalComplete').css('background-color','#007bff');

           }
       }
       window.addEventListener('refreshPB', function(event)  {
            // alert('test');
           //alert(event.currentTarget.section);
           // refreshProgressBarSection();

          refreshAllProgressBars();
           });



       window.addEventListener('ScrollMessageBoardToBottom', event=>  {
           //Scroll to the bottom of specific message_board
            console.log (event.detail.MessageBoardID);
           //alert ($("#"+ event));
               $("#message_board_" + event.detail.MessageBoardID).animate({
                   scrollTop:$("#message_board_" + event.detail.MessageBoardID)[0].scrollHeight - $("#message_board_" + event.detail.MessageBoardID).height()
               },1000,function(){
                   console.log("done " + event.detail.MessageBoardID);
               })

       });



       document.addEventListener("DOMContentLoaded", () => {
           Livewire.hook('component.initialized', (component) => {

           })
           Livewire.hook('element.initialized', (el, component) => {



           })
           Livewire.hook('element.updating', (fromEl, toEl, component) => {})
           Livewire.hook('element.updated', (el, component) => {

           })
           Livewire.hook('element.removed', (el, component) => {})
           Livewire.hook('message.sent', (message, component) => {})
           Livewire.hook('message.failed', (message, component) => {})
           Livewire.hook('message.received', (message, component) => {

           })
           Livewire.hook('message.processed', (message, component) => {


           })
       });



       $(function() {


           $section = [
               "countme_personal_information",
               "countme_family_composition",
               "countme_family_pets",
               "countme_home_community",
               "countme_physical_personality",
               "countme_personal_history",
               "countme_education_employment",
               "countme_relationship_partner",
               "countme_previous_marriage",
               "countme_management_children",
               "countme_communication",
               "countme_problem_solving",
               "countme_family_functioning",
               "countme_cultural",
               "countme_religious",
               "countme_special_skills",
               "countme_motivation_foster",
               "countme_financial",
               "countme_relief_fulltime",
               "countme_strengths"

           ];
            $section.forEach(function ($item) {
               /*setTimeout(refreshProgressBarSection, 3000, $item);*/

           });

            //upon load refresh all progress bars
           $section.forEach(function ($item) {
               refreshProgressBarSection($item)

           });

           //upon change on an field, refresh progress bar
           $(".form-control").change(function() {
               /*
               $section.forEach(function ($item) {
                   refreshProgressBarSection($item)

               });

                */

               //console.log ($(this).attr('class'));
                var lookupClass = String($(this).attr('class'));
                var item = String(lookupClass.substring(13));
                //console.log (item);
               if (item) {
                   //refreshProgressBarSection(item);
               }

           });





           function refreshProgressBarSection($item) {
             //alert ($item);
               var el = $('#progress>span');
               var totalFields =$(':input.' + $item).length;
               var filledFields;

               el.html('0');
               filledFields =0

               $(':input.' + $item).each(function() {
                   if (this.value) filledFields++;

               });

               // totalFields ... 3 ... 100%
               // filledFields ... 1 ... x%



               el.html(Math.round(filledFields*100/totalFields));
               $('.progress-bar.' + $item).css('width', Math.round(filledFields*100/totalFields)+'%').attr('aria-valuenow', Math.round(filledFields*100/totalFields));
               $('.progress-bar.' + $item).text('Completed Section: ' + Math.round(filledFields*100/totalFields)+'%');
               if (Math.round(filledFields*100/totalFields) == 100) {
                   $('.progress-bar.' +  $item).css('background-color', 'green');
                    $('#hdr_' + $item).css('background-color','green');
               } else {
                   $('.progress-bar.' + $item).css('background-color','#007bff');
                   $('#hdr_' + $item).css('background-color','#007bff');

               }
               //alert ('math done');
               $(':input.' + $item).change(function() {
                   refreshProgressBarSection($item);
               });
           }

           //Scroll to the bottom of each message_board
           $(".message_board").each(function (index) {
               $(this).animate({
                   scrollTop:$(this)[0].scrollHeight - $(this).height()
               },1000,function(){
                   console.log("done " + this.id);
               })
           })

       })



   </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7gZgrs12bkKHrcUN5ySRN-UIOZorEV6U&libraries=places"></script>
    <script>




        google.maps.event.addDomListener(window, 'load', function () {
            const options = {

                componentRestrictions: { country: "ca" },
                //fields: ["address_components", "geometry", "icon", "name"],

            };

            function getAddressComponent(place, componentName, property) {
                var comps = place.address_components.filter(function(component) {
                    return component.types.indexOf(componentName) !== -1;
                });

                if(comps && comps.length && comps[0] && comps[0][property]) {
                    return comps[0][property];
                } else {
                    return null;
                }
            }
            var places = new google.maps.places.Autocomplete(document.getElementById('address'),options);
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;



                if (place) {
                    // console.log (place);

                    var city = getAddressComponent(place, 'locality', 'long_name');
                    var province = getAddressComponent(place, 'administrative_area_level_1', 'long_name');
                    var postal = getAddressComponent(place, 'postal_code', 'short_name');
                    var country = getAddressComponent(place, 'country', 'long_name');


                    /*
                    var province = place.address_components[4].long_name;
                    var city = place.address_components[2].long_name;
                    var postal = place.address_components[6].long_name;
                    */
                    //document.getElementById('txtCountry').value = country;


                @this.set('FPAForm.mailing_address', place.name);
                @this.set('FPAForm.province', province);
                @this.set('FPAForm.city', city);
                @this.set('FPAForm.postal_code', postal);

                $item = "countme_personal_information";

                    var el = $('#progress>span');
                    var totalFields =$(':input.' + $item).length;
                    var filledFields;

                    el.html('0');
                    filledFields =0

                    $(':input.' + $item).each(function() {
                        if (this.value) filledFields++;

                    });

                    // totalFields ... 3 ... 100%
                    // filledFields ... 1 ... x%



                    el.html(Math.round(filledFields*100/totalFields));
                    $('.progress-bar.' + $item).css('width', Math.round(filledFields*100/totalFields)+'%').attr('aria-valuenow', Math.round(filledFields*100/totalFields));
                    $('.progress-bar.' + $item).text('Completed Section: ' + Math.round(filledFields*100/totalFields)+'%');
                    if (Math.round(filledFields*100/totalFields) == 100) {
                        $('.progress-bar.' +  $item).css('background-color', 'green');
                        $('#hdr_' + $item).css('background-color','green');
                    } else {
                        $('.progress-bar.' + $item).css('background-color','#007bff');
                        $('#hdr_' + $item).css('background-color','#007bff');

                    }
                    //document.getElementById('address').value = place.name;
                    //document.getElementById('city').value = city;
                    //document.getElementById('province').value = province;
                    //document.getElementById('postal_code').value = postal;
                }


            });
        });
    </script>
   {{-- <script>
        let myAnnotator = "";

        jQuery(function ($) {
            Annotator.Plugin.StoreLogger = function (element) {
                return {
                    pluginInit: function () {
                        this.annotator
                            .subscribe("annotationCreated", function (annotation) {
                                console.info("The annotation: %o has just been created!", annotation)
                                console.info("element: %o", element)
                            })
                            .subscribe("annotationUpdated", function (annotation) {
                                console.info("The annotation: %o has just been updated!", annotation)
                            })
                            .subscribe("annotationDeleted", function (annotation) {
                                console.info("The annotation: %o has just been deleted!", annotation)
                            })
                            .subscribe("annotationEditorSubmit", function (editor, annotation) {
                                console.info("Editor Submitted: %o", editor)
                            });

                    }


                }

            };

            if (typeof $.fn.annotator !== 'function') {
                alert("Ooops! it looks like you haven't built the Annotator concatenation file. " +
                    "Either download a tagged release from GitHub, or modify the Cakefile to point " +
                    "at your copy of the YUI compressor and run `cake package`.");
            } else {
                // This is the important bit: how to create the annotator and add
                // plugins
                myAnnotator = $('#myform').annotator()
                    .annotator('addPlugin', 'Permissions')

                    .annotator('addPlugin', 'Tags')

                    .annotator('addPlugin', 'StoreLogger')


                    .annotator('addPlugin', 'Store', {
                        prefix: '/annotation',
                        loadFromSearch: {
                            page: "FPAForm"
                        },
                        annotationData: {
                            page: "FPAForm"
                        },
                        urls: {
                            create: '/store',
                            update: '/update/:id',
                            destroy: '/delete/:id',
                            search: '/search'
                        }
                    });


                $('#myform').data('annotator').plugins['Permissions'].setUser("{{auth()->user()->name}}");

/*
                $('#myform').data('annotator').loadAnnotations([{
                    "id": "39fc339cf058bd22176771b3e3187329",
                    "created": "2011-05-24T18:52:08.036814",
                    "updated": "2011-05-26T12:17:05.012544",
                    "text": "This is a comment",
                    "quote": "Information",
                    "ranges":
                        [{
                            "start": "/div[1]/div[1]/h6[1]",
                            "end": "/div[1]/div[1]/h6[1]",
                            "startOffset": 9,
                            "endOffset": 20
                        }],
                }]);
*/

            }
        });




    </script>--}}

</div>
