<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PdfReport;
use App\Models\User;
use App\Models\Shift;
use App\Models\Child;
use Carbon\Carbon;
use Auth;

class DesktopApps extends Controller
{

    public function index() {
        if (Auth::user()->user_type == 1) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::where('user_type','=','1')->get();
        $children = Child::all();
    return view('reports', compact('users','children'));
    }

    public function HomeVisit() {
        return view('CaseManage.Modules.HomeVisitDesktop');
    }


    public function OnCall() {
        return view('CaseManage.Modules.OnCallDesktop');
    }

    public function OnCallCYSW() {
        return view('CaseManage.Modules.OnCallCYSWDesktop');
    }

    public function PreliminaryAssessmentDesktop() {
        return view('CaseManage.Modules.PreliminaryAssessmentDesktop');
    }

}
