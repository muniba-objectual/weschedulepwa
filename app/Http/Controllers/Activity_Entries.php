<?php

namespace App\Http\Controllers;

use App\Models\Activity_Entry;
use Illuminate\Http\Request;

class Activity_Entries extends Controller
{

    public function edit(Request $request)
    {
        if ($request->ajax()) {

            if ($request->type == "AddMessage") {
               $activity_entry = Activity_Entry::create(

                   [

                       'message' => $request->message,
                       'fk_ChildID' => $request->ChildID,
                       'fk_UserID' => $request->UserID


                   ]
               );


                return response()->json(['success' => true, 'message' => 'Created Activity Entry ID: ' . $activity_entry->id]);
            }
        }
    }
}
