<div class="container-fluid">

    <script>
        var user;
        var field;
        var typing;

        var originalShowing = true;
        var onlineUsers = [];

        var ignoreScrollEvents = false

        function generateIR_Report() {
            location.assign("/reports/IR_Report/{{ $LW_incident_entry->id }}/generateReport");
        }

        function toggleOriginal() {
            if (originalShowing) {
                //collapse it

                $('#original').collapse('hide');
                $('#lblShowOriginal').html(
                    ' <button wire:ignore type="button" onclick="toggleOriginal()" class="mb-2 btn-sm btn-success waves-effect"><i class="fas fa-chevron-right pr-2" aria-hidden="true"></i>SHOW ORIGINAL</button>'
                )
                originalShowing = false;
            } else {
                //show it
                $('#original').collapse('show');
                $('#lblShowOriginal').html(
                    '  <button wire:ignore type="button" onclick="toggleOriginal()" class="mb-2 btn-sm btn-success waves-effect"><i class="fas fa-chevron-left pr-2" aria-hidden="true"></i>HIDE ORIGINAL</button>'
                )
                originalShowing = true;

            }

        }

        function openOriginal() {
            $('#original').collapse('show');
        }


        function pleaseWait() {
            $("#pleaseWaitSpinner").css({
                visibility: 'visible'
            })
        }

        window.addEventListener('hideSpinner', event => {
            $("#pleaseWaitSpinner").css({
                visibility: 'hidden'
            })
            $("#modalCompose").hide();

        })
        $(document).ready(function() {
            $("#pleaseWaitSpinner").css({
                visibility: 'hidden'
            })


            function mirrorSize(selector) {
                selector.style.height = 0;
                var base_id = $(selector).attr('id').replace("_editable", "")
                $("#" + base_id).css("height", 0);
                $("#" + base_id + "_editable").css("height", 0);
                var size = $('#' + base_id)[0].scrollHeight > $('#' + base_id + "_editable")[0].
                scrollHeight ? $('#' + base_id)[0].scrollHeight : $('#' +
                    base_id + "_editable")[0].scrollHeight

                $("#" + base_id).css("height", (size + 4) + "px");
                $("#" + base_id + "_editable").css("height", (size + 4) + "px");
            }


            $("textarea.autoResize").each(function() {
                mirrorSize(this)
            }).on("input", function() {
                mirrorSize(this)
            });




            window.addEventListener('ScrollMessageBoardToBottom', event => {
                // alert ('got dispatch');
                //Scroll to the bottom of specific message_board
                console.log(event.detail.MessageBoardID);
                //alert ($("#"+ event));
                $("#message_board_" + event.detail.MessageBoardID).animate({
                    scrollTop: $("#message_board_" + event.detail.MessageBoardID)[0]
                        .scrollHeight -
                        $("#message_board_" + event.detail.MessageBoardID).height()
                }, 1000, function() {
                    console.log("done " + event.detail.MessageBoardID);
                })

            });

            //Join Room
            Echo.join('IR.{{ $LW_incident_entry->id }}')
                .here((users) => {
                    console.log("here");
                    console.log(users);
                    console.log(' are in the room');
                })
                .joining((user) => {
                    console.log(user.name + " has joined");
                })

                .leaving((user) => {
                    console.log(user.name + " has left");
                    // Livewire.emit('userLeft',user);
                })

                .error((error) => {
                    console.log("Error: ");
                    console.log(error);
                });


            // START OF TYPING REQUEST
            var intervalID_Typing;
            var that;
            let channel = Echo.private('IR.{{ $LW_incident_entry->id }}');

            function sendTypingRequest(e) {
                var that = this;
                console.log("Sending Typing Request for: " + e.currentTarget.id);
                $label = $('label[for="' + e.currentTarget.id + '"]').html();

                channel.whisper('typing', {
                    user: {{ Auth::user()->id }},
                    name: '{{ Auth::user()->name }}',
                    field: e.currentTarget.id,
                    label: $label,
                    typing: true
                });

                intervalID_Typing = setTimeout(function(e) {
                    console.log("Typing Stopped for: " + that.id + ", Sending Request");

                    typing = false;
                    $label = $('label[for="' + that.id + '"]').html();

                    channel.whisper('typing', {
                        user: {{ Auth::user()->id }},
                        name: '{{ Auth::user()->name }}',
                        field: that.id,
                        label: $label,

                        typing: false
                    });

                }, 1000);
            }

            // Event handlers to show information when events are being emitted
            $('#frmEditable input, textarea')
                .on('keydown', function(e) {
                    console.log("Waiting for more keystrokes from: " + e.currentTarget.id);
                    // $statusKey.html('Waiting for more keystrokes... ');
                    clearInterval(intervalID_Typing);
                })


            // Display when the ajax request will happen (after user stops typing)
            // Exagerated value of 1.2 seconds for demo purposes, but in a real example would be better from 50ms to 200ms
            $('#frmEditable input, textarea').on('keyup',
                _.debounce(sendTypingRequest, 50));



            channel
                .listenForWhisper('typing', (e) => {
                    console.log('typing event detected');

                    user = e.user;
                    name: e.name;
                    field = e.field;
                    typing = e.typing;
                    label = e.label;
                    console.log(e);
                    // remove is typing indicator after 0.6s


                    {{-- if ({{Auth::user()->id}} != user && typing) { --}}
                    if (typing) {
                        $("#typingIndicator").html(name + " is typing on field: " + "<b><u>" + e.label +
                            "</u></b>");
                    } else {
                        $("#typingIndicator").html("");
                    }
                    // } else {
                    // $("#typingIndicator").html ("");
                    // }

                });
            // END OF TYPING REQUEST

            // START OF FIELD FOCUS REQUEST
            var intervalID_Focus;

            function sendFocusRequest(e) {
                var that = this;
                console.log("Sending Focus Request for: " + e.currentTarget.id);
                $label = $('label[for="' + e.currentTarget.id + '"]').html();

                channel.whisper('focus', {
                    user: {{ Auth::user()->id }},
                    name: '{{ Auth::user()->name }}',
                    field: e.currentTarget.id,
                    label: $label
                });

                intervalID_Focus = setTimeout(function() {
                    console.log("Focus lost on: " + that.id);
                    {{-- let channel = Echo.private('IR'); --}}

                    {{-- channel.whisper('focusout', { --}}
                    {{--    user: {{Auth::user()->id}}, --}}
                    {{--    field: field, --}}
                    {{-- }); --}}

                }, 1000);
            }



            // Event handlers to show information when events are being emitted
            $('#frmEditable input').focusout(function(e) {
                console.log("user lost focus on the field: " + e.currentTarget.id);
                $label = $('label[for="' + e.currentTarget.id + '"]').html();

                // $statusKey.html('Waiting for more keystrokes... ');
                // clearInterval(intervalID_Focus);
                console.log("Sending Focus Out Request");

                channel.whisper('focusout', {
                    user: {{ Auth::user()->id }},
                    name: '{{ Auth::user()->name }}',
                    field: e.currentTarget.id,
                    label: $label
                });


            });


            // Display when the ajax request will happen (after user stops typing)
            // Exagerated value of 1.2 seconds for demo purposes, but in a real example would be better from 50ms to 200ms
            $('#frmEditable input').on('focusin', _.debounce(sendFocusRequest, 50));




            channel
                .listenForWhisper('focus', (e) => {
                    console.log('focus event detected for: ' + e.field);

                    user = e.user;
                    name = e.name;
                    field = e.field;
                    label = e.label;


                    console.log(e);
                    console.log('test: ' + user);


                    if ({{ Auth::user()->id }} != user && !$("#" + e.field).prop('disabled')) {
                        $("#" + e.field).prop('disabled', true);
                        $("#" + e.field).prop('readonly', true);
                        $("#" + e.field).css('background-color', 'blue');
                        $("#" + e.field).css('color', 'white');

                    } else {
                        // $("#typingIndicator").html ("");
                    }

                });

            channel
                .listenForWhisper('focusout', (e) => {
                    console.log('focusout event detected for field: ' + e.field);

                    user = e.user;
                    field = e.field;

                    console.log(e);


                    if ({{ Auth::user()->id }} != user && $("#" + e.field).prop('disabled')) {
                        $("#" + e.field).prop('disabled', false);
                        $("#" + e.field).prop('readonly', false);
                        $("#" + e.field).css('background-color', 'white');
                        $("#" + e.field).css('color', 'black');

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

    <style>
        .modal-header-info {
            color: #fff;
            padding: 9px 15px;
            border-bottom: 1px solid #eee;
            background-color: #5bc0de;
            -webkit-border-top-left-radius: 5px;
            -webkit-border-top-right-radius: 5px;
            -moz-border-radius-topleft: 5px;
            -moz-border-radius-topright: 5px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .content-wrapper {
            /*min-height: 100% !important;*/
            /*max-height: 100% !important;*/
            /*height: 100% !important;*/
            height: inherit;
        }
    </style>

    <nav wire:ignore style="" class="navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark">
        <span wire:ignore class="float-right text-white" id="typingIndicator">&nbsp;</span>
    </nav>
    <!-- /.modal compose message -->
    <div wire:ignore class="modal show" id="modalCompose">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-envelope-square"></i> Send Incident Response</h5>
                    <button type="button" onclick="$('#modalCompose').hide()" class="close" data-dismiss="modal"
                        aria-hidden="true">×</button>

                </div>
                <div class="modal-body">
                    <form role="form" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2" for="inputTo"><i class="fas fa-user"></i>To</label>
                            <div class="col-sm-10"><input wire:model="emailTo" type="email" class="form-control"
                                    id="inputTo"
                                    placeholder="Enter e-mail address, comma separated list of recipients"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2" for="inputSubject"><span
                                    class="glyphicon glyphicon-list-alt"></span>Subject</label>
                            <div class="col-sm-10"><input wire:model="emailSubject" type="text" class="form-control"
                                    id="inputSubject" placeholder="Enter Subject"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="inputBody"><span
                                    class="glyphicon glyphicon-list"></span>Message</label>
                            <div class="col-sm-12">
                                <textarea wire:ignore wire:model="emailMessage" class="form-control" id="inputBody" rows="8"
                                    placeholder="Enter Message"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div id="pleaseWaitSpinner" class="spinner-border text-primary float-left" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <button onclick="$('#modalCompose').hide()" type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">Cancel</button>
                    <button type="button" wire:click="sendIR_Email()" onclick="pleaseWait()"
                        class="btn btn-primary ">Send <i class="fa fa-arrow-circle-right fa-lg"></i></button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal compose message -->


    <div class="mb-0 pb-0 mt-0 pt-0"
        style="display: inline-flex; padding-left:0px; text-align:center; width:100%; height:75px;">

        <span class="float-left mb-0 pb-0" style="width:200px;" wire:ignore.self id="lblShowOriginal">
            <button wire:ignore onclick="toggleOriginal()" type="button"
                class="mb-2 btn-sm btn-success waves-effect"><i class="fas fa-chevron-left pr-2"
                    aria-hidden="true"></i>HIDE ORIGINAL</button>
        </span>

        <div class="justify-content-center mb-0 pb-0"
            style="display:inline-flex; position:relative; top:-50px; width:90%;">
            @foreach ($onlineUsers as $onlineUser)
                <figure>
                    @if ($onlineUser['profilePic'])
                        <img style="margin-left:10px" height="100px" width="80px"
                            src="/storage/profile_pic/{{ substr($onlineUser['profilePic'], 20) }}" alt="avatar"
                            class="rounded-circle ">
                    @else
                        <img height="100px" width="80px" src="/img/default-avatar.png" alt="avatar"
                            class="rounded-circle" />
                    @endif

                    {{--                                            <figcaption class="figure-caption text-sm text-center">{{strtok($onlineUser['name'],' ')}}</figcaption> --}}
                    <figcaption style="margin-left: 10px" class="figure-caption text-sm">{{ $onlineUser['name'] }}
                    </figcaption>
                </figure>
            @endforeach
        </div>

        <span style="width:200px;" class="float-right ml-3 mb-0 pb-0"> <button onclick="$('#modalCompose').show()"
                type="button" class="mb-2 btn-sm btn-success waves-effect"><i class="fas fa-envelope pr-2"
                    aria-hidden="true"></i>SEND IR</button></span>
        <span style="width:200px;" class="float-right mb-0 pb-0"> <button onclick="generateIR_Report()" type="button"
                class="mb-2 btn-sm btn-info waves-effect"><i class="fas fa-eye pr-2" aria-hidden="true"></i>PREVIEW
                IR</button></span>


    </div>






    <div class="row">
        <div wire:ignore.self id="original" name="frms"
            class="syncscroll pre-scrollable col ml-2 bg-gradient-lightblue collapse show ">
            <div class="text-red text-center text-bold mt-1">ORIGINAL
            </div>
            {{--                    ORIGINAL IR FORM --}}
            <div class="form-group" id="IR_form_entry" name="IR_form_entry" style="">
                <div class="form-group">
                    <label for="inputNameOfChild">Name of
                        Child</label>
                    <input readonly type="inputNameOfChild" class="form-control" id="inputNameOfChild"
                        value="{{ $child->initials }}">
                </div>

                <div class="form-group">
                    <label for="inputDOB">Date of Birth</label>
                    <input readonly type="inputDOB" class="form-control" id="inputDOB"
                        value="{{ $child->DOB }}">
                </div>

                <div class="form-group">
                    <label for="inputDateofIncident">Date of
                        Placement</label>
                    <input readonly type="inputDateofPlacement" class="form-control" id="inputDateofPlacement"
                        value="{{ Carbon\Carbon::now()->toDateString('Y-m-d H:i') }}">
                </div>

                <div class="form-group">
                    <label for="inputFosterHome">Foster Home</label>
                    <input readonly name="inputFosterHome" class="form-control" id="inputFosterHome"
                        value="{{ $child->getCaseManageAssignedHome ? $child->getCaseManageAssignedHome->name : 'N/A' }}">
                </div>

                <div class="form-group">
                    <label for="inputPlacingAgency">Placing
                        Agency</label>
                    <input readonly type="inputPlacingAgency" class="form-control" id="inputPlacingAgency"
                        value="{{ $child->getCASAgency ? $child->getCASAgency->name : 'N/A' }}">
                </div>

                <div class="form-group">
                    <label for="inputLegalGuardian">Legal Guardian's
                        Name</label>
                    <input readonly wire:model="LW_incident_entry.legal_guardian_name" type="inputLegalGuardian"
                        class="form-control" id="inputLegalGuardian" placeholder="Enter Data...">
                    @error('LW_incident_entry.legal_guardian_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>


                <div class="form-group">
                    <br /><br /> <span style="color:red;">NOTIFY / REPORT WITHIN 24 HOURS / S.O. AS SOON AS
                        POSSIBLE</span>
                    <br /><b>*Carpe Diem must submit Serious
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
                        <option value="Property Damage / Destruction">
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
                        <option value="School Issues (Concern, Suspension)">
                            School Issues (Concern, Suspension)
                        </option>
                        <option value="Food Issues (hoarding)">Food
                            Issues (hoarding)
                        </option>
                        <option value="Aggression / Defiance / Tantrums">
                            Aggression / Definance / Tantrums
                        </option>
                        <option value="Medication Error">Medication
                            Error
                        </option>
                        <option value="Stealing">Stealing</option>
                        <option value="Fire Setting">Fire Setting
                        </option>
                        <option value="Issues Relating to Visits or Family Contact">
                            Issues Relating to Visits or Family
                            Contact
                        </option>
                        <option value="Suicidal Thoughts or Attempts / Self-Harm">
                            Suicidal Thoughts or Attempts /
                            Self-Harm
                        </option>
                        <option value="Other">Other</option>


                    </select>
                    @error('LW_incident_entry.incident_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
                @if ($LW_incident_entry->incident_type == 'Serious Occurence')
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
                    @error('LW_incident_entry.serious_occurence')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                @endif

                @if ($LW_incident_entry->incident_type == 'Level 1 Serious Occurence')
                    <div class="form-group">
                        <label for="inputLevel1SeriousOccurence">Level 1
                            - Serious Occurence</label>
                        <select readonly wire:model="LW_incident_entry.level1_serious_occurence"
                            id="inputLevel1SeriousOccurence" class="form-control">
                            <option value="Media Coverage">Media
                                Coverage
                            </option>
                            <option value="Emeregency Services">
                                Emergency Services used in response to a
                                significant incident involving a client
                            </option>

                        </select>
                        @error('LW_incident_entry.level1_serious_occurence')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                @endif

                <div class="form-group">
                    <label for="inputDateofIncident">Date of
                        Incident</label>
                    <input readonly wire:model="LW_incident_entry.date_of_incident" type="inputDateofIncident"
                        class="form-control" id="inputDateofIncident" placeholder="Enter Data...">
                    @error('LW_incident_entry.date_of_incident')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="inputTimeDuration">Time/Duration</label>
                    <input readonly wire:model="LW_incident_entry.time_duration" type="inputTimeDuration"
                        class="form-control" id="inputTimeDuration" placeholder="Enter Data...">
                    @error('LW_incident_entry.time_duration')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="inputDateTimeReportReceived">Date/Time
                        Report Received</label>
                    <input readonly wire:model="LW_incident_entry.datetime_report_received"
                        type="inputDateTimeReportReceived" class="form-control" id="inputDateTimeReportReceived"
                        placeholder="Enter Data...">
                    @error('LW_incident_entry.datetime_report_received')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="inputLocationofIncident">Location of
                        Incident</label>
                    <textarea wire:ignore readonly wire:model="LW_incident_entry.location_of_incident" id="inputLocationofIncident"
                        placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                    @error('LW_incident_entry.location_of_incident')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="inputAntecedent">Antecedent leading
                        to the Incident</label>
                    <textarea wire:ignore readonly wire:model="LW_incident_entry.antecedent_leading_to_incident" id="inputAntecedent"
                        placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                    @error('LW_incident_entry.antecedent_leading_to_incident')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="inputDescription">Description of
                        Incident (What, When, Where and How)</label>
                    <textarea wire:ignore readonly wire:model="LW_incident_entry.description_of_incident" id="inputDescription"
                        placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                    @error('LW_incident_entry.description_of_incident')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="inputActionTaken">Action
                        Taken</label>
                    <textarea wire:ignore readonly wire:model="LW_incident_entry.action_taken" id="inputActionTaken"
                        placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                    @error('LW_incident_entry.action_taken')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="inputWhoWasNotified">Who Was
                        Notified</label><br />
                    <input disabled wire:model="who_was_notified" type="checkbox"
                        @if (in_array('Carpe Diem Case Manager / Supervisor', $who_was_notified)) checked @endif name="inputWhoWasNotified[]"
                        value="Carpe Diem Case Manager / Supervisor">
                    Carpe Diem Case Manager / Supervisor<br>
                    <input disabled wire:model="who_was_notified" type="checkbox"
                        @if (in_array('Carpe Diem On Call Worker', $who_was_notified)) checked @endif name="inputWhoWasNotified[]"
                        value="Carpe Diem On Call Worker"> Carpe
                    Diem On Call Worker - (FOSTER PARENT – Call
                    After Hours 905-799-2947x8)<br>
                    <input disabled wire:model="who_was_notified" type="checkbox"
                        @if (in_array('CAS Worker/After Hours Worker', $who_was_notified)) checked @endif name="inputWhoWasNotified[]"
                        value="CAS Worker/After Hours Worker">
                    CAS Worker/After Hours Worker - (TO BE DONE BY
                    CARPE DIEM ON CALL WORKER)<br>
                    <input disabled wire:model="who_was_notified" type="checkbox"
                        @if (in_array('Other', $who_was_notified)) checked @endif name="inputWhoWasNotified[]" value="Other">
                    Other<br>
                    @error('LW_incident_entry.who_was_notified')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="inputPhysicalInjuries">Physical
                        Injuries (Include specific details of injury
                        and medical intervention)</label>
                    <textarea wire:ignore readonly wire:model="LW_incident_entry.physical_injuries" id="inputPhysicalInjuries"
                        placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                    @error('LW_incident_entry.physical_injuries')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="inputPropertyDamage">Property Damage
                        (Attach Damage Form)</label>
                    <textarea wire:ignore readonly wire:model="LW_incident_entry.property_damage" id="inputPropertyDamage"
                        placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                    @error('LW_incident_entry.property_damageLW_incident_entry.property_damage')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="inputComments">Comments
                        (Why)</label>
                    <textarea wire:ignore readonly wire:model="LW_incident_entry.comments" id="inputComments" placeholder="Enter Data..."
                        class="form-control autoResize" rows="4"></textarea>
                    @error('LW_incident_entry.comments')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

            </div>
        </div>

        <div name="frms" class="syncscroll pre-scrollable col ml-4  bg-gradient-gray">
            <div class="text-danger text-center text-bold mt-1">REVISED

            </div>

            {{--                    REVISIONS IR FORM --}}
            <div id="frmEditable">
                <div class="form-group" id="IR_form_entry_editable" name="IR_form_entry_editable" style="">
                    <div class="form-group">
                        <label for="inputNameOfChild_editable">Name of Child</label>
                        <input type="text" class="form-control" id="inputNameOfChild_editable"
                            value="{{ $child->initials }}">
                    </div>

                    <div class="form-group">
                        <label for="inputDOB_editable">Date of Birth</label>
                        <input disabled type="text" class="form-control" id="inputDOB_editable"
                            value="{{ $child->DOB }}">
                    </div>

                    <div class="form-group">
                        <label for="inputDateofIncident_editable">Date of Placement</label>
                        <input disabled type="text" class="form-control" id="inputDateofPlacement_editable"
                            value="{{ Carbon\Carbon::now()->toDateString('Y-m-d H:i') }}">
                    </div>

                    <div class="form-group">
                        <label for="inputFosterHome_editable">Foster Home</label>
                        <input disabled name="inputFosterHome" class="form-control" id="inputFosterHome_editable"
                            value="{{ $child->getCaseManageAssignedHome ? $child->getCaseManageAssignedHome->name : 'N/A' }}">
                    </div>

                    <div class="form-group">
                        <label for="inputPlacingAgency_editable">Placing Agency</label>
                        <input disabled type="text" class="form-control" id="inputPlacingAgency_editable"
                            value="{{ $child->getCASAgency ? $child->getCASAgency->name : 'N/A' }}">
                    </div>

                    <div class="form-group">
                        <label for="inputLegalGuardian_editable">Legal Guardian's Name</label>
                        {{--                                <input @if ($lockField->field == 'legal_guardian')  @endif wire:model="LW_incident_entryCurrentRevision.legal_guardian_name" type="inputLegalGuardian" --}}
                        {{--                                       class="form-control @if ($lockField->field == 'legal_guardian') text-green @else text-black @endif " --}}
                        {{--                                       id="inputLegalGuardian2" placeholder="Enter Data..." > --}}
                        <input wire:ignore wire:model="LW_incident_entryCurrentRevision.legal_guardian_name"
                            type="input" class="form-control " id="inputLegalGuardian_editable"
                            placeholder="Enter Data...">
                        {{--                                @if ($lockField->field == 'legal_guardian') LOCKED @else "NOT LOCKED" @endif --}}

                        @error('LW_incident_entryCurrentRevision.legal_guardian_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>


                    <div class="form-group">
                        <br /><br /> <span style="color:red;">NOTIFY / REPORT WITHIN 24 HOURS / S.O. AS SOON AS
                            POSSIBLE</span>
                        <br /><b>*Carpe Diem must submit Serious
                            Occurrence Reports to Ministry within 24
                            hours</b> <br /><br />

                        <label for="inputIncidentType_editable">Incident</label>
                        <select wire:model="LW_incident_entryCurrentRevision.incident_type" id="inputIncidentType"
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
                            <option value="Property Damage / Destruction">
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
                            <option value="School Issues (Concern, Suspension)">
                                School Issues (Concern, Suspension)
                            </option>
                            <option value="Food Issues (hoarding)">Food
                                Issues (hoarding)
                            </option>
                            <option value="Aggression / Defiance / Tantrums">
                                Aggression / Definance / Tantrums
                            </option>
                            <option value="Medication Error">Medication
                                Error
                            </option>
                            <option value="Stealing">Stealing</option>
                            <option value="Fire Setting">Fire Setting
                            </option>
                            <option value="Issues Relating to Visits or Family Contact">
                                Issues Relating to Visits or Family
                                Contact
                            </option>
                            <option value="Suicidal Thoughts or Attempts / Self-Harm">
                                Suicidal Thoughts or Attempts /
                                Self-Harm
                            </option>
                            <option value="Other">Other</option>


                        </select>
                        @error('LW_incident_entryCurrentRevision.incident_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    @if ($LW_incident_entryCurrentRevision->incident_type == 'Serious Occurence')
                        <div class="form-group">
                            <label for="inputSeriousOccurence_editable">Serious Occurence</label>
                            <select wire:model="LW_incident_entryCurrentRevision.serious_occurence"
                                id="inputSeriousOccurence_editable" class="form-control">
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
                        @error('LW_incident_entryCurrentRevision.serious_occurence')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    @endif

                    @if ($LW_incident_entryCurrentRevision->incident_type == 'Level 1 Serious Occurence')
                        <div class="form-group">
                            <label for="inputLevel1SeriousOccurence_editable">Level 1 - Serious Occurence</label>
                            <select wire:model="LW_incident_entryCurrentRevision.level1_serious_occurence"
                                id="inputLevel1SeriousOccurence_editable" class="form-control">
                                <option value="Media Coverage">Media
                                    Coverage
                                </option>
                                <option value="Emeregency Services">
                                    Emergency Services used in response to a
                                    significant incident involving a client
                                </option>

                            </select>
                            @error('LW_incident_entryCurrentRevision.level1_serious_occurence')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                    @endif

                    <div class="form-group">
                        <label for="inputDateofIncident_editable">Date of Incident</label>
                        <input wire:model="LW_incident_entryCurrentRevision.date_of_incident"
                            type="inputDateofIncident" class="form-control" id="inputDateofIncident_editable"
                            placeholder="Enter Data...">
                        @error('LW_incident_entryCurrentRevision.date_of_incident')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputTimeDuration_editable">Time/Duration</label>
                        <input wire:model="LW_incident_entryCurrentRevision.time_duration" type="inputTimeDuration"
                            class="form-control" id="inputTimeDuration_editable" placeholder="Enter Data...">
                        @error('LW_incident_entryCurrentRevision.time_duration')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">

                        <label for="inputDateTimeReportReceived_editable">Date/Time Report Received</label>
                        <input wire:model="LW_incident_entryCurrentRevision.datetime_report_received"
                            type="inputDateTimeReportReceived" class="form-control"
                            id="inputDateTimeReportReceived_editable" placeholder="Enter Data...">
                        @error('LW_incident_entryCurrentRevision.datetime_report_received')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputLocationofIncident_editable">Location of Incident</label>
                        <textarea wire:ignore wire:model="LW_incident_entryCurrentRevision.location_of_incident"
                            id="inputLocationofIncident_editable" name="inputLocationofIncident_editable" placeholder="Enter Data..."
                            class="form-control autoResize" rows="4"></textarea>
                        @error('LW_incident_entryCurrentRevision.location_of_incident')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputAntecedent_editable">Antecedent leading to the Incident</label>
                        <textarea wire:ignore wire:model="LW_incident_entryCurrentRevision.antecedent_leading_to_incident"
                            id="inputAntecedent_editable" placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                        @error('LW_incident_entryCurrentRevision.antecedent_leading_to_incident')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputDescription_editable">Description of Incident (What, When, Where and
                            How)</label>
                        <textarea wire:ignore wire:model="LW_incident_entryCurrentRevision.description_of_incident"
                            id="inputDescription_editable" placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                        @error('LW_incident_entryCurrentRevision.description_of_incident')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputActionTaken_editable">Action Taken</label>
                        <textarea wire:ignore wire:model="LW_incident_entryCurrentRevision.action_taken" id="inputActionTaken_editable"
                            placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                        @error('LW_incident_entryCurrentRevision.action_taken')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputWhoWasNotified_editable">Who Was Notified</label><br />
                        <input wire:model="who_was_notifiedCurrentRevision" type="checkbox"
                            @if (in_array('Carpe Diem Case Manager / Supervisor', $who_was_notifiedCurrentRevision)) checked @endif
                            value="Carpe Diem Case Manager / Supervisor">
                        Carpe Diem Case Manager / Supervisor<br>
                        <input wire:model="who_was_notifiedCurrentRevision" type="checkbox"
                            @if (in_array('Carpe Diem On Call Worker', $who_was_notifiedCurrentRevision)) checked @endif value="Carpe Diem On Call Worker"> Carpe
                        Diem On Call Worker - (FOSTER PARENT – Call
                        After Hours 905-799-2947x8)<br>
                        <input wire:model="who_was_notifiedCurrentRevision" type="checkbox"
                            @if (in_array('CAS Worker/After Hours Worker', $who_was_notifiedCurrentRevision)) checked @endif value="CAS Worker/After Hours Worker">
                        CAS Worker/After Hours Worker - (TO BE DONE BY
                        CARPE DIEM ON CALL WORKER)<br>
                        <input wire:model="who_was_notifiedCurrentRevision" type="checkbox"
                            @if (in_array('Other', $who_was_notifiedCurrentRevision)) checked @endif value="Other"> Other<br>
                        @error('LW_incident_entryCurrentRevision.who_was_notified')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputPhysicalInjuries_editable">Physical Injuries (Include specific details of
                            injury and medical intervention)</label>
                        <textarea wire:ignore wire:model="LW_incident_entryCurrentRevision.physical_injuries"
                            id="inputPhysicalInjuries_editable" placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                        @error('LW_incident_entryCurrentRevision.physical_injuries')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputPropertyDamage_editable">Property Damage (Attach Damage Form)</label>
                        <textarea wire:ignore wire:model="LW_incident_entryCurrentRevision.property_damage" id="inputPropertyDamage_editable"
                            placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                        @error('LW_incident_entryCurrentRevision.property_damageLW_incident_entryCurrentRevision.property_damage')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="inputComments_editable">Comments (Why)</label>
                        <textarea wire:ignore wire:model="LW_incident_entryCurrentRevision.comments" id="inputComments_editable"
                            placeholder="Enter Data..." class="form-control autoResize" rows="4"></textarea>
                        @error('LW_incident_entryCurrentRevision.comments')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    {{--                            <div class="form-group mb-0"> --}}
                    {{--                                <button wire:click="SaveRevision()" type="button"  class="mb-2 btn-danger btn-sm float-right">Save Revision</button> --}}
                    {{--                            </div> --}}

                </div>
            </div>

        </div>

        <div class="col-3 ml-3">
            {{--                <p>                                @if ($lockField->field == 'legal_guardian') LOCKED @else "NOT LOCKED" @endif --}}
            {{--                </p> --}}
            <div wire:poll.active class="mb-2">
                {{--                    <div id="onlineUsers" class="card card-primary"> --}}
                {{--                            <div class="card-header"> --}}
                {{--                                <h3 class="card-title">Online Users</h3> --}}
                {{--                            </div> --}}

                {{--                            <div class="card-body mb-0 pb-0"> --}}
                {{--                                <div class="container"> --}}
                {{--                                    <div class="row"> --}}
                {{--                                @foreach ($onlineUsers as $onlineUser) --}}

                {{--                                    --}}{{--                                    @if ($onlineUser['profilePic']) --}}
                {{--                                    --}}{{--                                        <img src="{{$onlineUser['profilePic']}}" /> --}}
                {{--                                    --}}{{--                                    @endif --}}
                {{--                                    <div class="col-3"> --}}
                {{--                                        <figure> --}}
                {{--                                            @if ($onlineUser['profilePic']) --}}
                {{--                                                <img height="75px" width="56px" src="/storage/profile_pic/{{substr($onlineUser['profilePic'],20)}}" alt="avatar" class="rounded-circle  figure-img"> --}}
                {{--                                            @else --}}
                {{--                                                <img height="75px" width="56px"  src="/img/default-avatar.png" alt="avatar" class="rounded-circle  figure-img" /> --}}
                {{--                                            @endif --}}

                {{--                                            <figcaption class="figure-caption text-sm text-center">{{strtok($onlineUser['name'],' ')}}</figcaption> --}}
                {{--                                                <figcaption class="figure-caption text-sm">{{$onlineUser['name']}}</figcaption> --}}
                {{--                                        </figure> --}}
                {{--                                        <span class="text-center figure-caption text-sm">{{strtok($onlineUser['name'],' ')}}</span> --}}
                {{--                                    </div> --}}
                {{--                                @endforeach --}}

                {{--                                    </div> --}}
                {{--                            </div> --}}

                {{--                        </div> --}}




                {{--                </div> --}}

                <div id="revisions" class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Revisions</h3>
                    </div>

                    <div class="card-body">
                        Total Revisions: {{ count($IR_UserEditHistory) ? count($IR_UserEditHistory) : 0 }}
                        <span class="ml-3"><a wire:click.prevent="toggleApprove"><i
                                    class="fas fa-thumbs-up fa-lg @if (
                                        $LW_incident_entryCurrentRevision->approvedBy &&
                                            in_array(Auth::user()->id, $LW_incident_entryCurrentRevision->approvedBy)) text-success @else text-primary @endif"></i></a>
                            <span class="badge badge-notify" style="font-size:14px;">
                                @if ($LW_incident_entryCurrentRevision->approvedBy)
                                    {{ count($LW_incident_entryCurrentRevision->approvedBy) }}
                                @else
                                    0
                                @endif
                            </span>

                            @if ($LW_incident_entryCurrentRevision->approvedBy)
                                <span class="float-right"> <a wire:click.prevent="ViewApprovals"
                                        class="btn btn-sm btn-outline-success float-right">View Approvals</a></span>
                            @endif
                        </span>

                    </div>
                    {{--                <p>Load Revision:</p> --}}
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <td>User</td>
                                <td>Last Updated</td>
                            </tr>
                        </thead>



                        @foreach ($IR_UserEditHistory as $entry)
                            <tr>
                                {{--                            <td><a @if ($entry->id == '1') class="text-primary" @endif @if ($entry->id == '2') class="text-green" @endif wire:click="LoadRevision('{{$revision->id}}')">{{$revision->get_user->name}}</a></td> --}}

                                <td
                                    class="@if ($entry->fk_UserID == '1') text-primary @endif @if ($entry->fk_UserID == '2') text-green @endif">
                                    {{ \App\Models\User::where('id', '=', $entry->fk_UserID)->first()->name }}</td>
                                <td>{{ $entry->date }}</td>
                            </tr>
                            {{--                        <li wire:click="LoadRevision('{{$revision->id}}')">{{$revision->get_user->name}} - {{$revision->updated_at}} - {{$revision->fk_UserID}}</li> --}}
                        @endforeach
                    </table>

                    {{--                <button wire:click="CreateNewRevision()" class="btn-sm btn-primary">Create New Revision</button> --}}

                    {{--                <button onclick="window.test()" class="btn-sm btn-primary">Test</button> --}}

                    {{--                {{$currentAction}} --}}
                </div>

                <div id="teamDiscussion" class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Team Discussion</h3>
                    </div>

                    <div class="card-body">
                        @livewire('forms.case-manage.module-chat', ['user' => Auth::user(), 'model' => 'Edited_Incident_Entry', 'fk_ModelID' => $LW_incident_entry->id, 'rows' => 337])

                    </div>




                </div>



            </div>




        </div>

    </div>
    <div class="row mt-5" style="height:25px;">&nbsp;</div>

    {{--    <div class="row" style="margin-top:50px;">&nbsp;</div> --}}


</div>
