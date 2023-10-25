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

        body {
            font-size: 30px;
        }

        pre{
            /*white-space: pre-wrap;*/
            word-break: break-word;
            font-size: 30px;
            margin-left: 0px;
            font-family: serif;

        }

        table, th {
            border: 1px solid black;
        }

        td {
            font-size: 24px;
        }

        tr {
            line-height: 30px;
        }
        label {
            /*display: block;*/
            /*padding-left: 15px;*/
            /*text-indent: -15px;*/
        }

        input {

            padding: 0;
            margin: 0;
            vertical-align: bottom;
            position: relative;
            top: -5px;
            *overflow: hidden;
        }

        input .incident_type_other{

            padding: 0;
            margin: 0;
            vertical-align: bottom;
            position: relative;
            top: 20px;
            left: 12px;
            *overflow: hidden;
        }

    </style>



</head>
<body>
<script type="text/php">

    if (isset($pdf)) {
        $x = 540;
        $y = 10;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 8;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }

     if (isset($pdf)) {
        $x = 100;
        $y = 810;
        $text = "9355 Dixie Road, Brampton, ON L6S 1J7 Tel: 905.799.2947 Fax: 905.790.8262 Email: info@carpediem.ca";
        $font = null;
        $size = 8;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>
<div class="container-fluid">
    <div class="text-center"><img mb-1 mt-0 src="img/carpe_diem_logo.jpg"/></div>
    <h6 class="text-center">INCIDENT REPORT</h3>

    <div class="row  mb-3">
        Name of Child: &nbsp;<b>{{\App\Models\Child::where('id','=',$incident->EditedRevisions->fk_ChildID)->first()->initials}}</b>
    </div>

    <div class="row  mb-3">
        Date of Birth: &nbsp;<b>{{\App\Models\Child::where('id','=',$incident->EditedRevisions->fk_ChildID)->first()->DOB}}</b>
    </div>

    <div class="row  mb-3">
        Date of Placement: &nbsp;<b>{{\App\Models\Child::with('getCMProfile')->where('id','=',$incident->EditedRevisions->fk_ChildID)->first()->getCMProfile->date_admitted_fosterhome ?? 'N/A'}}</b>

    </div>

    <div class="row  mb-3">
        Foster Home: &nbsp;<b>{{\App\Models\Child::where('id','=',$incident->EditedRevisions->fk_ChildID)->first()->getCaseManageAssignedHome->name ?? 'N/A'}}</b>
    </div>

    <div class="row  mb-3">
        Placing Agency: &nbsp;<b>{{\App\Models\Child::where('id','=',$incident->EditedRevisions->fk_ChildID)->first()->getCASAgency->name ??  'N/A'}}</b>
    </div>

    <div class="row  mb-3">
        Legal Guardian's Name: &nbsp;<b>{{$incident->EditedRevisions->legal_guardian_name }}</b>
    </div>

    <div class="row  mb-0">
        <span style="font-size:32px; margin-bottom:0px;"><b>NOTIFY / REPORT WITHIN 24 HOURS / S.O. AS SOON AS POSSIBLE</b></span>
        <br/>
        <span style="font-size:28px; margin-top:0px; position:relative; top:-10px;">*Carpe Diem must submit Serious Occurrence Reports to Ministry within 24 hours</span>
    </div>


    <div class="row  mb-3">

        <table class="" style="width:100%">
            <thead>
            <tr style="line-height: 40px;">
                <th style="width:35%">Check off Type of Incident:</th>
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
                <td><b><span style="font-size:22px;">LEVEL 1 SERIOUS OCCURRENCE (Notify within 1 hour)</span></b></td>
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
                    Other: (Please Specify)
{{--                    <input class="incident_type_other" type="text" id="incident_type_other" value="test"/>--}}
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>

    </div>

    <div class="row mb-3">

            Date of Incident: &nbsp;<b>{{$incident->EditedRevisions->date_of_incident}}</b>

        <span class="float-right" style="margin-right: 30%">
            Time/Duration: &nbsp;<b>{{$incident->EditedRevisions->time_duration}}</b>
        </span>
    </div>

    <div class="row  mb-3">
        Date and Time Report Received: &nbsp;<b>{{$incident->EditedRevisions->datetime_report_received}}</b>
    </div>

    <div class="row  mb-3">
        Location of Incident: <span style="white-space:pre-wrap;">&nbsp;{{$incident->EditedRevisions->location_of_incident}}</span>
    </div>

    <div class="row  mb-3">
        Antecedent leading to the Incident: &nbsp;<span style="white-space:pre-wrap;">{{$incident->EditedRevisions->antecedent_leading_to_incident}}</span>
    </div>

    <div class="row  mb-3">
        Description of Incident (What, When, Where and How): &nbsp;<span style="white-space:pre-wrap;">{{$incident->EditedRevisions->description_of_incident}}</span>
    </div>

    <div class="row  mb-3">
        Action Taken: &nbsp;<span style="white-space:pre-wrap;">{{$incident->EditedRevisions->action_taken}}</span>
    </div>

    <div class="row  mb-3">
        <table class="">
            <thead>
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

    <div class="row  mb-3">
        Physical Injuries (Include specific details of injury and medical intervention): &nbsp;<b>{{$incident->EditedRevisions->physical_injuries}}</b>
    </div>

    <div class="row  mb-3">
        Property Damage (Attach Damage Form): &nbsp;<b>{{$incident->EditedRevisions->property_damage}}</b>
    </div>

    <div class="row  mb-3">
        Comments (Why): &nbsp;<b>{{$incident->EditedRevisions->comments}}</b>
    </div>

    <div class="row  mt-5 mb-3">
        ________________________________________
        <table style="width:100%;border:none;">
            <tr>
                <td style="width:15%;">Completed By:</td>
                <td>{{Auth::user()->name}}</td>
            </tr>
{{--            <tr><td></td>--}}
{{--                <td>{{Auth::user()->get_user_type->name}}</td>--}}
{{--            </tr>--}}
        </table>

    </div>



</div>
</div>
</body>
</html>


<div class="container">

</div>

