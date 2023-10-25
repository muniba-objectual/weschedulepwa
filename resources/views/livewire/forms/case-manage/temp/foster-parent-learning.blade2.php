<div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"   integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="   crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

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

        textarea, input[type="text"] {
            background: #f4eef1;
        }
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
    @endphp

    <form wire:submit.prevent="submit">

        <h5 class="form-heading">FOSTER PARENT LEARNING PLAN</h5>

        <br/>

        <x-form class="form-group">

        {{--SECTION A--}}

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Standard First Aid, Including Infant and Child CPR</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">

                    <div class="row">

                                <div class="input-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="form-completed-by">Organization
                                                (Name of Training Agency (must be issued by a training agency recognized by the WSIB)</label>
                                        </div>
                                        <div class="col">
                                            <label for="form-completed-by">Proof of Certification on File</label>
                                        </div>

                                        <div class="col">
                                            <label for="form-completed-by">Date of Issue</label>
                                        </div>

                                        <div class="col">
                                            <label for="form-completed-by">Expiry Date</label>
                                        </div>

                                    </div>
                                    @php($rowCount = ($formData['table1']['row_count']??1))
                                    @for($r = 1; $r<=$rowCount; $r++ )
                                        <div class="row">

                                                <div class="col">
                                                <input type='text' class='table-input marker marker-prefix-FPL_A00' wire:model="formData.table1.{{$r}}.organization" /></td>
                                                </div>


                                <div class="col">
                                <span class="radio-options marker marker-prefix-FPL_A00">
                                    <label>Yes</label>
                                    <input type="radio" name="formData.table1.{{$r}}.Proof_of_cert_on_fle" value="1" wire:model="formData.table1.{{$r}}.Proof_of_cert_on_fle">
                                    &nbsp;&nbsp;
                                    <label>No</label>
                                    <input type="radio" name="formData.table1.{{$r}}.Proof_of_cert_on_fle" value="0" wire:model="formData.table1.{{$r}}.Proof_of_cert_on_fle">
                                </span>
                                        </div>


                                           <div class="col">
                                            <span class="data-picker marker marker-prefix-FPL_A00">
                                                <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="formData_table1__{{$r}}__date_of_issue"
                                                                       wire:model="formData.table1.{{$r}}.date_of_issue" igroup-size="sm" :config="$config"/>
                                            </span>
                                           </div>

                                    <div class="col">
                                            <span class="data-picker marker marker-prefix-FPL_A00">
                                                <div class="form-group">
                                                    <div class="input-group input-group-sm">
                                                        <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="formData_table1__{{$r}}__expiry_date"
                                                                               wire:model="formData.table1.{{$r}}.expiry_date" igroup-size="sm" :config="$config"/>
                                                    </div>
                                                </div>
                                            </span>
                                           </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-form>
        <div class="section">
            <div class="section-body">
                <table>
                    <tr class="blue-fill grid-header">
                        <td colspan="4">Standard First Aid, Including Infant and Child CPR</td>
                    </tr>

                    <tr class="grid-header">
                        <td>
                            Organization
                            <br/><p class="sub-text">(Name of Training Agency (must be issued by a training agency recognized by the WSIB)</p>
                        </td>
                        <td>Proof of Certification on File</td>
                        <td>Date of Issue</td>
                        <td>Expiry date</td>
                    </tr>

                    @php($rowCount = ($formData['table1']['row_count']??1))
                    @for($r = 1; $r<=$rowCount; $r++ )
                        <tr>
                            <td><input type='text' class='table-input marker marker-prefix-FPL_A00' wire:model="formData.table1.{{$r}}.organization" /></td>
                            <td>
                                <span class="radio-options marker marker-prefix-FPL_A00">
                                    <label>Yes</label>
                                    <input type="radio" name="formData.table1.{{$r}}.Proof_of_cert_on_fle" value="1" wire:model="formData.table1.{{$r}}.Proof_of_cert_on_fle">
                                    &nbsp;&nbsp;
                                    <label>No</label>
                                    <input type="radio" name="formData.table1.{{$r}}.Proof_of_cert_on_fle" value="0" wire:model="formData.table1.{{$r}}.Proof_of_cert_on_fle">
                                </span>
                            </td>
                            <td class="data-picker marker marker-prefix-FPL_A00">
                                <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="formData_table1__{{$r}}__date_of_issue"
                                                       wire:model="formData.table1.{{$r}}.date_of_issue" igroup-size="sm" :config="$config"/>
                            </td>
                            <td class="data-picker marker marker-prefix-FPL_A00">
                                <div class="form-group">
                                    <div class="input-group input-group-sm">
                                        <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="formData_table1__{{$r}}__expiry_date"
                                                               wire:model="formData.table1.{{$r}}.expiry_date" igroup-size="sm" :config="$config"/>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endfor
                </table>

                <div class="footer-note">
                    Note: Duplicate the above lines as required
                    <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"table1"}}')">Add Row</span>
                    <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"table1"}}')">Remove Row</span>
                </div>
            </div>
        </div>

        {{--SECTION B--}}
        <div class="section">
            <div class="section-header">
                SECTION B: Required Foster Parent Training
            </div>
            <div class="section-body">
                <table>
                    <tr class="blue-fill grid-header">
                        <td>Required Course</td>
                        <td>Name of Course and Course descriptions</td>
                        <td>
                            Course Provider
                            (Include details of the person or entity that developed or co-developed and delivered/co-delivered the training)
                        </td>
                        <td>
                            Completion Date and
                            Proof of Completion on File
                        </td>
                    </tr>

                    <tr>
                        <td>
                            The Parent Resources for Information, Development and Education (PRIDE) pre-service training or Strong Parent Indigenous Relationships Information Training (SPIRIT).
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_B00' wire:model="formData.acz" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_B00' wire:model="formData.ada" /></td>
                        <td class="data-picker marker marker-prefix-FPL_B00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker5" wire:model="formData.XXX_date_picker5"
                                                   igroup-size="sm" :config="$config"/>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            Training on First Nations, Inuit and/or Métis cultural competency
                            <br>
                            Exempt: <input type="checkbox" class="marker marker-prefix-FPL_B00" name="XX_NAME" value="1" wire:model="formData.adc">  Check the box if Yes
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_B00' wire:model="formData.add" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_B00' wire:model="formData.ade" /></td>
                        <td class="data-picker marker marker-prefix-FPL_B00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker6" wire:model="formData.XXX_date_picker6" 	 igroup-size="sm" :config="$config"/>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Training on providing trauma-informed care
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_B00' wire:model="formData.adg" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_B00' wire:model="formData.adh" /></td>
                        <td class="data-picker marker marker-prefix-FPL_B00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker7" wire:model="formData.XXX_date_picker7" 	 igroup-size="sm" :config="$config"/>
                        </td>
                    </tr>

                </table>

                <div class="footer-note"></div>
            </div>
        </div>

        {{--SECTION C--}}
        <div class="section">
            <div class="section-header">
                SECTION C: Training on the Provision of Foster Care
                <br>
                <p class="sub-text">
                    Details of All Training Completed by the Foster Parent on the Provision of Foster Care<sup>2</sup> &amp; Plans for Ongoing Training<sup>3</sup>
                </p>
            </div>

            <div class="section-body">

                <p><b>Training Completed by Foster Parent on the Provision of Foster Care:</b></p>

                <table>
                    <tr class="blue-fill grid-header">
                        <td>Name of Training Course and Provider</td>
                        <td>Date Completed</td>
                        <td>
                            Learning & Development Area including Individual Learning Objectives
                            <br/><p class="sub-text">The topic of the training being used to enhance knowledge and skills (examples of topics may include: FASD, medication administration, anti-human trafficking, cultural competency training, etc.)</p>
                        </td>
                        <td>
                            Skills Acquired from Training
                        </td>
                    </tr>

                    @php($rowCount = ($formData['table2']['row_count']??1))
                    @for($r = 1; $r<=$rowCount; $r++ )
                        <tr>
                            <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.table2.{{$r}}.course_name" /></td>
                            <td class="data-picker marker marker-prefix-FPL_C00">
                                <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="formData__table2__{{$r}}__course_name" wire:model="formData.table2.{{$r}}.course_date"	 igroup-size="sm" :config="$config"/>
                            </td>
                            <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.table2.{{$r}}.area_and_objectives" /></td>
                            <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.table2.{{$r}}.skills_acquired" /></td>
                        </tr>
                    @endfor

                    <tr>
                        <td colspan="4" class="table-content-footer">
                            Note: Duplicate the above lines as required.
                            <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"table2"}}')">Add Row</span>
                            <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"table2"}}')">Remove Row</span>
                        </td>
                    </tr>
                </table>

                <div class="footer-note"></div>

                <br/><br/>
                <p>
                    <b>Plans for Ongoing Training:</b>
                    <br/>Plans for ongoing training may include:
                    <br/>
                <ul>
                    <li>Individual learning objectives, which are skills that a foster parent wants to further develop.</li>
                    <li>Training required by the foster care licensee, consistent with the program they deliver.</li>
                    <li>Specific training related to the needs of the individual children or youth being placed or that have been placed in their care.</li>
                </ul>
                <i>Once a registered training has been completed in the Plans for Ongoing Training section below, please record it in the Training Completed by Foster Parent on the Provision of Foster Care section above.</i>
                </p>

                <table>
                    <tr class="blue-fill grid-header">
                        <td>Date Added</td>
                        <td>
                            Learning & Development Area, Including Individual Learning Objectives
                            <br/><p class="sub-text">(i.e., FASD, medication administration, anti-human trafficking)</p>
                        </td>
                        <td>
                            Reason For Area of Focus
                            <br/><p class="sub-text">i.e., align with needs of children (plans of care), agency mandate/program, foster parent’s learning objectives. Provide details of how the training is consistent with the program delivered and the needs of the children served or placed with the foster parent</p>
                        </td>
                        <td>
                            Is this a Formal Training and/or a Continuous Learning Opportunity?
                            <br/><p class="sub-text">Formal Training may include training courses, webinars, events, etc. Continuous learning opportunities include ongoing mentoring, peer shadowing, etc.</p>
                        </td>
                        <td>
                            Description of How Skill will be Obtained
                            <br/><p class="sub-text">Name of course provider or description of continuous learning opportunity</p>
                        </td>
                        <td>
                            Timeline for Completion <sup>4</sup>
                        </td>
                    </tr>

                    <tr>
                        <td class="data-picker marker marker-prefix-FPL_C00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker141" wire:model="formData.XXX_date_picker141" igroup-size="sm" :config="$config"/>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aab" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aac" /></td>
                        <td>
                            <select name="XXX_selector" class="select-input"  wire:model="formData.aad">
                                <option value="Formal Testing">Formal Testing</option>
                                <option value="Continuous Learning Opportunity">Continuous Learning Opportunity</option>
                                <option value="Both (Formal Training and Continuous Learning Opportunity)">Both (Formal Training and Continuous Learning Opportunity) </option>
                            </select>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aae" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aaf" /></td>
                    </tr>
                    <tr>
                        <td class="data-picker marker marker-prefix-FPL_C00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker14" wire:model="formData.XXX_date_picker14" igroup-size="sm" :config="$config"/>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aag" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aah" /></td>
                        <td>
                            <select name="XXX_selector" class="select-input" wire:model="formData.aai" >
                                <option value="Formal Testing">Formal Testing</option>
                                <option value="Continuous Learning Opportunity">Continuous Learning Opportunity</option>
                                <option value="Both (Formal Training and Continuous Learning Opportunity)">Both (Formal Training and Continuous Learning Opportunity) </option>
                            </select>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aaj" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aak" /></td>
                    </tr>
                    <tr>
                        <td class="data-picker marker marker-prefix-FPL_C00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker16" wire:model="formData.XXX_date_picker16" igroup-size="sm" :config="$config"/>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aam" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aan" /></td>
                        <td>
                            <select name="XXX_selector" class="select-input" wire:model="formData.aao" >
                                <option value="Formal Testing">Formal Testing</option>
                                <option value="Continuous Learning Opportunity">Continuous Learning Opportunity</option>
                                <option value="Both (Formal Training and Continuous Learning Opportunity)">Both (Formal Training and Continuous Learning Opportunity) </option>
                            </select>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aap" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aaq" /></td>
                    </tr>
                    <tr>
                        <td class="data-picker marker marker-prefix-FPL_C00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker18" wire:model="formData.XXX_date_picker148" igroup-size="sm" :config="$config"/>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aas" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aat" /></td>
                        <td>
                            <select name="XXX_selector" class="select-input" wire:model="formData.aau" >
                                <option value="Formal Testing">Formal Testing</option>
                                <option value="Continuous Learning Opportunity">Continuous Learning Opportunity</option>
                                <option value="Both (Formal Training and Continuous Learning Opportunity)">Both (Formal Training and Continuous Learning Opportunity) </option>
                            </select>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aaw" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_C00' wire:model="formData.aax" /></td>
                    </tr>
                </table>

            </div>
        </div>


        {{--SECTION D--}}
        <div class="section">
            <div class="section-header">
                SECTION D: Comments
            </div>

            <div class="section-body">

                <table>
                    <tr class="blue-fill grid-header section-header-center">
                        <td colspan="2">Foster Parent Comments</td>
                    </tr>
                    <tr class="grid-header">
                        <td>Date</td>
                        <td>Foster Parent summary of how they were consulted on the development of this plan and which individualized learning objectives, if any, they identified.</td>
                    </tr>
                    @php($rowCount = ($formData['foster_comments']['row_count']??1))
                    @for($r = 1; $r<=$rowCount; $r++ )
                        <tr>
                            <td class="data-picker marker marker-prefix-FPL_D00">
                                <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="formData__foster_comments__{{$r}}__date"  wire:model="formData.foster_comments.{{$r}}.date" igroup-size="sm" :config="$config"/>
                            </td>
                            <td><input type='text' class='table-input marker marker-prefix-FPL_D00' wire:model="formData.foster_comments.{{$r}}.comment" /></td>
                        </tr>
                    @endfor
                    <tr>
                        <td colspan="2" class="table-content-footer">
                            Note: Duplicate the above lines as required.
                            <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"foster_comments"}}')">Add Row</span>
                            <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"foster_comments"}}')">Remove Row</span>
                        </td>
                    </tr>
                </table>

                <br/><br/>

                <table>
                    <tr class="blue-fill grid-header section-header-left">
                        <td colspan="2">Licensee or Person Designated by the Licensee Comments</td>
                    </tr>
                    <tr class="grid-header">
                        <td>Date</td>
                        <td>Provide any comments or reflections regarding the above learning plan and planned ongoing training activities.</td>
                    </tr>
                    @php($rowCount = ($formData['license_comments']['row_count']??1))
                    @for($r = 1; $r<=$rowCount; $r++ )
                        <tr>
                            <td class="data-picker marker marker-prefix-FPL_D00">
                                <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="formData_license_comments__{{$r}}__date" wire:model="formData.license_comments.{{$r}}.date" igroup-size="sm" :config="$config"/>
                            </td>
                            <td><input type='text' class='table-input marker marker-prefix-FPL_D00' wire:model="formData.license_comments.{{$r}}.comment" /></td>
                        </tr>
                    @endfor
                    <tr>
                        <td colspan="2" class="table-content-footer">
                            Note: Duplicate the above lines as required
                            <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"license_comments"}}')">Add Row</span>
                            <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"license_comments"}}')">Remove Row</span>
                        </td>
                    </tr>
                </table>

            </div>
        </div>


        {{--SECTION E--}}
        <div class="section">
            <div class="section-header">
                SECTION E: Signatures
            </div>

            <div class="section-body">

                <table>
                    <tr class="blue-fill grid-header">
                        <td>Date</td>
                        <td>Foster Parent Name</td>
                        <td>
                            Foster Parent Signature
                            <br/><p class="sub-text">Signature is an acknowledgement that that the plan is an accurate reflection of the training completed by the foster parent and the plans for the foster parent’s ongoing training</p>
                        </td>
                        <td>Licensee Name or Person Designated by the Licensee</td>
                        <td>
                            Licensee Name or Person Designated by the Licensee Signature
                            <br/><p class="sub-text">Signature is an acknowledgement that that the plan is an accurate reflection of the training completed by the foster parent and the plans for the foster parent’s ongoing training.</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="data-picker marker marker-prefix-FPL_E00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker28"  igroup-size="sm" :config="$config"/>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_E00' wire:model="formData.abp" /></td>
                        <td>@include('livewire.forms.case-manage.temp.signature-input', ['sigName' => 'foster_parent_signature_for_completion'])</td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_E00' wire:model="formData.abr" /></td>
                        <td>@include('livewire.forms.case-manage.temp.signature-input', ['sigName' => 'person_designated_signature_for_completion'])</td>
                    </tr>
                    <tr>
                        <td class="data-picker marker marker-prefix-FPL_E00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker29" igroup-size="sm" :config="$config"/>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_E00' wire:model="formData.abu" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_E00' wire:model="formData.abw" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_E00' wire:model="formData.abx" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPL_E00' wire:model="formData.aby" /></td>
                    </tr>
                </table>

            </div>
        </div>



        <br/><br/><br/>



        <h5 class="form-heading">REVIEW OF FOSTER PARENT LEARNING PLAN</h5>

        {{--SECTION A--}}
        <div class="section">
            <div class="section-header section-header-center">SECTION A: Reason for Review</div>
            <div class="section-body">

                <b>The Foster Parent Learning Plan must be reviewed at each of the following times listed:</b>
                <ul>
                    <li>Prior to any placement of a foster child with the foster parent, as required under s. 120.2(1), para. 1. (Note: The licensee does not need to consult with the foster parent when reviewing the foster parent learning plan in this circumstance.)</li>
                    <li>At least once every three months, as required under section 122 of O. Reg. 156/18.</li>
                    <li>During the annual review of the foster home, as required under section 120.2(1), para. 2 of O. Reg. 156/18.</li>
                    <li>A material change in circumstances occurs that necessitates a review of the foster parent learning plan, to be conducted as soon as possible, as required under section 120.2(1), para. 3 of O. Reg. 156/18.</li>
                </ul>

                <br/>
                <b>In the chart below, specify the date of review, identify which reason above prompted the review, and identify the name of the person conducting the review:</b>

                <table>
                    <tr class="blue-fill grid-header">
                        <td>
                            Date of Review
                        </td>
                        <td>Reason for Review (refer to above list)</td>
                        <td>Review Details</td>
                        <td>Name of Person that conducted the review (licensee or person designated by the licensee)</td>
                    </tr>

                    <tr>
                        <td class="data-picker marker marker-prefix-FPR_A00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker30" igroup-size="sm" :config="$config"/>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPR_A00' wire:model="formData.aca" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPR_A00' wire:model="formData.acb" /></td>
                        <td><input type='text' class='table-input marker marker-prefix-FPR_A00' wire:model="formData.acc" /></td>
                    </tr>
                </table>
            </div>
        </div>


        {{--SECTION B--}}
        <div class="section">
            <div class="section-header section-header-center">SECTION B: Mandatory Checklist for Review</div>
            <div class="section-body">

                <table>
                    <tr class="blue-fill grid-header section-header-left">
                        <td colspan="2">
                            Date of Review
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <b>Confirm the following was completed as part of the review by checking the boxes listed below.  Ensure that changes made to the foster parent learning plan are documented in the plan together with signatures of the persons involved in the review (see s. 120.2(c) of O. Reg. 156/18). corresponding changes are reflected in the foster parent learning plan</b>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Are changes to the foster parent learning plan required to better support the foster parent in meeting the needs of foster children to whom the foster parent provides or will provide foster care (see s. 120.2(a) of O. Reg. 156/18)?
                        </td>
                        <td>
                            <span class="radio-options marker marker-prefix-FPR_B00">
                                <label>Yes</label>
                                <input type="radio" name="formData.acd" value="1" wire:model="formData.acd">
                                &nbsp;&nbsp;
                                <label>No</label>
                                <input type="radio" name="formData.acd" value="0" wire:model="formData.acd">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            If yes to the above, have the changes been updated and tracked in the foster parent’s learning plan?
                        </td>
                        <td>
                            <span class="radio-options marker marker-prefix-FPR_B00">
                                <label>Yes</label>
                                <input type="radio" name="formData.ace" value="1" wire:model="formData.ace">
                                &nbsp;&nbsp;
                                <label>No</label>
                                <input type="radio" name="formData.ace" value="0" wire:model="formData.ace">
                                &nbsp;&nbsp;
                                <label>N/A</label>
                                <input type="radio" name="formData.ace" value="2" wire:model="formData.ace">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Has the training that the foster parent has completed and plans to complete, continuous learning opportunities that the foster parent has engaged in and plans to engage in and learning objectives that the foster parent has met and plans to meet been documented in the foster parent learning plan (see section 120.2(b) of O. Reg. 156/18)?
                        </td>
                        <td>
                            <span class="radio-options marker marker-prefix-FPR_B00">
                                <label>Yes</label>
                                <input type="radio" name="formData.acf" value="1" wire:model="formData.acf">
                                &nbsp;&nbsp;
                                <label>No</label>
                                <input type="radio" name="formData.acf" value="0" wire:model="formData.acf">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Does the foster parent have a valid certification in Standard First Aid, including infant and child CPR, issued by a training agency approved by the Workplace Safety and Insurance Board? Ensure you confirm the date of completion and date of expiry of the certification and that there is proof of valid certification included in the Foster Parent File
                        </td>
                        <td>
                            <span class="radio-options marker marker-prefix-FPR_B00">
                                <label>Yes</label>
                                <input type="radio" name="formData.acg" value="1" wire:model="formData.acg">
                                &nbsp;&nbsp;
                                <label>No</label>
                                <input type="radio" name="formData.acg" value="0" wire:model="formData.acg">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Was the foster parent learning plan reviewed with the foster parent?  (Not required in circumstances where the review is conducted prior to placement of a foster child in the foster home).
                        </td>
                        <td>
                            <span class="radio-options marker marker-prefix-FPR_B00">
                                <label>Yes</label>
                                <input type="radio" name="formData.ach" value="1" wire:model="formData.ach">
                                &nbsp;&nbsp;
                                <label>No</label>
                                <input type="radio" name="formData.ach" value="0" wire:model="formData.ach">
                                &nbsp;&nbsp;
                                <label>N/A</label>
                                <input type="radio" name="formData.ach" value="2" wire:model="formData.ach">
                            </span>
                        </td>
                    </tr>
                </table>

                <div class="footer-note">
                    <b>Note:</b> All changes made to the foster parent learning plan as part of the review must be clearly documented in the foster parent learning plan.  Failure to document that information constitutes a non-compliance with regulatory requirements (see s. 120.2(c)).
                </div>
            </div>
        </div>


        {{--SECTION C--}}
        <div class="section">
            <div class="section-header section-header-center">SECTION C: Review Comments</div>
            <div class="section-body">

                <table>
                    <tr class="blue-fill grid-header section-header-left">
                        <td colspan="2">
                            Foster Parent Comments
                        </td>
                    </tr>
                    <tr class="grid-header">
                        <td>
                            Date
                        </td>
                        <td>
                            Provide any comments or reflections regarding the review and your ongoing learning plan.
                        </td>
                    </tr>

                    <tr>
                        <td class="data-picker marker marker-prefix-FPR_C00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker31" igroup-size="sm" :config="$config"/>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPR_C00' wire:model="formData.acj" /></td>
                    </tr>
                </table>

                <br/><br/>

                <table>
                    <tr class="blue-fill grid-header section-header-left">
                        <td colspan="2">
                            Licensee or Person Designated by the Licensee Comments
                        </td>
                    </tr>
                    <tr class="grid-header">
                        <td>
                            Date
                        </td>
                        <td>
                            Provide any comments or reflections regarding the review and ongoing learning plan of the foster parent.
                        </td>
                    </tr>

                    <tr>
                        <td class="data-picker marker marker-prefix-FPR_C00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker32" igroup-size="sm" :config="$config"/>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPR_C00' wire:model="formData.acl" /></td>
                    </tr>
                </table>
            </div>
        </div>


        {{--SECTION D--}}
        <div class="section">
            <div class="section-header section-header-center">SECTION D: Signatures</div>
            <div class="section-body">

                <p>Each time the foster parent learning plan is reviewed, the foster parent and person responsible for conducting the review must sign and date the plan to reflect the changes.    Signatures may be included in the chart below if this document remains part of the foster parent learning plan.</p>

                <table>
                    <tr class="blue-fill grid-header">
                        <td>Date of Completed Review</td>
                        <td>Foster Parent Name</td>
                        <td>
                            Foster Parent Signature
                            <br/><p class="sub-text">Signature is an acknowledgement that the changes made to the foster parent learning plan are an accurate reflection of the information discussed as part of the review of the foster parent learning plan.</p>
                        </td>
                        <td>Licensee Name or Person Designated by the Licensee</td>
                        <td>
                            Licensee Name or Person Designated by the Licensee Signature
                            <br/><p class="sub-text">Signature is an acknowledgement that the changes made to the foster parent learning plan are an accurate reflection of the information discussed as part of the review of the foster parent learning plan.</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="data-picker marker marker-prefix-FPR_D00">
                            <x-adminlte-date-range onchange="this.dispatchEvent(new InputEvent('input'))" name="XXX_date_picker33" igroup-size="sm" :config="$config"/>
                        </td>
                        <td><input type='text' class='table-input marker marker-prefix-FPR_D00' wire:model="formData.acn" /></td>
                        <td>@include('livewire.forms.case-manage.temp.signature-input', ['sigName' => 'foster_parent_signature_for_change_acknowledgement'])</td>
                        <td><input type='text' class='table-input marker marker-prefix-FPR_D00' wire:model="formData.acp" /></td>
                        <td>@include('livewire.forms.case-manage.temp.signature-input', ['sigName' => 'person_designated_signature_for_change_acknowledgement'])</td>
                    </tr>
                </table>

                <div class="footer-note">
                    <b>Note:</b> Please ensure that each foster parent has a copy of the current foster parent learning plan. A copy of the foster parent learning plan must also be kept in the foster parent file (s. 124, O. Reg. 156/18).
                </div>
            </div>
        </div>

        <br/>
        <hr/>

        <span style="width:200px;" class="hide-on-print float-right ml-3 mb-0 pb-0">
            <button wire:click="saveVersion()" type="button" class="mb-2 btn-sm btn-success waves-effect">
                <i class="fas fa-clipboard-check" aria-hidden="true"></i> Submit this Version
            </button>
        </span>

        @include('livewire.forms.case-manage.temp.signature-scripts')

        @unless($autoSave)
            <button type="submit">Submit</button>
        @endunless

    </form>

</div>

{{--<script>--}}
{{--    $(() => {--}}
{{--        let usrCfg = _AdminLTE_DateRange.parseCfg( {"singleDatePicker":true,"showDropdowns":true,"startDate":"js:moment()","minYear":2000,"maxYear":"js:parseInt(moment().format(\u0027YYYY\u0027),10)","timePicker":true,"timePicker24Hour":false,"timePickerSeconds":false,"cancelButtonClasses":"btn-danger","locale":{"format":"YYYY-MM-DD HH:mm"}} );--}}

{{--        $(document).ready(function() {--}}
{{--            $('td.data-picker-test').each(function() {--}}
{{--                $(this).find('input').daterangepicker(usrCfg);--}}
{{--            });--}}
{{--        });--}}

{{--        $('#formData__table1__3__expiry_date').daterangepicker(usrCfg);--}}
{{--    })--}}
{{--</script>--}}
