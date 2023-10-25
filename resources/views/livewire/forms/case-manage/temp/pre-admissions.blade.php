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
            "minYear" => 2000,
            "maxYear" => "js:parseInt(moment().format('YYYY'),10)",
            "timePicker" => true,
            "timePicker24Hour" => false,
            "timePickerSeconds" => false,
            "cancelButtonClasses" => "btn-danger",
            "locale" => ["format" => "YYYY-MM-DD HH:mm"],
        ];
    @endphp

    <form wire:submit.prevent="submit">

        <h5 class="form-heading">Pre-Admission/Pre-Placement</h5>

        <br/>

        {{--EMERGENCY CONTACT(S)--}}
        <div class="section">
            <div class="section-body">

                <p>
                    <span class="text-danger">**</span>
                    PLEASE NOTE: The following is information that is available/ provided at time of placement request
                    <span class="text-danger">**</span>
                </p>

                <table>
                    <tr>
                        <td>Date of request:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_A00' wire:model="formData.aaa" /></td>
                    </tr>
                    <tr>
                        <td>Date of form completion:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_A00' wire:model="formData.aab" /></td>
                    </tr>
                    <tr>
                        <td>Referring Agency:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_A00' wire:model="formData.aac" /></td>
                    </tr>
                    <tr>
                        <td>Referring Agency Address:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_A00' wire:model="formData.aad" /></td>
                    </tr>
                    <tr>
                        <td>Agency Number:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_A00' wire:model="formData.aae" /></td>
                    </tr>
                    <tr>
                        <td>Placement Worker:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_A00' wire:model="formData.aaf" /></td>
                    </tr>
                    <tr>
                        <td>Form completed by:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_A00' wire:model="formData.aag" /></td>
                    </tr>
                </table>

                <br/>

                <table>
                    <tr class="grid-header">
                        <td>Child (ren) Name (s)</td>
                        <td>D.O.B</td>
                        <td>AGE</td>
                        <td>Identity/Pro nouns</td>
                    </tr>
                    <tr>
                        <td><input placeholder="1." type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aah" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aai" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aaj" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aak" /></td>
                    </tr>
                    <tr>
                        <td><input placeholder="2." type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aal" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aam" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aan" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aao" /></td>
                    </tr>
                    <tr>
                        <td><input placeholder="3." type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aap" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aaq" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aar" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aas" /></td>
                    </tr>
                    <tr>
                        <td><input placeholder="4." type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aat" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aau" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aav" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aaw" /></td>
                    </tr>
                    <tr>
                        <td><input placeholder="5." type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aax" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aay" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aaz" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PP_B00' wire:model="formData.aba" /></td>
                    </tr>
                </table>

                <br/>

                <table class="borderless">
                    <tr class="blue-fill grid-header section-header-left">
                        <td colspan="5"> Child description:</td>
                    </tr>
                    <tr>
                        <td>a) Height:</td>
                        <td colspan="4"><input type='text' class='table-input marker marker-prefix-PA_PP_C00' wire:model="formData.abb" /></td>
                    </tr>
                    <tr>
                        <td>b) Hair colour:</td>
                        <td colspan="4"><input type='text' class='table-input marker marker-prefix-PA_PP_C00' wire:model="formData.abc" /></td>
                    </tr>
                    <tr>
                        <td>c) Eye colour:</td>
                        <td colspan="4"><input type='text' class='table-input marker marker-prefix-PA_PP_C00' wire:model="formData.abd" /></td>
                    </tr>
                    <tr>
                        <td>d) Weight:</td>
                        <td colspan="4"><input type='text' class='table-input marker marker-prefix-PA_PP_C00' wire:model="formData.abe" /></td>
                    </tr>
                    <tr>
                        <td>e) Other:</td>
                        <td colspan="4"><input type='text' class='table-input marker marker-prefix-PA_PP_C00' wire:model="formData.abf" /></td>
                    </tr>

                    <tr><td colspan="5" style="font-size:0.7em;"><br/><i>(if more than one child, please complete for each child)</i></td></tr>

                    <tr>
                        <td colspan="5">
                            <table style="width: 100%">
                                <tr class="grid-header">
                                    <td>Height</td>
                                    <td>Hair colour</td>
                                    <td>Eye colour</td>
                                    <td>Weight</td>
                                    <td>Other</td>
                                </tr>
                                <tr>
                                    <td><input placeholder="1." type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abg" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abh" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abi" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abj" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abk" /></td>
                                </tr>
                                <tr>
                                    <td><input placeholder="2." type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abl" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abm" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abn" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abn" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abo" /></td>
                                </tr>
                                <tr>
                                    <td><input placeholder="3." type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abp" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abq" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abr" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abs" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abt" /></td>
                                </tr>
                                <tr>
                                    <td><input placeholder="4." type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abu" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abv" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abw" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abx" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.aby" /></td>
                                </tr>
                                <tr>
                                    <td><input placeholder="5." type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.ab" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.abz" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.aca" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.acb" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_D00' wire:model="formData.acc" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="5">
                            <br><u>Cultural/Religious:</u>
                        </td>
                    </tr>

                    <tr>
                        <td>a)Ethnic background:</td>
                        <td colspan="4"><input type='text' class='table-input marker marker-prefix-PA_PP_E00' wire:model="formData.acd" /></td>
                    </tr>
                    <tr>
                        <td>b) Status:</td>
                        <td colspan="4"><input type='text' class='table-input marker marker-prefix-PA_PP_E00' wire:model="formData.ace" /></td>
                    </tr>
                    <tr>
                        <td>c) Band affiliated:</td>
                        <td colspan="4"><input type='text' class='table-input marker marker-prefix-PA_PP_E00' wire:model="formData.acf" /></td>
                    </tr>
                    <tr>
                        <td>d) Language(s) spoken:</td>
                        <td colspan="4"><input type='text' class='table-input marker marker-prefix-PA_PP_E00' wire:model="formData.acg" /></td>
                    </tr>
                    <tr>
                        <td>e) Cultural/Religious background:</td>
                        <td colspan="4"><input type='text' class='table-input marker marker-prefix-PA_PP_E00' wire:model="formData.ach" /></td>
                    </tr>
                    <tr>
                        <td style="border-top: none; border-right: none;">
                            f) Any important cultural/religious/spiritual practices?<br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="radio-options marker marker-prefix-PA_PP_E00">

                                <label>Yes </label>
                                <input type="radio" name="formData.aci" value="1" wire:model="formData.aci">

                                &nbsp;&nbsp;

                                <label>No </label>
                                <input type="radio" name="formData.aci" value="0" wire:model="formData.aci">

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span>Describe:</span>
                            </span>
                        </td>
                        <td colspan="4" style="border-top: none; border-left: none;">
                            <input style="width: 50em;" type='text' class='table-input marker marker-prefix-PA_PP_E00' wire:model="formData.ack" />
                        </td>
                    </tr>
                    <tr><td colspan="5" style="font-size:0.7em;"><br/><i>(if more than one child, please complete for each child)</i></td></tr>
                    <tr>
                        <td colspan="5">
                            <table style="width: 100%">
                                <tr class="grid-header">
                                    <td>Ethnic background</td>
                                    <td>Status</td>
                                    <td>Band affiliated</td>
                                    <td>Language(s) spoken</td>
                                    <td>Cultural/Religious background</td>
                                </tr>
                                <tr>
                                    <td><input placeholder="1." type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acl" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acm" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acn" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.aco" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acp" /></td>
                                </tr>
                                <tr>
                                    <td><input placeholder="2." type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acq" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acr" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acs" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.act" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acu" /></td>
                                </tr>
                                <tr>
                                    <td><input placeholder="3." type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acv" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acw" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acx" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acy" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.acz" /></td>
                                </tr>
                                <tr>
                                    <td><input placeholder="4." type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.ada" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.adb" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.adc" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.add" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.ade" /></td>
                                </tr>
                                <tr>
                                    <td><input placeholder="5." type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.ad" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.adf" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.adg" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.adh" /></td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_PP_F00' wire:model="formData.adi" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <br>

                <table class="borderless">
                    <tr class="grid-header section-header-left">
                        <td colspan="2"> Reason for placement:</td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" wire:model="formData.adj">
                                <span><b>NEW PLACEMENT</b></span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" wire:model="formData.adk">
                                <span><b>PLACEMENT BREAKDOWN</b></span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" wire:model="formData.adl">
                                <span><b>PLACEMENT CHANGE</b></span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_PP_G00" name="XX_NAME" value="1" wire:model="formData.adm">
                                <span><b>RELIEF</b></span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top: none; border-right: none;">
                            <span class="radio-options marker marker-prefix-PA_PP_G00">

                                <label>Yes </label>
                                <input type="radio" name="formData.adn" value="1" wire:model="formData.adn">

                                &nbsp;&nbsp;

                                <label>No </label>
                                <input type="radio" name="formData.adn" value="0" wire:model="formData.adn">

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span>Describe:</span>
                            </span>
                        </td>
                    </tr>
                    <td colspan="2" style="border-top: none; border-left: none;">
                        <input style="width: 50em;" type='text' class='table-input marker marker-prefix-PA_PP_G00' wire:model="formData.adp" />
                    </td>
                </table>
            </div>
        </div>

        {{--IDENTIFYING INFORMATION--}}
        <div class="section">
            <div class="section-header section-header-center">
                CHILD INFORMATION
            </div>
            <div class="section-body">
                <table>
                    <tr>
                        <td colspan="2" class="grid-header section-header-left">
                            Behavioral/social presentation:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.adq">
                                <span>No unusual behaviours</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.adr">
                                <span>Instigates conflict</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.ads">
                                <span>Positive/age-appropriate social interaction with peers</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.adt">
                                <span>Demanding</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.adu">
                                <span>Positive social interaction with adults</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.adv">
                                <span>Temper tantrums</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.adw">
                                <span>Caring</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.adx">
                                <span>Known gang involvement</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.ady">
                                <span>Adaptable</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.adz">
                                <span>Physically aggressive</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aea">
                                <span>Timid</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aeb">
                                <span>Chronic lying</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aec">
                                <span>Difficulty reading social cues</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aed">
                                <span>Verbally aggressive</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aee">
                                <span>Unpredictable</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aef">
                                <span>Smokes</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aeg">
                                <span>Unhappy</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aeh">
                                <span>Using drugs/alcohol</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aei">
                                <span>Lack of or flat affect</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aej">
                                <span>Difficulty following instructions</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aek">
                                <span>Hyperactive/ADHD/ADD</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.ael">
                                <span>Carrying weapons</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aem">
                                <span>Short attention span</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aen">
                                <span>Fire setting</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aeo">
                                <span>Impulsive</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_BS00" name="XX_NAME" wire:model="formData.aep">
                                <span>Toilet trained (for younger children)</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Description
                            <br>
                            <input style="width: 50em;" type='text' class='table-input marker marker-prefix-PA_CI_BS00' wire:model="formData.aeq" />
                        </td>
                    </tr>

                </table>

                <br>

                {{--Emotional--}}
                <table>
                    <tr>
                        <td colspan="2" class="grid-header section-header-left">
                            Emotional:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.aer">
                                <span>Depression</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.aes">
                                <span>Eat/sleep disorder</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.aet">
                                <span>Suicidal</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.aeu">
                                <span>Self-abusive</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.aev">
                                <span>Mental health diagnosis</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.aew">
                                <span>Head-banging</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.aex">
                                <span>Threatened/injured self</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.aey">
                                <span>Hair pulling</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.aez">
                                <span>Bed-wetting/soiling</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.afa">
                                <span>Hair pulling</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.afb">
                                <span>Bed-wetting/soiling</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_EM00" name="XX_NAME" wire:model="formData.afc">
                                <span>History of being in care previously</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Is the child/youth currently involved with any support services (e.g. counseling)?
                            <br/>
                            <span class="radio-options marker marker-prefix-PA_CI_EM00">

                                <label>Yes </label>
                                <input type="radio" name="formData.afd" value="1" wire:model="formData.afd">

                                &nbsp;&nbsp;

                                <label>No </label>
                                <input type="radio" name="formData.afd" value="0" wire:model="formData.afd">

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </span>
                            <br/>
                            <span>If yes, where? <input style="width: 50em;" type='text' class='table-input marker marker-prefix-PA_CI_EM00' wire:model="formData.aff" /></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Description:
                            <br/>
                            <textarea class='table-input marker marker-prefix-PA_CI_EM00' wire:model="formData.afg" /></textarea>
                            <br/>
                            <i>(<span class="text-danger">**</span>If more than one child, please provide narrative in description sections for each child)</i>
                        </td>
                    </tr>
                </table>

                <br/>

                {{--Self-care/life skills--}}
                <table>
                    <tr>
                        <td colspan="2" class="grid-header section-header-left">
                            Self-care/life skills:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afh">
                                <span>Ability to demonstrate age-appropriate behaviour</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afi">
                                <span>Cultural dietary needs</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afj">
                                <span>Inappropriate in public</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afk">
                                <span>Diagnosed eating disorder</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afl">
                                <span>No difficulties eating/restrictions</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afm">
                                <span>Age appropriate hygiene skills</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afn">
                                <span>Dietary restrictions/allergies</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afo">
                                <span>Poor hygiene</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afp">
                                <span>Vegetarian</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afq">
                                <span>Needs assistance with hygiene</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Description:
                            <br/>
                            <textarea class='table-input marker marker-prefix-PA_CI_SC00' wire:model="formData.afr" /></textarea>
                            <br/>
                            <i>(<span class="text-danger">**</span>If more than one child, please provide narrative in description sections for each child)</i>
                        </td>
                    </tr>
                </table>

                <br/>

                {{--Family relationships/background--}}
                <table>
                    <tr>
                        <td colspan="2" class="grid-header section-header-left">
                            Family relationships/background:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" wire:model="formData.afs">
                                <span>Settles easy into family setting</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" wire:model="formData.aft">
                                <span>History of family/domestic violence</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" wire:model="formData.afu">
                                <span>Difficulty in family setting</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" wire:model="formData.afv">
                                <span>History of parent substance usage</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_FR00" name="XX_NAME" wire:model="formData.afw">
                                <span>History of parent/family mental health issues</span>
                            </span>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Description:
                            <br/>
                            <textarea class='table-input marker marker-prefix-PA_CI_FR00' wire:model="formData.afx" /></textarea>
                            <br/>
                            <i>(<span class="text-danger">**</span>If more than one child, please provide narrative in description sections for each child)</i>
                        </td>
                    </tr>
                </table>

                <br/>

                {{--School--}}
                <table>
                    <tr>
                        <td colspan="2" class="grid-header section-header-left">
                            School:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afy">
                                <span>No major issues</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.afz">
                                <span>Modified program</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.aga">
                                <span>Attends school regularly</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.agb">
                                <span>Truancy/ attendance issues</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.agc">
                                <span>IEP</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.agd">
                                <span>Disruptive behaviour in classroom</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.age">
                                <span>Section 20</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.agf">
                                <span>Frequent suspensions from school</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SC00" name="XX_NAME" wire:model="formData.agg">
                                <span>Learning disability</span>
                            </span>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="borderless" width="100%">
                                <tr>
                                    <td>Current school attending:</td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_CI_SC00' wire:model="formData.agh" /></td>
                                </tr>
                                <tr>
                                    <td>Current grade level:</td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_CI_SC00' wire:model="formData.agi" /></td>
                                </tr>
                                <tr>
                                    <td>Special program:</td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_CI_SC00' wire:model="formData.agj" /></td>
                                </tr>
                                <tr>
                                    <td>School address:</td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_CI_SC00' wire:model="formData.agk" /></td>
                                </tr>
                                <tr>
                                    <td>Other:</td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_CI_SC00' wire:model="formData.agl" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Description:
                            <br/>
                            <textarea class='table-input marker marker-prefix-PA_CI_SC00' wire:model="formData.agm" /></textarea>
                            <br/>
                            <i>(<span class="text-danger">**</span>If more than one child, please provide narrative in description sections for each child)</i>
                        </td>
                    </tr>
                </table>

                <br/>

                {{--Health--}}
                <table>
                    <tr>
                        <td colspan="2" class="grid-header section-header-left">
                            Health:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agq">
                                <span>No medical issues</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agr">
                                <span>Encopresis (soiling)</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ags">
                                <span>Diagnosed medical issue/condition</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agt">
                                <span>Enuresis (bed wetting)</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agu">
                                <span>Medical attention/procedure required</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agv">
                                <span>Autistic/ PDD</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agw">
                                <span>Seizures</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agx">
                                <span>FAS/FASD</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agy">
                                <span>Asthma</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.agz">
                                <span>HIV or HIV exposed</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.aha">
                                <span>Allergies/allergic reactions</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahb">
                                <span>STD</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahc">
                                <span>Medically fragile</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahd">
                                <span>HEP</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahe">
                                <span>Low birth weight</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahf">
                                <span>Diabetic</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahg">
                                <span>Complex/tube feeding</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_H00" name="XX_NAME" wire:model="formData.ahh">
                                <span>Speech/language issues</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>If other, please describe:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_CI_H00' wire:model="formData.ahi" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="borderless">
                                <tr>
                                    <td style="width: 20.4em">Medical/therapeutic services active or required:</td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_CI_H00' wire:model="formData.ahj" /></td>
                                </tr>
                                <tr>
                                    <td>Doctor:</td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_CI_H00' wire:model="formData.ahk" /></td>
                                </tr>
                                <tr>
                                    <td>Medications (drug, dosage, what prescribed for):</td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_CI_H00' wire:model="formData.ahl" /></td>
                                </tr>
                                <tr>
                                    <td>Allergies (medications, pollen, pets, etc):</td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_CI_H00' wire:model="formData.ahm" /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <br/><br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Does the child have any anaphylactic reactions?: </td>
                                    <td><input type='text' class='table-input marker marker-prefix-PA_CI_H00' wire:model="formData.ahn" /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <i>(<span class="text-danger">**</span>NOTE: Anaphylaxis is a serious allergic reaction that can be life threatening. Food is the most common cause of anaphylaxis, but insect stings, medicine, latex, or exercise can also cause a reaction)</i>
                                        <br/><br/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Description:
                            <br/>
                            <textarea class='table-input marker marker-prefix-PA_CI_H00' wire:model="formData.aho" /></textarea>
                            <br/>
                            <i>(<span class="text-danger">**</span>If more than one child, please provide narrative in description sections for each child)</i>
                        </td>
                    </tr>
                </table>

                <br/>

                {{--Sexual identity/behaviour--}}
                <table>
                    <tr>
                        <td colspan="2" class="grid-header section-header-left">
                            Sexual identity/behaviour:
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahp">
                                <span>Gay</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahq">
                                <span>Healthy understanding of sexual health</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahr">
                                <span>Lesbian</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahs">
                                <span>Prostitution</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.aht">
                                <span>Bisexual</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahu">
                                <span>Sexually acting out</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahv">
                                <span>Transsexual</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahw">
                                <span>Sexually active</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahx">
                                <span>Not applicable</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahy">
                                <span>Sexually active</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.ahz">
                                <span>Heterosexual</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.aia">
                                <span>Intrusive</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.aib">
                                <span>Struggling to identify sexual orientation</span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <input type="checkbox" class="marker marker-prefix-PA_CI_SI00" name="XX_NAME" wire:model="formData.aic">
                                <span>Masturbation: normal or excessive</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Description:
                            <br/><textarea class='table-input marker marker-prefix-PA_CI_SI00' wire:model="formData.aid"></textarea>
                            <br/><i>(<span class="text-danger">**</span>If more than one child, please provide narrative in description sections for each child)</i>
                        </td>
                    </tr>
                </table>

                <br/>

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 20.7em;">Details of how the licensee determined that the child’s immediate needs will be met if admitted<sup>1</sup>.</td>
                        <td><textarea class='table-input marker marker-prefix-PA_CI_SI00' wire:model="formData.aie"></textarea></td>
                    </tr>
                    <tr>
                        <td>Details of any immediate needs of the child that cannot be met.</td>
                        <td><textarea class='table-input marker marker-prefix-PA_CI_SI00' wire:model="formData.aif"></textarea></td>
                    </tr>
                    <tr>
                        <td>Details of how any immediate needs that cannot be met will otherwise be met.</td>
                        <td><textarea class='table-input marker marker-prefix-PA_CI_SI00' wire:model="formData.aig"></textarea></td>
                    </tr>
                </table>
            </div>
        </div>

        <br/><br/>

        <h5 class="form-heading">PLACEMENT HISTORY/CONSIDERATIONS:</h5>

        <br/>

        {{--Previous placement history--}}
        <div class="section">
            <div class="section-body">

                <table style="width: 100%">
                    <tr class="grid-header section-header-left">
                        <td colspan="2">
                            Previous placement history:
                            <br><span class="text-danger">**</span>If there are multiple placements, consider this a HIGH RISK placement. Follow up with CARS
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20.7em;">Please list all previous placements:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aih" /></td>
                    </tr>
                    <tr>
                        <td>Consider past placements for the child. What does their history mean?</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aii" /></td>
                    </tr>
                    <tr>
                        <td>What is the child’s response to placement loss and attachment?</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aij" /></td>
                    </tr>
                </table>

                <br/>

                <table style="width: 100%">
                    <tr class="grid-header section-header-left">
                        <td colspan="2">
                            Type of placement:
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20.7em;">What kind of home does child do best in?</td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aik" placeholder="Children need structure to continue to integrate in a healthy home environment as well as to be regulated and used to their schedules with school, other activities and other appointments."></textarea></td>
                    </tr>
                    <tr>
                        <td>The names of the proposed foster parent or parents, the date on which the foster parent or parents were approved to provide foster care and an assessment of whether the </td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.ail"></textarea></td>
                    </tr>
                </table>

                <hr style="width: 25%;"/>

                <p>
                    <sup>1</sup> The details of how the licensee determined the child’s immediate needs will be met if admitted should include details of the program offered by the licensee, staff training and the population of the licensed site and an analysis of how that aligns with the child’s immediate needs. It might also include details of any additional staffing supports that will be provided to the child, if admitted and any additional services and supports that will be provided to respond to any immediate needs of the child. For example, where applicable, the licensee should identify how the unique needs of an Indigenous child/youth will be met in the setting, including connecting the child/youth’s FNIM band or community.
                </p>

                <br/>

                <table>
                    <tr>
                        <td style="width: 32%;">
                            parent or parents have access to the supports and have completed the training necessary to meet the child’s immediate needs, as described in the foster parent’s foster parent learning plan.
                        </td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' rows="4" wire:model="formData.aim"></textarea></td>
                    </tr>
                    <tr>
                        <td>
                            Details of any support services available to and training provided to the proposed foster parent or parents, as well as any training completed by the proposed foster parent or parents, that are relevant to the care of the child.
                        </td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' rows="4" wire:model="formData.ain"></textarea></td>
                    </tr>
                    <tr>
                        <td>
                            The total number of children and adults already receiving out of home care at the time of the proposed placement.
                        </td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' rows="4" wire:model="formData.aio"></textarea></td>
                    </tr>
                    <tr>
                        <td>
                            The ages, gender and information about the needs of the persons already receiving foster care in the home at the time of the proposed placement, as well as services and supports required to meet those needs, that might impact on the services to be provided to the proposed placement.
                        </td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' rows="4" wire:model="formData.aip"></textarea></td>
                    </tr>
                    <tr>
                        <td>
                            The total number of persons living in the proposed foster home and any information about those persons that is known to the licensee that is relevant to the care to be provided to the child whose placement is being proposed.
                        </td>
                        <td>
                            <textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aiq" rows="6" placeholder="Example:&#10;Foster Parent Biological child X: Age 16; Female – goes to high school each day and has a part time job. Excellent with younger children&#10;&#10;Foster Parent Paternal Grandmother X: Age 72; Female: VSS and medical on file. Lives in a self-contained unit in the basement, spends time with the family, will not be involved in direct care or supervision of the placed children.
                            ">
                            </textarea>
                        </td>
                    </tr>
                </table>

                <br/>

                <table style="width: 100%">
                    <tr class="grid-header section-header-left">
                        <td colspan="2">
                            Siblings:
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20.7em;">Are there siblings in care? Where?</td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.air"></textarea></td>
                    </tr>
                    <tr>
                        <td style="width: 20.7em;">Can you place close proximity to them?</td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.ais"></textarea></td>
                    </tr>
                </table>

                <br/>

                <table style="width: 100%">
                    <tr class="grid-header section-header-left">
                        <td colspan="2">
                            Considerations:
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20.7em;">Does child have multiple placement history? More than 2?</td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' placeholder="The children have been in one previous home." wire:model="formData.ait"></textarea></td>
                    </tr>
                    <tr>
                        <td style="width: 20.7em;">Is this a risk of break down?</td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aiu"></textarea></td>
                    </tr>
                    <tr>
                        <td style="width: 25em;">Are there identified or suspected mental health issues?</td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aiv"></textarea></td>
                    </tr>
                    <tr>
                        <td style="width: 20.7em;">Risky behaviours?</td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aiw"></textarea></td>
                    </tr>
                    <tr>
                        <td style="width: 25em;">Any information set out in a personal, family and social history or assessment respecting the child that is prepared by or provided to the placing agency or person placing the child. </td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aix"></textarea></td>
                    </tr>
                    <tr>
                        <td style="width: 25em;">Strengths of the child, including information about their personality, aptitudes and abilities</td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aiy"></textarea></td>
                    </tr>
                    <tr>
                        <td style="width: 25em;">Information respecting the child’s identity characteristics.</td>
                        <td><textarea class='table-input marker marker-prefix-PA_PH00' wire:model="formData.aiz"></textarea></td>
                    </tr>
                </table>

            </div>
        </div>

        <br/><br/>

        <h5 class="form-heading">FAMILY CONTACT</h5>

        {{--FAMILY CONTACT--}}
        <div class="section">
            <div class="section-body">

                {{--Access--}}
                <table style="width: 100%">
                    <tr class="grid-header section-header-left">
                        <td colspan="2">
                            Access:
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20.7em;">Potential access plan:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_FC00' wire:model="formData.aja" /></td>
                    </tr>
                    <tr>
                        <td>Who:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_FC00' wire:model="formData.ajb" /></td>
                    </tr>
                    <tr>
                        <td>Prohibited contacts:</td>
                        <td><input type='text' class='table-input marker marker-prefix-PA_FC00' wire:model="formData.ajc" /></td>
                    </tr>
                </table>

                <br/>

                {{--Other--}}
                <table style="width: 100%">
                    <tr class="grid-header section-header-left">
                        <td colspan="2">
                            Other:
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20.7em;">Guidelines for telephone contact:</td>
                        <td><textarea class='table-input marker marker-prefix-PA_FC00' wire:model="formData.ajd"></textarea></td>
                    </tr>
                    <tr>
                        <td>Concerns with child/youth being placed in same community as family?</td>
                        <td>
                            <span class="radio-options marker marker-prefix-PA_FC00">

                                <label>Yes </label>
                                <input type="radio" name="formData.aje" value="1" wire:model="formData.aje">

                                &nbsp;&nbsp;

                                <label>No </label>
                                <input type="radio" name="formData.aje" value="0" wire:model="formData.aje">

                                <br>
                                <span>Describe:</span>
                                <textarea class='table-input marker marker-prefix-PA_FC00' wire:model="formData.ajg"></textarea>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Safety concerns (placement or access)?</td>
                        <td>
                            <span class="radio-options marker marker-prefix-PA_FC00">

                                <label>Yes </label>
                                <input type="radio" name="formData.ajh" value="1" wire:model="formData.ajh">

                                &nbsp;&nbsp;

                                <label>No </label>
                                <input type="radio" name="formData.ajh" value="0" wire:model="formData.ajh">

                                <br>
                                <span>Describe:</span>
                                <textarea class='table-input marker marker-prefix-PA_FC00' wire:model="formData.ajj"></textarea>
                            </span>
                        </td>
                    </tr>
                </table>

                <br/>
                <h3>Signature</h3>
                <table style="width: 100%">
                    <tr>
                        <td>Signature of Licensee:</td>
                        <td><textarea class='table-input marker marker-prefix-PA_SIG00' wire:model="formData.ajk"></textarea></td>
                    </tr>
                    <tr>
                        <td>Date Report Prepared: </td>
                        <td><textarea class='table-input marker marker-prefix-PA_SIG00' wire:model="formData.ajl"></textarea></td>
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
