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

        textarea, input[type="text"] {
            background: #f4eef1;
        }
    </style>


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

        $configRange = [
            "singleDatePicker" => false,
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

        $allFosterHomes = \App\Models\User::query()
            ->whereIn('user_type', \App\CustomClasses\DynamicExpenseBuilder\ExpenseConfig::roleMapping()['foster-homes']) //foster homes only
            ->get();
    @endphp

    <form wire:submit.prevent="submit">

        <h5 class="form-heading">CARPE DIEM’S PRELIMINARY ASSESSMENT</h5>
        <h6 class="form-heading">Revised March 2021</h6>
        <hr>

        <br/>

        {{--EMERGENCY CONTACT(S)--}}
        <div class="section">
            <div class="section-body">
                <table>
                    <tr>
                        <td>Date of Placement call:</td>
                        <td style="min-width: 50em;" class="data-picker marker marker-prefix-SASP_SPR00"><x-adminlte-date-range name="formData_date_of_placement_call" wire:model="formData.date_of_placement_call" igroup-size="sm" :config="$config"/></td>
                    </tr>
                    <tr>
                        <td>Child’s Name</td>
                        <td><input type='text' class='table-input marker marker-prefix-A00' wire:model="formData.aax" /></td>
                    </tr>
                    <tr>
                        <td>Preferred Pronoun</td>
                        <td>
                            <select class="select-input marker marker-prefix-PA_PP_A00" wire:model="formData.aac">
                                <option value="">Select</option>
                                <option value="She">She</option>
                                <option value="She">Her</option>
                                <option value="She">He</option>
                                <option value="She">His</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>D.O.B.</td>
                        <td class="data-picker marker marker-prefix-SASP_SPR00"><x-adminlte-date-range name="formData_dob" wire:model="formData.dob" igroup-size="sm" :config="$config"/></td>
                    </tr>
                    <tr>
                        <td>CAS Agency</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>CAS Agency Address</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>CAS Phone #</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>Placement Worker</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>Immediate Needs of child</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>Is the child expected to return home? If no, explain</td>
                        <td>
                            <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Orientation to Foster Parent:</td>
                    </tr>
                    <tr>
                        <td>Date of Admission</td>
                        <td class="data-picker marker marker-prefix-SASP_SPR00"><x-adminlte-date-range name="formData_date_of_admission" wire:model="formData.date_of_admission" igroup-size="sm" :config="$config"/></td>
                    </tr>
                    <tr>
                        <td>CSW</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>FSW</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>Health Card #</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>Greenshield #</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>Wardship Status</td>
                        <td>
                            <select class="select-input marker marker-prefix-PA_PP_A00" wire:model="formData.aac">
                                <option value="">Select</option>
                                <option value="Removed from care">Removed from care</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <select class="select-input marker marker-prefix-PA_PP_A00" wire:model="formData.aac">
                                <option value="">Select</option>
                                <option value="Female">Female</option>
                                <option value="Female">Male</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Ethnicity</td>
                        <td>
                            <select class="select-input marker marker-prefix-PA_PP_A00" wire:model="formData.ethnicity">
                                <option value="">Select</option>
                                <option value="Caucasian/White">Caucasian/White</option>
                                <option value="African/African American/Black">African/African American/Black</option>
                                <option value="Asian">Asian</option>
                                <option value="Hispanic/Latino">Hispanic/Latino</option>
                                <option value="Native American/Indigenous">Native American/Indigenous</option>
                                <option value="Pacific Islander">Pacific Islander</option>
                                <option value="Middle Eastern/Arab">Middle Eastern/Arab</option>
                                <option value="Mixed/Multiracial">Mixed/Multiracial</option>
                                <option value="Other">Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Reason in Care</td>
                        <td>
                            <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Bio-Family Information</td>
                        <td>
                            <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Family Access/Visits</td>
                        <td>
                            <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Carpe Diem Foster Home</td>
                        <td>
                            <select class="select-input marker marker-prefix-PA_PP_A00" wire:model="formData.foster_home">
                                <option value="">Select</option>
                                @foreach($allFosterHomes as $fosterHome)
                                    <option value="{{$fosterHome->name}}">{{$fosterHome->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>POC Dates</td>
                        <td class="data-picker marker marker-prefix-SASP_SPR00"><x-adminlte-date-range name="formData_poc_dates" wire:model="formData.poc_dates" igroup-size="sm" :config="$configRange"/></td>
                    </tr>
                    <tr>
                        <td>School Information</td>
                        <td>
                            <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Therapy</td>
                        <td>
                            <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Medical Concerns</td>
                        <td>
                            <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Admission Medical</td>
                        <td>
                            <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Allergies</td>
                        <td>
                            <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Approval for extra funding or clothing upon Admission</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>Transportation (if required)</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>Resource Person</td>
                        <td><input type='text' class='table-input marker marker-prefix-SASP_INFO00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>Notes</td>
                        <td>
                            <textarea class='table-input marker marker-prefix-SASP_MI00' wire:model="formData.aaz" /></textarea>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <br/>

        <hr/>

        <button type="submit">Submit</button>
        <button type="button">Email</button>
    </form>

</div>
