<?php

use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\Mobile\CaseManage\Dashboard as MobileCMDashboard;
use App\Http\Controllers\Mobile\ChildProfile;
use App\Http\Controllers\Mobile\Dashboard as MobileDashboard;
use App\Http\Controllers\Qb\QbBaseController;
use App\Http\Controllers\Qb\QbItemCategoryController;
use App\Http\Controllers\Qb\QbResourceController;
use App\Http\Controllers\Qb\QbVendorController;
use App\Models\Child;
use App\Models\Home;
use App\Models\Shift_Layout_Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

$CaseManage_appRoutes = function() {

    Route::post('FPAFileUpload', [\App\Http\Controllers\FosterParentApplicationFormFilepondController::class,"store"])->name('FPAFileUpload');

    Route::group(['middleware'=>'auth'], function (){
        Route::get('/', ['uses'=>'App\Http\Controllers\CaseManageController@index'])->name('casemanage_index');
        Route::get('/CaseManage/showFosterParentDashboard', ['uses'=>'App\Http\Controllers\CaseManageController@showFosterParentDashboard'])->name('casemanage_showFosterParentDashboard');
        Route::get('/CaseManage/showFosterParentDashboard_2.0', ['uses'=>'App\Http\Controllers\CaseManageController@showFosterParentDashboard_2_0'])->name('casemanage_showFosterParentDashboard_2_0');
        Route::get('/CaseManage/showFosterParentDashboard_2.1', ['uses'=>'App\Http\Controllers\CaseManageController@showFosterParentDashboard_2_1'])->name('casemanage_showFosterParentDashboard_2_1');
        Route::get('/CaseManage/showFosterParentDashboard_2.2', ['uses'=>'App\Http\Controllers\CaseManageController@showFosterParentDashboard_2_2'])->name('casemanage_showFosterParentDashboard_2_2');
        Route::get('/CaseManage/showFosterParentDashboard_2.3', ['uses'=>'App\Http\Controllers\CaseManageController@showFosterParentDashboard_2_3'])->name('casemanage_showFosterParentDashboard_2_3');


        Route::get('/CaseManage/showStaffDashboard', ['uses'=>'App\Http\Controllers\CaseManageController@showStaffDashboard'])->name('casemanage_showStaffDashboard');
        Route::get('/CaseManage/showChildrenDashboard', ['uses'=>'App\Http\Controllers\CaseManageController@showChildrenDashboard'])->name('casemanage_showChildrenDashboard');
        Route::get('/CaseManage/showPlacingAgenciesDashboard', ['uses'=>'App\Http\Controllers\CaseManageController@showPlacingAgenciesDashboard'])->name('casemanage_showPlacingAgenciesDashboard');
        Route::get('/CaseManage/showPlacingAgencyDashboard/{id}', ['uses'=>'App\Http\Controllers\CaseManageController@showPlacingAgencyDashboard',])->name('casemanage_showPlacingAgencyDashboard');
        Route::get('/CaseManage/showFormsDashboard', ['uses'=>'App\Http\Controllers\CaseManageController@showFormsDashboard'])->name('casemanage_showFormsDashboard');

        Route::get('/placingAgency/{id}', ['uses'=>'App\Http\Controllers\CaseManageController@showPlacingAgency'])->name('casemanage_showPlacingAgency');

        Route::get('CaseManage/users/{id}/viewFosterParentApplicationForm', ['uses'=>'App\Http\Controllers\Users@viewFosterParentApplicationForm'])->name('users_viewFosterParentApplicationForm');

        Route::get('/caseworker/{id}/', ['uses'=>'App\Http\Controllers\PlacingAgencyCaseWorkerController@show'])->name('caseworkers_show');

        Route::get('/{user}/impersonate',['uses'=>'App\Http\Controllers\Users@impersonate'])->name('users.impersonate');
        Route::get('/leave-impersonate', ['uses'=>'App\Http\Controllers\Users@leaveImpersonate'])->name('users.leave-impersonate');

        Route::get('OnCallReport', ['uses'=>'App\Http\Controllers\OnCallReportController@show'])->name('OnCallReport');
        Route::post('updateOnCallSeenStatus', ['uses'=>'App\Http\Controllers\OnCallReportController@updateSeenStatus'])->name('updateOnCallSeenStatus');

        Route::get('OnCallCYSWReport', ['uses'=>'App\Http\Controllers\OnCallCYSWReportController@show'])->name('OnCallCYSWReport');

        Route::get('NewChildReport', ['uses'=>'App\Http\Controllers\NewChildReportController@show'])->name('NewChildReport');
        Route::get('PrivacyNotesReport', ['uses'=>'App\Http\Controllers\PrivacyNotesReportController@show'])->name('PrivacyNotesReport');
        Route::get('SupportNotesReport', ['uses'=>'App\Http\Controllers\SupportNotesReportController@show'])->name('SupportNotesReport');

        Route::get('BankDeposits', ['uses'=>'App\Http\Controllers\BankDepositsController@show'])->name('BankDeposits');


        Route::get('MentorHomeVisitReport', [\App\Http\Controllers\MentorHomeVisitReportController::class, 'show'])->name('MentorHomeVisitReport');
        Route::post('updateMentorHomeVisitSeenStatus', [\App\Http\Controllers\MentorHomeVisitReportController::class, 'updateSeenStatus'])->name('updateMentorHomeVisitSeenStatus');

        Route::get('BankDeposits', ['middleware'=>'auth','uses'=>'App\Http\Controllers\BankDepositsController@show'])->name('BankDeposits');
        Route::post('getBankDepositDetails', ['uses'=>'App\Http\Controllers\BankDepositsDetailsController@getBankDepositDetails'])->name('getBankDepositDetails');
        Route::post('updateBankDepositDetails', ['uses'=>'App\Http\Controllers\BankDepositsDetailsController@updateBankDepositDetails'])->name('updateBankDepositDetails');

        Route::get('Expense/Report', [ExpenseReportController::class, 'show'])->name('expense.report');
        Route::get('Expense/PermissionEscalation', [ExpenseReportController::class, 'show'])->name('expense.permission-escalation');
        //TODO::add access limitatoin after notification dismiss, to avoid misuse
        Route::get('Expense/TemporaryExpenseShow/{expenseId}', [ExpenseReportController::class, 'temporaryExpenseShow'])->name('expense.temporary-expense-show');
        Route::get('Expense/ScrumBoard', [ExpenseReportController::class, 'scrumBoard'])->name('expense.scrum-board');
        Route::get('Expense/MyExpenses', [ExpenseReportController::class, 'myExpenses'])->name('expense.my-expenses');
        Route::get('Expense/CsvReport', [ExpenseReportController::class, 'downloadCsvReport'])->name('expense.csv-report');


        Route::get('TestFormBuilder/{formType}/{formId?}', [FormsController::class, 'GeneralFormBuilder']);
        Route::get('pdfView/{formType}/{formId}', [FormsController::class, 'renderAsPdf']);
        Route::get('testPDF', [FormsController::class, 'testPDF']);

        Route::get('MentorHomeVisitReport', [\App\Http\Controllers\MentorHomeVisitReportController::class, 'show'])->name('MentorHomeVisitReport');
        Route::post('updateMentorHomeVisitSeenStatus', [\App\Http\Controllers\MentorHomeVisitReportController::class, 'updateSeenStatus'])->name('updateMentorHomeVisitSeenStatus');

        Route::get('addChildProfilePic/{id}', [\App\Http\Controllers\ChildController::class, 'addChildProfilePic'])->name('addChildProfilePic');

        //TODO::ashain, remove route after QA
        Route::get('ExpenseReport/seed', ['uses'=>'App\Http\Controllers\ExpenseReportController@seed'])->name('ExpenseReport.seed');

        Route::get('NewChildAdmission', ['uses'=>'App\Http\Controllers\NewChildAdmissionController@show'])->name('NewChildAdmission');
    });


    //Document Viewer
    Route::group(['middleware'=>'checkDocumentTokenExpiration', 'prefix'=>'/documentViewer/{token}'], function (){
        Route::get('/', [FormsController::class, 'documentViewer'])->name('documentViewer');
    });
    Route::get('/document/login/{token?}', [FormsController::class, 'showLoginForm'])->name('document.login');
    Route::post('/document/login', [FormsController::class, 'login'])->name('document.login.submit');


    /*   //Annotations for FPAForm
       Route::get('/annotation/search', 'App\Http\Controllers\CaseManageController@annotationSearch');
       Route::post('/annotation/store', 'App\Http\Controllers\CaseManageController@annotationStore');
       Route::put('/annotation/update/{id}', 'App\Http\Controllers\CaseManageController@annotationUpdate');
       Route::delete('/annotation/delete/{id}', 'App\Http\Controllers\CaseManageController@annotationDelete');
    */

};

if (App::environment('local')) {
    /**
     * Using ngrok to create a `casemanage.local` equivalent domain access (temporary only, for publicly facing API integration testing, in local environment)
     * ex:- ENV:- NGROK_TEMP_DOMAIN="9fc7-198-52-182-202.ngrok-free.app"
     * This only activates in local env and when the `NGROK_TEMP_DOMAIN` is set.
     * Comment out the `NGROK_TEMP_DOMAIN` in teh ENV file, to work in regular local mode
    */
    if( config('app.env') == 'local' && env('NGROK_TEMP_DOMAIN') ){
        Route::group(array('domain' => env('NGROK_TEMP_DOMAIN') ), $CaseManage_appRoutes);
    }else{
        // The environment is local
        Route::group(array('domain' => 'casemanage.local'), $CaseManage_appRoutes);
    }
}

elseif (App::environment('production')) {
    // The environment is production
    Route::group(array('domain' => 'casemanage.ca'), $CaseManage_appRoutes);
}

elseif (App::environment('staging')) {
    // The environment is production
    Route::group(array('domain' => 'staging.casemanage.ca'), $CaseManage_appRoutes);
}

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('notifications/get', [\App\Http\Controllers\NotificationsController::class, 'getNotificationsData'])->name('notifications.get')->middleware('auth');
Route::get('notifications/actionCenter/{type}', [\App\Http\Controllers\NotificationsController::class, 'getActionCenter'])->name('notifications.action-center')->middleware('auth');

//Route::get('list', 'User@list');
//Route::get('/dashboard', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@list']);
Route::get('/dashboard', ['middleware'=>'auth','uses'=>'App\Http\Controllers\HomeController@index']);
Route::get('/', ['middleware'=>'auth','uses'=>'App\Http\Controllers\HomeController@index']);


// -- BEGIN STAFF MANAGEMENT //
Route::get('/staff', ['middleware'=>'auth','uses'=>function() {
    $data = User::all ();
    return view ( 'staff' )->withData ( $data );
}]);

Route::get('getUsers', function (Request $request) {
    if ($request->ajax()) {

        $data = User::latest()->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('User Type',function (User $user) {
                return $user->get_user_type->name;
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                $btn = $btn.'<a href="staff/' . $row->id.'/edit" class="edit btn btn-primary btn-sm">Edit</a>&nbsp;&nbsp;';
                $btn = $btn.'<a href="#" class="edit btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="' . $row->id . '" >Edit Modal</a>&nbsp;&nbsp;';


                $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>&nbsp;&nbsp;';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

})->name('user.index');


Route::get('staff/{id}/edit', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@edit']);
Route::get('staff/{id}/editModal', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@editModal']);

Route::get('ajaxRequest',  ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@ajaxRequest']);
Route::post('ajaxRequest', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@ajaxRequestPost'])->name('ajaxRequest.post');

//Route::get('users', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@index']);

Route::get('users/MyProfile', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@MyProfile']);
Route::post('users_myprofile.edit', 'App\Http\Controllers\Users@MyProfile_edit')->name('users_myprofile.edit');
Route::post('users_profile.edit', 'App\Http\Controllers\Users@Profile_edit')->name('users_profile.edit');

Route::post('users_mycysw-profile.edit', 'App\Http\Controllers\Users@MyCYSWProfile_edit')->name('users_mycysw-profile.edit');


Route::get('users/MyBudgets', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@MyBudget']);
Route::post('user/{id}/updateUserStatus', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@updateUserStatus'])->name('user.updateUserStatus');
Route::post('user/{id}/updateUserHoldStatus', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@updateUserHoldStatus'])->name('user.updateUserHoldStatus');
Route::post('user/{id}/toggleSecondaryLearningForm', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@toggleSecondaryLearningForm'])->name('user.foster-parent.toggleSecondaryLearningForm');


Route::resource('users', 'App\Http\Controllers\Users')->middleware('auth');
Route::get('user_getTimelineData', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@getTimelineData'])->name('user.getTimelineData');
Route::get('user_getAssociatedChildrenFromFosterParentHome', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Users@getAssociatedChildrenFromFosterParentHome'])->name('user.getAssociatedChildrenFromFosterParentHome');
ROute::get('act-test', function (){
    activity('OnCall') //log_name
        ->causedBy(auth()->id()) //causer_id
        ->performedOn(auth()->user()) //subject_id
        ->event("MyEvent")//event
        ->withProperties(['prop1'=>1, 'prop2'=>2])//properties
        ->log('description');//description
});
// -- END STAFF MANAGEMENT //


// -- BEGIN HOME MANAGEMENT //
Route::get('/homes2', ['middleware'=>'auth','uses'=>function() {
    $data = Home::all ();
    return view ( 'homes' )->withData ( $data );
}]);

Route::get('getHomes', function (Request $request) {
    if ($request->ajax()) {

        $data = Home::latest()->get();

        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                $btn = $btn.'<a href="homes/' . $row->id.'/edit" class="edit btn btn-primary btn-sm">Edit</a>&nbsp;&nbsp;';
                $btn = $btn.'<a href="#" class="edit btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="' . $row->id . '" >Edit Modal</a>&nbsp;&nbsp;';


                $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>&nbsp;&nbsp;';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

})->name('homes2.index');

Route::get('homes.all',['middleware'=>'auth','uses'=>'App\Http\Controllers\Homes@listAll'])->name('homes.all');
Route::get('homes/{id}/edit', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Homes@edit']);
Route::get('homes/{id}/editModal', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Homes@editModal']);

Route::get('ajaxRequest',  ['middleware'=>'auth','uses'=>'App\Http\Controllers\Homes@ajaxRequest']);
Route::post('ajaxRequest', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Homes@ajaxRequestPost'])->name('ajaxRequest.post');

Route::resource('homes', 'App\Http\Controllers\Homes');

// -- END HOME MANAGEMENT //


// -- BEGIN CHILD MANAGEMENT //
Route::get('/child', [\App\Http\Controllers\ChildController::class, 'index2']);

Route::get('getChild', function (Request $request) {
    if ($request->ajax()) {

        //$data = Child::latest()->get();
        $data = Child::latest();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('HomeRelationship', function ($row) {
                return $row->get_home->name;

                //$testRelationship = Child::first()->get_home->name;
                //$rel = $testRelationship->first()->get_home->name;
                //$testRelationship ="test";
                //return $testRelationship;
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                $btn = $btn.'<a href="#" class="edit btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="' . $row->id . '" >Edit</a>&nbsp;&nbsp;';


                $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>&nbsp;&nbsp;';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

})->name('child.index');

Route::get('child/{id}/edit', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ChildController@edit']);
Route::get('child/{id}/editModal', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ChildController@editModal']);
Route::get('child/{id}/getMedication', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ChildController@getMedication'])->name('child.getMedication');

Route::post('child/{id}/updateChildStatus', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ChildController@updateChildStatus'])->name('child.updateChildStatus');
Route::post('child/{id}/updateChildProgram', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ChildController@updateChildProgram'])->name('child.updateChildProgram');
Route::get('getTimelineData', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ChildController@getTimelineData'])->name('child.getTimelineData');

Route::get('ajaxRequest',  ['middleware'=>'auth','uses'=>'App\Http\Controllers\ChildController@ajaxRequest']);
Route::post('ajaxRequest', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ChildController@ajaxRequestPost'])->name('ajaxRequest.post');

Route::resource('children', 'App\Http\Controllers\ChildController');
//Route::get('children/showTab/{tab?}', 'App\Http\Controllers\ChildController@showTab')->name('child_tab.showProfile');

Route::resource('ChildNotificationsSchedule', 'App\Http\Controllers\ChildNotificationsScheduleController');

// -- END CHILD MANAGEMENT //

// -- BEGIN SHIFT LAYOUT MANAGEMENT //
Route::get('/shiftlayout2', [\App\Http\Controllers\ShiftLayoutTemplate::class, 'index2']);

Route::get('getShiftLayout', function (Request $request) {
    if ($request->ajax()) {

        //$data = Child::latest()->get();
        $data = Shift_Layout_Template::latest();
        return DataTables::of($data)
            ->addIndexColumn()
            /*->addColumn('HomeRelationship', function ($row) {
                return $row->get_home->name;

                //$testRelationship = Child::first()->get_home->name;
                //$rel = $testRelationship->first()->get_home->name;
                //$testRelationship ="test";
                //return $testRelationship;
            })
            */
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="edit btn btn-info btn-sm">View</a>&nbsp;&nbsp;';
                $btn = $btn.'<a href="#" class="edit btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" data-whatever="' . $row->id . '" >Edit</a>&nbsp;&nbsp;';


                $btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>&nbsp;&nbsp;';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

})->name('shiftlayout2.index');

Route::get('shiftlayout/{id}/edit', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ShiftLayoutTemplate@edit']);
Route::get('shiftlayout/{id}/editModal', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ShiftLayoutTemplate@editModal']);

Route::get('ajaxRequest',  ['middleware'=>'auth','uses'=>'App\Http\Controllers\ShiftLayoutTemplate@ajaxRequest']);
Route::post('ajaxRequest', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ShiftLayoutTemplate@ajaxRequestPost'])->name('ajaxRequest.post');

Route::get('shiftlayouttest', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ShiftLayoutTemplate@test'])->name('shiftlayouttest');;


Route::resource('shiftlayout', 'App\Http\Controllers\ShiftLayoutTemplate');
Route::get('shiftlayout_generateSchedule', 'App\Http\Controllers\ShiftLayoutTemplate@generateSchedule')->name('generateSchedule');
// -- END SHIFT LAYOUT MANAGEMENT //

// -- BEGIN CALENDAR //
Route::get('calendar', ['middleware'=>'auth','uses'=>'App\Http\Controllers\CalendarController@index']);
Route::get('calendar/getRecords', ['middleware'=>'auth','uses'=>'App\Http\Controllers\CalendarController@getRecords']);

Route::post('calendarAjax', ['middleware'=>'auth','uses'=>'App\Http\Controllers\CalendarController@ajax']);

Route::get('newcal', function() {
    return view ('newcalendar');
});
Route::get('calendar/getStaff', ['middleware'=>'auth','uses'=>'App\Http\Controllers\CalendarController@getStaff']);
Route::get('calendar/getShifts', ['middleware'=>'auth','uses'=>'App\Http\Controllers\CalendarController@getShifts']);

Route::get('calendar/getCYSWbyChildID', ['middleware'=>'auth','uses'=>'App\Http\Controllers\CalendarController@getCYSWbyChildID']);

Route::get('ajax/getChildren', ['middleware'=>'auth','uses'=>'App\Http\Controllers\AjaxController@getChildren']);

// -- END CALENDAR //

// -- BEGIN SHIFT //
Route::resource('shifts', 'App\Http\Controllers\Shifts');
// -- END SHIFT  //

Route::resource('myshifts', 'App\Http\Controllers\MyShifts');
Route::get('myshifts.getShiftCardDetails', 'App\Http\Controllers\MyShifts@getShiftCardDetails')->name('myshifts.getShiftCardDetails');

Route::get('myshifts.getTodaysShifts', 'App\Http\Controllers\MyShifts@getTodaysShifts')->name('myshifts.getTodaysShifts');
Route::get('myshifts.getUpcomingShifts', 'App\Http\Controllers\MyShifts@getUpcomingShifts')->name('myshifts.getUpcomingShifts');

// -- BEGIN SHIFT ENTRIES //
Route::resource('shift_entries', 'App\Http\Controllers\Shift_Entries_Controller');

// -- END SHIFT ENTRIES //

// -- BEGIN MYSHIFTS //
Route::resource('myshifts', 'App\Http\Controllers\MyShifts');
Route::post('myshifts.edit', 'App\Http\Controllers\MyShifts@edit')->name('myshifts.edit');

// -- END MYSHIFTS //

// -- BEGIN SHIFT_FORMS //
Route::resource('shift_forms', 'App\Http\Controllers\Shift_Forms');
Route::get('shift_forms.getShiftForm', 'App\Http\Controllers\Shift_Forms@getShiftForm')->name('getShiftForm');
Route::get('getShiftFormSRA', 'App\Http\Controllers\Shift_Forms@getShiftFormSRA')->name('getShiftFormSRA');
// -- END SHIFT_FORMS //

// -- BEGIN ACTIVITY MESSAGES //
Route::resource('activity', 'App\Http\Controllers\Activity_Entries');
Route::post('activity.edit', 'App\Http\Controllers\Activity_Entries@edit')->name('activity.edit');
// -- END ACTIVITY MESSAGES //

// -- BEGIN IMAGE UPLOAD //

Route::get('image-upload', [ ImageUploadController::class, 'imageUpload' ])->name('image.upload');
Route::post('image-upload', [ ImageUploadController::class, 'imageUploadPost' ])->name('image.upload.post');
// -- END IMAGE UPLOAD //

// -- BEGIN ACTIVITY PHOTO MESSAGES //
Route::resource('activity_photos', 'App\Http\Controllers\Activity_Photos');
Route::post('activity_photos.edit', 'App\Http\Controllers\Activity_Photos@edit')->name('activity_photos.edit');
// -- END ACTIVITY PHOTO MESSAGES //

//  -- REPORTS //
Route::get('/reports', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Reports@index']);
Route::get('/reports/PayrollReport', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Reports@PayrollReport']);
Route::get('/reports/PayrollReportbyCYSW', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Reports@PayrollReportbyCYSW']);
Route::get('/reports/PayrollReportbyChild', ['middleware'=>'auth','uses'=>'App\Http\Controllers\Reports@PayrollReportbyChild']);


//  --*REPORTS

//  -- Desktop Apps //
Route::get('/DesktopApps/HomeVisit', ['middleware'=>'auth','uses'=>'App\Http\Controllers\DesktopApps@HomeVisit'])->name('HomeVisitDesktop');
Route::get('/DesktopApps/OnCall', ['middleware'=>'auth','uses'=>'App\Http\Controllers\DesktopApps@OnCall'])->name('OnCallDesktop');
Route::get('/DesktopApps/OnCallCYSW', ['middleware'=>'auth','uses'=>'App\Http\Controllers\DesktopApps@OnCallCYSW'])->name('OnCallCYSWDesktop');
Route::get('/DesktopApps/AdmissionPreliminaryAssessment', ['middleware'=>'auth','uses'=>'App\Http\Controllers\DesktopApps@PreliminaryAssessmentDesktop'])->name('PreliminaryAssessmentDesktop');

//  --*Desktop Apps

Route::view('/powergrid', 'powergrid-demo');
Auth::routes();



/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/


Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');


Route::post('mobile_myprofile.edit', 'App\Http\Controllers\Mobile\MyProfile@mobile_myprofile_edit')->name('mobile_myprofile.edit');
Route::post('mobile_cysw_profile.edit', 'App\Http\Controllers\Mobile\MyProfile@mobile_cysw_profile')->name('mobile_cysw_profile.edit');

Route::post('mobileCM_myprofile.edit', 'App\Http\Controllers\Mobile\CaseManage\MyProfile@mobile_myprofile_edit')->name('mobileCM_myprofile.edit');

Route::get('mobileCM', [MobileCMDashboard::class, 'index']);
Route::get('mobileCM/MyProfile/{id}', [\App\Http\Controllers\Mobile\CaseManage\MyProfile::class, 'show']);

Route::get('child/IR_Entry', [ChildProfile::class, 'IR_Entry']);
Route::get('mobile/child/EOD_Viewer', [ChildProfile::class, 'EOD_Viewer']);


Route::group(['prefix'=>'mobile', 'as' => 'mobile.'], function (){

    Route::get('/', [MobileDashboard::class, 'index'])->name('dashboard.index');
    Route::get('expenses', [ChildProfile::class, 'myExpenses'])->name('expenses.index'); //TODO::ashain, move to a separate resource controller
    Route::resource('MyProfile', \App\Http\Controllers\Mobile\MyProfile::class)->only(['edit', 'show']);

    Route::resource("child", ChildProfile::class)->only('show');
    Route::get('child/IR_Entry', [ChildProfile::class, 'IR_Entry']);
    Route::get('child/EOD_Viewer', [ChildProfile::class, 'EOD_Viewer']);


    Route::group(['prefix'=>'CaseManage', 'as' => 'case-manage.'], function (){

        Route::get('HomeVisits', [MobileCMDashboard::class, 'HomeVisits']);

        Route::get('HomeVisit', [MobileCMDashboard::class, 'HomeVisit']);
        Route::get('HomeVisitSubmission', [MobileCMDashboard::class, 'HomeVisitSubmission']);

        Route::get('HomeVisitPrivacy', [MobileCMDashboard::class, 'HomeVisitPrivacy']);

        Route::get('OnCall', [MobileCMDashboard::class, 'OnCall']);
        Route::get('OnCallCYSW', [MobileCMDashboard::class, 'OnCallCYSW']);

        Route::get('MentorHomeVisit', [MobileCMDashboard::class, 'MentorHomeVisit']);

        Route::get('Expenses', [MobileCMDashboard::class, 'Expenses']);
        Route::get('ExpensesTest', function() {return View::make("livewire.forms.ExpensesTest");})
            ->middleware('auth')->name('expenses.index');

        Route::get('FosterParentApplicationForm', [MobileCMDashboard::class, 'FosterParentApplicationForm']);
    });

});

Route::post('ExpensesFileUpload', [\App\Http\Controllers\ExpensesFilepondController::class,"store"])->name('ExpensesFileUpload');

Route::get('/mobilelogout', 'App\Http\Controllers\Mobile\Logout@logout')->name('mobilelogout');


Route::get('/report', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ReportController@NewPayrollReport'])->name('report');
Route::get('/StatHolidayReport', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ReportController@StatHolidayReport'])->name('StatHolidayReport');
Route::get('/reports/IR_Report', ['middleware'=>'auth','uses'=>'App\Http\Controllers\ReportController@IR_Report']);
Route::get('/reports/IR_Report/{IRid}', \App\Http\Livewire\ViewIR::class)->middleware('auth');

Route::get('/reports/IR_Report/{IRid}/generateReport',['middleware'=>'auth','uses'=>'App\Http\Controllers\ReportController@generateReport'])->name('generateIR_Report');
Route::get('/reports/IR_Report/{IRid}/saveReport',['middleware'=>'auth','uses'=>'App\Http\Controllers\ReportController@saveReport'])->name('saveReport');
Route::View('/reports/child/ReferralReport', 'CaseManage.Modules.ChildReferralReport')->middleware('auth');
Route::get('/MakeFromHTML',  ['middleware'=>'auth','uses'=>'App\Http\Controllers\MakePDF@MakeFromHTML'])->name('MakeFromHTML');

Route::post('AddMedicationProfile',['middleware'=>'auth','uses'=>'App\Http\Controllers\MedicationProfileController@AddMedicationProfile'])->name('AddMedicationProfile');
Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(DropzoneController::class)->group(function(){
    Route::get('dropzone', 'index');
    Route::post('dropzone/store', 'store')->name('dropzone.store');
});

Route::get('/encrypt', ['middleware'=>'auth','uses'=>'App\Http\Controllers\HomeController@encrypt'])->name('encrypt');
Route::get('/fire', function () {
//    \App\Events\IR_Field_Update_Status::dispatch();

    event(new \App\Events\IR_Field_Update_Status(Auth::user()));
    return 'Event has been sent!';
});

Route::get('/listen', function () {
    return view('listen');
});

//SPATIE MEDIA LIBRARY
Route::mediaLibrary();

Route::get('/manifest.json', function() {

    return response()->json([
        'name' => 'We-Schedule.ca',
        'short_name' => 'We-Schedule.ca',
        'start_url' => '/',
        'display' => 'standalone',
        'theme_color' => '#000000',
        'background_color' => '#000000',
        'orientation' => 'portrait'
    ]);
})->name('manifest');


//route base file browsing, for secured file rendering.
Route::get('storage/{filename}', function ($filename)
{
    //TODO::ashian, add a changing key to validate against auth session, b4 returning file.
    $path = storage_path('app/public/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->where('filename', '.*');


Route::group(['prefix'=>'qb', 'as' => 'qb.', 'middleware' => 'auth'], function (){
    //QB connection
    Route::get('/callback', [QbBaseController::class, 'callback']);
    Route::get('/authorize', [QbBaseController::class, 'authorizeQbConnection'])->name('authorize');

    //EULA and Privacy Policy
    Route::get('/eula', [QbBaseController::class, 'eula']);
    Route::get('/privacy', [QbBaseController::class, 'privacy']);

    //Payment Management
    Route::get('/purchase/{expenseId}', [QbResourceController::class, 'purchase'])->name('purchase');


    Route::get('/dashboard', [QbResourceController::class, 'dashboard'])->name('dashboard');

    //manage vendor accounts
    Route::group(['prefix'=>'vendors-accounts', 'as' => 'vendors-accounts.'], function (){
        Route::get('/', [QbVendorController::class, 'index'])->name('index');
        Route::get('/duplicates', [QbVendorController::class, 'listDuplicates'])->name('duplicates');
        Route::view('/mapped-billed-description',  'qb.vendors-accounts.mapped-billed-descriptions')->name('mapped-billed-description');
        Route::get('/sync', [QbVendorController::class, 'sync'])->name('sync');
    });

    //manage item-categories
    Route::group(['prefix'=>'item-categories', 'as' => 'item-categories.'], function (){
        Route::get('/', [QbItemCategoryController::class, 'index'])->name('index');
        Route::view('/mapped-vendor-names',  'qb.item-categories.mapped-vendor-names')->name('mapped-vendor-names');
        Route::get('/sync', [QbItemCategoryController::class, 'sync'])->name('sync');
    });

    Route::view('other-settings', 'qb.other-resource-settings.index')->name('other-settings');

    //testing
    Route::group(['prefix'=>'test', 'as' => 'test.'], function (){
        Route::get('companyInfo', [QbBaseController::class, 'getCompanyInfo'])->name('companyInfo');
        Route::get('vendors', [QbResourceController::class, 'loadVendors'])->name('vendors');
        Route::get('accounts', [QbResourceController::class, 'loadAccounts'])->name('accounts');
        Route::get('customers', [QbResourceController::class, 'loadCustomers'])->name('customers');
//        Route::get('test/{expense}', [QbResourceController::class, 'purchase'])->name('test');
    });
});
