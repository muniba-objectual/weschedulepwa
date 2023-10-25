<div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"   integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="   crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <style>
        .form-heading{
            text-align: center;
            font-weight: bold;
            padding-top: 2em;
        }

        .loop-item-remover{
            margin-left: 1em;
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

        <h5 class="form-heading mt-1 mb-0">FOSTER PARENT LEARNING PLAN</h5>

        @if ($printMode)
           @if (isset($formData['abp']))
            <h4 class="form-heading mt-0">{{$formData['abp']}}</h4>
               @endif
        @endif
        <br/>

        {{--SECTION A--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Standard First Aid, Including Infant and Child CPR</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @php($rowCount = ($formData['table1']['row_count']??1))
                @for($r = 1; $r<=$rowCount; $r++ )
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Organization - {{$r}}</h3>
                           @unless ($printMode)
                            <span class="loop-item-remover btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"table1"}}', {{$r}})">Remove Row</span>
                            @endunless
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <x-adminlte-input label="Organization (Name of Training Agency (must be issued by a training agency recognized by the WSIB)" class='table-input marker marker-prefix-FPL_A00' name="formData_table1_{{$r}}_organization" wire:model="formData.table1.{{$r}}.organization"/>

                            <div class="form-group radio-options marker marker-prefix-FPL_A00">
                                <label for="kinship_placement">Proof of Certification on File</label>

                                <div class="form-check">
                                    <input class="form-radio-input" name="formData.table1.{{$r}}.Proof_of_cert_on_fle" value="1" wire:model="formData.table1.{{$r}}.Proof_of_cert_on_fle" type="radio">
                                    <label class="form-check-label">Yes</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-radio-input" name="formData.table1.{{$r}}.Proof_of_cert_on_fle" value="0" wire:model="formData.table1.{{$r}}.Proof_of_cert_on_fle" type="radio">
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>

                            <x-adminlte-date-range class="data-picker marker marker-prefix-FPL_A00" label="Date of Issue" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.table1.{{$r}}.date_of_issue" name="formData_table1__{{$r}}__date_of_issue" igroup-size="sm" :config="$config"/>
                            <x-adminlte-date-range class="data-picker marker marker-prefix-FPL_A00" label="Expiry date" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.table1.{{$r}}.expiry_date" name="formData_table1__{{$r}}__expiry_date" igroup-size="sm" :config="$config"/>
                        </div>
                        <!-- /.card-body -->
                    </div>
                @endfor

                @unless($printMode)
                    <div class="row">
                        <div class="footer-note">
                            Note: Duplicate the above lines as required
                            <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"table1"}}')">Add Row</span>
                            <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"table1"}}')">Remove Row</span>
                        </div>
                    </div>
                @endunless
            </div>
            <!-- /.card-body -->
        </div>
        <br/>


        {{--SECTION B--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">SECTION B: Required Foster Parent Training</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            The Parent Resources for Information, Development and Education (PRIDE) pre-service training or Strong Parent Indigenous Relationships Information Training (SPIRIT).
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <x-adminlte-input label="Name of Course and Course descriptions" class='table-input marker marker-prefix-FPL_B00' name="acz" wire:model="formData.acz"/>
                        <x-adminlte-input label="Course Provider (Include details of the person or entity that developed or co-developed and delivered/co-delivered the training)" class='table-input marker marker-prefix-FPL_B00' name="ada" wire:model="formData.ada"/>
                        <x-adminlte-date-range class="data-picker marker marker-prefix-FPL_B00" label="Completion Date and Proof of Completion on File" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker5" name="XXX_date_picker5" igroup-size="sm" :config="$config"/>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Training on First Nations, Inuit and/or Métis cultural competency
                            <br>
                            Exempt: <input type="checkbox" class='marker marker-prefix-FPL_B00' name="adc" wire:model="formData.adc"/>  Check the box if Yes
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <x-adminlte-input label="Name of Course and Course descriptions" class='table-input marker marker-prefix-FPL_B00' name="add" wire:model="formData.add"/>
                        <x-adminlte-input label="Course Provider (Include details of the person or entity that developed or co-developed and delivered/co-delivered the training)" class='table-input marker marker-prefix-FPL_B00' name="ade" wire:model="formData.ade"/>
                        <x-adminlte-date-range class="data-picker marker marker-prefix-FPL_B00" label="Completion Date and Proof of Completion on File" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker6" name="XXX_date_picker6" igroup-size="sm" :config="$config"/>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Training on providing trauma-informed care
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <x-adminlte-input label="Name of Course and Course descriptions" class='table-input marker marker-prefix-FPL_B00' name="adg" wire:model="formData.adg"/>
                        <x-adminlte-input label="Course Provider (Include details of the person or entity that developed or co-developed and delivered/co-delivered the training)" class='table-input marker marker-prefix-FPL_B00' name="adh" wire:model="formData.adh"/>
                        <x-adminlte-date-range class="data-picker marker marker-prefix-FPL_B00" label="Completion Date and Proof of Completion on File" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker7" name="XXX_date_picker7" igroup-size="sm" :config="$config"/>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <br/>


        {{--SECTION C--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    SECTION C: Training on the Provision of Foster Care
                    <br>
                    <p class="sub-text">
                        Details of All Training Completed by the Foster Parent on the Provision of Foster Care<sup>2</sup> &amp; Plans for Ongoing Training<sup>3</sup>
                    </p>
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Training Completed by Foster Parent on the Provision of Foster Care
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @php($rowCount = ($formData['table2']['row_count']??1))
                        @for($r = 1; $r<=$rowCount; $r++ )
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Training - {{$r}}</h3>
                                   @unless ($printMode)
                                        <span class="loop-item-remover btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"table2"}}', {{$r}})">Remove Row</span>
                                    @endunless
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <x-adminlte-input label="Name of Training Course and Provider" class='table-input marker marker-prefix-FPL_C00' name="table2_{{$r}}_course_name" wire:model="formData.table2.{{$r}}.course_name"/>
                                    <x-adminlte-date-range class="data-picker marker marker-prefix-FPL_C00" label="Date Completed" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.table2.{{$r}}.course_date" name="table2_{{$r}}_course_date" igroup-size="sm" :config="$config"/>
                                    <div class="form-group">
                                <span>
                                    <b>Learning & Development Area including Individual Learning Objectives</b>
                                    <br/><p class="sub-text">The topic of the training being used to enhance knowledge and skills (examples of topics may include: FASD, medication administration, anti-human trafficking, cultural competency training, etc.)</p>
                                </span>
                                        <x-adminlte-input label="" class='table-input marker marker-prefix-FPL_C00' name="table2_{{$r}}_area_and_objectives" wire:model="formData.table2.{{$r}}.area_and_objectives"/>
                                    </div>

                                    <x-adminlte-input label="Skills Acquired from Training" class='table-input marker marker-prefix-FPL_C00' name="table2_{{$r}}_skills_acquired" wire:model="formData.table2.{{$r}}.skills_acquired"/>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        @endfor

                        @unless($printMode)
                            <div class="row">
                                <div class="footer-note">
                                    Note: Duplicate the above lines as required.
                                    <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"table2"}}')">Add Row</span>
                                    <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"table2"}}')">Remove Row</span>
                                </div>
                            </div>
                        @endunless
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            Plans for Ongoing Training
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <p>
                            Plans for ongoing training may include:<br/>
                            <ul>
                                <li>Individual learning objectives, which are skills that a foster parent wants to further develop.</li>
                                <li>Training required by the foster care licensee, consistent with the program they deliver.</li>
                                <li>Specific training related to the needs of the individual children or youth being placed or that have been placed in their care.</li>
                            </ul>
                            <i>Once a registered training has been completed in the Plans for Ongoing Training section below, please record it in the Training Completed by Foster Parent on the Provision of Foster Care section above.</i>
                        </p>

                        <div class="card card-primary">
                            <div class="card-header">#1</div>
                            <div class="card-body">
                                <x-adminlte-date-range label="Date Added" class="data-picker marker marker-prefix-FPL_C00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker141" name="XXX_date_picker141" igroup-size="sm" :config="$config"/>

                                <div class="form-group">
                                    Learning & Development Area, Including Individual Learning Objectives
                                    <br/><p class="sub-text">(i.e., FASD, medication administration, anti-human trafficking)</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aab" wire:model="formData.aab"/>
                                </div>
                                <div class="form-group">
                                    Reason For Area of Focus
                                    <br/><p class="sub-text">i.e., align with needs of children (plans of care), agency mandate/program, foster parent’s learning objectives. Provide details of how the training is consistent with the program delivered and the needs of the children served or placed with the foster parent</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aac" wire:model="formData.aac"/>
                                </div>
                                <div class="form-group">
                                    Is this a Formal Training and/or a Continuous Learning Opportunity?
                                    <br/><p class="sub-text">Formal Training may include training courses, webinars, events, etc. Continuous learning opportunities include ongoing mentoring, peer shadowing, etc.</p>
                                    <select name="XXX_selector" class="select-input"  wire:model="formData.aad">
                                        <option value="Formal Testing">Formal Testing</option>
                                        <option value="Continuous Learning Opportunity">Continuous Learning Opportunity</option>
                                        <option value="Both (Formal Training and Continuous Learning Opportunity)">Both (Formal Training and Continuous Learning Opportunity) </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Description of How Skill will be Obtained
                                    <br/><p class="sub-text">Name of course provider or description of continuous learning opportunity</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aae" wire:model="formData.aae"/>
                                </div>
                                <div class="form-group">
                                    Timeline for Completion <sup>4</sup>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aaf" wire:model="formData.aaf"/>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">#2</div>
                            <div class="card-body">
                                <x-adminlte-date-range label="Date Added" class="data-picker marker marker-prefix-FPL_C00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker14" name="XXX_date_picker14" igroup-size="sm" :config="$config"/>

                                <div class="form-group">
                                    Learning & Development Area, Including Individual Learning Objectives
                                    <br/><p class="sub-text">(i.e., FASD, medication administration, anti-human trafficking)</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aag" wire:model="formData.aag"/>
                                </div>
                                <div class="form-group">
                                    Reason For Area of Focus
                                    <br/><p class="sub-text">i.e., align with needs of children (plans of care), agency mandate/program, foster parent’s learning objectives. Provide details of how the training is consistent with the program delivered and the needs of the children served or placed with the foster parent</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aah" wire:model="formData.aah"/>
                                </div>
                                <div class="form-group">
                                    Is this a Formal Training and/or a Continuous Learning Opportunity?
                                    <br/><p class="sub-text">Formal Training may include training courses, webinars, events, etc. Continuous learning opportunities include ongoing mentoring, peer shadowing, etc.</p>
                                    <select name="XXX_selector" class="select-input"  wire:model="formData.aai">
                                        <option value="Formal Testing">Formal Testing</option>
                                        <option value="Continuous Learning Opportunity">Continuous Learning Opportunity</option>
                                        <option value="Both (Formal Training and Continuous Learning Opportunity)">Both (Formal Training and Continuous Learning Opportunity) </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Description of How Skill will be Obtained
                                    <br/><p class="sub-text">Name of course provider or description of continuous learning opportunity</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aaj" wire:model="formData.aaj"/>
                                </div>
                                <div class="form-group">
                                    Timeline for Completion <sup>4</sup>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aak" wire:model="formData.aak"/>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">#3</div>
                            <div class="card-body">
                                <x-adminlte-date-range label="Date Added" class="data-picker marker marker-prefix-FPL_C00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker16" name="XXX_date_picker16" igroup-size="sm" :config="$config"/>
                                <div class="form-group">
                                    Learning & Development Area, Including Individual Learning Objectives
                                    <br/><p class="sub-text">(i.e., FASD, medication administration, anti-human trafficking)</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aam" wire:model="formData.aam"/>
                                </div>
                                <div class="form-group">
                                    Reason For Area of Focus
                                    <br/><p class="sub-text">i.e., align with needs of children (plans of care), agency mandate/program, foster parent’s learning objectives. Provide details of how the training is consistent with the program delivered and the needs of the children served or placed with the foster parent</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aan" wire:model="formData.aan"/>
                                </div>
                                <div class="form-group">
                                    Is this a Formal Training and/or a Continuous Learning Opportunity?
                                    <br/><p class="sub-text">Formal Training may include training courses, webinars, events, etc. Continuous learning opportunities include ongoing mentoring, peer shadowing, etc.</p>
                                    <select name="XXX_selector" class="select-input"  wire:model="formData.aao">
                                        <option value="Formal Testing">Formal Testing</option>
                                        <option value="Continuous Learning Opportunity">Continuous Learning Opportunity</option>
                                        <option value="Both (Formal Training and Continuous Learning Opportunity)">Both (Formal Training and Continuous Learning Opportunity) </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Description of How Skill will be Obtained
                                    <br/><p class="sub-text">Name of course provider or description of continuous learning opportunity</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aap" wire:model="formData.aap"/>
                                </div>
                                <div class="form-group">
                                    Timeline for Completion <sup>4</sup>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aaq" wire:model="formData.aaq"/>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">#4</div>
                            <div class="card-body">
                                <x-adminlte-date-range label="Date Added" class="data-picker marker marker-prefix-FPL_C00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker148" name="XXX_date_picker148" igroup-size="sm" :config="$config"/>
                                <div class="form-group">
                                    Learning & Development Area, Including Individual Learning Objectives
                                    <br/><p class="sub-text">(i.e., FASD, medication administration, anti-human trafficking)</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aas" wire:model="formData.aas"/>
                                </div>
                                <div class="form-group">
                                    Reason For Area of Focus
                                    <br/><p class="sub-text">i.e., align with needs of children (plans of care), agency mandate/program, foster parent’s learning objectives. Provide details of how the training is consistent with the program delivered and the needs of the children served or placed with the foster parent</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aat" wire:model="formData.aat"/>
                                </div>
                                <div class="form-group">
                                    Is this a Formal Training and/or a Continuous Learning Opportunity?
                                    <br/><p class="sub-text">Formal Training may include training courses, webinars, events, etc. Continuous learning opportunities include ongoing mentoring, peer shadowing, etc.</p>
                                    <select name="XXX_selector" class="select-input"  wire:model="formData.aau">
                                        <option value="Formal Testing">Formal Testing</option>
                                        <option value="Continuous Learning Opportunity">Continuous Learning Opportunity</option>
                                        <option value="Both (Formal Training and Continuous Learning Opportunity)">Both (Formal Training and Continuous Learning Opportunity) </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    Description of How Skill will be Obtained
                                    <br/><p class="sub-text">Name of course provider or description of continuous learning opportunity</p>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aaw" wire:model="formData.aaw"/>
                                </div>
                                <div class="form-group">
                                    Timeline for Completion <sup>4</sup>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="aax" wire:model="formData.aax"/>
                                </div>
                            </div>
                        </div>

                        @php($rowCount = ($formData['table3']['row_count']??0))
                        @for($r = 5; $r<=$rowCount+4; $r++ )
                            <div class="card card-primary">
                                <div class="card-header">
                                    #{{$r}}
                                    @unless ($printMode)
                                    <span class="loop-item-remover btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"table3"}}', {{$r}})">Remove Row</span>
                                    @endunless
                                </div>
                                <div class="card-body">
                                    <x-adminlte-date-range label="Date Added" class="data-picker marker marker-prefix-FPL_C00" onchange="this.dispatchEvent(new InputEvent('input'))" name="table3_{{$r}}_date_added" wire:model="formData.table3.{{$r}}.date_added" igroup-size="sm" :config="$config"/>
                                    <div class="form-group">
                                        Learning & Development Area, Including Individual Learning Objectives
                                        <br/><p class="sub-text">(i.e., FASD, medication administration, anti-human trafficking)</p>
                                        <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="table3_{{$r}}_learning_development_area" wire:model="formData.table3.{{$r}}.learning_development_area"/>
                                    </div>
                                    <div class="form-group">
                                        Reason For Area of Focus
                                        <br/><p class="sub-text">i.e., align with needs of children (plans of care), agency mandate/program, foster parent’s learning objectives. Provide details of how the training is consistent with the program delivered and the needs of the children served or placed with the foster parent</p>
                                        <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="table3_{{$r}}_reason_for_area_of_focus" wire:model="formData.table3.{{$r}}.reason_for_area_of_focus"/>
                                    </div>
                                    <div class="form-group">
                                        Is this a Formal Training and/or a Continuous Learning Opportunity?
                                        <br/><p class="sub-text">Formal Training may include training courses, webinars, events, etc. Continuous learning opportunities include ongoing mentoring, peer shadowing, etc.</p>
                                        <select name="table3_{{$r}}_is_formal_training_or_learning_opportunity" class="select-input" wire:model="formData.table3.{{$r}}.is_formal_training_or_learning_opportunity">
                                            <option value="Formal Testing">Formal Testing</option>
                                            <option value="Continuous Learning Opportunity">Continuous Learning Opportunity</option>
                                            <option value="Both (Formal Training and Continuous Learning Opportunity)">Both (Formal Training and Continuous Learning Opportunity) </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        Description of How Skill will be Obtained
                                        <br/><p class="sub-text">Name of course provider or description of continuous learning opportunity</p>
                                        <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="table3_{{$r}}_how_skill_be_obtained" wire:model="formData.table3.{{$r}}.how_skill_be_obtained"/>
                                    </div>
                                    <div class="form-group">
                                        Timeline for Completion <sup>4</sup>
                                        <x-adminlte-input class="table-input marker marker-prefix-FPL_C00" type="text" name="table3_{{$r}}_timeline_for_completion" wire:model="formData.table3.{{$r}}.timeline_for_completion"/>
                                    </div>
                                </div>
                            </div>
                        @endfor

                        @unless($printMode)
                            <div class="row">
                                <div class="footer-note">
                                    Note: Duplicate the above lines as required.
                                    <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"table3"}}')">Add Row</span>
                                    @if($rowCount)
                                        @unless ($printMode)
                                        <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"table3"}}')">Remove Row</span>
                                        @endunless
                                        @endif
                                </div>
                            </div>
                        @endunless

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <br/>


        {{--SECTION D--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">SECTION D: Comments</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Foster Parent Comments</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @php($rowCount = ($formData['foster_comments']['row_count']??1))
                        @for($r = 1; $r<=$rowCount; $r++ )
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Foster Parent Comment - {{$r}}</h3>
                                    @unless ($printMode)
                                        <span class="loop-item-remover btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"foster_comments"}}', {{$r}})">Remove Row</span>
                                    @endunless
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <x-adminlte-date-range class="data-picker marker marker-prefix-FPL_D00" label="Date" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.foster_comments.{{$r}}.date" name="formData__foster_comments_{{$r}}_date" igroup-size="sm" :config="$config"/>
                                    <x-adminlte-input class="table-input marker marker-prefix-FPL_D00" label="Provide any comments or reflections regarding the above learning plan and planned ongoing training activities." name="formData__foster_comments_{{$r}}_comment" wire:model="formData.foster_comments.{{$r}}.comment"/>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        @endfor

                        @unless($printMode)
                            <div class="row">
                                <div class="footer-note">
                                    Note: Duplicate the above lines as required.
                                    <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"foster_comments"}}')">Add Row</span>
                                    <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"foster_comments"}}')">Remove Row</span>
                                </div>
                            </div>
                        @endunless
                    </div>
                    <!-- /.card-body -->
                </div>

                <br/><br/>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Licensee or Person Designated by the Licensee Comments</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @php($rowCount = ($formData['license_comments']['row_count']??1))
                        @for($r = 1; $r<=$rowCount; $r++ )
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Licensee or Person Designated - {{$r}}</h3>
                                    @unless ($printMode)
                                        <span class="loop-item-remover btn btn-xs btn-danger" href="#" wire:click="removeNthRow('{{"license_comments"}}', {{$r}})">Remove Row</span>
                                    @endunless
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <x-adminlte-date-range label='Date' class="data-picker marker marker-prefix-FPL_D00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.license_comments.{{$r}}.date" name="license_comments_{{$r}}_date" igroup-size="sm" :config="$config"/>
                                    <x-adminlte-input label="Provide any comments or reflections regarding the above learning plan and planned ongoing training activities." class="table-input marker marker-prefix-FPL_D00" name="license_comments_{{$r}}_comment" wire:model="formData.license_comments.{{$r}}.comment"/>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        @endfor

                        @unless($printMode)
                            <div class="row">
                                <div class="footer-note">
                                    Note: Duplicate the above lines as required
                                    <span class="btn btn-xs btn-outline-success" href="#" wire:click="addRow('{{"license_comments"}}')">Add Row</span>
                                    <span class="btn btn-xs btn-outline-danger" href="#" wire:click="removeRow('{{"license_comments"}}')">Remove Row</span>
                                </div>
                            </div>
                        @endunless
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <br/>


        {{--SECTION E--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">SECTION E: Signatures</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <x-adminlte-date-range class="data-picker marker marker-prefix-FPL_E00" label="Date" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker28" name="XXX_date_picker28" igroup-size="sm" :config="$config"/>
                <x-adminlte-input class="table-input marker marker-prefix-FPL_E00" label="Foster Parent Name" name="abp" wire:model="formData.abp"/>
                <div class="form-group">
                    <p>
                        <b>Foster Parent Signature</b>
                        <br/>Signature is an acknowledgement that the plan is an accurate reflection of the training completed by the foster parent and the plans for the foster parent’s ongoing training
                    </p>
                    <div class="input-group">
                        @include('livewire.forms.case-manage.temp.signature-input', ['sigName' => 'foster_parent_signature_for_completion'])
                    </div>
                </div>
                <x-adminlte-input class="table-input marker marker-prefix-FPL_E00" label="Licensee Name or Person Designated by the Licensee" name="abr" wire:model="formData.abr"/>
                <div class="form-group">
                    <p>
                        <b>Foster Parent Signature</b>
                        <br/>Signature is an acknowledgement that the plan is an accurate reflection of the training completed by the foster parent and the plans for the foster parent’s ongoing training
                    </p>
                    <div class="input-group">
                        @include('livewire.forms.case-manage.temp.signature-input', ['sigName' => 'person_designated_signature_for_completion'])
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <br/>


        <br/><br/><br/>


        <h5 class="form-heading">REVIEW OF FOSTER PARENT LEARNING PLAN</h5>

        {{--SECTION A--}}
        <div class="card card-primary">
            <div class="card-header">
                SECTION A: Reason for Review
            </div>
            <div class="card-body">

                <b>The Foster Parent Learning Plan must be reviewed at each of the following times listed:</b>
                <ul>
                    <li>Prior to any placement of a foster child with the foster parent, as required under s. 120.2(1), para. 1. (Note: The licensee does not need to consult with the foster parent when reviewing the foster parent learning plan in this circumstance.)</li>
                    <li>At least once every three months, as required under section 122 of O. Reg. 156/18.</li>
                    <li>During the annual review of the foster home, as required under section 120.2(1), para. 2 of O. Reg. 156/18.</li>
                    <li>A material change in circumstances occurs that necessitates a review of the foster parent learning plan, to be conducted as soon as possible, as required under section 120.2(1), para. 3 of O. Reg. 156/18.</li>
                </ul>

                <br/>
                <b>In the chart below, specify the date of review, identify which reason above prompted the review, and identify the name of the person conducting the review:</b>

                <x-adminlte-date-range label="Date of Review" class="data-picker marker marker-prefix-FPR_A00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker30" name="XXX_date_picker30" igroup-size="sm" :config="$config"/>
                <x-adminlte-input label="Reason for Review (refer to above list)" class="table-input marker marker-prefix-FPR_A00" type="text" name="aca" wire:model="formData.aca"/>
                <x-adminlte-input label="Review Details" class="table-input marker marker-prefix-FPR_A00" type="text" name="acb" wire:model="formData.acb"/>
                <x-adminlte-input label="Name of Person that conducted the review (licensee or person designated by the licensee)" class="table-input marker marker-prefix-FPR_A00" type="text" name="acc" wire:model="formData.acc"/>
            </div>
        </div>
        <br/>


        {{--SECTION B--}}
        <div class="card card-primary">
            <div class="card-header">
                SECTION B: Mandatory Checklist for Review
            </div>
            <div class="card-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="section-header section-header-center">Date of Review</div>
                    </div>
                    <div class="card-body">
                        <p>
                            <b>Confirm the following was completed as part of the review by checking the boxes listed below.  Ensure that changes made to the foster parent learning plan are documented in the plan together with signatures of the persons involved in the review (see s. 120.2(c) of O. Reg. 156/18). corresponding changes are reflected in the foster parent learning plan</b>
                        </p>

                        <div class="form-group radio-options marker marker-prefix-FPR_B00">
                            <label>Are changes to the foster parent learning plan required to better support the foster parent in meeting the needs of foster children to whom the foster parent provides or will provide foster care (see s. 120.2(a) of O. Reg. 156/18)?</label>

                            <div class="form-check">
                                <input class="form-check-input" name="acd" value="1" wire:model="formData.acd" type="radio">
                                <label class="form-check-label">Yes</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" name="acd" value="0" wire:model="formData.acd" type="radio">
                                <label class="form-check-label">No</label>
                            </div>
                        </div>

                        <div class="form-group radio-options marker marker-prefix-FPR_B00">
                            <label>If yes to the above, have the changes been updated and tracked in the foster parent’s learning plan?</label>

                            <div class="form-check">
                                <input class="form-check-input" name="ace" value="1" wire:model="formData.ace" type="radio">
                                <label class="form-check-label">Yes</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" name="ace" value="0" wire:model="formData.ace" type="radio">
                                <label class="form-check-label">No</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" name="ace" value="2" wire:model="formData.ace" type="radio">
                                <label class="form-check-label">N/A</label>
                            </div>
                        </div>

                        <div class="form-group radio-options marker marker-prefix-FPR_B00">
                            <label>Has the training that the foster parent has completed and plans to complete, continuous learning opportunities that the foster parent has engaged in and plans to engage in and learning objectives that the foster parent has met and plans to meet been documented in the foster parent learning plan (see section 120.2(b) of O. Reg. 156/18)?</label>

                            <div class="form-check">
                                <input class="form-check-input" name="acf" value="1" wire:model="formData.acf" type="radio">
                                <label class="form-check-label">Yes</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" name="acf" value="0" wire:model="formData.acf" type="radio">
                                <label class="form-check-label">No</label>
                            </div>
                        </div>

                        <div class="form-group radio-options marker marker-prefix-FPR_B00">
                            <label>Does the foster parent have a valid certification in Standard First Aid, including infant and child CPR, issued by a training agency approved by the Workplace Safety and Insurance Board? Ensure you confirm the date of completion and date of expiry of the certification and that there is proof of valid certification included in the Foster Parent File</label>

                            <div class="form-check">
                                <input class="form-check-input" name="acg" value="1" wire:model="formData.acg" type="radio">
                                <label class="form-check-label">Yes</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" name="acg" value="0" wire:model="formData.acg" type="radio">
                                <label class="form-check-label">No</label>
                            </div>
                        </div>

                        <div class="form-group radio-options marker marker-prefix-FPR_B00">
                            <label>Was the foster parent learning plan reviewed with the foster parent? (Not required in circumstances where the review is conducted prior to placement of a foster child in the foster home).</label>

                            <div class="form-check">
                                <input class="form-check-input" name="ach" value="1" wire:model="formData.ach" type="radio">
                                <label class="form-check-label">Yes</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" name="ach" value="0" wire:model="formData.ach" type="radio">
                                <label class="form-check-label">No</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" name="ach" value="2" wire:model="formData.ach" type="radio">
                                <label class="form-check-label">N/A</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="footer-note">
                                <b>Note:</b> All changes made to the foster parent learning plan as part of the review must be clearly documented in the foster parent learning plan.  Failure to document that information constitutes a non-compliance with regulatory requirements (see s. 120.2(c)).
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br/>


        {{--SECTION C--}}
        <div class="card card-primary">
            <div class="card-header">
                SECTION C: Review Comments
            </div>
            <div class="card-body">

                <div class="card card-primary">
                    <div class="card-header">
                        Foster Parent Comments
                    </div>
                    <div class="card-body">
                        <x-adminlte-date-range label="Date" class="data-picker marker marker-prefix-FPR_C00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker31" name="XXX_date_picker31" igroup-size="sm" :config="$config"/>
                        <x-adminlte-input label="Provide any comments or reflections regarding the review and your ongoing learning plan." class="table-input marker marker-prefix-FPR_C00" name="acj" wire:model="formData.acj"/>
                    </div>
                </div>

                <br/>

                <div class="card card-primary">
                    <div class="card-header">
                        Licensee or Person Designated by the Licensee Comments
                    </div>
                    <div class="card-body">
                        <x-adminlte-date-range label="Date" class="data-picker marker marker-prefix-FPR_C00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker32" name="XXX_date_picker32" igroup-size="sm" :config="$config"/>
                        <x-adminlte-input label="Provide any comments or reflections regarding the review and ongoing learning plan of the foster parent." class="table-input marker marker-prefix-FPR_C00" name="acl" wire:model="formData.acl"/>
                    </div>
                </div>

            </div>
        </div>
        <br/>


        {{--SECTION D--}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">SECTION D: Signatures</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <p>Each time the foster parent learning plan is reviewed, the foster parent and person responsible for conducting the review must sign and date the plan to reflect the changes.    Signatures may be included in the chart below if this document remains part of the foster parent learning plan.</p>

                <x-adminlte-date-range label="Date of Completed Review" class="data-picker marker marker-prefix-R_D00" onchange="this.dispatchEvent(new InputEvent('input'))" wire:model="formData.XXX_date_picker33" name="XXX_date_picker33" igroup-size="sm" :config="$config"/>

                <x-adminlte-input class="table-input marker marker-prefix-R_D00" label="Foster Parent Name" name="acn" wire:model="formData.acn"/>

                <div class="form-group">
                    <p>
                        <b>Foster Parent Signature</b>
                        <br/>Signature is an acknowledgement that the changes made to the foster parent learning plan are an accurate reflection of the information discussed as part of the review of the foster parent learning plan.
                    </p>
                    <div class="input-group">
                        @include('livewire.forms.case-manage.temp.signature-input', ['sigName' => 'foster_parent_signature_for_change_acknowledgement'])
                    </div>
                </div>

                <x-adminlte-input class="table-input marker marker-prefix-R_D00" label="Licensee Name or Person Designated by the Licensee" name="acp" wire:model="formData.acp"/>

                <div class="form-group">
                    <p>
                        <b>Licensee Name or Person Designated by the Licensee Signature</b>
                        <br/>Signature is an acknowledgement that the changes made to the foster parent learning plan are an accurate reflection of the information discussed as part of the review of the foster parent learning plan.
                    </p>
                    <div class="input-group">
                        @include('livewire.forms.case-manage.temp.signature-input', ['sigName' => 'person_designated_signature_for_change_acknowledgement'])
                    </div>
                </div>

                <div class="row">
                    <div class="footer-note">
                        <b>Note:</b> Please ensure that each foster parent has a copy of the current foster parent learning plan. A copy of the foster parent learning plan must also be kept in the foster parent file (s. 124, O. Reg. 156/18).
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
        </div>

        @unless($printMode)
            <br/>
            <hr/>

            <span style="width:200px;" class="hide-on-print float-right ml-3 mb-0 pb-0">
                <button wire:click="saveVersion()" type="button" class="mb-2 btn-sm btn-success waves-effect">
                    <i class="fas fa-clipboard-check" aria-hidden="true"></i> Submit this Version
                </button>
            </span>

            @unless($autoSave)
                <button type="submit">Submit</button>
            @endunless
        @endunless

        @include('livewire.forms.case-manage.temp.signature-scripts')

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
