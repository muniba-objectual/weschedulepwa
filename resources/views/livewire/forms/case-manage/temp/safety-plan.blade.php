<div>
    <style type="text/css">
        .form-heading{
            text-align: center;
            font-weight: bold;
            margin-top: 2.5em;
            margin-bottom: 1.5em;
            text-decoration: underline;
        }

        .section-header-center{
            text-align: center;
        }

        .section-header-left{
            text-align: left !important;
        }

        .section{
            padding-top: 1em;
            padding-bottom: 1em;
        }

        .section .section-header{
            background: #dcdada;

            padding-left: 0.5em;
            padding-top: 0.5em;
            padding-bottom: 0.75em;

            margin-top: 2em;
            margin-bottom: 0.75em;

            font-weight: bold;
            font-size: 1.2em;
        }

        .section .section-header .sub-text{ /*override*/
            font-weight: normal;
            font-size: 0.75em;
        }

        .section .section-body table, .section .section-body table td{
            border: 1px solid black;
        }

        .section .section-body table .grid-header{
            text-align: center;
            font-weight: bold;
            background: #c3d8ea;
        }

        .section .section-body table .grid-header.blue-fill{
            background: #96cffa;
        }

        .section .section-body table .grid-header .sub-text{
            font-weight: normal; /*override*/
        }

        .section .section-body table .grid-header td{
            padding-left: 0.5em;
            padding-right: 0.5em;
        }

        .section .section-body table .table-content-footer{
            text-align: center;
            background: #eee6e6;
            font-style: italic;
        }

        .section .section-body table td .radio-options {
            display: inline; /** Not working properly */
        }

        .section .section-body table td .table-input{
            width: 100%;
            border: none;
        }

        .section .section-body table td .select-input{
            width: 100%;
            border: none;
        }

        .section .section-body table td.data-picker{
            width: 8em;
        }

        .section .section-body table td.data-picker .form-group{
            margin-bottom: 0rem !important; /** Override bootstrap */
            border: transparent;
        }

        .section .footer-note{
            font-style: italic;
        }

        .borderless td:not(.borderless td td){
            border: none !important;
        }

        .word-wrap{
            word-wrap: break-word;
        }
    </style>


    @php
        $config = [
            "singleDatePicker" => true,
            "showDropdowns" => true,
            "startDate" => "js:moment()",
            "minYear" => 2020,
            "maxYear" => 2023,
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

        {{--EMERGENCY CONTACT(S)--}}
        <div class="section">
            <div class="section-body">
                <table>
                    <tr class="blue-fill grid-header">
                        <td colspan="2">EMERGENCY CONTACT(S)</td>
                    </tr>
                    <tr>
                        <td>Foster Parent (address & Phone #):</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_EC00' wire:model="formData.aaa" /></td>
                    </tr>
                    <tr>
                        <td>Case Manager:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_EC00' wire:model="formData.aab" /></td>
                    </tr>
                    <tr>
                        <td>Carpe Diem on call:</td>
                        <td>905-799-2947 Dial 8</td>
                    </tr>
                    <tr>
                        <td>Incident reports and Serious occurrences are sent to the following email:</td>
                        <td>ir@carpediem.ca</td>
                    </tr>
                </table>
            </div>
        </div>


        {{--IDENTIFYING INFORMATION--}}
        <div class="section">
            <div class="section-body">
                <table>
                    <tr class="blue-fill grid-header">
                        <td colspan="2">IDENTIFYING INFORMATION</td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>D.O.B.:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aad" /></td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aae" /></td>
                    </tr>
                    <tr>
                        <td>C.S.W.:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aaf" /></td>
                    </tr>
                    <tr>
                        <td>Children’s Aid Society:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aag" /></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><u>Cultural / Religious:</u></b></td>
                    </tr>
                    <tr>
                        <td>Ethnic background:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aah" /></td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aai" /></td>
                    </tr>
                    <tr>
                        <td>Band affiliated:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aaj" /></td>
                    </tr>
                    <tr>
                        <td>Language(s) spoken:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aak" /></td>
                    </tr>
                    <tr>
                        <td>Cultural/Religious background:</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aal" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom: none;">Any important cultural/religious/spiritual practices?</td>
                    </tr>
                    <tr>
                        <td style="border-top: none; border-right: none;">
                            <span class="radio-options marker marker-prefix-SASP_INFO00">

                                <label>Yes </label>
                                <input type="radio" name="formData.aam" value="1" wire:model="formData.aam">

                                &nbsp;&nbsp;

                                <label>No </label>
                                <input type="radio" name="formData.aam" value="0" wire:model="formData.aan">

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span>Describe:</span>
                            </span>
                        </td>
                        <td style="border-top: none; border-left: none;">
                            <input style="width: 50em;" type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aao" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        {{--MEDICAL INFORMATION--}}
        <div class="section">
            <div class="section-body">
                <table>
                    <tr class="blue-fill grid-header">
                        <td colspan="3">MEDICAL INFORMATION</td>
                    </tr>
                    <tr>
                        <td>Health Card #:</td>
                        <td colspan="2"><input type='text' class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aap" /></td>
                    </tr>
                    <tr>
                        <td>Physician:</td>
                        <td colspan="2"><input type='text' class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaq" /></td>
                    </tr>
                    <tr>
                        <td>Allergies:</td>
                        <td colspan="2"><input type='text' class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aar" /></td>
                    </tr>
                    <tr>
                        <td>Food Restrictions:</td>
                        <td colspan="2"><input type='text' class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aas" /></td>
                    </tr>
                    <tr>
                        <td>Medical Condition (if applicable):</td>
                        <td colspan="2"><input type='text' class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aat" /></td>
                    </tr>
                    <tr>
                        <td>Medication (if applicable):</td>
                        <td colspan="2"><input type='text' class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaw" /></td>
                    </tr>
                    <tr>
                        <td>PRN’s:</td>
                        <td colspan="2"><input type='text' class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aax" /></td>
                    </tr>
                    <tr>
                        <td>Diagnosed with:</td>
                        <td colspan="2"><input type='text' class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aay" /></td>
                    </tr>



                    <tr>
                        <td colspan="3">
                            <p>
                                <b>A summary of any behaviours the child engages in that may pose a risk to the safety of themselves or others, or any other risks to the child’s safety:</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <p>
                                <b>Brief overview of the material or documents reviewed when completing the assessment above, including any Serious Occurrence Reports or other information collected by the licensee as part of the pre-admission/placement assessment process:</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aba" /></textarea>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <p>
                                <b>View of the person or agency placing the child/youth or who placed the child regarding any safety risks identified for the child/youth:</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.abb" /></textarea>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <p>
                                <b><span class="text-danger">*</span> View of the child/youth’s FNIM band or community regarding any safety risks identified for the child/youth:</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.abc" /></textarea>
                            </p>
                        </td>
                    </tr>

                    {{--                    <tr><td>col1</td>col2<td></td><td>col3</td></tr>--}}

                    <tr>
                        <td class="word-wrap" colspan="2">Based on the results of the safety assessment, does the child engage in behaviours that may pose a risk to the safety of themselves or others or are there other risks to the safety of the child? </td>
                        <td style="min-width: 15em;">
                            <span class="radio-options marker marker-prefix-SASP_MI00">
                                <span>
                                    <label>Yes </label>
                                    <input type="radio" name="formData.abd" value="1" wire:model="formData.abd">
                                </span>
                                <br>
                                <span>
                                    <label>No </label>
                                    <input type="radio" name="formData.abd" value="0" wire:model="formData.abe">
                                </span>
                                <br><br>
                                <span><span class="text-danger">*</span> If yes, a safety plan is required.</span>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="word-wrap" colspan="2">Is it the view of the person who is placing or who placed the child or the placing agency, as the case may be, that a safety plan is needed?</td>
                        <td style="min-width: 15em;">
                            <span class="radio-options marker marker-prefix-SASP_MI00">
                                <span>
                                    <label>Yes </label>
                                    <input type="radio" name="formData.abf" value="1" wire:model="formData.abf">
                                </span>
                                <br>
                                <span>
                                    <label>No </label>
                                    <input type="radio" name="formData.abf" value="0" wire:model="formData.abg">
                                </span>
                                <br><br>
                                <span><span class="text-danger">*</span> If yes, a safety plan is required.</span>
                            </span>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="3">
                            <p>
                                <b><span class="text-danger">*</span> Child/youth’s view of safety assessment:</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.abh" /></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <p>
                                <b><span class="text-danger">*</span> Child/youth’s view of safety assessment:</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.abi" /></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <p>
                                <span>
                                    <input type="checkbox" class="marker marker-prefix-SASP_MI00" name="XX_NAME" value="1" wire:model="formData.abj">
                                    <b>Rationale for <u>not</u> requiring a Safety Plan:</b>
                                </span>
                                <br/><i>[Provide a rationale for why a safety plan is not required, based on the results of the safety assessment]</i>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.abk" /></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <b>Date of Safety Assessment Completion: </b>
                        </td>
                        <td colspan="2" class="data-picker marker marker-prefix-SASP_MI00">
                            <x-adminlte-date-range  onchange="this.dispatchEvent(new InputEvent('input'))"  wire:model="formData.abl" name="XXX_date_picker31" igroup-size="sm" :config="$config"/>
                        </td>
                        <td></td>
                    </tr>

                </table>
            </div>
        </div>


        {{--Safety Plan--}}
        <div class="section">
            <div class="section-body">
                <table class="borderless">
                    <tr class="blue-fill grid-header">
                        <td colspan="2">Safety Plan</td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Child Risks:
                                    <br><br>
                                    Describe the child/youth’s behaviours that may pose a risk to the safety of the child or youth
                                </b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abm">
                                    For example: The child engages in self-harming behaviour (further describe the behaviour) and has suicidal ideations; the child has a history of frequent unexplained absences; known involvement in sex trafficking
                                </textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Describe the child/youth’s behaviours that may pose a risk to the safety of others and any other reasons for which the safety of the child or youth is at risk</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abn">
                                    For example: The child has a history of being physically aggressive toward staff and peers.
                                </textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Safety Measures:
                                    <br><br>
                                    Describe safety measures, including the amount of any supervision required, to prevent the child or youth from engaging in behaviours that may pose a risk to the safety of the child/youth or others or to otherwise protect the child/youth and which are informed by the information provided by the person who is placing or who placed the child/youth or the placing agency respecting the safety measures that should be implemented
                                </b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abo">
                                    For example: Describe how the child will receive 1:1 staffing supervision, 24 hours a day in the licenced setting to assist in preventing the child from engaging in self-harming behaviours. Describe how the child will receive regular (weekly) counselling to assist in addressing concerns about engagement in self-harming behaviours.
                                </textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Procedures:
                                    <br><br>
                                    Describe procedures to be followed by the licensee’s staff and any other persons providing direct care to the child/youth on behalf of the licensee (including foster parents) in circumstances in which the child engages in behaviours referred to above or in which the safety of the child is otherwise at risk.
                                </b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abp">
                                    For example:  In the case of a child who frequently has unexplained absences from the out of home care setting, ensure they have a cell phone.
                                </textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Additional Support:
                                    <br><br>
                                    Describe any recommendations, to which licensee has access, from persons that provided or are providing specialized consultation services, specialized treatment, or other clinical supports to address the child/youths behaviours described above]. *Include the child/youth’s views on what is most helpful and effective, where applicable.
                                </b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abq">
                                    For example: Medication reviews to be conducted to determine if medication is at appropriate levels.
                                </textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Date(s) of meeting(s) with the child regarding safety plan development:</b>
                                <br><b>Note:</b> It is a requirement for the child to be engaged on the development of their safety plan, to the extent possible given their age and maturity.
                                <br>
                                <b>
                                    <span class="text-danger">* </span>Document in the child/youth’s words, what supports they would need and what situations/action could indicate they are having difficulty, as well as coping strategies the child or youth finds effective:
                                </b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abr"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>If the child was not involved in the development of their safety plan, indicate the reasons why and a description of any efforts made to engage them (to the extent possible given their age and maturity):</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abs"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Additional participants <u>required</u> to be engaged on the development of the child’s safety plan, in addition to the child themselves (to the extent possible given their age and maturity):</b>
                                <br/><br/>
                            <table>
                                <tr class="grid-header">
                                    <td>Name</td>
                                    <td>Contact Information</td>
                                    <td>Role or Relationship, if applicable</td>
                                    <td>Date Consulted</td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abt" placeholder="[Insert name of placing agency representative if the placing agency is not the licensee]"/></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abw" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abx" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.aby" /></td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.abz" placeholder="[Insert name of child’s parents, if appropriate] "/></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.aca" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acb" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acc" /></td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acd" placeholder="Insert name of foster parent or parent(s) if appropriate"/></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.ace" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acf" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acg" /></td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.ach" placeholder="[In the case of a First Nation, Inuk or Métis child, the name of a representative chosen by each of the child’s First Nation, Inuit or Métis communities]"/></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.aci" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acj" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.ack" /></td>
                                </tr>
                            </table>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>If the placing agency was not involved in the development of the child’s safety plan, indicate the reasons why and a description of any efforts made to engage them (only applicable if the placing agency is not the licensee):</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acl"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>If the child’s parent(s) were not involved in the development of the child’s safety plan, indicate the reasons why and a description of any efforts made to engage them (where appropriate):</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acm"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>If the child’s foster parent(s) were not involved in the development of the child’s safety plan, indicate the reasons why and a description of any efforts made to engage them (where applicable):</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acn"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>In the case of a FNIM child, if a representative chosen by the child’s band or FNIM community was not involved in the development of the safety plan indicate the reasons why and a description of any efforts to engage them:</b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.aco"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Additional <u>optional</u> participants in the development of the child’s safety plan: </b>
                                <br/><br/>

                            <table style="width: 100%">
                                <tr class="grid-header">
                                    <td>Name</td>
                                    <td>Contact Information</td>
                                    <td>Role</td>
                                    <td>Date Consulted</td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acp" placeholder="[Insert the names of optional participants that were engaged in the development of the child’s safety plan]"/></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acq" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acr" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acs" /></td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.act" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acw" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acx" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acy" /></td>
                                </tr>
                            </table>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <br/>
                                <span class="text-gray-900"><i>Indicate the date and format the safety plan was provided to each participate.</i></span>
                                <br/>

                            <table style="width: 100%">
                                <tr class="grid-header">
                                    <td>Name of participant and role</td>
                                    <td>Date safety plan provided</td>
                                    <td>Format</td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.acz" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.ada" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.adb" /></td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.adc" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.add" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.ade" /></td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.adf" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.adg" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.adh" /></td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.adi" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.adj" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SP00' wire:model="formData.adk" /></td>
                                </tr>
                            </table>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <br/>
                                <b><span class="text-danger">*</span> Has a safety plan been developed by the placing agency and provided to the licensee to be reviewed and considered when developing the safety plan? </b>
                                <br/><br/>
                                <span style="min-width: 15em;" class="radio-options marker marker-prefix-SASP_SP00">
                                    <span>
                                        <label>Yes </label>
                                        <input type="radio" name="formData.adl" value="1" wire:model="formData.adl">
                                    </span>

                                    &nbsp;&nbsp;&nbsp;

                                    <span>
                                        <label>No </label>
                                        <input type="radio" name="formData.adl" value="0" wire:model="formData.adm">
                                    </span>
                                </span>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>


        {{--Safety Plan Review--}}
        <div class="section">
            <div class="section-body">
                <table class="borderless">
                    <tr class="blue-fill grid-header">
                        <td colspan="2">Safety Plan Review</td>
                    </tr>

                    <tr>
                        <td><b>Date of safety plan review initiation:</b></td>
                        <td class="data-picker marker marker-prefix-SASP_SPR00">
                            <x-adminlte-date-range name="XXX_date_picker32" wire:model="formData.adn" igroup-size="sm" :config="$config"/>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Date of safety plan review initiation:</b></td>
                        <td class="data-picker marker marker-prefix-SASP_SPR00">
                            <x-adminlte-date-range name="XXX_date_picker33" wire:model="formData.ado" igroup-size="sm" :config="$config"/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <b>
                                A review of the safety plan must occur when any of the following occurs. Indicate
                                which action has prompted an immediate review of the safety plan:
                            </b>
                            <br/>
                            <table class="borderless">
                                <tr>
                                    <td><input type="checkbox" class="marker marker-prefix-SASP_SPR00" name="XX_NAME" value="1" wire:model="formData.adp"></td>
                                    <td>The child/youth has engaged in behaviour that poses a risk to the safety of themselves or others or a situation has occurred in which the child/youth is put at risk.</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="marker marker-prefix-SASP_SPR00" name="XX_NAME" value="1" wire:model="formData.adq"></td>
                                    <td>An incident occurs during which the measures set out in the safety plan are shown to be ineffective in preventing the child/youth from engaging in behaviours that may pose a risk to the safety of the child or others or from otherwise being put at risk.</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="marker marker-prefix-SASP_SPR00" name="XX_NAME" value="1" wire:model="formData.adr"></td>
                                    <td>New information comes to the attention of the licensee respecting the safety risks posed by the child, or to which the child/youth’s subject, or behaviours of the child that has implications for the information contained in the safety plan.</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="marker marker-prefix-SASP_SPR00" name="XX_NAME" value="1" wire:model="formData.ads"></td>
                                    <td>The child/youth or a person consulted with and involved in developing the safety plan has requested that the safety plan be reviewed.</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="marker marker-prefix-SASP_SPR00" name="XX_NAME" value="1" wire:model="formData.adt"></td>
                                    <td>The Child’s Plan of Care is being developed or being reviewed.</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Based on the review, does the current safety plan still adequately keep the child/ youth and others safe?</b>
                                <br/>
                                <span class="radio-options marker marker-prefix-SASP_SPR00">

                                    <label>Yes </label>
                                    <input type="radio" name="formData.adu" value="1" wire:model="formData.adu">

                                    &nbsp;&nbsp;

                                    <label>No </label>
                                    <input type="radio" name="formData.adu" value="0" wire:model="formData.adv">
                                </span>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Indicate the rationale:<br/>
                                    <textarea class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.adw"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>Indicate the person(s) who were involved in determining the current safety plan still adequately keeps the child/youth and others safe:<br/>
                                    <textarea class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.adx"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>
                                    Note: Once a licensee has determined that a review of updated safety plan is required, they must ensure that the same process and requirements for the development of a Safety Plan under the Development of a Safety Plan as above are followed. This process also highlighted under O. Reg. 156/18, s. 86.4  and O. Reg. 156/18, s. 129.1.
                                </b>
                                <br/>
                                Summarize any amendments that were made to the safety plan as a result of the review:
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.ady"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>
                                    Describe information that was considered about the child/youth’s behaviours that informed the review of the safety plan, including but not limited to information collected from the child’s foster parent or parents and persons providing direct care to the child on behalf of the licensee
                                </b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.adz"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                <b>
                                    Describe any recommendations received by the licensee from any individual named as a resource person for the child under section 5 or any person who provides direct care to the child on behalf of the licensee, other than the foster parent or parents, are incorporated into the safety plan.
                                </b>
                                <br/>
                                <textarea class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aea"></textarea>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <br/>
                            <p>
                                <b>
                                    Identify the following information on persons who provide direct care to the child/youth, including foster parents where applicable. Completing the chart below should indicate that these persons have reviewed the safety plan or amended safety plan.
                                </b>
                                <br/><br/>
                            <table>
                                <tr class="grid-header">
                                    <td>Full Name</td>
                                    <td>Role</td>
                                    <td>Date</td>
                                    <td>Initials</td>
                                </tr>
                                @php($rowCount = ($formData['direct_care_people']['row_count']??1))
                                @for($r = 1; $r<=$rowCount; $r++ )
                                    <tr>
                                        <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.direct_care_people.{{$r}}.full_name" /></td>
                                        <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.direct_care_people.{{$r}}.role" /></td>
                                        <td class="data-picker marker marker-prefix-SASP_SPR00"><x-adminlte-date-range name="formData_direct_care_people__{{$r}}__date" wire:model="formData.direct_care_people.{{$r}}.date" igroup-size="sm" :config="$config"/></td>
                                        <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.direct_care_people.{{$r}}.initials" /></td>
                                    </tr>
                                @endfor
                            </table>
                            Note: Duplicate additional lines as required.
                            <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"direct_care_people"}}')">Add Row</span>
                            <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"direct_care_people"}}')">Remove Row</span>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <p>
                                Where applicable, identify the following information on <b>persons who supervise or support foster parents.</b> Completing the chart below should indicate that these persons have reviewed the safety plan or amended safety plan.
                                <br/><br/>
                            <table>
                                <tr class="grid-header">
                                    <td>Full Name</td>
                                    <td>Role</td>
                                    <td>Date</td>
                                    <td>Initials</td>
                                </tr>
                                @php($rowCount = ($formData['supervise_or_support_people']['row_count']??1))
                                @for($r = 1; $r<=$rowCount; $r++ )
                                    <tr>
                                        <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.supervise_or_support_people.{{$r}}.full_name" /></td>
                                        <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.supervise_or_support_people.{{$r}}.role" /></td>
                                        <td class="data-picker marker marker-prefix-SASP_SPR00"><x-adminlte-date-range name="formData_supervise_or_support_people__{{$r}}__date" wire:model="formData.supervise_or_support_people.{{$r}}.date" igroup-size="sm" :config="$config"/></td>
                                        <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.supervise_or_support_people.{{$r}}.initials" /></td>
                                    </tr>
                                @endfor
                            </table>
                            <b>Note:</b> Duplicate additional lines as required.
                            <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"supervise_or_support_people"}}')">Add Row</span>
                            <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"supervise_or_support_people"}}')">Remove Row</span>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <br/>
                            <p>
                                The licensee is required to ensure that the child’s safety plan is reviewed by the following persons:
                                <br>1.	Any person providing direct care to the child on behalf of the licensee, including in the case of a foster child, the child’s foster parents.
                                <br>2.	In the case of a foster child, the person assigned by the licensee to supervise and support the foster parents.
                                <br><br>
                                <i>Indicate the date and format the safety plan was provided to each participate.</i>
                                <br/>
                            <table>
                                <tr class="grid-header">
                                    <td>Name of participant and role</td>
                                    <td>Date amended safety plan provided</td>
                                    <td>Format</td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aeb" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aec" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aed" /></td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aee" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aef" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aeg" /></td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aeh" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aei" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aej" /></td>
                                </tr>
                                <tr>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aek" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.ael" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-SASP_SPR00' wire:model="formData.aem" /></td>
                                </tr>
                            </table>
                            </p>
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <br/>
        <hr/>

        @unless($autoSave)
            <button type="submit">Submit</button>
        @endunless
    </form>

</div>
