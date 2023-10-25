<?php

namespace App\Http\Controllers;

use App\Models\Activity_Entry;
use App\Models\Child;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FosterParentApplicationForm;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Log;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use App\DataTables\UsersDataTableEditor;
use App\DataTables\UsersDataTable;

use DataTables;
use Laravelista\Comments\Commenter;
use Spatie\Activitylog\Models\Activity;


/*
// Get the currently authenticated user...
$user = Auth::user();

// Get the currently authenticated user's ID...
$id = Auth::id();
*/
class Users extends Controller
{


    //
    public function list(){
        $user = Auth::user();
    //return $user;
        return view('home',compact('user'));
    }

    public function edit($id) {
        $user = User::where('id',$id)->firstOrFail();
        return view ('staff_edit', compact ('user'));
    }


    public function MyProfile() {
        $id = auth::user()->id;
        $user = User::where('id',$id)->firstOrFail();
        return view ('users.myprofile', compact ('user'));
    }



    public function MyBudget() {
        return view ('users.mybudget');
    }
    public function MyProfile_edit(Request $request)
    {
        if ($request->type == "update") {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required',
                'password' => 'confirmed'
            ]);

           // return $validated;

            $user = User::find(auth()->user()->id);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->address = $request->address;
            $user->city = $request->city;
            $user->province = $request->province;
            $user->postal = $request->postal;


            if ($validated['password']) {
                $user->password = bcrypt($validated['password']);
            }
            $updateValue = $user->update();



            return view('users.myprofile', compact('user', 'updateValue'));
        }

        if ($request->type == "AddDriversLicense") {

            $photo = $request->drivers_license;
                $filename = $photo->store('/public/drivers_license/');

                $user = User::find(auth()->user()->id);

                $user->drivers_license = $filename;
                $user->update();
            return response()->json(array('files' => $photo), 200);

            }



            //  return response()->json(['success' => true, 'message' => 'Created Activity Photo ID: ' . $activity_photo->id]);
        }

    public function Profile_edit(Request $request)
    {
        if ($request->type == "update") {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required',
                //'password' => 'confirmed'
            ]);

            // return $validated;

            $user = User::find($request->userID);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->address = $request->address;
            $user->city = $request->city;
            $user->province = $request->province;
            $user->postal = $request->postal;


           /* if ($validated['password']) {
                $user->password = bcrypt($validated['password']);
            }
           */
            $updateValue = $user->update();

            return redirect()->back()->with('message', 'User Profile has been updated successfully.');
            //return view('users.myprofile', compact('user', 'updateValue'));
        }

        if ($request->type == "AddDriversLicense") {

            $photo = $request->drivers_license;
            $filename = $photo->store('/public/drivers_license/');

            $user = User::find($request->userID);

            $user->drivers_license = $filename;
            $user->update();
            return response()->json(array('files' => $photo), 200);

        }



        //  return response()->json(['success' => true, 'message' => 'Created Activity Photo ID: ' . $activity_photo->id]);
    }


    public function editModal($id) {
        $user = User::where('id',$id)->firstOrFail();
        return $user;
    }

    public function ajaxRequest()
    {
        return view('staff');
    }

    public function ajaxRequestPost(Request $request)
    {
        $input_id = $request->input('id');

        //error_log("caught ajax request: id: " . $input_id);

        $user = User::where('id',$input_id)->firstOrFail();

        //error_log("got user data: " . $user);

return $user;

        //return response()->json(['success'=>'Got Simple Ajax Request.']);
    }

    public function index(UsersDataTable $dataTable)
    {
        $children = Child::all();

        return $dataTable->render('users.index', compact('children'));
    }

    public function store(UsersDataTableEditor $editor)
    {
        return $editor->process(request());
    }

    public function getAssociatedChildrenFromFosterParentHome(Request $request)
    {


        if ($request->FosterParentHomeID) {
            $tmpChildren = \App\Models\Child::where('FosterHome_fk_UserID', '=', $request->FosterParentHomeID)->get();
            if ($tmpChildren->count() > 0) {
                return $tmpChildren;
            } else {
                return -1;
            }


        }
    }
    public function getTimelineData(Request $request) {

        $array = Activity::query()
            ->where('causer_type','=',User::class)
            ->Where('causer_id','=', $request->input("UserID") )
            ->Where('log_name','!=','Wall')
            ->Where('log_name','!=','default')
            ->orderBy('created_at', 'DESC')
            ->get();

        $array = $array->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('d-M-y');
        });


        //$array->groupBy(function($date) {            return \Carbon\Carbon::parse($date->updated_at)->format('d-M-y');});
        //$array = (array) $tmparray;
        $per_page = 7; //1 day per page

        $data   =   $request->all();

        $current_page = $data['page'] ?? 1;

        //$array = $array->slice(($current_page - 1) * $per_page, $per_page);
        $pagination = new LengthAwarePaginator(
            $array->slice(($current_page - 1) * $per_page, $per_page),
            $array->count(),
            $per_page,
            $current_page,
            [
                //'path' => request()->url(),
                //'query' => request()->query(),
            ]
        );

        $timeline_data = $pagination;

        $UserID = $request->input("UserID");

        return view('users.getTimelineData',compact('timeline_data', 'UserID'));
    }

    public function show(User $user)
    {

        if ($user->user_type >= "2.0" && $user->user_type <= "8.0" ) {

            $timeline_data = Activity::query()
                ->where('subject_type', '=', User::class)
                ->Where('subject_id', '=', $user->id)
                ->Where('log_name', '!=', 'Wall')
                ->tap(function (&$q) {
                    $logNames = request()->get('filter_log_name', []);
                    $toFrom = explode(' - ', request()->get('filter_updated_at', ' - '));

                    if(count($logNames)){
                        $q->whereIn( 'log_name', $logNames );
                    }

                    if( (!empty($toFrom[0])) && (!empty($toFrom[1])) && $toFrom[0] != $toFrom[1] ){
                        $q->whereBetween( 'updated_at', $toFrom );
                    }
                })
                ->orderBy('created_at', 'DESC')
                ->paginate(9999)
                ->groupBy(function ($date) {
                    return \Carbon\Carbon::parse($date->created_at)->format('d-M-y');
                });

            $logNames = Activity::query()
                ->WhereNotIn('log_name', ['Wall', 'default'])
                ->distinct()
                ->pluck('log_name');

            return view ('users.casemanage.show', compact('user', 'timeline_data', 'logNames'))->with(request()->except('_token'));

        } else {
//            $timeline_data = Activity::query()
//                ->where('subject_type', '=', 'App\Models\User')
//                ->Where('subject_id', '=', $user->id)
//                ->Where('log_name', '!=', 'Wall')
//                ->orderBy('created_at', 'DESC')
//                ->paginate(10)
//                ->groupBy(function ($date) {
//                    return \Carbon\Carbon::parse($date->created_at)->format('d-M-y');
//                });
            return view('users.show', compact('user'));
        }
    }

    public function viewFosterParentApplicationForm($userID) {
        $FPAForm = FosterParentApplicationForm::where('fk_UserID','=',$userID)->firstOrCreate();
        return view ('users.casemanage.viewFosterParentApplicationForm', compact('userID', 'FPAForm'));
    }

    public function viewMobileFosterParentApplicationForm($userID) {
        $FPAForm = FosterParentApplicationForm::where('fk_UserID','=',$userID)->firstOrCreate();
        return view ('mobile.CaseManage.FosterParentApplicationForm.index', compact('userID', 'FPAForm'));
    }

    public function updateUserStatus(Request $request,$userId){
        if ($request->ajax()) {
            if(Auth::User()->get_user_type->type == '3.3' || Auth::User()->get_user_type->type == '4.1' || Auth::User()->get_user_type->type == '5.0' || Auth::User()->get_user_type->type == '10.0'){                $data   =   $request->all();
                $tmpUser  = User::find($data['user']);
                if($data['active'] == 'false'){
                    $tmpUser->inactive   = 1;
                }else{
                    $tmpUser->inactive   = 0;
                }
                $userUpdate =   $tmpUser->update();
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

    public function updateUserHoldStatus(Request $request,$userId){
        if ($request->ajax()) {
            if(Auth::User()->get_user_type->type == '3.3' || Auth::User()->get_user_type->type == '4.1' || Auth::User()->get_user_type->type == '5.0' || Auth::User()->get_user_type->type == '10.0'){                $data   =   $request->all();
                $tmpUser  = User::find($data['user']);
//                print_r ($data);
                if($data['OnHold'] == 'false'){
                    $tmpUser->OnHold   = 0;
                }else{
                    $tmpUser->OnHold   = 1;
                }
                $userUpdate =   $tmpUser->update();
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
    public function impersonate(User $user)
    {
        auth()->user()->impersonate($user);

        return redirect()->back();
    }


    public function leaveImpersonate()
    {
        auth()->user()->leaveImpersonation();

        return redirect()->back();
    }

    public function toggleSecondaryLearningForm(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));

        if ($request->input('has_secondary_learning_form') == 'true') { //problem! $request->input('has_secondary_learning_form') gives a string 'true' or a string 'false'
            $user->fosterParentSecondaryLearningForm()->update(['has_secondary_learning_form' => true]);
        } else {
            $user->fosterParentSecondaryLearningForm()->update(['has_secondary_learning_form' => false]);
        }

        return response()->json(['success' => true]);
    }


}
