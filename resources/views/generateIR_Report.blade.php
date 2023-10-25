<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>IR REPORT</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <style>

        pre{
            white-space: pre-wrap;
            word-break: break-word;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="text-center"><img src="/img/carpe_diem_logo.png"/></div>
    <h3 class="text-center">INCIDENT REPORT</h3>

    <div class="row ml-5 mb-3">
        Name of Child: &nbsp;<b>{{\App\Models\Child::where('id','=',$incident->EditedRevisions->fk_ChildID)->first()->initials}}</b>
    </div>

    <div class="row ml-5 mb-3">
        Date of Birth: &nbsp;<b>{{\App\Models\Child::where('id','=',$incident->EditedRevisions->fk_ChildID)->first()->DOB}}</b>
    </div>

    <div class="row ml-5 mb-3">
        Date of Placement: &nbsp;<b></b>

    </div>

    <div class="row ml-5 mb-3">
        Foster Home: &nbsp;<b>{{\App\Models\Child::where('id','=',$incident->EditedRevisions->fk_ChildID)->first()->getCaseManageAssignedHome->name}}</b>
    </div>

    <div class="row ml-5 mb-3">
        Placing Agency: &nbsp;<b>{{\App\Models\Child::where('id','=',$incident->EditedRevisions->fk_ChildID)->first()->getCASAgency->name ??  'N/A'}}</b>
    </div>

    <div class="row ml-5 mb-3">
        Legal Guardian's Name: &nbsp;<b>{{$incident->EditedRevisions->legal_guardian_name}}</b>
    </div>

    <div class="row ml-5 mb-0">
        <h4>NOTIFY / REPORT WITHIN 24 HOURS / S.O. AS SOON AS POSSIBLE</h4>
    </div>

    <div class="row ml-5 mb-3">
        <h6>*Carpe Diem must submit Serious Occurrence Reports to Ministry within 24 hours</h6>

    </div>


    <div class="row ml-5 mb-3">

        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th>Check off Type of Incident:</th>
                <th>Serious Occurence: (*Submit ASAP)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Injury") checked @endif>
                    Injury
                </td>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->serious_occurence == "Death") checked @endif>
                    Death
                </td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Property Damage / Destruction") checked @endif>
                    Property Damage / Destruction
                </td>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->serious_occurence == "Serious Injury") checked @endif>
                    Serious Injury
                </td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Disclosure") checked @endif>
                    Disclosure
                </td>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->serious_occurene == "Serious Illness") checked @endif>
                    Serious Illness
                </td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Alcohol / Drug Use") checked @endif>
                    Alcohol / Drug Use
                </td>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->serious_occurence == "Serious Individual Action") checked @endif>
                    Serious Individual Action
                </td>
            </tr>


            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Sexualized Behaviour") checked @endif>
                    Sexualized Behaviour
                </td>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->serious_occurence == "Restrictive Intervention") checked @endif>
                    Restrictive Intervention
                </td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Lying") checked @endif>
                    Lying
                </td>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->serious_occurence == "Abuse or Mistreatment") checked @endif>
                    Abuse or Mistreatment
                </td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "School Issue (Concern, Suspension)") checked @endif>
                    School Issues (Concern, Suspension)
                </td>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->serious_occurence == "Error or Omission") checked @endif>
                    Error or Omission
                </td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Food Issues (hoarding)") checked @endif>
                    Food Issues (Hoarding)
                </td>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->serious_occurence == "Serious Complaint") checked @endif>
                    Serious Complaint
                </td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Aggression / Defiance / Tantrums") checked @endif>
                    Aggression / Definance / Tantrums
                </td>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->serious_occurence == "Disturbance, Service Disruption. Emergency Situation or Disaster") checked @endif>
                    Disturbance, Service Disruption, Emergency Situation or Disaster
                </td>
            </tr>

            <tr>
                <td>
                <input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Medication Error") checked @endif>
                Medication Error</td>
                <td><b>LEVEL 1 SERIOUS OCCURRENCE (Notify within 1 hour)</b></td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Stealing") checked @endif>
                    Stealing
                </td>
                <td><b> <input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->level1_serious_occurence == "Media Coverage") checked @endif>
                        Media Coverage</b></td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Fire Setting") checked @endif>
                    Fire Setting
                </td>
                <td><b> <input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->level1_serious_occurence == "Emergency services used in response to a significant incident involving a client") checked @endif>
                        Emergency services used in response to a significant incident involving a client</b></td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Issues Relating to Visits or Family Contact") checked @endif>
                    Issues Relating to Visits or Family Contact
                </td>
                <td></td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Suicidal Thoughts or Attempts / Self-Harm") checked @endif>
                    Suicidal Thoughts or Attempts / Self-Harm
                </td>
                <td></td>
            </tr>

            <tr>
                <td><input type="checkbox" id="incident_type" name="incident_type" value="" @if ($incident->EditedRevisions->incident_type == "Other") checked @endif>
                    Other: (Please Specify) <input type="text" id="incident_type_other" />
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>

    </div>

    <div class="row mb-3">
        <div class="col ml-5">
            Date of Incident: &nbsp;<b>{{$incident->EditedRevisions->date_of_incident}}</b>
        </div>
        <div class="col">
            Time/Duration: &nbsp;<b>{{$incident->EditedRevisions->time_duration}}</b>
        </div>
    </div>

    <div class="row ml-5 mb-3">
        Date and Time Report Received: &nbsp;<b>{{$incident->EditedRevisions->datetime_report_received}}</b>
    </div>

    <div class="row ml-5 mb-3">
        Location of Incident: &nbsp;<pre>{{$incident->EditedRevisions->location_of_incident}}</pre>
    </div>

    <div class="row ml-5 mb-3">
        Antecedent leading to the Incident: &nbsp;<pre>{{$incident->EditedRevisions->antecedent_leading_to_incident}}</pre>
    </div>

    <div class="row ml-5 mb-3">
        Description of Incident (What, When, Where and How): &nbsp;<pre>{{$incident->EditedRevisions->description_of_incident}}</pre>
    </div>

    <div class="row ml-5 mb-3">
        Action Taken: &nbsp;<pre>{{$incident->EditedRevisions->action_taken}}</pre>
    </div>

    <div class="row ml-5 mb-3">
        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th>Who Was Notified:</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>                <input type="checkbox" id="incident_type" name="incident_type" value="" @if (str_contains($incident->EditedRevisions->who_was_notified,"Carpe Diem Case Manager")) checked @endif>
                    Carpe Diem Case Manager / Supervisor</td>
            </tr>

            <tr>
                <td>                <input type="checkbox" id="incident_type" name="incident_type" value=""  @if (str_contains($incident->EditedRevisions->who_was_notified,"Carpe Diem On Call Worker")) checked @endif>
                    Carpe Diem On Call Worker (FOSTER PARENT – Call After Hours 905-799-2947 – Press 8)</td>
            </tr>

            <tr>
                <td>                <input type="checkbox" id="incident_type" name="incident_type" value=""  @if (str_contains($incident->EditedRevisions->who_was_notified,"CAS Worker/After Hours Worker")) checked @endif>
                    CAS Worker / After Hours Worker (TO BE DONE BY CARPE DIEM ON CALL WORKER)</td>
            </tr>

            <tr>
                <td>                <input type="checkbox" id="incident_type" name="incident_type" value=""  @if (str_contains($incident->EditedRevisions->who_was_notified,"Other")) checked @endif>
                    Other</td>
            </tr>

            </tbody>
        </table>

    </div>

    <div class="row ml-5 mb-3">
        Physical Injuries (Include specific details of injury and medical intervention): &nbsp;<b>{{$incident->EditedRevisions->physical_injuries}}</b>
    </div>

    <div class="row ml-5 mb-3">
        Property Damage (Attach Damage Form): &nbsp;<b>{{$incident->EditedRevisions->property_damage}}</b>
    </div>

    <div class="row ml-5 mb-3">
        Comments (Why): &nbsp;<b>{{$incident->EditedRevisions->comments}}</b>
    </div>

    <div class="row ml-5 mt-5 mb-3">
        ________________________________________
        <br />Completed By: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{Auth::user()->name}} <br/>

    </div>

    <div class="footer text-center">
        9355 Dixie Road, Brampton, ON L6S 1J7 Tel: 905.799.2947 Fax: 905.790.8262 Email: info@carpediem.ca
    </div>


</div>
</div>
</body>
</html>


<div class="container">

</div>

