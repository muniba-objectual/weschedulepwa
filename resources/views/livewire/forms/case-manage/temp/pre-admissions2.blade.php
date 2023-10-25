<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autosize.js/4.0.2/autosize.js" ></script>

    <script>

            document.addEventListener("DOMContentLoaded", function(event) {
            //console.log("DOM fully loaded and parsed");
            autosize($('textarea').not(".ignoreResize"));
            //console.log ('after');

            Livewire.hook('message.received', (message, component) => {
            //console.log ('message.received');
            //console.log(message);
                autosize($('textarea').not(".ignoreResize"));
            //autosize($('.autoResize'));
        })

            Livewire.hook('element.initialized', (el, component) => {
            //console.log('element initialized');
                autosize($('textarea').not(".ignoreResize"));
        })
        });

    </script>

    <style type="text/css">

        label {
            white-space: nowrap !important;
        }
         .long_label {
            /*display: block;*/
            /*width: 100%;*/
            /*height: 24px;*/
            /*float: left;*/
            white-space: normal !important;
        }

        .form-heading {
            text-align: center;
            font-weight: bold;
            margin-top: 2.5em;
            margin-bottom: 1.5em;
            text-decoration: underline;
        }


        .word-wrap {
            word-wrap: break-word;
        }

        /*textarea, input[type="text"] {*/
        /*    background: #f4eef1;*/
        /*}*/
    </style>


    @php
        $config = [
            "singleDatePicker" => true,
            "showDropdowns" => true,
            "minYear" => 2000,
            "maxYear" => 2030,
            "timePicker" => false,
            "timePicker24Hour" => false,
            "timePickerSeconds" => false,
            "cancelButtonClasses" => "btn-danger",
            "locale" => ["format" => "YYYY-MM-DD"],
        ];

        $eyeColours = ["Brown", "Blue", "Green", "Hazel", "Other"];

        $hairColours = ["Black", "Brown", "Blonde", "Red", "Other"];

        $culturalReligiousEthnicBackgrounds = ["Indigenous", "Canadian", "Jamaican", "Ethiopian", "Nigerian", "Middle Eastern", "Portuguese", "Italian", "Jewish", "Greek", "Asian", "South Asian", "Pakistan", "European", "Caribbean", "Latin", "Other"];

        $culturalReligiousLanguages = ["English", "French", "Spanish", "Chinese", "Farsi", "Punjabi", "Urdu", "Hindi", "Other"];

        $ethnicBackgroundCulRelBgs = ["Christian", "Catholic", "Islam", "Judaism", "Greek Orthodox", "Buddhism", "Hindu", "Sikhism", "Wicca", "Atheist", "Muslim", "None", "Other"];

        $careStatusList = ["Extended Society Ccare", "Interim society care", "Temporary care agreement", "Customary care", "Legally independent adult", "COTA", "VYSA", "Other"];

    @endphp

    <form wire:submit.prevent="submit">

        <h5 class="form-heading">Pre-Admission/Pre-Placement</h5>

        <x-form class="form-group">

            {{--IDENTIFY INFORMATION--}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">IDENTIFYING INFORMATION</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <x-adminlte-date-range class="data-picker marker marker-prefix-PA_PP_A00" label="Date of Request" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.date_of_request" value="{{$formData['date_of_request'] ?? 'N/A'}}" name="date_of_request" igroup-size="sm" :config="$config"/>

                    <x-adminlte-date-range class="data-picker marker marker-prefix-PA_PP_A00" label="Date of Form Completion" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.date_of_form_completion" value="{{$formData['date_of_form_completion'] ?? 'N/A'}}" name="date_of_form_completion" igroup-size="sm" :config="$config"/>

                    <x-adminlte-select label="Referring Agency" value="{{$formData['placing_agency_id'] ?? ''}}" class="select-input marker marker-prefix-PA_PP_A00" wire:model="formData.placing_agency_id" name="selAgency">
                        <option value="">Select Agency</option>
                        @foreach(\App\Models\PlacingAgency::all() as $itemValue)
                            <option  value="{{$itemValue->id}}">{{$itemValue->name}}</option>
                        @endforeach
                    </x-adminlte-select>

                    @php
                        if( isset($formData['placing_agency_id']) && is_numeric($formData['placing_agency_id']) ){
                            $placementAgency = \App\Models\PlacingAgency::find($formData['placing_agency_id']);
                            $placementAgencyWorkers = $placementAgency
                                    ->workers()
                                    ->where('type', \App\Models\PlacingAgencyWorkers::WORKER_TYPE__PLACEMENT_WORKER)
                                    ->whereNotNUll('email') //you need the email address to send the email form
                                    ->whereRaw("TRIM(email) != ''")
                                    ->get() ?? [];
                        }
                    @endphp
                    <div class="form-group">
                        <label for="auto_id_placementAgency-address">Referring Agency Address</label>
                        <div class="input-group">
                            <input readonly class="form-control"  value="{{$placementAgency->address??'N/A'}}" type="text" name="placementAgency-address" id="auto_id_placementAgency-address">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="auto_id_placementAgency-address">Agency Telephone</label>
                        <div class="input-group">
                            <input readonly class="form-control"  value="{{$placementAgency->telephone??'N/A'}}" type="text" name="placementAgency-telephone" id="auto_id_placementAgency-telephone">
                        </div>
                    </div>

                    @if($placementAgency??false)
                    <x-adminlte-select label="Placement Worker" class="select-input marker marker-prefix-PA_PP_A00" wire:model="formData.placement_worker_id" name="placement_worker_id">
                        <option value="">Select Worker</option>
                        @foreach($placementAgencyWorkers as $itemValue)
                            <option  value="{{$itemValue->id}}">{{$itemValue->name}}</option>
                        @endforeach
                    </x-adminlte-select>
                    @else
                        <span class="sub-text"><i>N/A</i></span>
                    @endif

                    <div class="form-group">
                        <label for="form-completed-by">Form Completed By</label>
                        <div class="input-group">
                            <input readonly class="form-control"  value="{{$formData['edited_by']['name']??auth()->user()->name}}" type="text" name="form-completed-by" id="form-completed-by">
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->

            {{--CHILD INFORMATION--}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">CHILD INFORMATION</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="child-name">Child Name</label>
                        <div class="input-group">
                            <input  class="form-control marker marker-prefix-PA_PP_B00"  wire:model="formData.child_name"  value="{{$formData['child_name'] ?? ''}}"type="text" name="child-name" id="child-name">
                        </div>
                    </div>

                    <x-adminlte-date-range  label="D.O.B" class="data-picker marker marker-prefix-PA_PP_B00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.child_dob" value="{{$formData['child_dob'] ?? 'N/A'}}" name="child_dob" igroup-size="sm" :config="$config"/>

                    <div class="form-group">
                        <label for="child-age">Age</label>
                        <div class="input-group">
                            <input  readonly class="form-control marker marker-prefix-PA_PP_B00"  type="text" name="child-name" id="child-age" value="{{isset($formData['child_dob'])?\Carbon\Carbon::parse($formData['child_dob'])->age.' Yrs':'N\A'}}">
                        </div>
                    </div>

                    <x-adminlte-input label="Identity/Pronouns" class='marker marker-prefix-PA_PP_B00' name="child-pronouns"  wire:model="formData.child_identity_or_pro_nouns" value="{{$formData['child_identity_or_pro_nouns'] ?? 'N/A'}}"/>

                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->

            {{--CHILD DESCRIPTION--}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">CHILD DESCRIPTION</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <h4>Cultural/Religious</h4>

                        @include('livewire.forms.case-manage.temp.form-elements.select-input', [
                                'xFieldName'        => 'ethic_background',
                                'xFieldLabel'       => 'Ethnic Background',
                                'xFieldOptions'     => $culturalReligiousEthnicBackgrounds,
                                'xFieldClass'       => 'marker marker-prefix-PA_PP_E00',
                                'xFieldOtherValue'  => 'other',
                            ])

                        @include('livewire.forms.case-manage.temp.form-elements.select-input', [
                                'xFieldName'        => 'care_status',
                                'xFieldLabel'       => 'Legal Status',
                                'xFieldOptions'     => $careStatusList,
                                'xFieldClass'       => 'marker marker-prefix-PA_PP_E00',
                                'xFieldOtherValue'  => 'other',
                            ])

                        <x-adminlte-input label="Band Affiliated" class='marker marker-prefix-PA_PP_E00' name="band-affiliated" multiple wire:model="formData.band_affiliated"/>

                        @include('livewire.forms.case-manage.temp.form-elements.select-input', [
                                'xFieldName'        => 'languages',
                                'xFieldLabel'       => 'Language(s) Spoken',
                                'xFieldOptions'     => $culturalReligiousLanguages,
                                'xFieldClass'       => 'marker marker-prefix-PA_PP_E00',
                                'xFieldOtherValue'  => 'other',
                            ])

                        @include('livewire.forms.case-manage.temp.form-elements.select-input', [
                                'xFieldName'        => 'cultural_religious_background',
                                'xFieldLabel'       => 'Cultural/Religious Background',
                                'xFieldOptions'     => $ethnicBackgroundCulRelBgs,
                                'xFieldClass'       => 'marker marker-prefix-PA_PP_E00',
                                'xFieldOtherValue'  => 'other',
                            ])

                        <div class="form-group">
                            <label for="has_cultural_religious_spiritual_practices">Any Important Cultural/Religious/Spiritual Practices?</label>

                            <div class="form-check">
                                <input class="form-check-input" name="has_cultural_religious_spiritual_practices" value="1" wire:model="formData.has_cultural_religious_spiritual_practices" type="radio">
                                <label class="form-check-label">Yes</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" name="has_cultural_religious_spiritual_practices" value="0" wire:model="formData.has_cultural_religious_spiritual_practices" type="radio">
                                <label class="form-check-label">No</label>
                            </div>

                            <x-adminlte-textarea wire:ignore  label="Describe" class='marker marker-prefix-PA_PP_D00' name="cultural-description"  wire:model="formData.cultural_religious_spiritual_practices_description" />

                            <x-adminlte-input label="Height" class='marker marker-prefix-PA_PP_D00' name="height"  wire:model="formData.height"/>

                            @include('livewire.forms.case-manage.temp.form-elements.select-input', [
                                'xFieldName'        => 'hair_colour',
                                'xFieldLabel'       => 'Hair Colour',
                                'xFieldOptions'     => $hairColours,
                                'xFieldClass'       => 'marker marker-prefix-PA_PP_D00',
                                'xFieldOtherValue'  => 'other',
                            ])

                            @include('livewire.forms.case-manage.temp.form-elements.select-input', [
                                'xFieldName'        => 'eye_colour',
                                'xFieldLabel'       => 'Eye Colour',
                                'xFieldOptions'     => $eyeColours,
                                'xFieldClass'       => 'marker marker-prefix-PA_PP_D00',
                                'xFieldOtherValue'  => 'other',
                            ])

                            <x-adminlte-input label="Weight" class='marker marker-prefix-PA_PP_D00' name="weight"  wire:model="formData.weight"/>
                            <x-adminlte-input label="Other" class='marker marker-prefix-PA_PP_D00' name="other"  wire:model="formData.Other"/>

                            <x-adminlte-textarea wire:ignore  label="Strengths of the child, including information about their personality, aptitudes and abilities" class='marker marker-prefix-PA_PP_F00' name="child-strengths"  wire:model="formData.strengths_personality_aptitudes_abilities" />


                        </div>
                    </div>




                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->

            {{--REASON FOR PLACEMENT--}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">REASON FOR PLACEMENT</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">

                        <div class="form-group">

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" wire:model="formData.new_placement">
                                <label class="form-check-label">NEW PLACEMENT</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" wire:model="formData.placement_breakdown">
                                <label class="form-check-label">PLACEMENT BREAKDOWN</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" wire:model="formData.placement_change">
                                <label class="form-check-label">PLACEMENT CHANGE</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" wire:model="formData.relief">
                                <label class="form-check-label">RELIEF</label>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="kinship_placement">KINSHIP PLACEMENT CONSIDERED</label>

                            <div class="form-check">
                                <input class="form-radio-input marker marker-prefix-PA_PP_G00" name="adn" value="1" wire:model="formData.has_kinship_placement" type="radio">
                                <label class="form-check-label">Yes</label>
                            </div>

                            <div class="form-check">
                                <input class="form-radio-input marker marker-prefix-PA_PP_G00" name="adn" value="0" wire:model="formData.has_kinship_placement" type="radio">
                                <label class="form-check-label">No</label>
                            </div>

                            <x-adminlte-textarea wire:ignore  label="Explain" class='marker marker-prefix-PA_PP_G00' name="kinship_explain"  wire:model="formData.has_kinship_placement_reason" />

                            <x-adminlte-textarea wire:ignore  label="Basis on which the child is in care?" class='marker marker-prefix-PA_CI_EM00' name="basic_child_in_care"  wire:model="formData.basis_on_which_the_child_is_in_care" />

                            <x-adminlte-textarea wire:ignore  label="The Objectives of Placing Child" class='marker marker-prefix-PA_CI_EM00' name="child_objectives"  wire:model="formData.placing_child_objectives" />

                            <x-adminlte-textarea wire:ignore  label="What has occurred to prompt this placement request" class='marker marker-prefix-PA_CI_EM00' name="child_what_occured"  wire:model="formData.reason_to_prompt_this_placement_request" />


                        </div>
                    </div>




                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->


            {{--IMMEDIATE NEEDS--}}
            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">IMMEDIATE NEEDS</h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">

                    {{--Behavioural/Sociel Presentation--}}
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Behavioral/Social Presentation:</h3>

                        </div>
                        <div class="card-body">
                            <div class="form-group">

                                <div class="row">
                                    <div class="col">

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.no_unusual_behaviours">
                                            <label class="form-check-label">No unusual behaviours</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.age_appropriate_social_interaction">
                                            <label class="form-check-label">Positive/age-appropriate social interaction with peers</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.positive_social_interaction_with_adults">
                                            <label class="form-check-label">Positive social interaction with adults</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.is_caring">
                                            <label class="form-check-label">Caring</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.adaptable">
                                            <label class="form-check-label">Adaptable</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.timid">
                                            <label class="form-check-label">Timid</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.difficulty_reading_social_cues">
                                            <label class="form-check-label">Difficulty reading social cues</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.unpredictable">
                                            <label class="form-check-label">Unpredictable</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.unhappy">
                                            <label class="form-check-label">Unhappy</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.lack_of_or_flat_affect">
                                            <label class="form-check-label">Lack of or flat affect</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.hyperactive_adhd_add">
                                            <label class="form-check-label">Hyperactive/ADHD/ADD</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.short_attention_span">
                                            <label class="form-check-label">Short attention span</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.impulsive">
                                            <label class="form-check-label">Impulsive</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.instigates_conflict">
                                            <label class="form-check-label">Instigates conflict</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.is_demanding">
                                            <label class="form-check-label">Demanding</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.has_temper_tantrums">
                                            <label class="form-check-label">Temper tantrums</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.is_known_for_gang_involvement">
                                            <label class="form-check-label">Known gang involvement</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.physically_aggressive">
                                            <label class="form-check-label">Physically aggressive</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.chronic_lying">
                                            <label class="form-check-label">Chronic lying</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.verbally_aggressive">
                                            <label class="form-check-label">Verbally aggressive</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.smokes">
                                            <label class="form-check-label">Smokes</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.using_drugs_alcohol">
                                            <label class="form-check-label">Using drugs/alcohol</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.difficulty_following_instructions">
                                            <label class="form-check-label">Difficulty following instructions</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.carrying_weapons">
                                            <label class="form-check-label">Carrying weapons</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.fire_setting">
                                            <label class="form-check-label">Fire setting</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME"
                                                   wire:model="formData.toilet_trained">
                                            <label class="form-check-label">Toilet trained (for younger children)</label>
                                        </div>
                                    </div>


                                </div>

                                <x-adminlte-textarea wire:ignore  label="Description" class='marker marker-prefix-PA_CI_BS00' name="immediate_needs_description"  wire:model="formData.immediate_needs_description" />




                            </div>
                        </div>
                    </div>

                    {{--Emotional--}}
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Emotional:</h3>

                        </div>
                        <div class="card-body">
                            <div class="form-group">

                                <div class="row">
                                    <div class="col">

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.depression">
                                            <label class="form-check-label">Depression</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.suicidal">
                                            <label class="form-check-label">Suicidal</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.mental_health_diagnosis">
                                            <label class="form-check-label">Mental health diagnosis</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.threatened_injured_self">
                                            <label class="form-check-label">Threatened/Injured Self</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.bed_wetting_soiling">
                                            <label class="form-check-label">Bed-wetting/soiling</label>
                                        </div>


                                    </div>

                                    <div class="col">
                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.eat_sleep_disorder">
                                            <label class="form-check-label">Eat/sleep disorder</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.self_abusive">
                                            <label class="form-check-label">Self-abusive</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.head_banging">
                                            <label class="form-check-label">Head-banging</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.hair_pulling">
                                            <label class="form-check-label">Hair pulling</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.history_of_being_in_care_previously">
                                            <label class="form-check-label">History of being in care previously</label>
                                        </div>
                                    </div>


                                </div>

                                <label for="child_counselling">Is the child/youth currently involved with any support services (e.g. counseling)? </label>

                                <div class="form-check">
                                    <input class="form-radio-input marker marker-prefix-PA_CI_EM00" name="afd" value="1" wire:model="formData.afd" type="radio">
                                    <label class="form-check-label">Yes</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-radio-input marker marker-prefix-PA_CI_EM00" name="afd" value="0" wire:model="formData.afd" type="radio">
                                    <label class="form-check-label">No</label>
                                </div>

                                <x-adminlte-textarea wire:ignore  label="If yes, where?" class='marker marker-prefix-PA_CI_EM00' name="child_support_services_explain"  wire:model="formData.aff" />

                                <x-adminlte-textarea wire:ignore  label="Description" class='marker marker-prefix-PA_CI_EM00' name="child_support_services_description"  wire:model="formData.afg" />
                            </div>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Self-Care/Life Skills:</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afh">
                                            <label class="form-check-label">Ability to demonstrate age-appropriate behaviour</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afj">
                                            <label class="form-check-label">Inappropriate in public</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afl">
                                            <label class="form-check-label">No difficulties eating/restrictions</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afn">
                                            <label class="form-check-label">Dietary restrictions/allergies</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afp">
                                            <label class="form-check-label">Vegetarian</label>
                                        </div>

                                    </div>

                                    <div class="col">
                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afi">
                                            <label class="form-check-label">Cultural dietary needs</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afk">
                                            <label class="form-check-label">Diagnosed eating disorder</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afm">
                                            <label class="form-check-label">Age appropriate hygiene skills</label>
                                        </div>


                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afi">
                                            <label class="form-check-label">Cultural dietary needs</label>
                                        </div>


                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afq">
                                            <label class="form-check-label">Needs assistance with hygiene</label>
                                        </div>
                                    </div>
                                </div>




                                <x-adminlte-textarea wire:ignore  label="Description" class='marker marker-prefix-PA_CI_SC00' name="self-care-description"  wire:model="formData.afr" />

                            </div>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Family Relationships/Background:</h3>

                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" wire:model="formData.afs">
                                            <label class="form-check-label">Settles easy into family setting</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" wire:model="formData.afu">
                                            <label class="form-check-label">Difficulty in family setting</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" wire:model="formData.afw">
                                            <label class="form-check-label">History of parent/family mental health issues</label>
                                        </div>


                                    </div>

                                    <div class="col">
                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" wire:model="formData.aft">
                                            <label class="form-check-label">History of family/domestic violence</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" wire:model="formData.afv">
                                            <label class="form-check-label">History of parent substance usage</label>
                                        </div>


                                    </div>
                                </div>

                                <x-adminlte-textarea wire:ignore  label="Description" class='marker marker-prefix-PA_CI_FR00' name="family-relationship-description"  wire:model="formData.afx" />

                            </div>
                        </div>

                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">School:</h3>

                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afy">
                                            <label class="form-check-label">No major issues</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afz">
                                            <label class="form-check-label">Modified program</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.aga">
                                            <label class="form-check-label">Attends school regularly</label>
                                        </div>


                                    </div>

                                    <div class="col">
                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.agb">
                                            <label class="form-check-label">Truancy/Attendance issues</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.agc">
                                            <label class="form-check-label">IEP</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.agd">
                                            <label class="form-check-label">Disruptive behaviour in classroom</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.age">
                                            <label class="form-check-label">Section 20</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.agf">
                                            <label class="form-check-label">Frequent suspensions from school</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.agg">
                                            <label class="form-check-label">Learning disability</label>
                                        </div>


                                    </div>
                                </div>



                                <x-adminlte-input label="Current school attending" class='marker marker-prefix-PA_CI_SC00' name="current-school-attending"  wire:model="formData.agh"/>

                                <x-adminlte-input label="Current grade level" class='marker marker-prefix-PA_CI_SC00' name="current-grade-level"  wire:model="formData.agi"/>

                                <x-adminlte-input label="Special program" class='marker marker-prefix-PA_CI_SC00' name="special-program"  wire:model="formData.agj"/>

                                <x-adminlte-input label="School Address" class='marker marker-prefix-PA_CI_SC00' name="school-address"  wire:model="formData.agk"/>

                                <x-adminlte-input label="Other" class='marker marker-prefix-PA_CI_SC00' name="school-other"  wire:model="formData.agl"/>

                                <x-adminlte-textarea wire:ignore  label="Description" class='marker marker-prefix-PA_CI_SC00' name="school-description"  wire:model="formData.agm" />



                            </div>
                        </div>

                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Health:</h3>

                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agq">
                                            <label class="form-check-label">No medical issues</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ags">
                                            <label class="form-check-label">Diagnosed medical issue/condition</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agu">
                                            <label class="form-check-label">Medical attention/procedure required</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agw">
                                            <label class="form-check-label">Seizures</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agy">
                                            <label class="form-check-label">Asthma</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.aha">
                                            <label class="form-check-label">Allergies/Allergic Reactions</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahc">
                                            <label class="form-check-label">Medically Fragile</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahe">
                                            <label class="form-check-label">Low birth weight</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahg">
                                            <label class="form-check-label">Complex/tube feeding</label>
                                        </div>


                                    </div>






                                    <div class="col">
                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agr">
                                            <label class="form-check-label">Encopresis (soiling)</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agt">
                                            <label class="form-check-label">Enuresis (bed wetting)</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agv">
                                            <label class="form-check-label">Autistic/PDD</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agx">
                                            <label class="form-check-label">FAS/FASD</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agz">
                                            <label class="form-check-label">HIV or HIV exposed</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahb">
                                            <label class="form-check-label">STD</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahd">
                                            <label class="form-check-label">HEP</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahf">
                                            <label class="form-check-label">Diabetic</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahh">
                                            <label class="form-check-label">Speech/language issues</label>
                                        </div>


                                    </div>
                                </div>

                                <x-adminlte-textarea wire:ignore  label="If other, please describe:" class='marker marker-prefix-PA_CI_H00' name="health-description"  wire:model="formData.ahi" />

                                <x-adminlte-textarea wire:ignore  label="Medical/therapeutic services active or required" class='marker marker-prefix-PA_CI_H00' name="health-001"  wire:model="formData.ahj" />

                                <x-adminlte-textarea wire:ignore  label="Doctor" class='marker marker-prefix-PA_CI_H00' name="health-002"  wire:model="formData.ahk" />

                                <x-adminlte-textarea wire:ignore  label="Medications (drug, dosage, what prescribed for)" class='marker marker-prefix-PA_CI_H00' name="health-003"  wire:model="formData.ahl" />

                                <x-adminlte-textarea wire:ignore  label="Allergies (medications, pollen, pets, etc)" class='marker marker-prefix-PA_CI_H00' name="health-004"  wire:model="formData.ahm" />

                                <x-adminlte-textarea wire:ignore  label="Does the child have any anaphylactic reactions?" class='marker marker-prefix-PA_CI_H00' name="health-005"  wire:model="formData.ahn" />

                                <x-adminlte-textarea wire:ignore  label="Description" class='marker marker-prefix-PA_CI_H00' name="health-006"  wire:model="formData.aho" />





                            </div>
                        </div>

                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Identity/Behaviour:</h3>

                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahp">
                                            <label class="form-check-label">Gay</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahr">
                                            <label class="form-check-label">Lesbian</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.aht">
                                            <label class="form-check-label">Bisexual</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahv">
                                            <label class="form-check-label">Transsexual</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahx">
                                            <label class="form-check-label">Not Applicable</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahz">
                                            <label class="form-check-label">Heterosexual</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.aib">
                                            <label class="form-check-label">Struggling to identify sexual orientation</label>
                                        </div>






                                    </div>


                                    <div class="col">
                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahq">
                                            <label class="form-check-label">Healthy understanding of sexual health</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahs">
                                            <label class="form-check-label">Human Trafficking</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahu">
                                            <label class="form-check-label">Sexually acting out</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahw">
                                            <label class="form-check-label">Sexually active</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.aia">
                                            <label class="form-check-label">Intrusive</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.aic">
                                            <label class="form-check-label">Masturbation: normal or excessive</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.identity_behavior_other">
                                            <label class="form-check-label">Other</label>
                                        </div>


                                    </div>
                                </div>

                                <x-adminlte-textarea wire:ignore  label="Description" class='marker marker-prefix-PA_CI_SC00' name="identity-behaviour-description"  wire:model="formData.identity_behaviour_description" />

                            </div>
                        </div>

                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">FAMILY CONTACT</div>
                        </div>
                        <div class="card-body">
                            {{--                                        Access--}}
                            <div class="card-primary">
                                <div class="card-header">
                                    <div class="card-title">Access</div>
                                </div>
                                <div class="card-body">
                                    <x-adminlte-textarea wire:ignore  label="Potential Access Plan" class='marker marker-prefix-PA_FC00' name="access-pap"  wire:model="formData.aja" />

                                    <x-adminlte-textarea wire:ignore  label="Who" class='marker marker-prefix-PA_FC00' name="access-who"  wire:model="formData.ajb" />

                                    <x-adminlte-textarea wire:ignore  label="Prohibited Contacts" class='marker marker-prefix-PA_FC00' name="access-prohib"  wire:model="formData.ajc" />

                                </div>
                            </div>

                            {{--                                        Siblings--}}
                            <div class="card-primary">
                                <div class="card-header">
                                    <div class="card-title">Siblings</div>
                                </div>
                                <div class="card-body">
                                    <x-adminlte-textarea wire:ignore  label="Are there siblings in care? Where?" class='marker marker-prefix-PA_FC00' name="sibs1"  wire:model="formData.air" />

                                    <x-adminlte-textarea wire:ignore  label="Can you place close proximity to them?" class='marker marker-prefix-PA_FC00' name="sibs2"  wire:model="formData.ais" />


                                </div>
                            </div>

                            {{--                                        Other--}}
                            <div class="card-primary">
                                <div class="card-header">
                                    <div class="card-title">Other</div>
                                </div>
                                <div class="card-body">
                                    <x-adminlte-textarea wire:ignore  label="Guidelines for telephone contact" class='marker marker-prefix-PA_FC00' name="other1"  wire:model="formData.ajd" />

                                    <label for="other-concerns">Concerns with child/youth being placed in same community as family?</label>

                                    <div class="form-check">
                                        <input class="form-radio-input marker marker-prefix-PA_FC00" name="aje" value="1" wire:model="formData.aje" type="radio">
                                        <label class="form-check-label">Yes</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-radio-input marker marker-prefix-PA_FC00" name="aje" value="0" wire:model="formData.aje" type="radio">
                                        <label class="form-check-label">No</label>
                                    </div>

                                    <x-adminlte-textarea wire:ignore  label="Describe" class='marker marker-prefix-PA_FC00' name="other-concerns-desc"  wire:model="formData.ajg" />



                                    <label for="other-safety-concerns">Safety concerns (placement or access)?</label>

                                    <div class="form-check">
                                        <input class="form-radio-input marker marker-prefix-PA_FC00" name="ajh" value="1" wire:model="formData.ajh" type="radio">
                                        <label class="form-check-label">Yes</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-radio-input marker marker-prefix-PA_FC00" name="ajh" value="0" wire:model="formData.ajh" type="radio">
                                        <label class="form-check-label">No</label>
                                    </div>

                                    <x-adminlte-textarea wire:ignore  label="Describe" class='marker marker-prefix-PA_FC00' name="other-concerns-safety-desc"  wire:model="formData.ajj" />




                                </div>
                            </div>


                        </div>
                    </div>

                </div>

            </div>

            {{--FAMILY CONTACT--}}
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">Placement History/Considerations</div>
                </div>
                <div class="card-body">
                    <div class="card-primary">
                        <div class="card-header">
                            <div class="card-title">Previous Placement History</div>
                        </div>
                        <div class="card-body">
                            <x-adminlte-textarea wire:ignore  label="Please list all previous placements" class='marker marker-prefix-PA_PH00' name="pph_list_all_placements"  wire:model="formData.aih" />

                            <x-adminlte-textarea wire:ignore  label="Consider past placements for the child. What is the reason for placement breakdowns?" class='marker marker-prefix-PA_PH00' name="pph2"  wire:model="formData.aii" />

                            <x-adminlte-textarea wire:ignore  label="Consider past placements for the child. What does their history mean?" class='marker marker-prefix-PA_PH00' name="pph3"  wire:model="formData.aij" />

                            <x-adminlte-textarea wire:ignore  label="Does child have multiple placement history? More than 2?" class='marker marker-prefix-PA_PH00' name="pph4"  wire:model="formData.ait" />

                            <x-adminlte-textarea wire:ignore  label="Is this a risk of break down?" class='marker marker-prefix-PA_PH00' name="pph5"  wire:model="formData.aiu" />

                        </div>
                    </div>

                    <div class="card-primary">
                        <div class="card-header">
                            <div class="card-title">Immediate Needs Evaluation</div>
                        </div>
                        <div class="card-body">
                            <label for="child_counselling">Child appropriate for placement?</label>

                            <div class="form-check">
                                <input class="form-radio-input marker marker-prefix-PA_CI_SI00" name="is_child_appropriate_for_placement" value="1" wire:model="formData.is_child_appropriate_for_placement" type="radio">
                                <label class="form-check-label">Yes</label>
                            </div>

                            <div class="form-check">
                                <input class="form-radio-input marker marker-prefix-PA_CI_SI00" name="is_child_appropriate_for_placement" value="0" wire:model="formData.is_child_appropriate_for_placement" type="radio">
                                <label class="form-check-label">No</label>
                            </div>

                            <label for="child_counselling">**NOTE - IF YES SAFETY ASSESSMENT NEEDS TO BE GENERATED**</label>

                            <x-adminlte-textarea wire:ignore  label="Details of how the licensee determined that the child’s immediate needs will be met if admitted" class='marker marker-prefix-PA_CI_SI00' name="INE1"  wire:model="formData.aie" />

                            <x-adminlte-textarea wire:ignore  label="Details of any immediate needs of the child that cannot be met." class='marker marker-prefix-PA_CI_SI00' name="INE2"  wire:model="formData.aif" />

                            <x-adminlte-textarea wire:ignore  label="Details of how any immediate needs that cannot be met will otherwise be met.	" class='marker marker-prefix-PA_CI_SI00' name="INE3"  wire:model="formData.aig" />

                            <br />
                            <span>*The details of how the licensee determined the child’s immediate needs will be met if admitted should include details of the program offered by the licensee, staff training and the population of the licensed site and an analysis of how that aligns with the child’s immediate needs. It might also include details of any additional staffing supports that will be provided to the child, if admitted and any additional services and supports that will be provided to respond to any immediate needs of the child. For example, where applicable, the licensee should identify how the unique needs of an Indigenous child/youth will be met in the setting, including connecting the child/youth’s FNIM band or community.</span>

                            <br />

                        </div>
                    </div>

                    @if( ($formData['is_child_appropriate_for_placement']??1) == 1)
                        <div class="card-primary">
                        <div class="card-header">
                            <div class="card-title">Type of Placement</div>
                        </div>
                        <div class="card-body">
                            <x-adminlte-textarea wire:ignore  label="What kind of home does child do best in?" class='marker marker-prefix-PA_PH00' name="top1"  wire:model="formData.aik" />

                            <div class="form-group">
                                <span class="text-bold">The names of the proposed foster parent or parents, the date on which the foster parent or parents were approved to provide foster care and an assessment of whether the	parent or parents have access to the supports and have completed the training necessary to meet the child’s immediate needs, as described in the foster parent’s foster parent learning plan.</span>
                                <div class="input-group">
                                    <select class="select-input select2 marker marker-prefix-PA_PH00" wire:model="formData.foster_parent_id" style="width:100%;"> {{-- old=formData.aim --}}
                                        <option value="">Select Foster Parent</option>
                                        @foreach(\App\Models\User::query()->whereIn('user_type', \App\CustomClasses\DynamicExpenseBuilder\ExpenseConfig::roleMapping()['foster-parent'])->get() as $fosterUser)
                                            <option value="{{$fosterUser->id}}">{{$fosterUser->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <x-adminlte-textarea label="Foster Parent Other Details" wire:ignore class='marker marker-prefix-PA_PH00' name="top3"  wire:model="formData.foster_parent_other_details" />


                            <span class="text-bold">Details of any support services available to and training provided to the proposed foster parent or parents, as well as any training completed by the proposed foster parent or parents, that are relevant to the care of the child.</span>
                            <x-adminlte-textarea wire:ignore class='marker marker-prefix-PA_PH00' name="top3"  wire:model="formData.ail" />

                            <x-adminlte-textarea wire:ignore  label="The total number of children and adults already receiving out of home care at the time of the proposed placement." class='marker marker-prefix-PA_PH00' name="top4"  wire:model="formData.aio" />

                            <span class="text-bold">The ages, gender and information about the needs of the persons already receiving foster
                            care in the home at the time of the proposed placement, as well as services and supports
                            required to meet those needs, that might impact on the services to be provided to the
                            proposed placement.</span>
                            <x-adminlte-textarea wire:ignore class=' marker marker-prefix-PA_PH00' name="top5"  wire:model="formData.aip" />

                            <span class="text-bold">The total number of persons living in the proposed foster home and any information about
                            those persons that is known to the licensee that is relevant to the care to be provided to
                                the child whose placement is being proposed.</span>
                            <x-adminlte-textarea wire:ignore class='marker marker-prefix-PA_PH00' name="top6"  wire:model="formData.aiq" />


                        </div>
                    </div>
                    @endif

                </div>


                <div class="card-primary">
                    <div class="card-header">
                        <div class="card-title">Signature</div>
                    </div>
                    <div class="card-body">


                        <div class="form-group">
                            <label for="sig1">Signature of Licensee</label>
                            <div class="input-group">
                                @include('livewire.forms.case-manage.temp.signature-input', ['sigName' => 'signature_of_licensee'])
                            </div>
                        </div>

                        <x-adminlte-date-range label="Date Report Prepared" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.date_report_prepared" name="date_report_prepared" igroup-size="sm" :config="$config"/>

                        <x-adminlte-date-range label="Date Report Shared with Placing Agency" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.date_report_shared_with_placing_agency" name="date_report_shared_with_placing_agency" igroup-size="sm" :config="$config"/>

                    </div>
                </div>
            </div>

        </x-form>


        @unless($autoSave)
            <button class="hide-on-print" type="submit">Submit</button>
            &nbsp;
        @endunless

        <span style="width:200px;" class="hide-on-print float-right ml-3 mb-0 pb-0">
            @if(isset($formData['placement_worker_id']) && isset($formData['child_name']))
                <button wire:click="onEmail" type="button" class="mb-2 btn-sm btn-success waves-effect">
                    <i class="fas fa-envelope pr-2" aria-hidden="true"></i>Email
                </button>
            @else
                <button wire:click="onEmail" type="button" class="mb-2 btn-sm btn-default waves-effect"
                        disabled title="Placement Worker & Child Name is Required!">
                    <i class="fas fa-envelope pr-2" aria-hidden="true"></i>Email
                </button>
            @endif

        </span>


        @livewire('forms.case-manage.temp.email-link-sharing')

        @section('form-controls')
{{--            <a href="#" onclick="printForm()">jQuery Printer</a>&nbsp;--}}
{{--            <a class="btn btn-danger btn-default" href="/pdfView/3/{{$formDataId}}">PDF</a>--}}
        @endsection

        @include('livewire.forms.case-manage.temp.signature-scripts')
    </form>

</div>
