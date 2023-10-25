<div>
    <style>
        .form-heading{
            text-align: center;
            font-weight: bold;
            padding-top: 2em;
        }

        .loop-item-remover unless-read-only{
            margin-left: 1em;
        }
    </style>

    @php
        $config = [
            "singleDatePicker" => true,
            "showDropdowns" => true,
            "minYear" => 2020,
            "maxYear" => 2030,
            "timePicker" => false,
            "timePicker24Hour" => false,
            "timePickerSeconds" => false,
            "cancelButtonClasses" => "btn-danger",
            "locale" => ["format" => "YYYY-MM-DD"],
        ];
    @endphp

    <form wire:submit.prevent="submit">

        <h5 class="form-heading">Safety Assessment / Safety Plan</h5>
        <br/>


        {{--IDENTIFY THE REASON(S) FOR THE COMPLETION OF THE SAFETY ASSESSMENT:--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">IDENTIFY THE REASON(S) FOR THE COMPLETION OF THE SAFETY ASSESSMENT</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-check">
                    <input type="checkbox" class="marker marker-prefix-SASP_IRSA00" value="1" wire:model="formData.aen">
                    <label class="form-check-label">Safety assessment required prior to the child/youth’s admission into a licenced site or placement in a foster home.</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="marker marker-prefix-SASP_IRSA00" value="1" wire:model="formData.aeo">
                    <label class="form-check-label">Safety assessment required for a child or youth currently residing in a licensed setting, during the development of their written plan of care.</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="marker marker-prefix-SASP_IRSA00" value="1" wire:model="formData.aep">
                    <label class="form-check-label">Safety assessment required for a child or youth currently residing in licensed setting, during the review of their written plan of care.</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="marker marker-prefix-SASP_IRSA00" value="1" wire:model="formData.aeq">
                    <label class="form-check-label">Safety assessment required following a situation in which the child or youth has engaged in behaviour that may pose a risk to the safety of themselves or others.</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="marker marker-prefix-SASP_IRSA00" value="1" wire:model="formData.aer">
                    <label class="form-check-label">Safety assessment had not been completed prior to the new requirements which come into effect on July 1, 2023, and the child resided in the licensed setting prior to that date.</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="marker marker-prefix-SASP_IRSA00" value="1" wire:model="formData.aes">
                    <label class="form-check-label">Safety assessment to review pre-existing safety plan created by placing agency and determine if the information is still accurate, where applicable <sup>2</sup>.</label>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <br/>


        {{--IDENTIFYING INFORMATION--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">IDENTIFYING INFORMATION</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <x-adminlte-input label="Name" class='table-input marker marker-prefix-SASP_INFO00' name="aac" wire:model="formData.aac"/>
                <x-adminlte-date-range class="data-picker marker marker-prefix-SASP_INFO00" label="D.O.B" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.aad" name="aad" igroup-size="sm" :config="$config"/>
                <x-adminlte-input label="C.S.W." class='table-input marker marker-prefix-SASP_INFO00' name="aaf" wire:model="formData.aaf"/>
                <x-adminlte-input label="Children’s Aid Society" class='table-input marker marker-prefix-SASP_INFO00' name="aag" wire:model="formData.aag"/>
                <br/>
                <h4><u>Cultural / Religious:</u></h4>
                <x-adminlte-input label="Ethnic background" class='table-input marker marker-prefix-SASP_INFO00' name="aah" wire:model="formData.aah"/>
                <x-adminlte-input label="Status" class='table-input marker marker-prefix-SASP_INFO00' name="aai" wire:model="formData.aai"/>
                <x-adminlte-input label="Band affiliated" class='table-input marker marker-prefix-SASP_INFO00' name="aaj" wire:model="formData.aaj"/>
                <x-adminlte-input label="Language(s) spoken" class='table-input marker marker-prefix-SASP_INFO00' name="aak" wire:model="formData.aak"/>
                <x-adminlte-input label="Cultural/Religious background" class='table-input marker marker-prefix-SASP_INFO00' name="aal" wire:model="formData.aal"/>
                <div class="form-group radio-options marker marker-prefix-SASP_INFO00">
                    <label>Any important cultural/religious/spiritual practices?</label>

                    <div class="form-check">
                        <input class="form-radio-input" name="aam" value="1" wire:model="formData.aam" type="radio">
                        <label class="form-check-label">Yes</label>
                    </div>

                    <div class="form-check">
                        <input class="form-radio-input" name="aam" value="0" wire:model="formData.aam" type="radio">
                        <label class="form-check-label">No</label>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <br/>


        {{--MEDICAL INFORMATION--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">MEDICAL INFORMATION</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <x-adminlte-input label="Health Card #" class='table-input marker marker-prefix-SASP_MI00' name="aap" wire:model="formData.aap"/>
                <x-adminlte-input label="Physician" class='table-input marker marker-prefix-SASP_MI00' name="aaq" wire:model="formData.aaq"/>
                <x-adminlte-input label="Allergies" class='table-input marker marker-prefix-SASP_MI00' name="aar" wire:model="formData.aar"/>
                <x-adminlte-input label="Food Restrictions" class='table-input marker marker-prefix-SASP_MI00' name="aas" wire:model="formData.aas"/>
                <x-adminlte-input label="Medical Condition (if applicable)" class='table-input marker marker-prefix-SASP_MI00' name="aat" wire:model="formData.aat"/>
                <x-adminlte-input label="Medication (if applicable)" class='table-input marker marker-prefix-SASP_MI00' name="aaw" wire:model="formData.aaw"/>
                <x-adminlte-input label="PRN’s" class='table-input marker marker-prefix-SASP_MI00' name="aax" wire:model="formData.aax"/>
                <x-adminlte-input label="Diagnosed with" class='table-input marker marker-prefix-SASP_MI00' name="aay" wire:model="formData.aay"/>
                <div class="form-group">
                    <b>A summary of any behaviours the child engages in that may pose a risk to the safety of themselves or others, or any other risks to the child’s safety</b>
                    <br/>
                    <x-adminlte-textarea rows="{{$this->getRowHeight('formData.aaz')}}" class='table-input marker marker-prefix-SASP_MI00' name="aaz" wire:model="formData.aaz" />
                </div><div class="form-group">
                    <b>Brief overview of the material or documents reviewed when completing the assessment above, including any Serious Occurrence Reports or other information collected by the licensee as part of the pre-admission/placement assessment process</b>
                    <br/>
                    <x-adminlte-textarea rows="{{$this->getRowHeight('formData.aba')}}" class='table-input marker marker-prefix-SASP_MI00' name="aba" wire:model="formData.aba" />
                </div><div class="form-group">
                    <b>View of the person or agency placing the child/youth or who placed the child regarding any safety risks identified for the child/youth</b>
                    <br/>
                    <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abb')}}" class='table-input marker marker-prefix-SASP_MI00' name="abb" wire:model="formData.abb" />
                </div>
                <div class="form-group">
                    <b><span class="text-danger">*</span> View of the child/youth’s FNIM band or community regarding any safety risks identified for the child/youth</b>
                    <br/>
                    <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abc')}}" class='table-input marker marker-prefix-SASP_MI00' name="abc" wire:model="formData.abc" />
                </div>

                <div class="form-group radio-options marker marker-prefix-SASP_MI00">
                    <label>
                        <sup class="text-danger no-print"><em>(Q1) &nbsp;</em></sup>Based on the results of the safety assessment, does the child engage in behaviours that may pose a risk to the safety of themselves or others or are there other risks to the safety of the child?
                    </label>

                    <div class="form-check">
                        <input class="form-check-input" name="is_child_behavior_and_safety_risky" value="1" wire:model="formData.is_child_behavior_and_safety_risky" type="radio">
                        <label class="form-check-label">Yes</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" name="is_child_behavior_and_safety_risky" value="0" wire:model="formData.is_child_behavior_and_safety_risky" type="radio">
                        <label class="form-check-label">No</label>
                    </div>

                    <p style="margin-top: 4px;"><span class="text-danger">*</span> If yes, a safety plan is required.</p>
                </div>

                <br/>

                <div class="form-group radio-options marker marker-prefix-SASP_MI00">
                    <label>
                        <sup class="text-danger no-print"><em>(Q2) &nbsp;</em></sup>Is it the view of the person who is placing or who placed the child or the placing agency, as the case may be, that a safety plan is needed?
                    </label>

                    <div class="form-check">
                        <input class="form-check-input" name="placer_recommends_safety_plan" value="1" wire:model="formData.placer_recommends_safety_plan" type="radio">
                        <label class="form-check-label">Yes</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" name="placer_recommends_safety_plan" value="0" wire:model="formData.placer_recommends_safety_plan" type="radio">
                        <label class="form-check-label">No</label>
                    </div>

                    <p style="margin-top: 4px;"><span class="text-danger">*</span> If yes, a safety plan is required.</p>
                </div>

                <div class="form-group">
                    <b><span class="text-danger">*</span> Child/youth’s view of safety assessment:</b>
                    <br/>
                    <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abh')}}" class='table-input marker marker-prefix-SASP_MI00' name="abh" wire:model="formData.abh" />
                </div>

                <div class="form-group">
                    <span>
                        <input type="checkbox" class="marker marker-prefix-SASP_MI00" name="XX_NAME" value="1" wire:model="formData.abj">
                        <b>Rationale for <u>not</u> requiring a Safety Plan:</b>
                    </span>
                    <br/><i>[Provide a rationale for why a safety plan is not required, based on the results of the safety assessment]</i>
                    <br/>
                    <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abk')}}" class='table-input marker marker-prefix-SASP_MI00' name="abk" wire:model="formData.abk" />
                </div>

                <x-adminlte-date-range label="Date of Safety Assessment Completion" class="data-picker marker marker-prefix-SASP_MI00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.abl" name="abl" igroup-size="sm" :config="$config"/>

            </div>
            <!-- /.card-body -->
        </div>


        @if($needsASafetyPlan)
            <br/><hr style="border-style: solid; border-color: red; border-width: 2px; width: 50%;"><br/>

            {{--Safety Plan--}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Safety Plan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    {{--EMERGENCY CONTACT(S)--}}
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">EMERGENCY CONTACT(S)</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <x-adminlte-input label="Foster Parent (address & Phone #):" class='marker marker-prefix-SASP_EC00' name="aaa"  wire:model="formData.aaa"/>
                            <x-adminlte-input label="Case Manager:" class='marker marker-prefix-SASP_EC00' name="aab"  wire:model="formData.aab"/>
                            <div class="form-group">
                                <label>Carpe Diem on call:</label>
                                <br/>
                                905-799-2947 Dial 8
                            </div>
                            <div class="form-group">
                                <label>Incident reports and Serious occurrences are sent to the following email:</label>
                                <br/>
                                ir@carpediem.ca
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <br/>

                    <div class="form-group">
                        <b>Child Risks:
                            <br><br>
                            Describe the child/youth’s behaviours that may pose a risk to the safety of the child or youth
                        </b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abm')}}" class='table-input marker marker-prefix-SASP_SP00' name="abm" wire:model="formData.abm" placeholder="For example: The child engages in self-harming behaviour (further describe the behaviour) and has suicidal ideations; the child has a history of frequent unexplained absences; known involvement in sex trafficking" />
                    </div>

                    <div class="form-group">
                        <b>Describe the child/youth’s behaviours that may pose a risk to the safety of others and any other reasons for which the safety of the child or youth is at risk</b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abn')}}" class='table-input marker marker-prefix-SASP_SP00' name="abn" wire:model="formData.abn" placeholder="For example: The child has a history of being physically aggressive toward staff and peers" />
                    </div>

                    <div class="form-group">
                        <b>Safety Measures:
                            <br><br>
                            Describe safety measures, including the amount of any supervision required, to prevent the child or youth from engaging in behaviours that may pose a risk to the safety of the child/youth or others or to otherwise protect the child/youth and which are informed by the information provided by the person who is placing or who placed the child/youth or the placing agency respecting the safety measures that should be implemented
                        </b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abo')}}" class='table-input marker marker-prefix-SASP_SP00' name="abo" wire:model="formData.abo" placeholder="For example: Describe how the child will receive 1:1 staffing supervision, 24 hours a day in the licenced setting to assist in preventing the child from engaging in self-harming behaviours. Describe how the child will receive regular (weekly) counselling to assist in addressing concerns about engagement in self-harming behaviours." />
                    </div>


                    <div class="form-group">
                        <b>Procedures:
                            <br><br>
                            Describe procedures to be followed by the licensee’s staff and any other persons providing direct care to the child/youth on behalf of the licensee (including foster parents) in circumstances in which the child engages in behaviours referred to above or in which the safety of the child is otherwise at risk.
                        </b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abp')}}" class='table-input marker marker-prefix-SASP_SP00' name="abp" wire:model="formData.abp" placeholder="For example:  In the case of a child who frequently has unexplained absences from the out of home care setting, ensure they have a cell phone." />
                    </div>

                    <div class="form-group">
                        <b>Additional Support:
                            <br><br>
                            Describe any recommendations, to which licensee has access, from persons that provided or are providing specialized consultation services, specialized treatment, or other clinical supports to address the child/youths behaviours described above]. *Include the child/youth’s views on what is most helpful and effective, where applicable.
                        </b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abq')}}" class='table-input marker marker-prefix-SASP_SP00' name="abq" wire:model="formData.abq" placeholder="For example: Medication reviews to be conducted to determine if medication is at appropriate levels." />
                    </div>


                    <div class="form-group">
                        <b>Date(s) of meeting(s) with the child regarding safety plan development:</b>
                        <br><b>Note:</b> It is a requirement for the child to be engaged on the development of their safety plan, to the extent possible given their age and maturity.
                        <br>
                        <b>
                            <span class="text-danger">* </span>Document in the child/youth’s words, what supports they would need and what situations/action could indicate they are having difficulty, as well as coping strategies the child or youth finds effective:
                        </b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abr')}}" class='table-input marker marker-prefix-SASP_SP00' name="abr" wire:model="formData.abr" />
                    </div>

                    <div class="form-group">
                        <b>If the child was not involved in the development of their safety plan, indicate the reasons why and a description of any efforts made to engage them (to the extent possible given their age and maturity):</b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.abs')}}" class='table-input marker marker-prefix-SASP_SP00' name="abs" wire:model="formData.abs" />
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Additional participants <u>required</u> to be engaged on the development of the child’s safety plan, in addition to the child themselves (to the extent possible given their age and maturity):
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php($rowCount = ($formData['additional_participants']['row_count']??1))
                            @for($r = 1; $r<=$rowCount; $r++ )
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Additional participant #{{$r}}</h3>
                                       @unless ($printMode)
                                        <span class="loop-item-remover unless-read-only btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"additional_participants"}}', {{$r}})">Remove Row</span>
                                        @endunless
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <x-adminlte-input label="name" class='table-input marker marker-prefix-SASP_SP00' name="additional_participants_{{$r}}_name" wire:model="formData.additional_participants.{{$r}}.name"/>
                                        <x-adminlte-input label="Contact Information" class='table-input marker marker-prefix-SASP_SP00' name="additional_participants_{{$r}}_contact_information" wire:model="formData.additional_participants.{{$r}}.contact_information"/>
                                        <x-adminlte-input label="Role or Relationship, if applicable" class='table-input marker marker-prefix-SASP_SP00' name="additional_participants_{{$r}}_role" wire:model="formData.additional_participants.{{$r}}.role"/>
                                        <x-adminlte-date-range class="data-picker marker marker-prefix-SASP_SP00" label="Date Consulted" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.additional_participants.{{$r}}.date_consulted" name="additional_participants_{{$r}}_date_consulted" igroup-size="sm" :config="$config"/>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @endfor

                            @unless($printMode)
                                <div class="row unless-read-only">
                                    <div class="footer-note">
                                        <b>Note:</b> Duplicate additional lines as required.
                                        <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"additional_participants"}}')">Add Row</span>
                                        <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"additional_participants"}}')">Remove Row</span>
                                    </div>
                                </div>
                            @endunless
                        </div>
                    </div>

                    <div class="form-group">
                        <b>If the placing agency was not involved in the development of the child’s safety plan, indicate the reasons why and a description of any efforts made to engage them (only applicable if the placing agency is not the licensee):</b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.acl')}}" class='table-input marker marker-prefix-SASP_SP00' name="acl" wire:model="formData.acl" />
                    </div>

                    <div class="form-group">
                        <b>If the child’s parent(s) were not involved in the development of the child’s safety plan, indicate the reasons why and a description of any efforts made to engage them (where appropriate):</b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.acm')}}" class='table-input marker marker-prefix-SASP_SP00' name="acm" wire:model="formData.acm" />
                    </div>

                    <div class="form-group">
                        <b>If the child’s foster parent(s) were not involved in the development of the child’s safety plan, indicate the reasons why and a description of any efforts made to engage them (where applicable):</b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.acn')}}" class='table-input marker marker-prefix-SASP_SP00' name="acn" wire:model="formData.acn" />
                    </div>

                    <div class="form-group">
                        <b>In the case of a FNIM child, if a representative chosen by the child’s band or FNIM community was not involved in the development of the safety plan indicate the reasons why and a description of any efforts to engage them:</b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.aco')}}" class='table-input marker marker-prefix-SASP_SP00' name="aco" wire:model="formData.aco" />
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <b>Additional <u>optional</u> participants in the development of the child’s safety plan: </b>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php($rowCount = ($formData['participants_in_development']['row_count']??1))
                            @for($r = 1; $r<=$rowCount; $r++ )
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Participants in Development #{{$r}}</h3>
                                       @unless ($printMode)
                                        <span class="loop-item-remover unless-read-only btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"participants_in_development"}}', {{$r}})">Remove Row</span>
                                        @endunless
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <x-adminlte-input label="Name" class='table-input marker marker-prefix-SASP_SP00' name="participants_in_development_{{$r}}_name" wire:model="formData.participants_in_development.{{$r}}.name" placeholder="[Insert the names of optional participants that were engaged in the development of the child’s safety plan]"/>
                                        <x-adminlte-input label="Contact Information" class='table-input marker marker-prefix-SASP_SP00' name="participants_in_development_{{$r}}_contact_information" wire:model="formData.participants_in_development.{{$r}}.contact_information"/>
                                        <x-adminlte-input label="Role" class='table-input marker marker-prefix-SASP_SP00' name="participants_in_development_{{$r}}_role" wire:model="formData.participants_in_development.{{$r}}.role"/>
                                        <x-adminlte-date-range label="Date Consulted" class="data-picker marker marker-prefix-SASP_SP00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.participants_in_development.{{$r}}.date_consulted" name="participants_in_development_{{$r}}_date_consulted" igroup-size="sm" :config="$config"/>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @endfor

                            @unless($printMode)
                                <div class="row unless-read-only">
                                    <div class="footer-note">
                                        <b>Note:</b> Duplicate additional lines as required.
                                        <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"participants_in_development"}}')">Add Row</span>
                                        <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"participants_in_development"}}')">Remove Row</span>
                                    </div>
                                </div>
                            @endunless
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Indicate the date and format the safety plan was provided to each participate
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php($rowCount = ($formData['safety_plan_dates']['row_count']??1))
                            @for($r = 1; $r<=$rowCount; $r++ )
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Safety Plan Date #{{$r}}</h3>
                                        @unless ($printMode)
                                        <span class="loop-item-remover unless-read-only btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"safety_plan_dates"}}', {{$r}})">Remove Row</span>
                                        @endunless
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <x-adminlte-input label="Name of participant and role" class='table-input marker marker-prefix-SASP_SP00' name="safety_plan_dates_{{$r}}_name" wire:model="formData.safety_plan_dates.{{$r}}.name"/>
                                        <x-adminlte-date-range label="Date safety plan provided" class="data-picker marker marker-prefix-SASP_SP00" onchange="this.dispatchEvent(new InputEvent('input'))" name="formData_safety_plan_dates_{{$r}}_date" wire:model="formData.safety_plan_dates.{{$r}}.date" igroup-size="sm" :config="$config"/>
                                        <x-adminlte-input label="Format" class='table-input marker marker-prefix-SASP_SP00' name="safety_plan_dates_{{$r}}_format" wire:model="formData.safety_plan_dates.{{$r}}.format"/>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            @endfor

                            @unless($printMode)
                                <div class="row unless-read-only">
                                    <div class="footer-note">
                                        <b>Note:</b> Duplicate additional lines as required.
                                        <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"safety_plan_dates"}}')">Add Row</span>
                                        <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"safety_plan_dates"}}')">Remove Row</span>
                                    </div>
                                </div>
                            @endunless
                        </div>
                    </div>

                    <div class="form-group radio-options marker marker-prefix-SASP_SP00">
                        <label>
                            <b><span class="text-danger">*</span> Has a safety plan been developed by the placing agency and provided to the licensee to be reviewed and considered when developing the safety plan? </b>
                        </label>

                        <div class="form-check">
                            <input class="form-check-input" name="adl" value="1" wire:model="formData.adl" type="radio">
                            <label class="form-check-label">Yes</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" name="adl" value="0" wire:model="formData.adl" type="radio">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <br/>
        @endif


        @if($formStageIndex == 1 || $formStageIndex == 2)
            <br/><hr style="border-style: solid; border-color: red; border-width: 2px; width: 50%;"><br/>

            {{--Safety Plan Review--}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Safety Plan Review</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <x-adminlte-date-range label="Date of safety plan review initiation:" class="data-picker marker marker-prefix-SASP_SPR00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.adn" name="adn" igroup-size="sm" :config="$config"/>
                    <x-adminlte-date-range label="Date of safety plan review completion:" class="data-picker marker marker-prefix-SASP_SPR00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.ado" name="ado" igroup-size="sm" :config="$config"/>

                    <div class="form-group">
                        <label>
                            <b>A review of the safety plan must occur when any of the following occurs. Indicate which action has prompted an immediate review of the safety plan:</b>
                        </label>

                        <div class="form-check">
                            <input type="checkbox" class="marker marker-prefix-SASP_SPR00" value="1" wire:model="formData.adp">
                            <label class="form-check-label">The child/youth has engaged in behaviour that poses a risk to the safety of themselves or others or a situation has occurred in which the child/youth is put at risk.</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="marker marker-prefix-SASP_SPR00" value="1" wire:model="formData.adq">
                            <label class="form-check-label">An incident occurs during which the measures set out in the safety plan are shown to be ineffective in preventing the child/youth from engaging in behaviours that may pose a risk to the safety of the child or others or from otherwise being put at risk.</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="marker marker-prefix-SASP_SPR00" value="1" wire:model="formData.adr">
                            <label class="form-check-label">New information comes to the attention of the licensee respecting the safety risks posed by the child, or to which the child/youth’s subject, or behaviours of the child that has implications for the information contained in the safety plan.</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="marker marker-prefix-SASP_SPR00" value="1" wire:model="formData.ads">
                            <label class="form-check-label">The child/youth or a person consulted with and involved in developing the safety plan has requested that the safety plan be reviewed.</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="marker marker-prefix-SASP_SPR00" value="1" wire:model="formData.adt">
                            <label class="form-check-label">The Child’s Plan of Care is being developed or being reviewed.</label>
                        </div>
                    </div>

                    <div class="form-group radio-options marker marker-prefix-SASP_SPR00">
                        <label>
                            <b>Based on the review, does the current safety plan still adequately keep the child/ youth and others safe?</b>
                        </label>

                        <div class="form-check">
                            <input class="form-check-input" name="adu" value="1" wire:model="formData.adu" type="radio">
                            <label class="form-check-label">Yes</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" name="adu" value="0" wire:model="formData.adu" type="radio">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <b>Indicate the rationale:</b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.adw')}}" class='table-input marker marker-prefix-SASP_SPR00' name="adw" wire:model="formData.adw" />
                    </div>

                    <div class="form-group">
                        <b>Indicate the person(s) who were involved in determining the current safety plan still adequately keeps the child/youth and others safe:</b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.adx')}}" class='table-input marker marker-prefix-SASP_SPR00' name="adx" wire:model="formData.adx" />
                    </div>

                    <div class="form-group">
                        <b>
                            Note: Once a licensee has determined that a review of updated safety plan is required, they must ensure that the same process and requirements for the development of a Safety Plan under the Development of a Safety Plan as above are followed. This process also highlighted under O. Reg. 156/18, s. 86.4  and O. Reg. 156/18, s. 129.1.
                        </b>
                        <br/>
                        Summarize any amendments that were made to the safety plan as a result of the review:
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.ady')}}" class='table-input marker marker-prefix-SASP_SPR00' name="ady" wire:model="formData.ady" />
                    </div>

                    <div class="form-group">
                        <b>
                            Describe information that was considered about the child/youth’s behaviours that informed the review of the safety plan, including but not limited to information collected from the child’s foster parent or parents and persons providing direct care to the child on behalf of the licensee
                        </b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.adz')}}" class='table-input marker marker-prefix-SASP_SPR00' name="adz" wire:model="formData.adz" />
                    </div>

                    <div class="form-group">
                        <b>
                            Describe any recommendations received by the licensee from any individual named as a resource person for the child under section 5 or any person who provides direct care to the child on behalf of the licensee, other than the foster parent or parents, are incorporated into the safety plan.
                        </b>
                        <br/>
                        <x-adminlte-textarea rows="{{$this->getRowHeight('formData.aea')}}" class='table-input marker marker-prefix-SASP_SPR00' name="aea" wire:model="formData.aea" />
                    </div>

                </div>
                <!-- /.card-body -->
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <b>Identify the following information on persons who provide direct care to the child/youth, including foster parents where applicable. Completing the chart below should indicate that these persons have reviewed the safety plan or amended safety plan.</b>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @php($rowCount = ($formData['direct_care_people']['row_count']??1))
                    @for($r = 1; $r<=$rowCount; $r++ )
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Direct Care Person #{{$r}}</h3>
                                @unless ($printMode)
                                    <span class="loop-item-remover unless-read-only btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"direct_care_people"}}', {{$r}})">Remove Row</span>
                                @endunless
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <x-adminlte-input label="Full Name" class='table-input marker marker-prefix-SASP_SPR00' name="direct_care_people_{{$r}}_full_name" wire:model="formData.direct_care_people.{{$r}}.full_name"/>
                                <x-adminlte-input label="Role" class='table-input marker marker-prefix-SASP_SPR00' name="direct_care_people_{{$r}}_role" wire:model="formData.direct_care_people.{{$r}}.role"/>
                                <x-adminlte-date-range label="Date" class="data-picker marker marker-prefix-SASP_SPR00" onchange="this.dispatchEvent(new InputEvent('input'))" name="direct_care_people_{{$r}}_date" wire:model="formData.direct_care_people.{{$r}}.date" igroup-size="sm" :config="$config"/>
                                <x-adminlte-input label="Initials" class='table-input marker marker-prefix-SASP_SPR00' name="direct_care_people_{{$r}}_initials" wire:model="formData.direct_care_people.{{$r}}.initials"/>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    @endfor

                    @unless($printMode)
                        <div class="row unless-read-only">
                            <div class="footer-note">
                                <b>Note:</b> Duplicate additional lines as required.
                                <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"direct_care_people"}}')">Add Row</span>
                                <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"direct_care_people"}}')">Remove Row</span>
                            </div>
                        </div>
                    @endunless
                </div>
                <!-- /.card-body -->
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    Where applicable, identify the following information on <b>persons who supervise or support foster parents.</b> Completing the chart below should indicate that these persons have reviewed the safety plan or amended safety plan.
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @php($rowCount = ($formData['supervise_or_support_people']['row_count']??1))
                    @for($r = 1; $r<=$rowCount; $r++ )
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Supervise Or Support Person #{{$r}}</h3>
                                @unless ($printMode)
                                    <span class="loop-item-remover unless-read-only btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"supervise_or_support_people"}}', {{$r}})">Remove Row</span>
                                @endunless
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <x-adminlte-input label="Full Name" class='table-input marker marker-prefix-SASP_SPR00' name="supervise_or_support_people_{{$r}}_full_name" wire:model="formData.supervise_or_support_people.{{$r}}.full_name"/>
                                <x-adminlte-input label="Role" class='table-input marker marker-prefix-SASP_SPR00' name="supervise_or_support_people_{{$r}}_role" wire:model="formData.supervise_or_support_people.{{$r}}.role"/>
                                <x-adminlte-date-range label="Date" class="data-picker marker marker-prefix-SASP_SPR00" onchange="this.dispatchEvent(new InputEvent('input'))" name="supervise_or_support_people_{{$r}}_date" wire:model="formData.supervise_or_support_people.{{$r}}.date" igroup-size="sm" :config="$config"/>
                                <x-adminlte-input label="Initials" class='table-input marker marker-prefix-SASP_SPR00' name="supervise_or_support_people_{{$r}}_initials" wire:model="formData.supervise_or_support_people.{{$r}}.initials"/>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    @endfor

                    @unless($printMode)
                        <div class="row unless-read-only">
                            <div class="footer-note">
                                <b>Note:</b> Duplicate additional lines as required.
                                <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"supervise_or_support_people"}}')">Add Row</span>
                                <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"supervise_or_support_people"}}')">Remove Row</span>
                            </div>
                        </div>
                    @endunless
                </div>
                <!-- /.card-body -->
            </div>

            <p>
                <br>
                The licensee is required to ensure that the child’s safety plan is reviewed by the following persons:
                <br>1.	Any person providing direct care to the child on behalf of the licensee, including in the case of a foster child, the child’s foster parents.
                <br>2.	In the case of a foster child, the person assigned by the licensee to supervise and support the foster parents.
                <br>
            </p>

            <div class="card card-primary">
                <div class="card-header">
                    <i>Indicate the date and format the safety plan was provided to each participate.</i>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @php($rowCount = ($formData['safety_plan_participates']['row_count']??1))
                    @for($r = 1; $r<=$rowCount; $r++ )
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Supervise Or Support Person #{{$r}}</h3>
                                @unless ($printMode)
                                    <span class="loop-item-remover unless-read-only btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"safety_plan_participates"}}', {{$r}})">Remove Row</span>
                                @endunless
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <x-adminlte-input label="Name of participant and role" class='table-input marker marker-prefix-SASP_SPR00' name="safety_plan_participates_{{$r}}_name" wire:model="formData.safety_plan_participates.{{$r}}.name"/>
                                <x-adminlte-date-range label="Date amended safety plan provided" class="data-picker marker marker-prefix-SASP_SPR00" onchange="this.dispatchEvent(new InputEvent('input'))" name="safety_plan_participates_{{$r}}_date" wire:model="formData.safety_plan_participates.{{$r}}.date" igroup-size="sm" :config="$config"/>
                                <x-adminlte-input label="Format" class='table-input marker marker-prefix-SASP_SPR00' name="safety_plan_participates_{{$r}}_format" wire:model="formData.safety_plan_participates.{{$r}}.format"/>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    @endfor

                    @unless($printMode)
                        <div class="row unless-read-only">
                            <div class="footer-note">
                                <b>Note:</b> Duplicate additional lines as required.
                                <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"safety_plan_participates"}}')">Add Row</span>
                                <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"safety_plan_participates"}}')">Remove Row</span>
                            </div>
                        </div>
                    @endunless
                </div>
                <!-- /.card-body -->
            </div>

        @endif

        @unless($printMode)
            <br/>
            <hr/>

            @if($formStageIndex == 2)
                <span style="width:200px;" class="hide-on-print float-right ml-3 mb-0 pb-0">
                    <span class="text-success">
                        All Complete <i class="fas fa-check-circle"></i>
                    </span>
                </span>
            @elseif($formStageIndex == 1)
                <span style="width:200px;" class="hide-on-print float-right ml-3 mb-0 pb-0">
                    <button wire:click="submitReview" type="button" class="mb-2 btn-sm btn-primary waves-effect">
                        <i class="fas fa-check-double" aria-hidden="true"></i> Mark As Reviewed
                    </button>
                </span>
            @else {{-- $formStageIndex == 0 --}}
                @unless($canSubmitAssessment)
                    <span class="text-danger float-right"><em>Q1 & Q2 has to answered! </em></span>
                @endunless

                <span style="width:200px;" class="hide-on-print float-right ml-3 mb-0 pb-0">
                    <button wire:click="submitAssessment" type="button" class="mb-2 btn-sm btn-success waves-effect"  @unless($canSubmitAssessment) disabled @endunless>
                        <i class="fas fa-clipboard-check" aria-hidden="true"></i> Submit Assessment
                    </button>
                </span>
            @endif

            @unless($autoSave)
                <button type="submit">Submit</button>
            @endunless
        @endunless
    </form>

</div>
