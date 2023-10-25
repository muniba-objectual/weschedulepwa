<div class="row" >




    <style>
        hr.dashed {
            border-top: 2px dashed #999;
        }

        hr.dotted {
            border-top: 2px dotted #999;
        }

        hr.solid {
            border-top: 2px solid #999;
        }


        hr.hr-text {
            position: relative;
            border: none;
            height: 1px;
            background: #999;
        }

        hr.hr-text::before {
            content: attr(data-content);
            display: inline-block;
            background: #fff;
            font-weight: bold;
            font-size: 0.85rem;
            color: #999;
            border-radius: 30rem;
            padding: 0.2rem 2rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

    </style>


    <!-- Add IR Dialog -->
    <div wire:ignore.self class="modal fade dialog" id="addIncidentModal" data-accordion="static" tabindex="-1" role="dialog"
         aria-labelledby="addModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-blue">
                    <span class="modal-title" id="mymodelLabel">Add Incident Report</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>

        <div class="modal-body">
            <form id="frmAddIncident" wire:submit.prevent="submit" enctype="multipart/form-data">

                <div class="form-group" id="IR_form_entry"
                     name="IR_form_entry" style="">
                    {{-- With prepend slot, label and data-placeholder config --}}
                    <div wire:ignore>
                    <x-adminlte-select2 name="AddIncidentselChild" label="Child" label-class=""
                                        igroup-size="sm" data-placeholder="Select a Child...">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info">
                                <i class="fas fa-child"></i>
                            </div>
                        </x-slot>
                        <option/>
                        @foreach (App\Models\Child::where('WeSchedule','=','0')->orderBy('initials')->get() as $childEntry)
                            <option value="{{$childEntry->id}}">{{$childEntry->initials}}</option>
                        @endforeach
                    </x-adminlte-select2>
                    </div>

                    <div class="form-group">
                        <label for="inputDOB">Date of Birth</label>
                        <input disabled type="inputDOB" class="form-control"
                               id="inputDOB"
                               value="{{$child->DOB}}">
                    </div>
                    <div class="form-group">
                        <label for="inputDateofIncident">Date of
                            Placement</label>
                        <input disabled type="inputDateofPlacement"
                               class="form-control"
                               id="inputDateofPlacement"
                               value="{{ Carbon\Carbon::now()->toDateString('Y-m-d H:i')}}">
                    </div>

                    <div class="form-group">
                        <label for="inputFosterHome">Foster Home</label>
                        <input disabled name="inputFosterHome222"
                               class="form-control"
                               id="inputFosterHome"
                               value="{{(($child->getCaseManageAssignedHome) ?  $child->getCaseManageAssignedHome->name :  'N/A')}}">
                    </div>

                    <div class="form-group">
                        <label for="inputPlacingAgency">Placing
                            Agency</label>
                        <input  type="inputPlacingAgency"
                                class="form-control"
                                id="inputPlacingAgency" value="{{(($child->getCASAgency) ?  $child->getCASAgency->name :  'N/A')}}">
                    </div>

                    <div class="form-group">
                        <label for="inputLegalGuardian">Legal Guardian's
                            Name</label>
                        <input wire:model="LW_incident_entry.legal_guardian_name" type="inputLegalGuardian"
                               class="form-control"
                               id="inputLegalGuardian" placeholder="Enter Data...">
                        @error('LW_incident_entry.legal_guardian_name') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>


                    <div class="form-group">
                        <br /><br />   <span
                            style="color:red;">NOTIFY / REPORT WITHIN 24 HOURS / S.O. AS SOON AS POSSIBLE</span>
                        <br/><b>*Carpe Diem must submit Serious
                            Occurrence Reports to Ministry within 24
                            hours</b> <br /><br />

                        <label for="inputIncidentType">Incident</label>
                        <select wire:model="LW_incident_entry.incident_type" id="inputIncidentType"
                                class="form-control" placeholder="Please Select...">
                            <option value="" selected>Please Select...
                            </option>
                            <option value="Serious Occurence">-Serious
                                Occurence-
                            </option>
                            <option value="Level 1 Serious Occurence">
                                -Level 1 Serious Occurence-
                            </option>
                            <option value="Injury">Injury
                            </option>
                            <option
                                value="Property Damage / Destruction">
                                Property Damage / Destruction
                            </option>
                            <option value="Disclosure">Disclosure
                            </option>
                            <option value="Alcohol / Drug Use">Alcohol /
                                Drug Use
                            </option>
                            <option value="Sexualized Behaviour">
                                Sexualized Behaviour
                            </option>
                            <option value="Lying">Lying</option>
                            <option
                                value="School Issues (Concern, Suspension)">
                                School Issues (Concern, Suspension)
                            </option>
                            <option value="Food Issues (hoarding)">Food
                                Issues (hoarding)
                            </option>
                            <option
                                value="Aggression / Defiance / Tantrums">
                                Aggression / Definance / Tantrums
                            </option>
                            <option value="Medication Error">Medication
                                Error
                            </option>
                            <option value="Stealing">Stealing</option>
                            <option value="Fire Setting">Fire Setting
                            </option>
                            <option
                                value="Issues Relating to Visits or Family Contact">
                                Issues Relating to Visits or Family
                                Contact
                            </option>
                            <option
                                value="Suicidal Thoughts or Attempts / Self-Harm">
                                Suicidal Thoughts or Attempts /
                                Self-Harm
                            </option>
                            <option value="Other">Other</option>


                        </select>
                        @error('LW_incident_entry.incident_type') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>
                    @if ($LW_incident_entry->incident_type == "Serious Occurence")
                        <div class="form-group">
                            <label for="inputSeriousOccurence">Serious
                                Occurence</label>
                            <select wire:model="LW_incident_entry.serious_occurence" id="inputSeriousOccurence"
                                    class="form-control">
                                <option value="Death">Death</option>
                                <option value="Serious Injury">Serious
                                    Injury
                                </option>
                                <option selected value="Serious Illness">
                                    Serious Illness
                                </option>
                                <option value="Serious Individual Action">
                                    Serious Individual Action
                                </option>
                                <option value="Restrictive Intervention">
                                    Restriction Intervention
                                </option>
                                <option value="Abuse or Mistreatment">Abuse
                                    or Mistreatment
                                </option>
                                <option value="Error or Omission">Error or
                                    Omission
                                </option>
                                <option value="Serious Complaint">Serious
                                    Complaint
                                </option>


                            </select>
                        </div>
                        @error('LW_incident_entry.serious_occurence') <span class="text-danger">{{ $message }}</span> @enderror

                    @endif

                    @if ($LW_incident_entry->incident_type == "Level 1 Serious Occurence")
                        <div class="form-group">
                            <label for="inputLevel1SeriousOccurence">Level 1
                                - Serious Occurence</label>
                            <select wire:model="LW_incident_entry.level1_serious_occurence" id="inputLevel1SeriousOccurence"
                                    class="form-control">
                                <option value="Media Coverage">Media
                                    Coverage
                                </option>
                                <option value="Emeregency Services">
                                    Emergency Services used in response to a
                                    significant incident involving a client
                                </option>

                            </select>
                            @error('LW_incident_entry.level1_serious_occurence') <span class="text-danger">{{ $message }}</span> @enderror

                        </div>
                    @endif

                    <div class="form-group">
                        <label for="inputDateofIncident">Date of
                            Incident</label>
                        <input wire:model="LW_incident_entry.date_of_incident" type="inputDateofIncident"
                               class="form-control"
                               id="inputDateofIncident"
                               placeholder="Enter Data...">
                        @error('LW_incident_entry.date_of_incident') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label
                            for="inputTimeDuration">Time/Duration</label>
                        <input wire:model="LW_incident_entry.time_duration" type="inputTimeDuration"
                               class="form-control"
                               id="inputTimeDuration"
                               placeholder="Enter Data...">
                        @error('LW_incident_entry.time_duration') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">

                        <label for="inputDateTimeReportReceived">Date/Time
                            Report Received</label>
                        <input wire:model="LW_incident_entry.datetime_report_received" type="inputDateTimeReportReceived"
                               class="form-control"
                               id="inputDateTimeReportReceived"
                               placeholder="Enter Data...">
                        @error('LW_incident_entry.datetime_report_received') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputLocationofIncident">Location of
                            Incident</label>
                        <textarea wire:model="LW_incident_entry.location_of_incident" id="inputLocationofIncident" placeholder="Enter Data..."
                                  class="form-control"
                                  rows="4"></textarea>
                        @error('LW_incident_entry.location_of_incident') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputAntecedent">Antecedent leading
                            to the Incident</label>
                        <textarea wire:model="LW_incident_entry.antecedent_leading_to_incident" id="inputAntecedent" placeholder="Enter Data..."
                                  class="form-control"
                                  rows="4"></textarea>
                        @error('LW_incident_entry.antecedent_leading_to_incident') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputDescription">Description of
                            Incident (What, When, Where and How)</label>
                        <textarea wire:model="LW_incident_entry.description_of_incident" id="inputDescription" placeholder="Enter Data..."
                                  class="form-control"
                                  rows="4"></textarea>
                        @error('LW_incident_entry.description_of_incident') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputActionTaken">Action
                            Taken</label>
                        <textarea wire:model="LW_incident_entry.action_taken"  id="inputActionTaken" placeholder="Enter Data..."
                                  class="form-control"
                                  rows="4"></textarea>
                        @error('LW_incident_entry.action_taken') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputWhoWasNotified">Who Was
                            Notified</label><br/>
                        <input wire:model="who_was_notified"  type="checkbox" checked
                               name="inputWhoWasNotified[]"
                               value="Carpe Diem Case Manager / Supervisor">
                        Carpe Diem Case Manager / Supervisor<br>
                        <input wire:model="who_was_notified" type="checkbox"
                               name="inputWhoWasNotified[]"
                               value="Carpe Diem On Call Worker"> Carpe
                        Diem On Call Worker - (FOSTER PARENT – Call
                        After Hours 905-799-2947x8)<br>
                        <input wire:model="who_was_notified" type="checkbox"
                               name="inputWhoWasNotified[]"
                               value="CAS Worker/After Hours Worker">
                        CAS Worker/After Hours Worker - (TO BE DONE BY
                        CARPE DIEM ON CALL WORKER)<br>
                        <input wire:model="who_was_notified" type="checkbox"
                               name="inputWhoWasNotified[]"
                               value="Other"> Other<br>
                        @error('LW_incident_entry.who_was_notified') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputPhysicalInjuries">Physical
                            Injuries (Include specific details of injury
                            and medical intervention)</label>
                        <textarea wire:model="LW_incident_entry.physical_injuries" id="inputPhysicalInjuries" placeholder="Enter Data..."
                                  class="form-control"
                                  rows="4"></textarea>
                        @error('LW_incident_entry.physical_injuries') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputPropertyDamage">Property Damage
                            (Attach Damage Form)</label>
                        <textarea wire:model="LW_incident_entry.property_damage" id="inputPropertyDamage" placeholder="Enter Data..."
                                  class="form-control"
                                  rows="4"></textarea>
                        @error('LW_incident_entry.property_damageLW_incident_entry.property_damage') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputComments">Comments
                            (Why)</label>
                        <textarea wire:model="LW_incident_entry.comments" id="inputComments" placeholder="Enter Data..."
                                  class="form-control"
                                  rows="4"></textarea>
                        @error('LW_incident_entry.comments') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <button type="submit" wire:click.prevent="submit" class="btn btn-danger">Save & Submit</button>


                    </div>

                </div>
            </form>
        </div>

            </div>
        </div>

    </div>
    <!-- *Add IR Dialog -->



    <div id="SearchBy" wire:ignore.self class="col-12">
     Search By:  <table class="table table-bordered">
           <thead>
           <tr>
{{--               <td>Date</td>--}}
               <td>Child</td>
               <td>Foster Home</td>
               <td>Case Manger</td>
               <td>CAS</td>

           </tr>
           </thead>
            <tbody>
            <tr>
{{--                <td>--}}
{{--                        @php--}}
{{--                            $config = [--}}
{{--                                "singleDatePicker" => false,--}}
{{--                                "showDropdowns" => true,--}}
{{--                                "startDate" => "js:moment()",--}}
{{--                                "autoApply" => true,--}}
{{--                                //"ranges" => ['Today', 'Yesterday'],--}}


{{--                                "minYear" => 2000,--}}
{{--                                "maxYear" => "js:parseInt(moment().format('YYYY'),10)",--}}
{{--                                "timePicker" => false,--}}
{{--                                "timePicker24Hour" => false,--}}
{{--                                "timePickerSeconds" => false,--}}
{{--                                "cancelButtonClasses" => "btn-danger",--}}
{{--                                "locale" => ["format" => "MM/DD/YYYY"],--}}
{{--                            ];--}}
{{--                        @endphp--}}
{{--                        <x-adminlte-date-range name="drSizeSm" label="" igroup-size="sm" :config="$config" enable-default-ranges="This Month">--}}
{{--                            <x-slot name="appendSlot">--}}
{{--                                <div class="input-group-text bg-dark">--}}
{{--                                    <i class="fas fa-calendar-day"></i>--}}
{{--                                </div>--}}
{{--                            </x-slot>--}}

{{--                        </x-adminlte-date-range>--}}
{{--                </td>--}}
                <td>
                    <div wire:ignore>
                        <x-adminlte-select2 name="selChild" label="" label-class="text-lightblue"
                                           multiple igroup-size="sm" data-placeholder="Select a Child..." data-allow-clear="true">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-child"></i>
                                </div>
                            </x-slot>
                            <option/>
                            @foreach (App\Models\Child::all()->sortBy('initials') as $child)
                                <option value="{{$child->id}}">{{$child->initials}}</option>
                            @endforeach
                        </x-adminlte-select2>
                        <script>
                            var table;
                            // var filterObject;
                            var DefaultFilterObject = []
                            //     {field:"date_received_created", type:">=", value:moment($('#drSizeSm').data('daterangepicker').startDate).format('YYYY-MM-DD')},
                            //     {field:"date_received_created", type:"<=", value:moment($('#drSizeSm').data('daterangepicker').endDate).format('YYYY-MM-DD')}
                            // ]
                            var ChildFilterObject = [];
                            var FosterHomeFilterObject = [];
                            var CaseManagerFilterObject = [];
                            var CASFilterObject = [];


                            $(document).ready(function() {


                                // Livewire.emit('addFilter');
                            var picker = new Pikaday({field: $('#inputDateofIncident')[0]});
                            var picker2 = new Pikaday({field: $('#inputDateTimeReportReceived')[0]});

                                var icon = function(cell, formatterParams, onRendered){ //plain text value
                                    return "<i class='fa fa-edit'></i>";
                                };

                                var eyeIcon = function(cell, formatterParams, onRendered){ //plain text value
                                    // console.log(cell.getData().id)
                                    const myUserIRs = "{{\App\Models\User::where('id','=',Auth::user()->id)->with('IRs')->first()->IRs->pluck('id')}}";

                                    {{--$myUser = "{{User::where('id','=','2')->with('IRs')->first()->IRs->contains('id',cell.getData().id)}}"--}}
                                    // console.log (myUserIRs);
                                    if (myUserIRs.includes(cell.getData().id)) {
                                        //user has viewed this IR before
                                        return "<i class='fa fa-eye text-success'></i><i class='fa fa-eye text-success'></i>";
                                    } else {
                                        return "<i class='fa fa-eye'></i><i class='fa fa-eye'></i>";
                                    }

                                };

                                var thumbsUpIcon = function(cell, formatterParams, onRendered){ //plain text value
                                      // console.log(cell.getData().RevisionApproved)

                                    if (cell.getData().RevisionApproved) {
                                        //Edited IR has at least 1 approval
                                        return "<i class='fa fa-thumbs-up text-success'></i><span class='badge badge-notify ml-0' style='font-size:14px;'>" + cell.getData().RevisionApproved.length  + " </span>";

                                    }

                                };

                            var tabledata =  @json($tmpArray);
                            // console.log(tabledata);
                            //create Tabulator on DOM element with id "example-table"
                            table = new Tabulator("#example-table", {
                                    height: "720px", // set height of table (in CSS or here), this enables the Virtual DOM and improves render speed dramatically (can be any valid css height value)
                                    data: tabledata, //assign data to table

                                    // layout: "fitColumns", //fit columns to width of table (optional)
                                layout:"fitDataFill",

                                groupBy: "type",
                                    selectable:false,
                                initialSort: [
                                    {column: "type", dir:"asc"}
                                ],
                                columns: [ //Define Table Columns

                                    {title: "groupBy", field: "type", visible:false},
                                        //column definition in the columns array
                                        {formatter:icon, width:40, hozAlign:"center", cellClick:function(e, cell){
                                            // console.log(cell.getRow().getData());
                                            window.location = "/reports/IR_Report/" +cell.getRow().getData().id;
                                           // window.livewire.emit('slide-over.open', 'modals.case-manage.view-i-r-modal', {'IRid':cell.getRow().getData().id, 'childID':cell.getRow().getData().childID},{'size':'7xl'})
                                            // Livewire.emit('view',cell.getRow().getData().id);
                                            // alert("Printing row data for: " + cell.getRow().getData().name)
                                        }},
                                        {title: "id", field: "id", visible:false},
                                        {title: "Date Received/Created", field: "date_received_created", width:250, sorter: "date"},
                                        {title: "Name of Child", field: "child_name", width: 200},
                                        {title: "ChildID", field: "childID", visible:false},
                                        {title: "Foster Home", field: "foster_home", width: 200},
                                        {title: "fosterHomeID", field: "fosterHomeID", visible:false},
                                        {title: "Case Manager", field: "case_manager", width: 200},
                                        {title: "caseManagerID", field: "caseManagerID", visible:false},

                                    {title: "Type", field: "incident_type", width: 200},
                                    {formatter:eyeIcon, width:80, hozAlign:"center", cellClick:function(e, cell){
                                            // console.log(cell.getRow().getData());
                                            window.livewire.emit('slide-over.open', 'modals.case-manage.i-r-seen-unseen-modal', {'irid':cell.getRow().getData().id, 'childID':cell.getRow().getData().childID},{'size':'lg'})
                                            // Livewire.emit('view',cell.getRow().getData().id);
                                            // alert("Printing row data for: " + cell.getRow().getData().name)
                                        }},
                                    {formatter:thumbsUpIcon, width:80, hozAlign:"center", cellClick:function(e, cell){
                                            // console.log(cell.getRow().getData());

                                            // Livewire.emit('view',cell.getRow().getData().id);
                                            // alert("Printing row data for: " + cell.getRow().getData().name)
                                        }},
                                    ]
                                }


                            );

                            //trigger an alert message when the row is clicked
                            table.on("rowClick", function(e, row){
                                // alert("Row " + row.getData().id + " Clicked!!!!");
                            });

                            table.on("tableBuilt", function(){
                                // table.addFilter("childID","=","3");
                               table.setFilter(
                                   [
                                       // {field:"date_received_created", type:">=", value:moment($('#drSizeSm').data('daterangepicker').startDate).format('YYYY-MM-DD')},
                                       // {field:"date_received_created", type:"<=", value:moment($('#drSizeSm').data('daterangepicker').endDate).format('YYYY-MM-DD')},

                                   ]

                               )

                            });


                            function updateTableFilter() {
                                tmpFilter = ChildFilterObject.concat(FosterHomeFilterObject,CaseManagerFilterObject,CASFilterObject);
                                // console.log(tmpFilter);
                                DefaultFilterObject = [
                                    // {field:"date_received_created", type:">=", value:moment($('#drSizeSm').data('daterangepicker').startDate).format('YYYY-MM-DD')},
                                    // {field:"date_received_created", type:"<=", value:moment($('#drSizeSm').data('daterangepicker').endDate).format('YYYY-MM-DD')},
                                ]
                                DefaultFilterObject.push(tmpFilter);
                                // console.log (DefaultFilterObject);
                                table.setFilter(DefaultFilterObject);

                            }

                            function setChildFilter() {
                                var tmpData =$('#selChild').select2('data');

                                let result = tmpData.map(a => a.id);
                                // console.log(result);

                                ChildFilterObject = [];
                                for (let i =0; i < result.length; i++) {
                                    ChildFilterObject[i] = {"field" : "childID", "type" : "=", "value" : result[i]};
                                    }

                                }

                                function setFosterHomeFilter() {
                                    var tmpData =$('#selFosterHome').select2('data');

                                    let result = tmpData.map(a => a.id);
                                    // console.log(result);

                                    FosterHomeFilterObject = [];
                                    for (let i =0; i < result.length; i++) {
                                        FosterHomeFilterObject[i] = {"field" : "fosterHomeID", "type" : "=", "value" : result[i]};
                                    }

                                }

                                function setCaseManagerFilter() {
                                    var tmpData =$('#selCaseManager').select2('data');

                                    let result = tmpData.map(a => a.id);
                                    // console.log(result);

                                    CaseManagerFilterObject = [];
                                    for (let i =0; i < result.length; i++) {
                                        CaseManagerFilterObject[i] = {"field" : "caseManagerID", "type" : "=", "value" : result[i]};
                                    }

                                }

                                function setCASFilter() {
                                    var tmpData =$('#selCAS').select2('data');

                                    let result = tmpData.map(a => a.id);
                                    // console.log(result);

                                    CASFilterObject = [];
                                    for (let i =0; i < result.length; i++) {
                                        CASFilterObject[i] = {"field" : "CASID", "type" : "=", "value" : result[i]};
                                    }

                                }

                            $('#selChild').on('select2:select', function (e) {
                                //on select, clear selectedChildren dropdown
                                // $('#selChild').val(null).trigger('change');
                                $tmp = "";
                                console.log (e);
                                var data = e.params.data;
                                // console.log(data);
                                // Livewire.first().set('selectedChild', data.id);
                                // Livewire.first().set('selectedChild', $('#selChild').select2('data'));
                                // $tmp = getAssociatedChildrenFromFosterParentHome(data.id)
                                // console.log($tmp);
                                setChildFilter();
                                updateTableFilter();

                            });

                            $('#selChild').on('select2:unselect', function (e) {
                                var data = e.params.data;

                               setChildFilter();
                                updateTableFilter();


                            });


                            $('#AddIncidentselChild').on('select2:select', function (e) {
                                //on select, clear selectedChildren dropdown
                                // $('#selChild').val(null).trigger('change');
                                $tmp = "";

                                var data = e.params.data;
                                // console.log(data);
                                Livewire.first().set('childID', data.id);
                                // $tmp = getAssociatedChildrenFromFosterParentHome(data.id)
                                // console.log($tmp);

                            });

                            $('#AddIncidentselChild').on('select2:unselect', function (e) {

                                Livewire.first().set('childID', null);


                            });



                            $('#drSizeSm').on('apply.daterangepicker', function(ev, picker) {
                                // console.log(picker.startDate.format('YYYY-MM-DD'));
                                // Livewire.first().set('filterSD', picker.startDate.format('YYYY-MM-DD'));
                                //
                                // console.log(picker.endDate.format('YYYY-MM-DD'));
                                // Livewire.first().set('filterED', picker.endDate.format('YYYY-MM-DD'));
                                updateTableFilter()

                            });

                            $('#selFosterHome').on('select2:select', function (e) {
                                //on select, clear selectedChildren dropdown
                                // $('#selChild').val(null).trigger('change');

                                // Livewire.first().set('selectedFosterHome', $('#selFosterHome').select2('data'));

                               setFosterHomeFilter();
                                updateTableFilter();
                            });

                            $('#selFosterHome').on('select2:unselect', function (e) {
                                //on select, clear selectedChildren dropdown
                                // $('#selChild').val(null).trigger('change');

                                setFosterHomeFilter();
                                updateTableFilter();


                            });

                            $('#selCaseManager').on('select2:select', function (e) {
                                //on select, clear selectedChildren dropdown
                                // $('#selChild').val(null).trigger('change');

                                setCaseManagerFilter();
                                updateTableFilter();

                            });

                            $('#selCaseManager').on('select2:unselect', function (e) {

                                setCaseManagerFilter();
                                updateTableFilter();


                            });

                            $('#selCAS').on('select2:select', function (e) {
                                //on select, clear selectedChildren dropdown
                                // $('#selChild').val(null).trigger('change');

                                setCASFilter();
                                updateTableFilter();

                            });

                            $('#selCAS').on('select2:unselect', function (e) {

                                setCASFilter();
                                updateTableFilter();


                            });

                            });


                        </script>
                    </div>
                </td>
                <td>
                    <div wire:ignore>
                        <x-adminlte-select2 name="selFosterHome" label="" label-class="text-lightblue"
                                            multiple igroup-size="sm" data-placeholder="Select a Foster Home...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-home"></i>
                                </div>
                            </x-slot>
                            <option/>
                            @foreach (App\Models\User::where('user_type','>=','2.0')->where('user_type','<=','3.0')->get()->sortBy('name') as $fosterHomes)
                                <option value="{{$fosterHomes->id}}">{{$fosterHomes->name}}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                </td>
                <td>
                    <div wire:ignore>
                        <x-adminlte-select2 name="selCaseManager" label="" label-class="text-lightblue"
                                           multiple igroup-size="sm" data-placeholder="Select a Case Manager...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                            </x-slot>
                            <option/>
                            @foreach (App\Models\User::where('user_type','=','3.4')->get()->sortBy('name') as $CMs)
                                <option value="{{$CMs->id}}">{{$CMs->name}}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                </td>
                <td>
                    <div wire:ignore>
                        <x-adminlte-select2 name="selCAS" label="" label-class="text-lightblue"
                                           multiple igroup-size="sm" data-placeholder="Select a CAS Agency...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                            </x-slot>
                            <option/>
                            @foreach (App\Models\PlacingAgency::all()->sortBy('name') as $CAS)
                                <option value="{{$CAS->id}}">{{$CAS->name}}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                </td>

            </tr>
            </tbody>
       </table>

    </div>
    <div id="main" class="container-fluid">
        <div>
{{--            <button class="btn btn-success d-flex justify-content-center" data-toggle="modal"--}}
{{--                    data-target="#addIncidentModal">Submit New IR--}}
{{--            </button></div>--}}
            <div class="p-1 m-1">
                <button class="btn bg-gradient-orange" data-toggle="modal"
                        data-target="#addIncidentModal" style="color:white;">SUBMIT NEW IR
                </button></div>



            <div wire:ignore id="example-table"></div>




{{--            <hr data-content="NEW IR's (recently added)" class="hr-text">--}}
{{--            <livewire:i-r-report-new-entries--}}

{{--            />--}}


{{--    <div  id="new_entries">--}}
{{--        @if ($LW_incident_entries->has('New'))--}}

{{--            @php--}}
{{--                $heads = [--}}
{{--                    'Date Received/Created',--}}
{{--                    'Name of Child',--}}
{{--                    'Foster Home',--}}
{{--                    'Case Manager',--}}
{{--                    'Type',--}}
{{--                    'Eyes'--}}

{{--                ];--}}
{{--                @endphp--}}

{{--            --}}{{-- Minimal example / fill data using the component slot --}}
{{--            <x-adminlte-datatable id="table1" :heads="$heads" head-theme="" theme="light"--}}
{{--                                  striped hoverable footer-theme="light" beautify>--}}

{{--                @foreach ($LW_incident_entries as $group=>$entry)--}}
{{--                    @if ($group == "New")--}}
{{--                        @foreach ($entry as $newEntry)--}}

{{--                            <tr wire:key="{{$newEntry->id}}">--}}
{{--                                <td class="table-text text-nowrap">--}}
{{--                                    <div>{{$newEntry->date_of_incident}}</div>--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                    <div>{{$newEntry->get_child->initials}}</div>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <div>@if ($newEntry->get_child->getCaseManageAssignedHome)--}}
{{--                                            {{$newEntry->get_child->getCaseManageAssignedHome->name}}--}}
{{--                                        @else--}}
{{--                                            N/A--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    <div>@if ($newEntry->get_child->getCaseManageAssignedHome)--}}
{{--                                            @if ($newEntry->get_child->getCaseManageAssignedHome->getCaseManager)--}}
{{--                                                {{$newEntry->get_child->getCaseManageAssignedHome->getCaseManager->name}}--}}
{{--                                            @else--}}
{{--                                                N/A--}}
{{--                                            @endif--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </td>--}}


{{--                                <!-- Task Name -->--}}
{{--                                <td class="table-text">--}}
{{--                                    <div>--}}
{{--                                        <a  href="javascript:Livewire.emit('view',{{$newEntry->id}})">{{$newEntry->incident_type}}</a>--}}
{{--                                    </div>--}}
{{--                                </td>--}}


{{--                                <td class="table-text text-nowrap">--}}
{{--                                    <div> <i class="fa-solid fa-eye mr-0.5 text-green" style="font-size:14px"></i><i class="fa-solid fa-eye mr-2 text-green" style="font-size:14px"></i></a>--}}
{{--                                    </div>--}}
{{--                                </td>--}}

{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--            </x-adminlte-datatable>--}}

{{--            <div class="table-responsive">--}}

{{--                <table--}}
{{--                    class="table table-striped table-bordered"--}}
{{--                    id="tbl_incidententries" name="tbl_incidententries"--}}
{{--                    style="width:100%">--}}

{{--                    <!-- Table Headings -->--}}
{{--                    <thead>--}}
{{--                    <th>Date Received/Created</th>--}}
{{--                    <th>Name of Child</th>--}}
{{--                    <th>Foster Home</th>--}}
{{--                    <th>Case Manager</th>--}}
{{--                    <th>Type</th>--}}
{{--                    <th>EYES</th>--}}

{{--                    </thead>--}}

{{--                    <!-- Table Body -->--}}
{{--                    <tbody>--}}

{{--                    @foreach ($LW_incident_entries as $group=>$entry)--}}
{{--                        @if ($group == "New")--}}
{{--                        @foreach ($entry as $newEntry)--}}
{{--                        <tr>--}}
{{--                            <td class="table-text text-nowrap">--}}
{{--                                <div>{{$newEntry->date_of_incident}}</div>--}}
{{--                            </td>--}}

{{--                            <td>--}}
{{--                                <div>{{$newEntry->get_child->initials}}</div>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <div>@if ($newEntry->get_child->getCaseManageAssignedHome)--}}
{{--                                {{$newEntry->get_child->getCaseManageAssignedHome->name}}--}}
{{--                                    @else--}}
{{--                                    N/A--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                <div>@if ($newEntry->get_child->getCaseManageAssignedHome)--}}
{{--                                        @if ($newEntry->get_child->getCaseManageAssignedHome->getCaseManager)--}}
{{--                                        {{$newEntry->get_child->getCaseManageAssignedHome->getCaseManager->name}}--}}
{{--                                    @else--}}
{{--                                        N/A--}}
{{--                                    @endif--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </td>--}}


{{--                            <!-- Task Name -->--}}
{{--                            <td class="table-text">--}}
{{--                                <div>--}}
{{--                                    <a  href="javascript:Livewire.emit('view',{{$newEntry->id}})">{{$newEntry->incident_type}}</a>--}}
{{--                                </div>--}}
{{--                            </td>--}}


{{--                            <td class="table-text text-nowrap">--}}
{{--                                <div> <i class="fa-solid fa-eye mr-0.5 text-green" style="font-size:14px"></i><i class="fa-solid fa-eye mr-2 text-green" style="font-size:14px"></i></a>--}}
{{--                                </div>--}}
{{--                            </td>--}}

{{--                        </tr>--}}
{{--                        @endforeach--}}
{{--                        @endif--}}
{{--                    @endforeach--}}

{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}


{{--        @else--}}
{{--            No incident entries found.<br/>--}}
{{--            <hr>--}}
{{--        @endif--}}
{{--    </div>--}}


{{--    <div id="working_entries">--}}
{{--            <hr data-content="WORKING IR's" class="hr-text">--}}

{{--        @if ($LW_incident_entries->has('Working'))--}}
{{--                <div class="table-responsive">--}}

{{--                    <table--}}
{{--                        class="table table-striped table-bordered"--}}
{{--                        id="tbl_incidententries" name="tbl_incidententries"--}}
{{--                        style="width:100%">--}}

{{--                        <!-- Table Headings -->--}}
{{--                        <thead>--}}
{{--                        <th>Date Received/Created</th>--}}
{{--                        <th>Name of Child</th>--}}
{{--                        <th>Foster Home</th>--}}
{{--                        <th>Case Manager</th>--}}
{{--                        <th>Type</th>--}}
{{--                        <th>EYES</th>--}}

{{--                        </thead>--}}

{{--                        <!-- Table Body -->--}}
{{--                        <tbody>--}}

{{--                        @foreach ($LW_incident_entries as $group=>$entry)--}}
{{--                            @if ($group == "Working")--}}
{{--                                @foreach ($entry as $newEntry)--}}
{{--                                    <tr>--}}
{{--                                        <td class="table-text text-nowrap">--}}
{{--                                            <div>{{$newEntry->date_of_incident}}</div>--}}
{{--                                        </td>--}}

{{--                                        <td>--}}
{{--                                            <div>{{$newEntry->get_child->initials}}</div>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <div>@if ($newEntry->get_child->getCaseManageAssignedHome)--}}
{{--                                                    {{$newEntry->get_child->getCaseManageAssignedHome->name}}--}}
{{--                                                @else--}}
{{--                                                    N/A--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <div>@if ($newEntry->get_child->getCaseManageAssignedHome)--}}
{{--                                                    @if ($newEntry->get_child->getCaseManageAssignedHome->getCaseManager)--}}
{{--                                                        {{$newEntry->get_child->getCaseManageAssignedHome->getCaseManager->name}}--}}
{{--                                                    @else--}}
{{--                                                        N/A--}}
{{--                                                    @endif--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </td>--}}


{{--                                        <!-- Task Name -->--}}
{{--                                        <td class="table-text">--}}
{{--                                            <div>--}}
{{--                                                <a  href="javascript:Livewire.emit('view',{{$newEntry->id}})">{{$newEntry->incident_type}}</a>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}


{{--                                        <td class="table-text text-nowrap">--}}
{{--                                            <div>                                                        <i class="fa-solid fa-eye mr-0.5 text-green" style="font-size:14px"></i><i class="fa-solid fa-eye mr-2 text-green" style="font-size:14px"></i></a>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}

{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                        @endforeach--}}

{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}


{{--            @else--}}
{{--                No incident entries found.<br/>--}}
{{--                <hr>--}}
{{--            @endif--}}
{{--        </div>--}}

{{--    <div id="reworked_entries">--}}
{{--            <hr data-content="RE-WORKED IR's" class="hr-text">--}}

{{--            @if ($LW_incident_entries->has('Re-Worked'))--}}
{{--                <div class="table-responsive">--}}

{{--                    <table--}}
{{--                        class="table table-striped table-bordered"--}}
{{--                        id="tbl_incidententries" name="tbl_incidententries"--}}
{{--                        style="width:100%">--}}

{{--                        <!-- Table Headings -->--}}
{{--                        <thead>--}}
{{--                        <th>Date Received/Created</th>--}}
{{--                        <th>Name of Child</th>--}}
{{--                        <th>Foster Home</th>--}}
{{--                        <th>Case Manager</th>--}}
{{--                        <th>Type</th>--}}
{{--                        <th>EYES</th>--}}

{{--                        </thead>--}}

{{--                        <!-- Table Body -->--}}
{{--                        <tbody>--}}

{{--                        @foreach ($LW_incident_entries as $group=>$entry)--}}
{{--                            @if ($group == "Re-Worked")--}}
{{--                                @foreach ($entry as $newEntry)--}}
{{--                                    <tr>--}}
{{--                                        <td class="table-text text-nowrap">--}}
{{--                                            <div>{{$newEntry->date_of_incident}}</div>--}}
{{--                                        </td>--}}

{{--                                        <td>--}}
{{--                                            <div>{{$newEntry->get_child->initials}}</div>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <div>@if ($newEntry->get_child->getCaseManageAssignedHome)--}}
{{--                                                    {{$newEntry->get_child->getCaseManageAssignedHome->name}}--}}
{{--                                                @else--}}
{{--                                                    N/A--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <div>@if ($newEntry->get_child->getCaseManageAssignedHome)--}}
{{--                                                    @if ($newEntry->get_child->getCaseManageAssignedHome->getCaseManager)--}}
{{--                                                        {{$newEntry->get_child->getCaseManageAssignedHome->getCaseManager->name}}--}}
{{--                                                    @else--}}
{{--                                                        N/A--}}
{{--                                                    @endif--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </td>--}}


{{--                                        <!-- Task Name -->--}}
{{--                                        <td class="table-text">--}}
{{--                                            <div>--}}
{{--                                                <a  href="javascript:Livewire.emit('view',{{$newEntry->id}})">{{$newEntry->incident_type}}</a>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}


{{--                                        <td class="table-text text-nowrap">--}}
{{--                                            <div>EYES</div>--}}
{{--                                        </td>--}}

{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                        @endforeach--}}

{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}


{{--            @else--}}
{{--                No incident entries found.<br/>--}}
{{--                <hr>--}}
{{--            @endif--}}
{{--        </div>--}}

{{--    <div id="sent_entries">--}}
{{--            <hr data-content="SENT IR's" class="hr-text">--}}

{{--            @if ($LW_incident_entries->has('Sent'))--}}
{{--                <div class="table-responsive">--}}

{{--                    <table--}}
{{--                        class="table table-striped table-bordered"--}}
{{--                        id="tbl_incidententries" name="tbl_incidententries"--}}
{{--                        style="width:100%">--}}

{{--                        <!-- Table Headings -->--}}
{{--                        <thead>--}}
{{--                        <th>Date Received/Created</th>--}}
{{--                        <th>Name of Child</th>--}}
{{--                        <th>Foster Home</th>--}}
{{--                        <th>Case Manager</th>--}}
{{--                        <th>Type</th>--}}
{{--                        <th>EYES</th>--}}

{{--                        </thead>--}}

{{--                        <!-- Table Body -->--}}
{{--                        <tbody>--}}

{{--                        @foreach ($LW_incident_entries as $group=>$entry)--}}
{{--                            @if ($group == "Sent")--}}
{{--                                @foreach ($entry as $newEntry)--}}
{{--                                    <tr>--}}
{{--                                        <td class="table-text text-nowrap">--}}
{{--                                            <div>{{$newEntry->date_of_incident}}</div>--}}
{{--                                        </td>--}}

{{--                                        <td>--}}
{{--                                            <div>{{$newEntry->get_child->initials}}</div>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <div>@if ($newEntry->get_child->getCaseManageAssignedHome)--}}
{{--                                                    {{$newEntry->get_child->getCaseManageAssignedHome->name}}--}}
{{--                                                @else--}}
{{--                                                    N/A--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <div>@if ($newEntry->get_child->getCaseManageAssignedHome)--}}
{{--                                                    @if ($newEntry->get_child->getCaseManageAssignedHome->getCaseManager)--}}
{{--                                                        {{$newEntry->get_child->getCaseManageAssignedHome->getCaseManager->name}}--}}
{{--                                                    @else--}}
{{--                                                        N/A--}}
{{--                                                    @endif--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </td>--}}


{{--                                        <!-- Task Name -->--}}
{{--                                        <td class="table-text">--}}
{{--                                            <div>--}}
{{--                                                <a  href="javascript:Livewire.emit('view',{{$newEntry->id}})">{{$newEntry->incident_type}}</a>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}


{{--                                        <td class="table-text text-nowrap">--}}
{{--                                            <div>                                                        <i class="fa-solid fa-eye mr-0.5 text-green" style="font-size:14px"></i><i class="fa-solid fa-eye mr-2 text-green" style="font-size:14px"></i></a>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}

{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            @endif--}}
{{--                        @endforeach--}}

{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}


{{--            @else--}}
{{--                No incident entries found.<br/>--}}
{{--                <hr>--}}
{{--            @endif--}}
{{--        </div>--}}



    <script>


        window.addEventListener('SuccessMessage', event=> {
            //$("#frmAddMedication").trigger('reset');

           // $("#toast-success-message").text(event.detail.alertText);
            //toastbox('toast-success', 3000)
            $('#addIncidentModal').modal('hide');
            // window.location.reload(true);

        });



     </script>

</div>

    </div>
</div>


