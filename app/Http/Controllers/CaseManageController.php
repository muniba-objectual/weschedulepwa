<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Child;
use Spatie\Activitylog\Models\Activity;

use Illuminate\Support\Str;

class CaseManageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $id = $user->id;

//$shifts - upcoming shifts starting with today's date
        $shifts = Shift::where("fk_UserID", "=", $id)->whereDate("start", ">=", date('Y-m-d'))->where('published_status', '=', 'Published')->paginate(10);
        $pastShifts = Shift::where("fk_UserID", "=", $id)->whereDate("start", "<", date('Y-m-d'))->where('published_status', '=', 'Published')->paginate(10);

        $tmpchildren = Shift::where("fk_UserID", "=", $id)->whereDate("start", ">=", date('Y-m-d'))->where('published_status', '=', 'Published')->get();
        $tmpchildren2 = collect($tmpchildren->unique("fk_ChildID"));
        $children = $tmpchildren2;


        $children = array();
//ddd ($tmpchildren2);

        $x = 0;
        foreach ($tmpchildren2 as $tmpShift) {

            //    $myshift_activities = Activity::where('subject_type','=','App\Models\Child')->where('subject_id','=', $child->fk_ChildID)->orderBy('updated_at', 'DESC')->get();

            $children[$x]['id'] = $tmpShift->fk_ChildID;

            $children[$x]['child'] = Child::where("id", $tmpShift->fk_ChildID)->get();
            $children[$x]['activities'] = Activity::where('subject_type', '=', 'App\Models\Child')->where('subject_id', '=', $tmpShift->fk_ChildID)->orderBy('updated_at', 'DESC')->paginate(5);
            $x++;
        }
//ddd ($children);
//return $children;

        $users = User::orderBy('name', 'ASC')->get();
        $children = Child::orderBy('initials', 'ASC')->get();
        return view('casemanage_home', compact('shifts', 'pastShifts', 'user', 'children', 'users'));

    }

    public function showFosterParentDashboard () {
        $users = User::orderBy('name', 'ASC')->get();
        $children = Child::orderBy('initials', 'ASC')->get();
        // dd($children);
        $search     =   '';
        return view ('CaseManage.Dashboard.FosterParentDashboard', compact ('users', 'children','search' ));
    }


    public function showFosterParentDashboard_2_0 () {
        $users = User::orderBy('name', 'ASC')->where('user_type','>=','2.1')->get();
        $children = Child::orderBy('initials', 'ASC')->get();
        return view ('CaseManage.Dashboard.FosterParentDashboard_2_0', compact ('users', 'children' ));
    }
    public function showFosterParentDashboard_2_1 () {
        $users = User::orderBy('name', 'ASC')
            ->where('user_type','=', '2.1')
            ->get();
        $children = Child::orderBy('initials', 'ASC')->get();
        return view ('CaseManage.Dashboard.FosterParentDashboard_2_1', compact ('users', 'children' ));
    }
    public function showFosterParentDashboard_2_2 () {
        $users = User::orderBy('name', 'ASC')
            ->where('user_type','=', '2.2')
            ->get();
        $children = Child::orderBy('initials', 'ASC')->get();
        return view ('CaseManage.Dashboard.FosterParentDashboard_2_2', compact ('users', 'children' ));
    }

    public function showFosterParentDashboard_2_3 () {
        $users = User::orderBy('name', 'ASC')->where('user_type','=','2.3')->get();
        $children = Child::orderBy('initials', 'ASC')->get();
        return view ('CaseManage.Dashboard.FosterParentDashboard_2_3', compact ('users', 'children' ));
    }


    public function showStaffDashboard () {
        $users = User::orderBy('name', 'ASC')->where('user_type','>=','3.0')->where('user_type','<','8.0')->get();
        $search     =   '';
        return view ('CaseManage.Dashboard.Staff.StaffDashboard', compact ('users','search' ));
    }

    public function showChildrenDashboard () {
        $children = Child::orderBy('initials', 'ASC')->where('WeSchedule','=','0')->get();
        $search     =   '';
        return view ('CaseManage.Dashboard.Children.ChildrenDashboard', compact ('children','search' ));
    }

    public function showPlacingAgenciesDashboard () {
//        $users = \App\Models\PlacingAgencyCaseWorker::orderBy('name', 'ASC')->get();
        $placingAgencies = \App\Models\PlacingAgency::orderBy('name','ASC')->get();
        $search     =   '';
        return view ('CaseManage.Dashboard.PlacingAgencies.PlacingAgenciesDashboard', compact ('placingAgencies','search' ));
    }

    public function showPlacingAgencyDashboard ($id) {
        $agency = \App\Models\PlacingAgency::where('id','=',$id)->first();
        $users = \App\Models\PlacingAgencyCaseWorker::where('fk_PlacingAgencyID','=',$id)->orderBy('name', 'ASC')->get();
        $search     =   '';
        return view ('CaseManage.Dashboard.PlacingAgencies.PlacingAgencyDashboard', compact ('users','search', 'agency' ));
    }

    public function showPlacingAgency ($id) {
        $agency = \App\Models\PlacingAgency::where('id','=',$id)->first();
        $users = \App\Models\PlacingAgencyWorkers::where('fk_PlacingAgencyID','=',$id)->orderBy('name', 'ASC')->get();
        $search     =   '';
        return view ('PlacingAgency.show', compact ('agency', 'users', 'search' ));
    }

    public function showFormsDashboard () {
        $search     =   '';
        return view ('CaseManage.Dashboard.Forms.FormsDashboard', compact ('search' ));
    }

}


