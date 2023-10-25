<div>
    <!-- Add IR Dialog -->
    <div wire:ignore.self class="offcanvas offcanvas-bottom" id="addIncidentModal" tabindex="-1">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Add Incident Report Entry</h5>
            <a href="#" class="offcanvas-close" data-bs-dismiss="offcanvas">
                <ion-icon name="close-outline"></ion-icon>
            </a>
        </div>

        <div class="offcanvas-body">
            <form id="frmAddIncident" wire:submit.prevent="submit" enctype="multipart/form-data">

            <div class="form-group" id="IR_form_entry"
                 name="IR_form_entry" style="">
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
                            value="{{$child->get_home->address}}, {{$child->get_home->city}}, {{$child->get_home->postal}}">
                </div>

                <div class="form-group">
                    <label for="inputPlacingAgency">Placing
                        Agency</label>
                    <input  type="inputPlacingAgency"
                           class="form-control"
                           id="inputPlacingAgency" value="Carpe Diem Residential Therapeutic Treatment Homes for Children">
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
                    <input wire:model="LW_incident_entry.who_was_notified"  type="checkbox" checked
                           name="inputWhoWasNotified[]"
                           value="Carpe Diem Case Manager / Supervisor">
                    Carpe Diem Case Manager / Supervisor<br>
                    <input wire:model="LW_incident_entry.who_was_notified" type="checkbox"
                           name="inputWhoWasNotified[]"
                           value="Carpe Diem On Call Worker"> Carpe
                    Diem On Call Worker - (FOSTER PARENT – Call
                    After Hours 905-799-2947x8)<br>
                    <input wire:model="LW_incident_entry.who_was_notified" type="checkbox"
                           name="inputWhoWasNotified[]"
                           value="CAS Worker /After Hours Worker">
                    CAS Worker /After Hours Worker - (TO BE DONE BY
                    CARPE DIEM ON CALL WORKER)<br>
                    <input wire:model="LW_incident_entry.who_was_notified" type="checkbox"
                           name="inputWhoWasNotified[]"
                           value=Other"> Other<br>
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
    <!-- *Add IR Dialog -->

    <!-- View Medication Dialog -->
    <div wire:ignore.self class="modal fade dialog" id="viewModal" data-accordion="static" tabindex="-1" role="dialog"
         aria-labelledby="viewModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-blue">
                    <span class="modal-title" id="mymodelLabel">View Medication Entry</span>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group col">
                            <label for="medication_type">Medication Type</label>
                            <input readonly type="text" class="form-control" id="medication_type"
                                   wire:model="LW_medication_entry.medication_type">

                        </div>

                        <div class="form-group col">
                            <label for="dosage">Dosage</label>
                            <input readonly type="text" class="form-control" id="dosage" wire:model="LW_medication_entry.dosage">

                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="form-group col">
                            <label for="date_time">Date/Time</label>
                            <input readonly type="text" class="form-control" id="date_time"
                                   wire:model="LW_medication_entry.date_time">

                        </div>

                        <div class="form-group col">
                            <label for="compliance">Compliance</label>
                            <input readonly type="text" class="form-control" id="compliance"
                                   wire:model="LW_medication_entry.compliance">

                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="form-group col">
                            <label for="taken_with_food">Taken with Food</label>
                            <input readonly  name="taken_with_food" id="taken_with_food" class="form-control"
                                    wire:model="LW_medication_entry.taken_with_food" />


                        </div>


                        <div class="form-group col">
                            <label for="PRN">PRN</label>
                            <input readonly name="PRN" id="PRN" class="form-control"
                                    wire:model="LW_medication_entry.PRN" />

                        </div>
                    </div>

                    <div class="form-group">
                       {{--  @if ($LW_medication_entry->photo != "") --}}

                            Photo <br />
{{--   <img class="d-block mx-auto" src="/storage/{{substr($LW_medication_entry->photo,7)}}" wire:model="LW_medication_entry.photo" width="400px"/>


  @else
  No photo uploaded
  @endif
  --}}
</div>



</div>


</div>
</div>
</div>
    <!-- *View Medication Dialog -->

<div id="entries">
    @if ($LW_incident_entries->Count() >0)
        <div class="table-responsive">

<table
class="table table-striped table-bordered dt-responsive nowrap"
id="tbl_incidententries" name="tbl_incidententries"
style="width:100%">

<!-- Table Headings -->
<thead>
<th>Type</th>
<th>Date/Time</th>
<th>Description</th>
</thead>

<!-- Table Body -->
<tbody>

@foreach ($LW_incident_entries as $entry)

  <tr>
      <!-- Task Name -->
      <td class="table-text">
          <div>
              <a href="/mobile/child/IR_Entry?id={{$entry->id}}&childID={{$child->id}}">{{$entry->incident_type}}</a>
          </div>
      </td>
      <td class="table-text text-nowrap">
          <div>{{$entry->date_of_incident}}</div>
      </td>

      <td class="table-text text-nowrap">
          <div>{{$entry->description_of_incident}}</div>
      </td>

  </tr>

@endforeach

</tbody>
</table>
</div>
            <div class="d-flex justify-content-center p-1 m-1">
                {!! $LW_incident_entries->links() !!}
            </div>

    @else
        No incident entries found.<br/>
        <hr>
    @endif
</div>

<div class="d-flex justify-content-center p-1 m-1">
    <button class="btn btn-success d-flex justify-content-center" data-bs-toggle="offcanvas"
            data-bs-target="#addIncidentModal">Add Entry - LW
    </button></div>


<!-- Modal -->
<div wire:ignore.self class="modal fade dialogbox" id="deleteModal" data-bs-backdrop="static" tabindex="-1"
role="dialog" aria-labelledby="deleteModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="deleteModalLabel">Delete Medication</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
  <span aria-hidden="true close-btn">×</span>
</button>
</div>
<div class="modal-body">
<p>Are you sure want to delete this entry?</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
<button type="button" wire:click.prevent="deleteRecord()" class="btn btn-danger close-modal"
      data-bs-dismiss="modal">Yes, Delete
</button>
</div>
</div>
</div>
</div>

<script>
    window.addEventListener('SuccessMessage', event=> {
        //$("#frmAddMedication").trigger('reset');

        $("#toast-success-message").text(event.detail.alertText);
        toastbox('toast-success', 3000)
        $('#addIncidentModal').modal('hide')

    });

window.addEventListener('closeAddMedicationModal', event => {
//$("#frmAddMedication").trigger('reset');

$('#addModal').modal('hide')

});

window.addEventListener('viewMedicationModal', event => {
//$("#frmAddMedication").trigger('reset');

$('#viewModal').modal('show')

});



//stop background scrolling when modal is open

window.addEventListener('hidden.bs.modal', event => {
//$("#frmAddMedication").trigger('reset');

$('body').css('overflow', 'auto');
$('#appCapsule').css('overflow', 'auto');
$('#frmAddMedication').trigger('reset');

});

window.addEventListener('shown.bs.modal', event => {
$("#frmAddMedication").trigger('reset');

$('body').css('overflow', 'hidden');
$('#appCapsule').css('overflow', 'hidden');
});


$('#addModal').on('shown.bs.modal', function (e) {

});

</script>

</div>


