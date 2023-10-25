<?php
namespace App\Http\Controllers;
use App\Models\Child;
use App\Models\Edited_Incident_Entry;
use App\Models\Incident_Entry;
use App\Reports\StatHolidayReport;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Reports\MyReport;

class ReportController extends Controller
{
    public function __contruct()
    {
        $this->middleware("guest");
    }
    public function index(Request $request)
    {


    }

    public function NewPayrollReport(Request $request) {
        $fromDate = $request->input('from_date', (new Carbon)->startOfYear());
        $toDate = $request->input('to_date', (new Carbon)->endOfYear());
        $myUser = $request->input('user');
        $cysw = $request->input('cysw',false);
        $child = $request->input('child',false);

        $report = new MyReport(array(
            "from_date"=>$fromDate,
            "to_date"=>$toDate,
            "user"=>$myUser,
            "cysw"=>$cysw,
            "child"=>$child
        ));
        $report->run();
     return view("report",["report"=>$report]);
    }

    public function StatHolidayReport(Request $request) {
        $MonthYear = $request->input('MonthYear', 'January '.(new Carbon)->year);
        $myUser = $request->input('user');

        $report = new StatHolidayReport(array(
            "MonthYear"=>$MonthYear,
            "user"=>$myUser
        ));
        $report->run();
        return view("report",["report"=>$report]);
    }

    public function IR_Report() {

        return view ("IR_Report");
    }

    public function generateReport($IRid) {


//        $incident = Incident_Entry::with('EditedRevisions')->where('id','=',$IRid)->first();
//
//        return view ("generateIR_Report", compact('incident'));
        $incident = Incident_Entry::with('EditedRevisions')->where('id','=',$IRid)->first();
        $pdf = Pdf::loadView('saveIR_Report',compact('incident'));

        return $pdf->stream('test.pdf');
    }

    public function saveReport($IRid) {

        $incident = Incident_Entry::with('EditedRevisions')->where('id','=',$IRid)->first();
        $pdf = Pdf::loadView('saveIR_Report',compact('incident'));

        return $pdf->stream('test.pdf');
    }
}
