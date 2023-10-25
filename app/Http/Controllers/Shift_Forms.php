<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift_Form;
use View;
use DataTables;

use Illuminate\Support\Facades\Auth;
class Shift_Forms extends Controller
{
    public function getShiftForm(Request $request)
    {
        if ($request->ajax()) {


            // Get the currently authenticated user...
            $user = Auth::user();


            $shiftForm = Shift_Form::where("fk_ShiftID", "=", $request->id)->get();
            return response()->json(['success'=>$shiftForm]);
            //return $shiftForm->toJson();
        }
    }

    public function getShiftFormSRA(Request $request)
    {
        if ($request->id) {


            // Get the currently authenticated user...
            $user = Auth::user();


            $shiftForm = Shift_Form::where("id", "=", $request->id)->get();

            return response()->json(['success'=>$shiftForm]);
            //return $shiftForm->toJson();
        }
    }


    //
}
