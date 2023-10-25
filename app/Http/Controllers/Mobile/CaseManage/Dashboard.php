<?php

namespace App\Http\Controllers\Mobile\CaseManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Home;
use App\Models\Child;
use Auth;

class Dashboard extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index() {

        //return "Updates in progress; Mobile site is down for scheduled maintenance.";

        $user = Auth::user();
        $children = Child::all()->where('WeSchedule','=','0')->sortBy('initials');
        $homes = Home::all()->sortBy('name');
        return view('mobile.CaseManage.index', compact('user', 'homes', 'children'));

    }


    public function HomeVisits(Request $request) {
        $user = Auth::user();
        $homes = Home::all();
        //ray($children->get());
        return view('mobile.CaseManage.HomeVisits.index', compact('user', 'homes'));
    }
    public function HomeVisit(Request $request) {
        $user = Auth::user();
        $homes = Home::all();
        //ray($children->get());
        return view('mobile.CaseManage.HomeVisit.homevisit', compact('user', 'homes'));
    }

    public function HomeVisitPrivacy(Request $request) {
        $user = Auth::user();
        $homes = Home::all();
        //ray($children->get());
        return view('mobile.CaseManage.HomeVisit.homevisitprivacy', compact('user', 'homes'));
    }

    public function HomeVisitSubmission(Request $request) {
        $user = Auth::user();
        $homes = Home::all();
        $children = Child::where('fk_HomeID','=','$request->HomeID');
        //ray($children->get());
        return view('mobile.CaseManage.HomeVisit.submission', compact('user', 'homes'));
    }

    public function OnCall(Request $request) {
        $user = Auth::user();
        $homes = Home::all();
        //ray($children->get());
        return view('mobile.CaseManage.OnCall.oncall', compact('user', 'homes'));
    }

    public function MentorHomeVisit(Request $request) {
        $user = Auth::user();
        $homes = Home::all();
        return view('mobile.CaseManage.MentorHomeVisit.mentor-home-visit', compact('user', 'homes'));
    }

    public function OnCallSubmission(Request $request) {
        $user = Auth::user();
        $homes = Home::all();
        $children = Child::where('fk_HomeID','=','$request->HomeID');
        //ray($children->get());
        return view('mobile.CaseManage.OnCall.submission', compact('user', 'homes'));
    }

    public function OnCallCYSW(Request $request) {
        $user = Auth::user();

        $CYSWs = \App\Models\User::where('user_type','=','1.0')->where('inactive','=','0')->orderBy('name')->get();
        //ray($children->get());
        return view('mobile.CaseManage.OnCallCYSW.oncallCYSW', compact('user', 'CYSWs'));
    }

    public function FosterParentApplicationForm(Request $request) {
        $user = Auth::user();

        return view('mobile.CaseManage.FosterParentApplicationForm.index', compact('user'));
    }

    public function Expenses(Request $request) {
        $user = Auth::user();
        $homes = Home::all();
        //ray($children->get());
//        return view('mobile.CaseManage.Expenses.expenses', compact('user', 'homes'));
        return view('mobile.CaseManage.Expenses.expenses');

    }
}
