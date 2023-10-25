<?php

namespace App\Http\Controllers;

use App\Models\MentorHomeVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorHomeVisitReportController extends Controller
{
    public function updateSeenStatus(Request $request) {
        if ($request->MentorHomeVisitID) {

            $mentorHomeVisit = MentorHomeVisit::with('users')->where('id','=',$request->MentorHomeVisitID)->first();
            if ($mentorHomeVisit) {
                if (count($mentorHomeVisit->users) >0) {
                    foreach ($mentorHomeVisit->users as $user) {
                        if (!$user->id == Auth::user()->id) {
                            $mentorHomeVisit->users()->detach(Auth::user()->id);
                            $mentorHomeVisit->users()->attach(Auth::user())->id;
                        }
                    }
                } else {
                    $mentorHomeVisit->users()->attach(Auth::user()->id);

                }
            }
            return ($request->data);
        }
    }


    public function show() {
        return view('CaseManage.Modules.MentorHomeVisit');
    }
}
