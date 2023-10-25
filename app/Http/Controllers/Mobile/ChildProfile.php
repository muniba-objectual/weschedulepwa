<?php

namespace App\Http\Controllers\Mobile;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use App\Http\Controllers\Controller;
use App\Models\Incident_Entry;
use App\Models\Medication_Entry;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Child;
use App\Models\Shift_Form;
use App\Models\Shift;
use Auth;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;
use Livewire\WithPagination;
use Carbon\Carbon;

class ChildProfile extends Controller

{

    use WithPagination;
    public $child;
    public $user;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Child $child) {
        /**
         * @var User $user
         * @var Activity[]|Collection $activities
         * @var Incident_Entry[]|Collection $incidents
         * @var Child $child
         * @var Shift_Form[]|Collection $EOD_forms
         */
       // return "Updates in progress; Mobile site is down for scheduled maintenance.";

        $user = Auth::user();
        $activities = Activity::where('subject_type','=','App\Models\Child')->where('subject_id','=', $child->id)->orderBy('updated_at', 'DESC')->paginate(10,['*'],'AW');
        //$timeline_data = Activity::where('subject_type','=','App\Models\Child')->Where('subject_id','=', $child->id)->orWhere('event','=','IR')->orWhere('event','=','Medication')->orWhere('event','=','EndOfShiftForm')->orWhere('event','=','ShiftSignIn')->orWhere('event','=','ShiftSignOut')->orderBy('updated_at', 'DESC')->paginate(9999);
        $timeline_data = Activity::where('subject_type','=','App\Models\Child')->Where('subject_id','=', $child->id)->Where('log_name','!=','Wall')->orderBy('updated_at', 'DESC')->paginate(10);
        //$incidents = Incident_Entry::where('fk_ChildID','=',$child->id)->orderBy('updated_at', 'DESC')->paginate(5,['*'],'IRs');
        $incidents = Incident_Entry::where('fk_ChildID','=',$child->id)->orderBy('updated_at', 'DESC')->paginate(10,['*'],'IRs');
        //$medication_count = Medication_Entry::where('fk_ChildID','=',$child->id)->get();
        $child = $child::withCount(['get_medicationentries'])->where('id','=',$child->id)->first();

        if (auth()->user()->id == "5") {
            //CASSIE
            $EOD_forms_getShifts = Shift::where('fk_ChildID', '=', $child->id)->where('fk_ShiftFormID', '!=', '')->orderBy('start', 'DESC')->paginate(99999, ['*'], 'EOD');

        } else {
            $EOD_forms_getShifts = Shift::where('fk_ChildID', '=', $child->id)->where('fk_ShiftFormID', '!=', '')->orderBy('start', 'DESC')->paginate(20, ['*'], 'EOD');
        }
        $EOD_forms = collect();
        if ($EOD_forms_getShifts) {
            foreach ($EOD_forms_getShifts as $shift) {
                $EOD_forms->push((Shift_Form::find($shift->fk_ShiftFormID)));
            }
        }

        //list all shifts in the next 24 hours
        $getUpcomingShifts = Shift::with('get_child', 'get_user')->where('fk_ChildID', $child->id)->where('start','>=',Carbon::now())->where('start','<=',Carbon::now()->addDay())->where('published_status', 'Published')->get();
        $getNextShift = null;
        $showOnlyNextShift = false;
        if ($getUpcomingShifts->count() == 0) {
            //no shifts in the next 24 hours, get the next available shift
            $getUpcomingShifts = null;
            $getNextShifts = Shift::with('get_child', 'get_user')->where('fk_ChildID','=',$child->id)->where('start','>=',Carbon::now())->where('published_status','=','Published')->get();
            $showOnlyNextShift = true;
            $getUpcomingShifts = $getNextShifts;
        }

        $shiftIsSignedIn = (bool) $user->getTodaysPublishedShifts()
            ->where([
                'signed_in'     => 1,
                'fk_ChildID'    => $child->id
            ])
            ->first();
        //$shiftIsSignedIn = true; //TODO::ashain remove
        session()->put('expense.child_id', $child->id);

        return view('mobile.childProfile', compact(
            'child', 'user', 'activities',
            'timeline_data', 'incidents', 'EOD_forms', 'getUpcomingShifts',
            'showOnlyNextShift', 'shiftIsSignedIn'
        ));
    }

    public function IR_Entry(Request $request) {
        $user = Auth::user();
        $child = Child::where('id','=',$request->childID)->first();
        $incident = Incident_Entry::where('id','=',$request->id)->first();
        return view ('mobile.IR_Entry', compact('user', 'child', 'incident'));
    }

    public function EOD_Viewer(Request $request) {
        $user = Auth::user();
        $child = Child::where('id','=',$request->childID)->first();
        $shift_form = Shift_Form::where('id','=',$request->id)->first();
        return view ('mobile.EOD_Viewer', compact('user', 'child', 'shift_form'));
    }

    public function MyProfile(Request $request) {
        $user = Auth::user();
        return view ('mobile.MyProfile', compact('user'));
    }

    public function myExpenses(): \Illuminate\Contracts\View\View
    {
        return view('mobile.my-expenses', ['user' => \Auth::user()]);
    }
}
