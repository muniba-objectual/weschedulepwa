<div>


    @php

        $eyeColours = ["Brown", "Blue", "Green", "Hazel", "Other"];

        $hairColours = ["Black", "Brown", "Blonde", "Red", "Other"];

        $culturalReligiousEthnicBackgrounds = ["Indigenous", "Canadian", "Jamaican", "Ethiopian", "Nigerian", "Middle Eastern", "Portuguese", "Italian", "Jewish", "Greek", "Asian", "South Asian", "Pakistan", "European", "Caribbean", "Latin", "Other"];

        $culturalReligiousLanguages = ["English", "French", "Spanish", "Chinese", "Farsi", "Punjabi", "Urdu", "Hindi", "Other"];

        $ethnicBackgroundCulRelBgs = ["Catholic", "Islam", "Judaism", "Greek Orthodox", "Buddhism", "Hindu", "Sikhism", "Wicca", "Atheist", "Muslim", "None", "Other"];

        $careStatusList = ["Extended Society Care", "Interim society care", "Temporary care agreement", "Customary care", "Legally independent adult", "COTA", "VYSA", "Other"];

    @endphp

    <h5 class="form-heading text-center">Pre-Admission/Pre-Placement</h5>

    <div class="container-fluid">
        <div class="form-group">

        {{--            IDENTIFY INFORMATION--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">IDENTIFYING INFORMATION</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <?php
                $dateOfRequest = isset($formData['date_of_request']) ? $formData['date_of_request'] : '';
                $dateOfFormCompletion = isset($formData['date_of_form_completion']) ? $formData['date_of_form_completion'] : '';
                $placingAgencyId = isset($formData['placing_agency_id']) ? $formData['placing_agency_id'] : '';
                $placementAgency = null;
                $placementAgencyWorkers = [];

                if ($placingAgencyId && is_numeric($placingAgencyId)) {
                    $placementAgency = \App\Models\PlacingAgency::find($placingAgencyId);
                    $placementAgencyWorkers = $placementAgency
                        ->workers()
                        ->where('type', \App\Models\PlacingAgencyWorkers::WORKER_TYPE__PLACEMENT_WORKER)
                        ->whereNotNull('email') // you need the email address to send the email form
                        ->get() ?? [];
                }
                ?>

                <div class="row">
                    <div class="col-6">
                            <div class="form-group">
                                <label for="date-of-request">Date of Request</label>
                                <div class="input-group">
                                    {{ $dateOfRequest }}
                                </div>
                            </div>



                        <div class="form-group">
                            <label for="date-of-form-completion">Date of Form Completion</label>
                            <div class="input-group">
                                {{ $dateOfFormCompletion }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="referring-agency">Referring Agency</label>
                            <div class="input-group">
                                <span class="sub-text">{!! isset($placementAgency)? $placementAgency->name : '<i>N/A</i>' !!}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="referring-agency-address">Referring Agency Address</label>
                            <div class="input-group">
                                {{ $placementAgency ? $placementAgency->address : 'N/A' }}
                            </div>
                        </div>
                </div>

                    <div class="col-6">
                            <div class="form-group">
                                <label for="agency-telephone">Agency Telephone</label>
                                <div class="input-group">
                                    {{ $placementAgency ? $placementAgency->telephone : 'N/A' }}
                                </div>
                            </div>

                            @if ($placementAgency)
                                <div class="form-group">
                                    <label for="placement-worker">Placement Worker</label>
                                    <div class="input-group">
                                        <span class="sub-text">{!! $placementAgencyWorkers->where('id', $formData['placement_worker_id'])->first()->name ?? '<i>N/A</i>' !!}</span>
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="placement-worker">Placement Worker</label>
                                    <div class="input-group">
                                        <span class="sub-text"><i>N/A</i></span>
                                    </div>
                                </div>

                @endif

                <div class="form-group">
                    <label for="form-completed-by">Form Completed By</label>
                    <div class="input-group">
                        {{ $formData['edited_by']['name'] ?? auth()->user()->name }}
                    </div>
                </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        {{--            CHILD INFORMATION--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">CHILD INFORMATION</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
           <div class="row">
               <div class="col-6">
                        <div class="form-group">
                            <label for="child-name">Child Name</label>
                            <div class="input-group">
                                {{ $formData['child_name'] ?? '' }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="child-dob">D.O.B</label>
                            <div class="input-group">
                                {{ $formData['child_dob'] ?? '' }}
                            </div>
                        </div>
               </div>



                    <div class="col-6">
                <div class="form-group">
                    <label for="child-age">Age</label>
                    <div class="input-group">
                        {{ isset($formData['child_dob']) ? \Carbon\Carbon::parse($formData['child_dob'])->age.' Yrs' : 'N/A' }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="child-pronouns">Identity/Pronouns</label>
                    <div class="input-group">
                        {{ $formData['child_identity_or_pro_nouns'] ?? '' }}
                    </div>
                </div>
                    </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        {{--            CHILD DESCRIPTION--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">CHILD DESCRIPTION</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="row">


                    <div class="col-6">

                            <div class="form-group">
                                <h4>Cultural/Religious</h4>

                                <div class="form-group">
                                    <label for="ethnic-background">Ethnic Background</label>
                                    <div class="input-group">
                                        {{ $formData['ethic_background'] ?? '' }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <div class="input-group">
                                        {{ $formData['care_status'] ?? '' }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="band-affiliated">Band Affiliated</label>
                                    <div class="input-group">
                                        {{ $formData['band_affiliated'] ?? '' }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="languages">Language(s) Spoken</label>
                                    <div class="input-group">
                                        {{ $formData['languages'] ?? '' }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cultural-background">Cultural/Religious Background</label>
                                    <div class="input-group">
                                        {{ $formData['cultural_religious_background'] ?? '' }}
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="has-cultural-practices">Any Important Cultural/Religious/Spiritual Practices?</label>
                                <div class="input-group">
                                    {{ isset($formData['has_cultural_religious_spiritual_practices']) ? ($formData['has_cultural_religious_spiritual_practices'] == 1 ? 'Yes' : 'No') : 'N/A' }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cultural-description">Describe</label>
                                <div class="input-group">
                                    {{ $formData['cultural_religious_spiritual_practices_description'] ?? '' }}
                                </div>
                            </div>
                </div>

                    <div class="col-6" style="margin-top:35px">
                    <div class="form-group">
                        <label for="height">Height</label>
                        <div class="input-group">
                            {{ $formData['height'] ?? '' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hair-colour">Hair Colour</label>
                        <div class="input-group">
                            {{ $formData['hair_colour'] ?? '' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="eye-colour">Eye Colour</label>
                        <div class="input-group">
                            {{ $formData['eye_colour'] ?? '' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="weight">Weight</label>
                        <div class="input-group">
                            {{ $formData['weight'] ?? '' }}
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="other">Other</label>
                        <div class="input-group">
                            {{ $formData['Other'] ?? '' }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="child-strengths">Strengths of the child, including information about their personality, aptitudes and abilities</label>
                        <div class="input-group">
                            {{ $formData['strengths_personality_aptitudes_abilities'] ?? '' }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->



        {{--REASON FOR PLACEMENT --}}
        <div class="card card-primary page_break_before">
            <div class="card-header">
                <h3 class="card-title">REASON FOR PLACEMENT</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="row">
                    <div class="col-6">

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" {{ ($formData['new_placement']??0) == 1 ? 'checked' : '' }} disabled>
                            <label class="form-check-label">NEW PLACEMENT</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" {{ ($formData['placement_breakdown']??0) == 1 ? 'checked' : '' }} disabled>
                            <label class="form-check-label">PLACEMENT BREAKDOWN</label>
                        </div>

                    </div>
                    </div>

                    <div class="col-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" {{ ($formData['placement_change']??0) == 1 ? 'checked' : '' }} disabled>
                            <label class="form-check-label">PLACEMENT CHANGE</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" {{ ($formData['relief']??0) == 1 ? 'checked' : '' }} disabled>
                            <label class="form-check-label">RELIEF</label>
                        </div>
                        </div>



                    <div class="form-group">
                        <label for="kinship-placement">KINSHIP PLACEMENT CONSIDERED</label>
                        <div class="input-group">
                            {{ isset($formData['has_kinship_placement']) ? ($formData['has_kinship_placement'] == 1 ? 'Yes' : 'No') : 'N/A' }}
                        </div>
                        <div class="form-group mt-3">
                            <label for="kinship-explain">Explain</label>
                            <div class="input-group">
                                {{ $formData['has_kinship_placement_reason'] ?? '' }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="basic-child-in-care">Basis on which the child is in care?</label>
                            <div class="input-group">
                                {{ $formData['basis_on_which_the_child_is_in_care'] ?? '' }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="child-objectives">The Objectives of Placing Child</label>
                            <div class="input-group">
                                {{ $formData['placing_child_objectives'] ?? '' }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="child-what-occurred">What has occurred to prompt this placement request</label>
                            <div class="input-group">
                                {{ $formData['reason_to_prompt_this_placement_request'] ?? '' }}
                            </div>
                        </div>
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
                                <div class="col-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['no_unusual_behaviours']) && $formData['no_unusual_behaviours'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">No unusual behaviours</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['age_appropriate_social_interaction']) && $formData['age_appropriate_social_interaction'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Positive/age-appropriate social interaction with peers</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['positive_social_interaction_with_adults']) && $formData['positive_social_interaction_with_adults'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Positive social interaction with adults</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['is_caring']) && $formData['is_caring'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Caring</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['adaptable']) && $formData['adaptable'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Adaptable</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['timid']) && $formData['timid'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Timid</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['difficulty_reading_social_cues']) && $formData['difficulty_reading_social_cues'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Difficulty reading social cues</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['unpredictable']) && $formData['unpredictable'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Unpredictable</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['unhappy']) && $formData['unhappy'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Unhappy</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['lack_of_or_flat_affect']) && $formData['lack_of_or_flat_affect'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Lack of or flat affect</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['hyperactive_adhd_add']) && $formData['hyperactive_adhd_add'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Hyperactive/ADHD/ADD</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['short_attention_span']) && $formData['short_attention_span'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Short attention span</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['impulsive']) && $formData['impulsive'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Impulsive</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['instigates_conflict']) && $formData['instigates_conflict'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Instigates conflict</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['is_demanding']) && $formData['is_demanding'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Demanding</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['has_temper_tantrums']) && $formData['has_temper_tantrums'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Temper tantrums</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['is_known_for_gang_involvement']) && $formData['is_known_for_gang_involvement'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Known gang involvement</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['physically_aggressive']) && $formData['physically_aggressive'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Physically aggressive</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['chronic_lying']) && $formData['chronic_lying'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Chronic lying</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['verbally_aggressive']) && $formData['verbally_aggressive'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Verbally aggressive</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['smokes']) && $formData['smokes'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Smokes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['using_drugs_alcohol']) && $formData['using_drugs_alcohol'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Using drugs/alcohol</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['difficulty_following_instructions']) && $formData['difficulty_following_instructions'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Difficulty following instructions</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['carrying_weapons']) && $formData['carrying_weapons'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Carrying weapons</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['fire_setting']) && $formData['fire_setting'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Fire setting</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" {{ isset($formData['toilet_trained']) && $formData['toilet_trained'] == 1 ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Toilet trained (for younger children)</label>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="form-group">
                                    <label for="immediate-needs-description" style="margin-top: 10px;">Description</label>
                                    <p>{{ $formData['immediate_needs_description'] ?? '' }}</p>
                                </div>
                                </div>
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
                                <div class="col-6">

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" {{ isset($formData['depression']) && $formData['depression'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Depression</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" {{ isset($formData['suicidal']) && $formData['suicidal'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Suicidal</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" {{ isset($formData['mental_health_diagnosis']) && $formData['mental_health_diagnosis'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Mental health diagnosis</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" {{ isset($formData['threatened_injured_self']) && $formData['threatened_injured_self'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Threatened/Injured Self</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" {{ isset($formData['bed_wetting_soiling']) && $formData['bed_wetting_soiling'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Bed-wetting/soiling</label>
                                    </div>


                                </div>

                                <div class="col-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" {{ isset($formData['eat_sleep_disorder']) && $formData['eat_sleep_disorder'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Eat/sleep disorder</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" {{ isset($formData['self_abusive']) && $formData['self_abusive'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Self-abusive</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" {{ isset($formData['head_banging']) && $formData['head_banging'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Head-banging</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" {{ isset($formData['hair_pulling']) && $formData['hair_pulling'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Hair pulling</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" {{ isset($formData['history_of_being_in_care_previously']) && $formData['history_of_being_in_care_previously'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">History of being in care previously</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top: 10px;">
                                <label for="other-safety-concerns">Is the child/youth currently involved with any support services (e.g. counseling)? </label>
                                <p>{{ isset($formData['afd']) ? ($formData['afd'] == 1 ? 'Yes' : 'No') : 'N/A' }}</p>
                            </div>

                            <div class="form-group" style="margin-top: 10px;">
                                <label for="child-support-services-explain" style="margin-top: 10px;">If yes, where?</label>
                                <p>{{ $formData['aff'] ?? '' }}</p>
                            </div>

                            <div class="form-group" style="margin-top: 10px;">
                                <label for="child-support-services-description" style="margin-top: 10px;">Description</label>
                                <p>{{ $formData['afg'] ?? '' }}</p>
                            </div>
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
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" {{ isset($formData['afh']) && $formData['afh'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Ability to demonstrate age-appropriate behavior</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" {{ isset($formData['afj']) && $formData['afj'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Inappropriate in public</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" {{ isset($formData['afl']) && $formData['afl'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">No difficulties eating/restrictions</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" {{ isset($formData['afn']) && $formData['afn'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Dietary restrictions/allergies</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" {{ isset($formData['afp']) && $formData['afp'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Vegetarian</label>
                                    </div>

                                </div>

                                <div class="col">
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" {{ isset($formData['afi']) && $formData['afi'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Cultural dietary needs</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" {{ isset($formData['afk']) && $formData['afk'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Diagnosed eating disorder</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" {{ isset($formData['afm']) && $formData['afm'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Age-appropriate hygiene skills</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" {{ isset($formData['afi']) && $formData['afi'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Cultural dietary needs</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" {{ isset($formData['afq']) && $formData['afq'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Needs assistance with hygiene</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="self-care-description" style="margin-top: 10px;">Description</label>
                                <p>{{ $formData['afr'] ?? '' }}</p>
                            </div>
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
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" {{ isset($formData['afs']) && $formData['afs'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Settles easy into family setting</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" {{ isset($formData['afu']) && $formData['afu'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">Difficulty in family setting</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" {{ isset($formData['afw']) && $formData['afw'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">History of parent/family mental health issues</label>
                                    </div>


                                </div>

                                <div class="col">
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" {{ isset($formData['aft']) && $formData['aft'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">History of family/domestic violence</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" {{ isset($formData['afv']) && $formData['afv'] ? 'checked' : '' }} disabled>
                                        <label class="form-check-label">History of parent substance usage</label>
                                    </div>


                                </div>
                            </div>
                            <div class="form-group">
                                <label for="family-relationship-description" style="margin-top: 10px;">Describe</label>
                                <p>{{ $formData['afx'] ?? '' }}</p>
                            </div>
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
                                <div class="col-6">

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" disabled <?php echo isset($formData['afy']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">No major issues</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" disabled <?php echo isset($formData['afz']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Modified program</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" disabled <?php echo isset($formData['aga']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Attends school regularly</label>
                                    </div>

                                </div>

                                <div class="col-6">
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" disabled <?php echo isset($formData['agb']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Truancy/Attendance issues</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" disabled <?php echo isset($formData['agc']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">IEP</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" disabled <?php echo isset($formData['agd']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Disruptive behaviour in classroom</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" disabled <?php echo isset($formData['age']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Section 20</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" disabled <?php echo isset($formData['agf']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Frequent suspensions from school</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" disabled <?php echo isset($formData['agg']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Learning disability</label>
                                    </div>

                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col">
                                    <label>Current school attending</label>
                                    {{ $formData['agh'] ?? '' }}
                                </div>

                                <div class="col">
                                    <label>Current grade level</label>
                                    {{ $formData['agi'] ?? '' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label>Special program</label>
                                    {{ $formData['agj'] ?? '' }}
                                </div>

                                <div class="col">
                                    <label>School Address</label>
                                    {{ $formData['agk'] ?? '' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label>Other</label>
                                    {{ $formData['agl'] ?? '' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label>Description</label>
                                    {{ $formData['agm'] ?? '' }}
                                </div>
                            </div>

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
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['agq']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">No medical issues</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['ags']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Diagnosed medical issue/condition</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['agu']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Medical attention/procedure required</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['agw']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Seizures</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['agy']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Asthma</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['aha']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Allergies/Allergic Reactions</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['ahc']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Medically Fragile</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['ahe']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Low birth weight</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['ahg']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Complex/tube feeding</label>
                                    </div>

                                </div>

                                <div class="col">
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['agr']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Encopresis (soiling)</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['agt']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Enuresis (bed wetting)</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['agv']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Autistic/PDD</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['agx']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">FAS/FASD</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['agz']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">HIV or HIV exposed</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['ahb']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">STD</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['ahd']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">HEP</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['ahf']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Diabetic</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" disabled <?php echo isset($formData['ahh']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Speech/language issues</label>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col mt-3">
                                    <label>If other, please describe:</label>
                                    {{ $formData['ahi'] ?? '' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label>Medical/therapeutic services active or required:</label>
                                    {{ $formData['ahj'] ?? '' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mt-3">
                                    <label>Doctor:</label>
                                    {{ $formData['ahk'] ?? '' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label>Medications (drug, dosage, what prescribed for):</label>
                                    {{ $formData['ahl'] ?? '' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label>Allergies (medications, pollen, pets, etc):</label>
                                    {{ $formData['ahm'] ?? '' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label>Does the child have any anaphylactic reactions?</label>
                                    {{ $formData['ahn'] ?? '' }}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label>Description:</label>
                                    {{ $formData['aho'] ?? '' }}
                                </div>
                            </div>

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
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['ahp']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Gay</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['ahr']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Lesbian</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['aht']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Bisexual</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['ahv']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Transsexual</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['ahx']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Not Applicable</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['ahz']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Heterosexual</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['aib']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Struggling to identify sexual orientation</label>
                                    </div>

                                </div>

                                <div class="col">
                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['ahq']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Healthy understanding of sexual health</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['ahs']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Human Trafficking</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['ahu']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Sexually acting out</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['ahw']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Sexually active</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['aia']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Intrusive</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" disabled <?php echo isset($formData['aic']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label">Masturbation: normal or excessive</label>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label style="margin-top: 10px;">Description:</label>
                                    {{ $formData['agm'] ?? '' }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">FAMILY CONTACT</div>
                    </div>
                    <div class="card-body">
                        {{--                                        Access--}}
                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="card-title">Access</div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="access-pap" style="margin-top: 10px;">Potential Access Plan</label>
                                                <p>{{ $formData['aja'] ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="access-who" style="margin-top: 10px;">Who</label>
                                                <p>{{ $formData['ajb'] ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="access-prohib" style="margin-top: 10px;">Prohibited Contacts</label>
                                                <p>{{ $formData['ajc'] ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--Siblings--}}
                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="card-title">Siblings</div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="sibs1" style="margin-top: 10px;">Are there siblings in care? Where?</label>
                                                <p>{{ $formData['air'] ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="sibs2" style="margin-top: 10px;">Can you place close proximity to them?</label>
                                                <p>{{ $formData['ais'] ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--Other--}}
                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="card-title">Other</div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="other1" style="margin-top: 10px;">Guidelines for telephone contact</label>
                                    <p>{{ $formData['ajd'] ?? '' }}</p>
                                </div>
                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="other-concerns">Concerns with child/youth being placed in same community as family?</label>
                                    <p>{{ isset($formData['aje']) ? ($formData['aje'] == 1 ? 'Yes' : 'No') : 'N/A' }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="other-concerns-desc" style="margin-top: 10px;">Describe</label>
                                    <p>{{ $formData['ajg'] ?? '' }}</p>
                                </div>
                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="other-safety-concerns">Safety concerns (placement or access)?</label>
                                    <p>{{ isset($formData['ajh']) ? ($formData['ajh'] == 1 ? 'Yes' : 'No') : 'N/A' }}</p>
                                </div>
                                <div class="form-group">
                                    <label for="other-concerns-safety-desc" style="margin-top: 10px;">Describe</label>
                                    <p>{{ $formData['ajj'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{--FAMILY CONTACT--}}
        <div class="card-primary">
            <div class="card-header">
                <div class="card-title">Placement History/Considerations</div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">Previous Placement History</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="pph_list_all_placements" style="margin-top: 10px;">Please list all previous placements</label>
                        <p>{{ $formData['aih'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="pph2" style="margin-top: 10px;">Consider past placements for the child. What is the reason for placement breakdowns?</label>
                        <p>{{ $formData['aii'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="pph3" style="margin-top: 10px;">Consider past placements for the child. What does their history mean?</label>
                        <p>{{ $formData['aij'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="pph4" style="margin-top: 10px;">Does child have multiple placement history? More than 2?</label>
                        <p>{{ $formData['ait'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="pph5" style="margin-top: 10px;">Is this a risk of break down?</label>
                        <p>{{ $formData['aiu'] ?? '' }}</p>
                    </div>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">Type of Placement</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="top1" style="margin-top: 10px;">What kind of home does child do best in?</label>
                        <p>{{ $formData['aik'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <span class="text-bold">The names of the proposed foster parent or parents, the date on which the foster parent or parents were approved to provide foster care and an assessment of whether the parent or parents have access to the supports and have completed the training necessary to meet the child’s immediate needs, as described in the foster parent’s foster parent learning plan.</span>
                        <p>{{ $formData['aim'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <span class="text-bold">The names of the proposed foster parent or parents, the date on which the foster parent or parents were approved to provide foster care and an assessment</span>
                        <p>{{ $formData['ail'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="top4" style="margin-top: 10px;">The total number of children and adults already receiving out of home care at the time of the proposed placement.</label>
                        <p>{{ $formData['aio'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <span class="text-bold">The ages, gender and information about the needs of the persons already receiving foster care in the home at the time of the proposed placement, as well as services and supports required to meet those needs, that might impact on the services to be provided to the proposed placement.</span>
                        <p>{{ $formData['aip'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <span class="text-bold">The total number of persons living in the proposed foster home and any information about those persons that is known to the licensee that is relevant to the care to be provided to the child whose placement is being proposed.</span>
                        <p>{{ $formData['aiq'] ?? '' }}</p>
                    </div>
                </div>
            </div>



            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">Immediate Needs Evaluation</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="is_child_appropriate_for_placement" style="margin-top: 10px;">Child appropriate for placement?</label>
                        <p>{{ isset($formData['is_child_appropriate_for_placement']) ? ($formData['is_child_appropriate_for_placement'] == 1 ? 'Yes' : 'No') : 'N/A' }}</p>

                    </div>
                    <div class="form-group">
                        <label for="child_counselling" style="margin-top: 10px;">**NOTE - IF YES SAFETY ASSESSMENT NEEDS TO BE GENERATED**</label>
                    </div>
                    <div class="form-group">
                        <label for="INE1" style="margin-top: 10px;">Details of how the licensee determined that the child's immediate needs will be met if admitted</label>
                        <p>{{ $formData['aie'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="INE2" style="margin-top: 10px;">Details of any immediate needs of the child that cannot be met.</label>
                        <p>{{ $formData['aif'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="INE3" style="margin-top: 10px;">Details of how any immediate needs that cannot be met will otherwise be met.</label>
                        <p>{{ $formData['aig'] ?? '' }}</p>
                    </div>
                    <br />
                    <span>*The details of how the licensee determined the child’s immediate needs will be met if admitted should include details of the program offered by the licensee, staff training and the population of the licensed site and an analysis of how that aligns with the child’s immediate needs. It might also include details of any additional staffing supports that will be provided to the child, if admitted and any additional services and supports that will be provided to respond to any immediate needs of the child. For example, where applicable, the licensee should identify how the unique needs of an Indigenous child/youth will be met in the setting, including connecting the child/youth’s FNIM band or community.</span>
                    <br />
                </div>
            </div>


            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">Signature</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="sig1">Signature of Licensee</label>
                        <br />
                        <img src="{{$formData['signature_of_licensee']??''}}">
{{--                        @include('livewire.forms.case-manage.temp.signature-input', ['sigName' => 'signature_of_licensee', 'printMode' => true])--}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_report_prepared">Date Report Prepared</label>
                        <p>{{ $formData['date_report_prepared'] ?? '' }}</p>
                    </div>
                    <div class="form-group">
                        <label for="date_report_shared_with_placing_agency">Date Report Shared with Placing Agency</label>
                        <p>{{ $formData['date_report_shared_with_placing_agency'] ?? '' }}</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>
    @include('livewire.forms.case-manage.temp.signature-scripts')

</div>
