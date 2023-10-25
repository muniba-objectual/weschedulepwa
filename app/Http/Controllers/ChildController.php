<?php

namespace App\Http\Controllers;

use App\DataTables\ChildDataTable;
use App\DataTables\ChildDataTableEditor;
use App\DataTables\MedicationDataTable;

use App\Models\Child;
use App\Models\ChildSafetyForm;
use App\Models\Home;
use App\Models\Medication_Entry;
use App\Models\Shift;
use App\Models\Shift_Form;
use App\Models\TempFormData;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;

use Illuminate\Pagination\LengthAwarePaginator;


class ChildController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(ChildDataTable $dataTable)
    {
        $homes = Home::all();
        return $dataTable->render('children.index', compact('homes'));
    }



    public function store(ChildDataTableEditor $editor)
    {
        return $editor->process(request());
    }

    public function getTimelineData(Request $request) {

        $array = Activity::where('subject_type','=','App\Models\Child')->Where('subject_id','=', $request->input("childID") )->Where('log_name','!=','Wall')->orderBy('created_at', 'DESC')->get();

        $array = $array->groupBy(function($date) {            return \Carbon\Carbon::parse($date->created_at)->format('d-M-y');});





        //$array->groupBy(function($date) {            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');});
        //$array = (array) $tmparray;
        $per_page = 7; //1 day per page

        $data   =   $request->all();

        $current_page = $data['page'] ?? 1;

       // $array = $array->slice(($current_page - 1) * $per_page, $per_page);
        $pagination = new LengthAwarePaginator(
            $array->slice(($current_page - 1) * $per_page, $per_page),
            $array->count(),
            $per_page,
            $current_page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        $timeline_data = $pagination;

        $childID = $request->input("childID");
        //dd($array);
        return view('children.getTimelineData',compact('timeline_data', 'childID'));
    }
    public function show(Child $child)
    {

        if ($child->WeSchedule) {

            $activities = Activity::where('subject_type','=','App\Models\Child')->where('subject_id','=', $child->id)->orderBy('created_at', 'DESC')->paginate(10);
            /*$timeline_data = Activity::where('subject_type','=','App\Models\Child')->Where('subject_id','=', $child->id)->Where('log_name','!=','Wall')->orderBy('updated_at', 'DESC')
                ->paginate(10)->groupBy(function($date) {            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');});*/

            //$timeline_data = $this->getTimelineData($child, null);

            $timeline_data_EOD_forms_unique = Activity::where('subject_type','=','App\Models\Child')->Where('subject_id','=', $child->id)->Where('log_name','=','EndOfShiftForm')->orderBy('created_at', 'DESC')->paginate(9999)->groupBy(function($date) {            return \Carbon\Carbon::parse($date->created_at)->format('d-M-y');});

            $SRA_Form_entries = array();

            if ($child->SRA) {

                $tmpSRA_form_entries = Shift::with('get_shiftform', 'get_user')->where('fk_ChildID','=',$child->id)->where('validated','=','1')->orderBy('start','ASC')->get();

                foreach ($tmpSRA_form_entries as $key=>$shift_entry) {
                    // $tmp = Shift_Form::find($shift_entry->fk_ShiftFormID);
                    //  if ($tmp->SRA_enabled) { //shift_form is SRA
                    $SRA_Form_entries[$key] = $shift_entry;
                    $SRA_Form_entries[$key]['shift_form'] = $shift_entry->get_shiftform;
                    //$SRA_Form_entries[$key] = $tmp;
                    $SRA_Form_entries[$key]['user'] = $shift_entry->get_user->name;
                    // }
                }

            }

            //$timeline_data = Activity::where('subject_type','=','App\Models\Child')->where('subject_id','=', $child->id)->where('event','=','IR')->orWhere('event','=','Medication')->orWhere('event','=','EndOfShiftForm')->orWhere('event','=','ShiftSignIn')->orWhere('event','=','ShiftSignOut')->orderBy('updated_at', 'DESC')->paginate(50)->groupBy(function($date) {            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');});
            //$tmpSRA_form_entries = Shift::where('fk_ChildID','=',$child->id)->where('fk_ShiftFormID','!=','')->orderBy('start','ASC')->get();


            $user = User::where('id','=',Auth::id());
            $child = $child::withCount(['getShifts', 'getAssignedUser'])->where('id','=',$child->id)->first();
            //return view('children.show', compact('child', 'activities', 'timeline_data', 'user', 'timeline_data_EOD_forms_unique', 'SRA_Form_entries'));
            return view('children.show', compact('child', 'activities',  'user', 'timeline_data_EOD_forms_unique', 'SRA_Form_entries'));

        } else {
            //Return Case Manage Child Profile
            $activities = Activity::where('subject_type','=','App\Models\Child')->where('subject_id','=', $child->id)->orderBy('created_at', 'DESC')->paginate(10);

            $user = User::where('id','=',Auth::id());

            return view('children.casemanage.show', compact('child', 'activities',  'user'));

        }


    }

    public function getMedication(Request $request, $id) {
        if ($request->ajax()) {

            $data = Medication_Entry::where('fk_ChildID','=',$id)->get();
            return Datatables::of($data)
                /*->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                */

                ->make(true);
        }
    }

    public function updateChildStatus(Request $request, $userId){
        if ($request->ajax()) {
            $data = $request->all();

            $child = Child::query()->find($data['child']);

            if(
                (   //We-Schedule
                    $child->WeSchedule &&
                    (
                        Auth::User()->user_type == '3.3' ||
                        Auth::User()->user_type == '4.1' ||
                        Auth::User()->user_type == '5.0' ||
                        Auth::User()->user_type == '10.0'
                    )
                )
                ||
                (   //CARPE_DIEM
                    Auth::User()->user_type == '10.0'
                )
            ){
                $child->inactive = $data['active'] == 'false'? 1 : 0;
                return (bool) $child->update();
            }else{
                return false;
            }
        }
    }

    public function updateChildProgram(Request $request,$userId){
        if ($request->ajax()) {
            if(Auth::User()->get_user_type->type == '3.3' || Auth::User()->get_user_type->type == '4.1' || Auth::User()->get_user_type->type == '5.0' || Auth::User()->get_user_type->type == '10.0'){                $data   =   $request->all();
                $child  = Child::find($data['child']);
                if($data['program'] == 'SRA'){
                    $child->SRA   = 1;
                    $child->PFA = 0;
                    $child->ISA = 0;
                    $child->CARPE_DIEM = 0;

                }
                if($data['program'] == 'PFA') {
                    $child->SRA = 0;
                    $child->PFA = 1;
                    $child->ISA = 0;
                    $child->CARPE_DIEM = 0;
                }
                if($data['program'] == 'ISA') {
                    $child->SRA = 0;
                    $child->PFA = 0;
                    $child->ISA = 1;
                    $child->CARPE_DIEM = 0;
                }

                if($data['program'] == 'CARPE_DIEM') {
                    $child->SRA = 0;
                    $child->PFA = 0;
                    $child->ISA = 0;
                    $child->CARPE_DIEM = 1;
                }

                if($data['program'] == 'NONE') {
                    $child->SRA = 0;
                    $child->PFA = 0;
                    $child->ISA = 0;
                    $child->CARPE_DIEM = 0;
                }

                    $userUpdate =   $child->update();
                if($userUpdate){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }

    public function addChildProfilePic($id) {
        $child = Child::findorfail($id);


        $child->addMedia(public_path() . "/tmp/tmpProfile.png")
            ->toMediaCollection("Child_Profile");

    }

}
