<?php

namespace App\Http\Controllers;


use App\Models\Activity_Entry;
use App\Models\Incident_Entry;
use App\Models\Medication_Entry;
use App\Models\Shift;
Use DB;
use View;
use DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class MyShifts extends Controller
{

    public function index()
    {
        $id = Auth::id();
//$shifts - upcoming shifts starting with today's date
        $shifts = Shift::where("fk_UserID", "=", $id)->whereDate("start", ">=", date('Y-m-d'))->where('published_status', '=', 'Published')->paginate(10);
        $pastShifts = Shift::where("fk_UserID", "=", $id)->whereDate("start", "<", date('Y-m-d'))->where('published_status', '=', 'Published')->paginate(10);
        return view("myshifts.index", compact('shifts', 'pastShifts'));

    }

    public function getTodaysShifts(Request $request)
    {

        if ($request->ajax()) {


            // Get the currently authenticated user...
            $user = Auth::user();

// Get the currently authenticated user's ID...
            $id = Auth::id();

            $shifts = Shift::where("fk_UserID", "=", $id)->whereDate("start", "=", date('Y-m-d'))->get();


            //return view ("myshifts.index", compact ('shifts', 'upcomingShifts'));
            //return $shift;

            $returnShifts = DataTables::of($shifts)
                ->editColumn('start', function ($row) {
                    $tmpDate = date_create($row->start);
                    return date_format($tmpDate, 'g:ia');
                })
                ->editColumn('end', function ($row) {
                    $tmpDate = date_create($row->end);
                    return date_format($tmpDate, 'g:ia');
                })
                ->addColumn('relative', function ($row) {
                    return $row->getShiftTimeRelative();
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="/myshifts/' . $row->id . '"  class="edit btn btn-success btn-sm">View Shift</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $returnShifts;

        }
    }

    public function getUpcomingShifts(Request $request)
    {

        if ($request->ajax()) {


            // Get the currently authenticated user...
            $user = Auth::user();

// Get the currently authenticated user's ID...
            $id = Auth::id();


            $upcomingShifts = Shift::where("fk_UserID", "=", $id)->whereDate("start", ">", date('Y-m-d'))->get();
            //return view ("myshifts.index", compact ('shifts', 'upcomingShifts'));
            //return $shift;

            $returnShifts = DataTables::of($upcomingShifts)
                ->editColumn('start', function ($row) {
                    $tmpDate = date_create($row->start);
                    return date_format($tmpDate, 'D M j, Y @g:ia');
                })
                ->editColumn('end', function ($row) {
                    $tmpDate = date_create($row->end);
                    return date_format($tmpDate, 'D M j, Y @g:ia');
                })
                ->addColumn('relative', function ($row) {
                    return $row->getShiftTimeRelative();
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="/myshifts/' . $row->id . '"  class="edit btn btn-success btn-sm">View Shift</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return $returnShifts;

        }
    }

    public function store()
    {

    }


    public function show(Shift $myshift)
    {

        $myshift->load('get_user');
        $myshift->load('get_child');
        $myshift->load('get_shiftform');
        $myshift->load('get_medicationentries');
        $myshift->load('get_incidententries');

       // $myshift_activities = ($myshift->get_child->get_activities()->paginate(5));
        $tmpmyshift_activities_photos = ($myshift->get_child->get_activities_photos()->paginate(5));

        $myshift_activities = Activity::where('subject_type','=','App\Models\Child')->where('subject_id','=', $myshift->get_child->id)->orderBy('updated_at', 'DESC')->paginate(5);
        $myshift_timeline = Activity::where('subject_type','=','App\Models\Child')->where('subject_id','=', $myshift->get_child->id)->orderBy('updated_at', 'DESC')->paginate(5)->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');});

        //$myshift_activities = $tmpmyshift_activities->merge($tmpmyshift_activities_photos);

        //$myshift->load('get_child_related_activities');
//        $medication_entries = Medication_Entry::where('fk_ShiftID','=',$myshift->id);
//        $medication_entries->load('get_shift');

        ///ddd ($myshift);
        //$medication_entries = Medication_Entry::where('fk_ShiftID','=',$myshift->get_shiftform()->id);


        return view('myshifts.show', compact('myshift', 'myshift_activities', 'myshift_timeline'));
    }

public function getShiftCardDetails(Request $request) {
      if ($request->ajax()) {
          $myshift = Shift::find($request->ShiftID);
          return view('myshifts.components.shift_card_details',compact('myshift'));
      }
       // return $request;
}
    public function edit(Request $request)
    {
        if ($request->ajax()) {

            if ($request->type == "StartShift") {
                $date = date('Y-m-d H:i:s');
                $myshift = Shift::find($request->id);
                $myshift->actual_shift_start = $date;
                $myshift->status = "Started";
                $myshift->update();
                return response()->json(['success' => 'Your shift has now started']);
            }

            if ($request->type == "StopShift") {
                $date = date('Y-m-d H:i:s');
                $myshift = Shift::find($request->id);
                $myshift->actual_shift_end = $date;
                $myshift->status = "Ended - Incomplete";
                $myshift->update();
                return response()->json(['success' => 'Your shift has now ended. Please fill out the required Shift Form']);
            }

            if ($request->type == "UpdateShiftForm") {
                $date = date('Y-m-d H:i:s');
                $myshift = Shift::find($request->id);
                $shiftform = $myshift->get_shiftform()->count();
                if ($shiftform <= 0) {
                    //shift form association does not exist
                    //create it
                    $insert = $myshift->get_shiftform()->Create(

                        [

                            'datetime' => $request->datetime,
                            'mood_upon_arrival' => $request->mood_upon_arrival,
                            'interaction_with_staff' => $request->interaction_with_staff,
                            'general_observations' => $request->general_observations,
                            'dietary_notes' => $request->dietary_notes

                        ]);
                    $myshift->Update(['fk_ShiftFormID' => $insert->id]);
                    if ($myshift->status = "Ended - Incomplete") {
                        $myshift->Update(['status' => "Ended - Pending Verification"]);
                    }
                    return response()->json(['success' => true, 'message' => 'Created Shift Form ID: ' . $insert->id]);
                } else {
                    $update = $myshift->get_shiftform()->Update(
                        [
                            'datetime' => $request->datetime,
                            'mood_upon_arrival' => $request->mood_upon_arrival,
                            'interaction_with_staff' => $request->interaction_with_staff,
                            'general_observations' => $request->general_observations,
                            'dietary_notes' => $request->dietary_notes
                        ]);
                    // $myshift->Update(['fk_ShiftFormID' => $update->id]);
                    if ($myshift->status = "Ended - Incomplete") {
                        $myshift->Update(['status' => "Ended - Pending Verification"]);
                    }
                    return response()->json(['success' => true, 'message' => 'Updated Shift Form ID: ' . $myshift->fk_ShiftFormID]);
                }
            }

            if ($request->type == "AddMedicationEntry") {
                $myshift = Shift::find($request->id);
                $insert = $myshift->get_medicationentries()->Create(
                    [
                        'medication_type' => $request->medication_type,
                        'dosage' => $request->dosage,
                        'date_time' => $request->date_time,
                        'compliance' => $request->compliance,
                        'taken_with_food' => $request->taken_with_food,
                        'PRN' => $request->PRN,
                        'photo' => $request->photo,
                        'fk_ShiftID' => $myshift->id
                    ]);
                //          $myshift->Update(['fk_ShiftFormID' => $insert->id]);

                return response()->json(['success' => true, 'message' => 'Created Medication Entry: ' . $insert->id]);
            }

            if ($request->type == "DelMedicationEntry") {
                $myentry = Medication_Entry::find($request->id);
                $myentry->delete();
                return response()->json(['success' => true, 'message' => 'Deleted Medication Entry: ' . $request->id]);
            }

            if ($request->type == "AddIncidentEntry") {

                if (isset($request->who_was_notified)) {
                    $whowasnotified = implode(", ", $request->who_was_notified);
                }
                //$myshift = Shift::find($request->id);
                $insertIncident = Incident_Entry::Create(

                    [
                        'legal_guardian_name' => $request->legal_guardian,
                        'incident_type' => $request->incident_type,
                        'serious_occurence' => $request->serious_occurence,
                        'level1_serious_occurence' => $request->level1_serious_occurence,
                        'date_of_incident' => $request->date_of_incident,

                        'time_duration' => $request->time_duration,
                        'datetime_report_received' => $request->datetime_report_received,
                        'location_of_incident' => $request->location_of_incident,
                        'antecedent_leading_to_incident' => $request->antecedent_leading_to_incident,
                        'description_of_incident' => $request->description_of_incident,
                        'action_taken' => $request->action_taken,
                        'who_was_notified' => $whowasnotified,

                        'physical_injuries' => $request->physical_injuries,
                        'property_damage' => $request->property_damage,
                        'comments' => $request->comments,

                        'fk_ChildID' => $request->fk_ChildID
                    ]);
                //          $myshift->Update(['fk_ShiftFormID' => $insert->id]);

                return response()->json(['success' => true, 'message' => 'Created Incident Entry: ' . $insertIncident->id]);
            }

            if ($request->type == "AddMessage") {
                $myshift = Shift::find($request->id);
                $myuser = \App\Models\User::find($request->UserID);
                $mychild = \App\Models\Child::find($request->ChildID);


                activity('Wall')
                    ->causedBy($myuser)
                    ->performedOn($mychild)
                    ->event("Message")
                    ->log($request->message);


                return response()->json(['success' => true, 'message' => 'Posted to wall']);
            }

            if ($request->type == "AddPhoto") {
                $myuser = \App\Models\User::find($request->UserID);
                $mychild = \App\Models\Child::find($request->ChildID);

                $photos = [];
                foreach ($request->photos as $photo) {
                    $filename = $photo->store('/public/activities_photos');
                    activity('Wall')
                        ->causedBy($myuser)
                        ->performedOn($mychild)
                        ->event("Photo")
                        ->log($filename);
                    $photos[] = $filename;
                }
               // return response()->json(['success' => true, 'message' => 'Uploaded image(s) to wall']);
                return response()->json(array('files' => $photos), 200);

            }

        }
    }
}
