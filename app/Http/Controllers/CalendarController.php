<?php

namespace App\Http\Controllers;

use App\Models\Shift_Form;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\User;
use App\Models\Child;


class CalendarController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
        $staff = User::query()
            ->where(function($subQuery){
                /**
                 * Using nest where logic to avoid `orWhere()` condition
                 *  conflicting with future additional `where()` logic chaining.
                */
                $subQuery
                    ->where("user_type", 1)
                    ->orWhere('id', config('app.place_holder_user_id'));
            })
            ->orderBy('name')
            ->get();
        $children = Child::with('getAssignedUser')
            ->where('WeSchedule','=','1')
            ->where('inactive','=','0')
            ->orderBy('initials')
            ->get();
        $shifts = Shift::all();
        $shift_titles_unique = Shift::select('title')->groupBy('title')->get();


        if($request->ajax()) {

            /*$data = Shift::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);*/


         //   $data = Shift::all()->get(['id', 'title', 'start', 'end']);

//           return response()->json($data);

        }



        return view('calendar', compact('staff', 'children', 'shifts', 'shift_titles_unique'));
    }

    public function index2(Request $request)
    {
        $staff = User::where("user_type","=","1")->get();
        $children = Child::all();
        $shifts = Shift::all();
        $shift_titles_unique = Shift::select('title')->groupBy('title')->get();


        if($request->ajax()) {

            /*$data = Shift::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);*/


            //   $data = Shift::all()->get(['id', 'title', 'start', 'end']);

//           return response()->json($data);

        }



        return view('calendar2', compact('staff', 'children', 'shifts', 'shift_titles_unique'));
    }

    public function getStaff() {
        $staff = User::where("user_type","=","1")->get();
        return response()->json($staff);
    }

    public function getShifts() {
        $data = Shift::all();
        return response()->json($data);
    }
    public function getRecords(Request $request)
    {

        if ($request->id) {
            $request->id = $request->id =="-1" ? config('app.place_holder_user_id'):$request->id;
            $data = Shift::where('fk_UserID', '=', $request->id)
                ->get(['id', 'title', 'start', 'end', 'actual_shift_start', 'actual_shift_end', 'fk_UserID', 'fk_ChildID', 'published_status', 'signed_in', 'validated', 'exception_pastEventModified', 'status']);
        }

        if (!$request->id || $request->id == "All_Staff") {




            $data = Shift::whereDate('end', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'title', 'start', 'end', 'actual_shift_start', 'actual_shift_end', 'fk_UserID', 'fk_ChildID', 'published_status', 'signed_in', 'validated', 'exception_pastEventModified',  'status']);
        }


        /* Look into filter only by children
        if (!$request->id && $request->childrenFilter)  {
            $data = Shift::whereIn('fk_ChildID', $request->childrenFilter)
                ->get(['id', 'title', 'start', 'end', 'actual_shift_start', 'actual_shift_end', 'fk_UserID', 'fk_ChildID', 'published_status', 'signed_in', 'validated', 'exception_pastEventModified', 'status']);
        }

        if ($request->id && $request->childrenFilter)  {
            $data = Shift::where('fk_UserID', '=', $request->id)
                ->whereIn('fk_ChildID', $request->childrenFilter)
                ->get(['id', 'title', 'start', 'end', 'actual_shift_start', 'actual_shift_end', 'fk_UserID', 'fk_ChildID', 'published_status', 'signed_in', 'validated', 'exception_pastEventModified', 'status']);
        }
*/
        else {
                $data = Shift::whereDate('end', '>=', $request->start)
                    ->whereDate('end',   '<=', $request->end)
                    ->where('fk_UserID', '=', $request->id)
                    ->get(['id', 'title', 'start', 'end', 'actual_shift_start', 'actual_shift_end', 'fk_UserID', 'fk_ChildID', 'published_status',  'signed_in', 'validated', 'exception_pastEventModified', 'status']);
        }

                return response()->json($data);





    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request)
    {
        $SD = date_create($request->start);
        $ED = date_create($request->end);


        switch ($request->type) {
            case 'add':

                $child = Child::find($request->fk_ChildID);

                $shift = Shift::create([
                    'title' => $child->initials,
                    'start' => date_format($SD, "Y-m-d H:i:s"),
                    'end' => date_format($ED, "Y-m-d H:i:s"),
                    'published_status' => $request->published_status,
                    'fk_UserID' => $request->fk_UserID,
                    'fk_ChildID' => $child->id,
                    'exception_pastEventModified' => $request->exception_pastEventModified,
                    'exceptionReason' => $request->exceptionReason,

                ]);

                return response()->json($shift);
                break;

            case 'update':


                $child = Child::find($request->fk_ChildID);
                $validated = false;
                if ($request->validated == "True" || $request->validated == "true" || $request->validated == "1") {
                    $validated = true;
                }
                $shift = Shift::find($request->id)->update([
                    'title' => $child->initials,
                    'start' => date_format($SD, "Y-m-d H:i:s"),
                    'end' => date_format($ED, "Y-m-d H:i:s"),
                    'published_status' => $request->published_status,
                    'validated' => $validated,
                    'fk_UserID' => $request->fk_UserID,
                    'fk_ChildID' => $child->id,
                    'exception_pastEventModified' => $request->exception_pastEventModified,
                    'exceptionReason' => $request->exceptionReason,

                ]);

                return response()->json($shift);
                break;

            case 'delete':
                $shift = Shift::find($request->id)->delete();

                return response()->json($shift);
                break;

            case 'forceSignOut':

                $shift = Shift::find($request->id);
                if ($shift->fk_ShiftFormID) {
                    $shift->update([
                        'status' => 'Ended - Pending Verification',
                        'signed_in' => false
                    ]);
                } else {
                    $shift->update([

                        'status' => 'Ended - Incomplete',
                        'signed_in' => false
                    ]);
                }


                return response()->json($shift);
                break;

            case "viewEDR":
                $shiftForm = "";
                $shift = Shift::where('id','=',$request->id)->first();
                if ($shift) {
                    $shiftFormID = $shift->fk_ShiftFormID;
                }

                if ($shiftFormID) {
                    $shiftForm = Shift_Form::where('id','=',$shiftFormID)->first();
                }
                if ($shiftForm) {
                    return response()->json($shiftForm);
                } else {
                    return response()->json([
                        'error' => [
                            'message' => "Error Retrieving End of Shift Form",
                            'code'    => 500
                        ]
                    ], 500);                }
                break;

            case "viewExceptionReason":
                $shift = Shift::where('id','=',$request->id)->first();
                if ($shift) {
                    return response()->json($shift);
                } else {
                    return response()->json([
                        'error' => [
                            'message' => "Error Retrieving End of Shift Form",
                            'code'    => 500
                        ]
                    ], 500);                }
                break;


            default:
                # code...
                break;
        }
    }

    public function getCYSWbyChildID(Request $request) {
        $child = Child::findOrFail($request->childID);
        if ($child) {
            return $child->getAssignedUser->toJson();
        }
    }
}
