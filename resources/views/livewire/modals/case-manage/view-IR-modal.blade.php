<div wire:poll.active>

    <script>

        var user;
        var field;
        var typing;


        $(document).ready(function() {

            window.addEventListener('ScrollMessageBoardToBottom', event=>  {
                // alert ('got dispatch');
                //Scroll to the bottom of specific message_board
                console.log (event.detail.MessageBoardID);
                //alert ($("#"+ event));
                $("#message_board_" + event.detail.MessageBoardID).animate({
                    scrollTop:$("#message_board_" + event.detail.MessageBoardID)[0].scrollHeight - $("#message_board_" + event.detail.MessageBoardID).height()
                },1000,function(){
                    console.log("done " + event.detail.MessageBoardID);
                })

            });


            // START OF TYPING REQUEST
            var intervalID_Typing;
            var that;
            function sendTypingRequest(e){
                var that = this;
                console.log ("Sending Typing Request for: " + e.currentTarget.id);
                let channel = Echo.private('IR');

                channel.whisper('typing', {
                    user: {{Auth::user()->id}},
                    field: e.currentTarget.id,
                    typing: true
                });

                intervalID_Typing = setTimeout(function(e){
                    console.log ("Typing Stopped for: " + that.id + ", Sending Request");

                    let channel = Echo.private('IR');

                        typing = false;
                        channel.whisper('typing', {
                            user: {{Auth::user()->id}},
                            field: that.id,
                            typing: false
                        });

                },1000);
            }

            // Event handlers to show information when events are being emitted
            $('#frmEditable input')
                .on('keydown', function (e){
                    console.log ("Waiting for more keystrokes from: " + e.currentTarget.id);
                    // $statusKey.html('Waiting for more keystrokes... ');
                    clearInterval(intervalID_Typing);
                })


            // Display when the ajax request will happen (after user stops typing)
            // Exagerated value of 1.2 seconds for demo purposes, but in a real example would be better from 50ms to 200ms
            $('#frmEditable input').on('keyup',
                _.debounce(sendTypingRequest, 50));



            Echo.private('IR')
                .listenForWhisper('typing', (e) => {
                    console.log('typing event detected');

                    user = e.user;
                    field = e.field;
                    typing = e.typing;

                    console.log (e);
                    // remove is typing indicator after 0.6s


                         if ({{Auth::user()->id}} != user && typing) {
                            $("#typingIndicator").html (user + " is typing on field: " + e.field);
                        } else {
                            // $("#typingIndicator").html ("");
                        }

                });
            // END OF TYPING REQUEST

            // START OF FIELD FOCUS REQUEST
            var intervalID_Focus;

            function sendFocusRequest(e){
                var that = this;
                console.log ("Sending Focus Request for: " + e.currentTarget.id);
                let channel = Echo.private('IR');

                channel.whisper('focus', {
                    user: {{Auth::user()->id}},
                    field: e.currentTarget.id,
                });

                intervalID_Focus = setTimeout(function(){
                    console.log ("Focus lost on: " + that.id);
                    {{--let channel = Echo.private('IR');--}}

                    {{--channel.whisper('focusout', {--}}
                    {{--    user: {{Auth::user()->id}},--}}
                    {{--    field: field,--}}
                    {{--});--}}

                },1000);
            }



            // Event handlers to show information when events are being emitted
            $('#frmEditable input').focusout(function(e) {
                console.log ("user lost focus on the field: " + e.currentTarget.id);
                // $statusKey.html('Waiting for more keystrokes... ');
                // clearInterval(intervalID_Focus);
                console.log ("Sending Focus Out Request");
                let channel = Echo.private('IR');

                channel.whisper('focusout', {
                    user: {{Auth::user()->id}},
                    field: e.currentTarget.id,
                });


            });


            // Display when the ajax request will happen (after user stops typing)
            // Exagerated value of 1.2 seconds for demo purposes, but in a real example would be better from 50ms to 200ms
            $('#frmEditable input').on('focusin',_.debounce(sendFocusRequest, 50));





            Echo.private('IR')
                .listenForWhisper('focus', (e) => {
                    console.log('focus event detected for: ' + e.field);

                    user = e.user;
                    field = e.field;

                    console.log (e);


                    if ({{Auth::user()->id}} != user && !$("#" + e.field).prop('disabled')) {
                        $("#" + e.field).prop('disabled', true);
                    } else {
                        // $("#typingIndicator").html ("");
                    }

                });

            Echo.private('IR')
                .listenForWhisper('focusout', (e) => {
                    console.log('focusout event detected for field: ' + e.field);

                    user = e.user;
                    field = e.field;

                    console.log (e);


                    if ({{Auth::user()->id}} != user && $("#" + e.field).prop('disabled')) {
                        $("#" + e.field).prop('disabled', false);
                    } else {
                        // $("#typingIndicator").html ("");
                    }

                });
            // END OF FIELD FOCUS REQUEST

            // window.test = function test() {
            //     axios({
            //         url: '/fire',
            //         method: 'get',
            //         data: {
            //             foo: 'bar'
            //         }
            //     });
            // }



        });



    </script>
    <x-wire-elements-pro::bootstrap.slide-over on-submit="" :content-padding="false">

{{--        <x-slot name="title" class="mt-5">View IR Entry</x-slot>--}}
{{--            <a wire:click="closeAndRelease" class="btn btn-sm btn-danger">Close</a>--}}

        <div class="container-fluid mt-4">
            <div class="row">

            <div class="col-4 ml-2 bg-gradient-yellow">
                <div class="text-primary text-center text-bold mt-1">ORIGINAL</div>
                {{--                    ORIGINAL IR FORM--}}
                <div class="form-group" id="IR_form_entry"
                     name="IR_form_entry" style="">
                    <div class="form-group">
                        <label for="inputNameOfChild">Name of
                            Child</label>
                        <input readonly type="inputNameOfChild"
                               class="form-control"
                               id="inputNameOfChild"
                               value="{{$child->initials}}">
                    </div>

                    <div class="form-group">
                        <label for="inputDOB">Date of Birth</label>
                        <input readonly type="inputDOB" class="form-control"
                               id="inputDOB"
                               value="{{$child->DOB}}">
                    </div>

                    <div class="form-group">
                        <label for="inputDateofIncident">Date of
                            Placement</label>
                        <input readonly type="inputDateofPlacement"
                               class="form-control"
                               id="inputDateofPlacement"
                               value="{{ Carbon\Carbon::now()->toDateString('Y-m-d H:i')}}">
                    </div>

                    <div class="form-group">
                        <label for="inputFosterHome">Foster Home</label>
                        <input readonly name="inputFosterHome"
                               class="form-control"
                               id="inputFosterHome"
                               value="{{$child->getCaseManageAssignedHome ?  $child->getCaseManageAssignedHome->name :  'N/A'}}">
                    </div>

                    <div class="form-group">
                        <label for="inputPlacingAgency">Placing
                            Agency</label>
                        <input readonly type="inputPlacingAgency"
                                class="form-control"
                                id="inputPlacingAgency" value="{{$child->getCASAgency ? $child->getCASAgency->name : "N/A"}}">
                    </div>

                    <div class="form-group">
                        <label for="inputLegalGuardian">Legal Guardian's
                            Name</label>
                        <input readonly wire:model="LW_incident_entry.legal_guardian_name" type="inputLegalGuardian"
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
                        <select readonly wire:model="LW_incident_entry.incident_type" id="inputIncidentType"
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
                            <select readonly wire:model="LW_incident_entry.serious_occurence" id="inputSeriousOccurence"
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
                            <select readonly wire:model="LW_incident_entry.level1_serious_occurence" id="inputLevel1SeriousOccurence"
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
                        <input readonly wire:model="LW_incident_entry.date_of_incident" type="inputDateofIncident"
                               class="form-control"
                               id="inputDateofIncident"
                               placeholder="Enter Data...">
                        @error('LW_incident_entry.date_of_incident') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label
                            for="inputTimeDuration">Time/Duration</label>
                        <input  readonly wire:model="LW_incident_entry.time_duration" type="inputTimeDuration"
                                class="form-control"
                                id="inputTimeDuration"
                                placeholder="Enter Data...">
                        @error('LW_incident_entry.time_duration') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">

                        <label for="inputDateTimeReportReceived">Date/Time
                            Report Received</label>
                        <input  readonly wire:model="LW_incident_entry.datetime_report_received" type="inputDateTimeReportReceived"
                                class="form-control"
                                id="inputDateTimeReportReceived"
                                placeholder="Enter Data...">
                        @error('LW_incident_entry.datetime_report_received') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputLocationofIncident">Location of
                            Incident</label>
                        <textarea  readonly wire:model="LW_incident_entry.location_of_incident" id="inputLocationofIncident" placeholder="Enter Data..."
                                   class="form-control"
                                   rows="4"></textarea>
                        @error('LW_incident_entry.location_of_incident') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputAntecedent">Antecedent leading
                            to the Incident</label>
                        <textarea  readonly wire:model="LW_incident_entry.antecedent_leading_to_incident" id="inputAntecedent" placeholder="Enter Data..."
                                   class="form-control"
                                   rows="4"></textarea>
                        @error('LW_incident_entry.antecedent_leading_to_incident') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputDescription">Description of
                            Incident (What, When, Where and How)</label>
                        <textarea  readonly wire:model="LW_incident_entry.description_of_incident" id="inputDescription" placeholder="Enter Data..."
                                   class="form-control"
                                   rows="4"></textarea>
                        @error('LW_incident_entry.description_of_incident') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputActionTaken">Action
                            Taken</label>
                        <textarea  readonly wire:model="LW_incident_entry.action_taken"  id="inputActionTaken" placeholder="Enter Data..."
                                   class="form-control"
                                   rows="4"></textarea>
                        @error('LW_incident_entry.action_taken') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputWhoWasNotified">Who Was
                            Notified</label><br/>
                        <input disabled wire:model="who_was_notified"  type="checkbox" @if(in_array("Carpe Diem Case Manager / Supervisor",$who_was_notified)) checked @endif
                        name="inputWhoWasNotified[]"
                               value="Carpe Diem Case Manager / Supervisor">
                        Carpe Diem Case Manager / Supervisor<br>
                        <input disabled wire:model="who_was_notified" type="checkbox" @if(in_array("Carpe Diem On Call Worker",$who_was_notified)) checked @endif
                        name="inputWhoWasNotified[]"
                               value="Carpe Diem On Call Worker"> Carpe
                        Diem On Call Worker - (FOSTER PARENT – Call
                        After Hours 905-799-2947x8)<br>
                        <input disabled wire:model="who_was_notified" type="checkbox" @if(in_array("CAS Worker/After Hours Worker",$who_was_notified)) checked @endif
                        name="inputWhoWasNotified[]"
                               value="CAS Worker/After Hours Worker">
                        CAS Worker/After Hours Worker - (TO BE DONE BY
                        CARPE DIEM ON CALL WORKER)<br>
                        <input disabled wire:model="who_was_notified" type="checkbox" @if(in_array("Other",$who_was_notified)) checked @endif
                        name="inputWhoWasNotified[]"
                               value="Other"> Other<br>
                        @error('LW_incident_entry.who_was_notified') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputPhysicalInjuries">Physical
                            Injuries (Include specific details of injury
                            and medical intervention)</label>
                        <textarea  readonly wire:model="LW_incident_entry.physical_injuries" id="inputPhysicalInjuries" placeholder="Enter Data..."
                                   class="form-control"
                                   rows="4"></textarea>
                        @error('LW_incident_entry.physical_injuries') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputPropertyDamage">Property Damage
                            (Attach Damage Form)</label>
                        <textarea  readonly wire:model="LW_incident_entry.property_damage" id="inputPropertyDamage" placeholder="Enter Data..."
                                   class="form-control"
                                   rows="4"></textarea>
                        @error('LW_incident_entry.property_damageLW_incident_entry.property_damage') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputComments">Comments
                            (Why)</label>
                        <textarea  readonly wire:model="LW_incident_entry.comments" id="inputComments" placeholder="Enter Data..."
                                   class="form-control"
                                   rows="4"></textarea>
                        @error('LW_incident_entry.comments') <span class="text-danger">{{ $message }}</span> @enderror

                    </div>

                </div>
            </div>

            <div wire:poll.active class="col-4 ml-4  bg-gradient-gray">
                <div class="text-danger text-center text-bold mt-1">REVISED

                </div>

                {{--                    REVISIONS IR FORM--}}
                            <div id="frmEditable" >
                             <div class="form-group" id="IR_form_entry_editable"
                             name="IR_form_entry_editable" style="">
                            <div class="form-group">
                                <label for="inputNameOfChild">Name of
                                    Child</label>
                                <input disabled type="inputNameOfChild"
                                       class="form-control"
                                       id="inputNameOfChild"
                                       value="{{$child->initials}}">
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
                                <input disabled name="inputFosterHome"
                                       class="form-control"
                                       id="inputFosterHome"
                                       value="{{$child->getCaseManageAssignedHome ?  $child->getCaseManageAssignedHome->name :  'N/A'}}">
                            </div>

                            <div class="form-group">
                                <label for="inputPlacingAgency">Placing
                                    Agency</label>
                                <input disabled type="inputPlacingAgency"
                                        class="form-control"
                                        id="inputPlacingAgency" value="{{$child->getCASAgency ?  $child->getCASAgency->name :  'N/A'}}">
                            </div>

                            <div class="form-group">
                                <label for="inputLegalGuardian">Legal Guardian's
                                    Name</label>
{{--                                <input @if($lockField->field == "legal_guardian")  @endif wire:model="LW_incident_entryCurrentRevision.legal_guardian_name" type="inputLegalGuardian"--}}
{{--                                       class="form-control @if($lockField->field == "legal_guardian") text-green @else text-black @endif "--}}
{{--                                       id="inputLegalGuardian2" placeholder="Enter Data..." >--}}
                                <input wire:ignore wire:model="LW_incident_entryCurrentRevision.legal_guardian_name" type="inputLegalGuardian"
                                       class="form-control "
                                       id="inputLegalGuardian2" placeholder="Enter Data..." >
{{--                                @if($lockField->field == "legal_guardian") LOCKED @else "NOT LOCKED" @endif--}}

                                @error('LW_incident_entryCurrentRevision.legal_guardian_name') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>


                            <div class="form-group">
                                <br /><br />   <span
                                    style="color:red;">NOTIFY / REPORT WITHIN 24 HOURS / S.O. AS SOON AS POSSIBLE</span>
                                <br/><b>*Carpe Diem must submit Serious
                                    Occurrence Reports to Ministry within 24
                                    hours</b> <br /><br />

                                <label for="inputIncidentType">Incident</label>
                                <select  wire:model="LW_incident_entryCurrentRevision.incident_type" id="inputIncidentType"
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
                                @error('LW_incident_entryCurrentRevision.incident_type') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>
                            @if ($LW_incident_entryCurrentRevision->incident_type == "Serious Occurence")
                                <div class="form-group">
                                    <label for="inputSeriousOccurence">Serious
                                        Occurence</label>
                                    <select  wire:model="LW_incident_entryCurrentRevision.serious_occurence" id="inputSeriousOccurence"
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
                                @error('LW_incident_entryCurrentRevision.serious_occurence') <span class="text-danger">{{ $message }}</span> @enderror

                            @endif

                            @if ($LW_incident_entryCurrentRevision->incident_type == "Level 1 Serious Occurence")
                                <div class="form-group">
                                    <label for="inputLevel1SeriousOccurence">Level 1
                                        - Serious Occurence</label>
                                    <select  wire:model="LW_incident_entryCurrentRevision.level1_serious_occurence" id="inputLevel1SeriousOccurence"
                                            class="form-control">
                                        <option value="Media Coverage">Media
                                            Coverage
                                        </option>
                                        <option value="Emeregency Services">
                                            Emergency Services used in response to a
                                            significant incident involving a client
                                        </option>

                                    </select>
                                    @error('LW_incident_entryCurrentRevision.level1_serious_occurence') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                            @endif

                            <div class="form-group">
                                <label for="inputDateofIncident">Date of
                                    Incident</label>
                                <input  wire:model="LW_incident_entryCurrentRevision.date_of_incident" type="inputDateofIncident"
                                       class="form-control"
                                       id="inputDateofIncident"
                                       placeholder="Enter Data...">
                                @error('LW_incident_entryCurrentRevision.date_of_incident') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label
                                    for="inputTimeDuration">Time/Duration</label>
                                <input   wire:model="LW_incident_entryCurrentRevision.time_duration" type="inputTimeDuration"
                                        class="form-control"
                                        id="inputTimeDuration"
                                        placeholder="Enter Data...">
                                @error('LW_incident_entryCurrentRevision.time_duration') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">

                                <label for="inputDateTimeReportReceived">Date/Time
                                    Report Received</label>
                                <input   wire:model="LW_incident_entryCurrentRevision.datetime_report_received" type="inputDateTimeReportReceived"
                                        class="form-control"
                                        id="inputDateTimeReportReceived"
                                        placeholder="Enter Data...">
                                @error('LW_incident_entryCurrentRevision.datetime_report_received') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label for="inputLocationofIncident">Location of
                                    Incident</label>
                                <textarea   wire:model="LW_incident_entryCurrentRevision.location_of_incident" id="inputLocationofIncident_editable" name="inputLocationofIncident_editable" placeholder="Enter Data..."
                                           class="form-control"
                                           rows="4"></textarea>
                                @error('LW_incident_entryCurrentRevision.location_of_incident') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label for="inputAntecedent">Antecedent leading
                                    to the Incident</label>
                                <textarea   wire:model="LW_incident_entryCurrentRevision.antecedent_leading_to_incident" id="inputAntecedent" placeholder="Enter Data..."
                                           class="form-control"
                                           rows="4"></textarea>
                                @error('LW_incident_entryCurrentRevision.antecedent_leading_to_incident') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label for="inputDescription">Description of
                                    Incident (What, When, Where and How)</label>
                                <textarea   wire:model="LW_incident_entryCurrentRevision.description_of_incident" id="inputDescription" placeholder="Enter Data..."
                                           class="form-control"
                                           rows="4"></textarea>
                                @error('LW_incident_entryCurrentRevision.description_of_incident') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label for="inputActionTaken">Action
                                    Taken</label>
                                <textarea   wire:model="LW_incident_entryCurrentRevision.action_taken"  id="inputActionTaken" placeholder="Enter Data..."
                                           class="form-control"
                                           rows="4"></textarea>
                                @error('LW_incident_entryCurrentRevision.action_taken') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label for="inputWhoWasNotified">Who Was
                                    Notified</label><br/>
                                <input   wire:model="who_was_notifiedCurrentRevision"  type="checkbox" @if(in_array("Carpe Diem Case Manager / Supervisor",$who_was_notified)) checked @endif
                                name="inputWhoWasNotified[]"
                                       value="Carpe Diem Case Manager / Supervisor">
                                Carpe Diem Case Manager / Supervisor<br>
                                <input   wire:model="who_was_notifiedCurrentRevision" type="checkbox" @if(in_array("Carpe Diem On Call Worker",$who_was_notified)) checked @endif
                                name="inputWhoWasNotified[]"
                                       value="Carpe Diem On Call Worker"> Carpe
                                Diem On Call Worker - (FOSTER PARENT – Call
                                After Hours 905-799-2947x8)<br>
                                <input   wire:model="who_was_notifiedCurrentRevision" type="checkbox" @if(in_array("CAS Worker/After Hours Worker",$who_was_notified)) checked @endif
                                name="inputWhoWasNotified[]"
                                       value="CAS Worker/After Hours Worker">
                                CAS Worker/After Hours Worker - (TO BE DONE BY
                                CARPE DIEM ON CALL WORKER)<br>
                                <input   wire:model="who_was_notifiedCurrentRevision" type="checkbox" @if(in_array("Other",$who_was_notified)) checked @endif
                                name="inputWhoWasNotified[]"
                                       value="Other"> Other<br>
                                @error('LW_incident_entryCurrentRevision.who_was_notified') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label for="inputPhysicalInjuries">Physical
                                    Injuries (Include specific details of injury
                                    and medical intervention)</label>
                                <textarea   wire:model="LW_incident_entryCurrentRevision.physical_injuries" id="inputPhysicalInjuries" placeholder="Enter Data..."
                                           class="form-control"
                                           rows="4"></textarea>
                                @error('LW_incident_entryCurrentRevision.physical_injuries') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label for="inputPropertyDamage">Property Damage
                                    (Attach Damage Form)</label>
                                <textarea   wire:model="LW_incident_entryCurrentRevision.property_damage" id="inputPropertyDamage" placeholder="Enter Data..."
                                           class="form-control"
                                           rows="4"></textarea>
                                @error('LW_incident_entryCurrentRevision.property_damageLW_incident_entryCurrentRevision.property_damage') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group">
                                <label for="inputComments">Comments
                                    (Why)</label>
                                <textarea   wire:model="LW_incident_entryCurrentRevision.comments" id="inputComments" placeholder="Enter Data..."
                                           class="form-control"
                                           rows="4"></textarea>
                                @error('LW_incident_entryCurrentRevision.comments') <span class="text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="form-group mb-0">
                                <button wire:click="SaveRevision()" type="button"  class="mb-2 btn-danger btn-sm float-right">Save Revision</button>


                            </div>

                </div>
                            </div>

            </div>

            <div class="col-3 ml-3">
{{--                <p>                                @if($lockField->field == "legal_guardian") LOCKED @else "NOT LOCKED" @endif--}}
{{--                </p>--}}
                <div class="mb-2">Total Revisions: {{count($IR_UserEditHistory) ? count($IR_UserEditHistory) : 0}}
                    <span class="ml-3"><a wire:click.prevent="toggleApprove"><i class="fas fa-thumbs-up fa-lg @if ($LW_incident_entryCurrentRevision->approvedBy && in_array(Auth::user()->id,$LW_incident_entryCurrentRevision->approvedBy))text-success @else text-primary @endif"></i></a>
                        <span class="badge badge-notify" style="font-size:14px;">@if($LW_incident_entryCurrentRevision->approvedBy)  {{count($LW_incident_entryCurrentRevision->approvedBy)}} @else 0 @endif</span>

                       @if($LW_incident_entryCurrentRevision->approvedBy)
                        <span class="float-right"> <a wire:click.prevent="ViewApprovals" class="btn btn-sm btn-outline-success float-right">View Approvals</a></span>
                        @endif
                    </span>

                </div>
{{--                <p>Load Revision:</p>--}}
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <td>User</td>
                        <td>Last Updated</td>
                    </tr>
                    </thead>



                @foreach ($IR_UserEditHistory as $entry)
                        <tr>
{{--                            <td><a @if ($entry->id == "1") class="text-primary" @endif @if ($entry->id == "2") class="text-green" @endif wire:click="LoadRevision('{{$revision->id}}')">{{$revision->get_user->name}}</a></td>--}}

                            <td class="@if ($entry->fk_UserID == "1") text-primary @endif @if ($entry->fk_UserID == "2") text-green @endif">{{\App\Models\User::where('id','=',$entry->fk_UserID)->first()->name}}</td>
                            <td>{{$entry->date}}</td>
                        </tr>
{{--                        <li wire:click="LoadRevision('{{$revision->id}}')">{{$revision->get_user->name}} - {{$revision->updated_at}} - {{$revision->fk_UserID}}</li>--}}
                @endforeach
                </table>

{{--                <button wire:click="CreateNewRevision()" class="btn-sm btn-primary">Create New Revision</button>--}}

{{--                <button onclick="window.test()" class="btn-sm btn-primary">Test</button>--}}

{{--                {{$currentAction}}--}}

                <div class="form-group" id="comments_edits"
                     name="comments_edits" style="">
                    <div class="form-group">
                        <label for="inputNameOfChild"><u>IR Team Discussion</u></label>
                    </div>

                </div>
                @livewire('forms.case-manage.module-chat',['user' => Auth::user(), 'model' => 'Edited_Incident_Entry', 'fk_ModelID' => $LW_incident_entry->id, 'rows' => 530])

            </div>



                <nav style="margin-left: 30%;" class="navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark">
                    <span class="navbar-text float-right" id="typingIndicator"></span>

                </nav>

        </div>


        </x-wire-elements-pro::bootstrap.slide-over>




</div>
