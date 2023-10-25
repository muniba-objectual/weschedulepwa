<?php

namespace App\Http\Controllers;

use App\DataTables\ShiftLayoutDataTable;
use App\DataTables\ShiftLayoutDataTableEditor;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Home;
use App\Models\User;
use App\Models\Child;
use App\Models\Shift_Layout_Template;
Use DB;
use View;
use Yajra\DataTables\Services\DataTable;


class ShiftLayoutTemplate extends Controller
{
    public function index2() {
        $homes = Home::all();
        $shiftLayout = Shift_Layout_Template::all();

        return view('shiftlayout')->with('homes',$homes);
    }
    public function ajaxRequest()
    {


        return view('shiftlayout');
    }

    public function ajaxRequestPost(Request $request)
    {
        $input_id = $request->input('id');

        //error_log("caught ajax request: id: " . $input_id);

        $shiftLayout = Shift_Layout_Template::where('id',$input_id)->firstOrFail();

        //error_log("got user data: " . $user);


        return $shiftLayout;

        //return response()->json(['success'=>'Got Simple Ajax Request.']);
    }

    function getMondays($year, $month)
    {
        $mondays = array();
        # First weekday in specified month: 1 = monday, 7 = sunday
        $firstDay = date('N', mktime(0, 0, 0, $month, 1, $year));
        /* Add 0 days if monday ... 6 days if tuesday, 1 day if sunday
            to get the first monday in month */
        $addDays = (8 - $firstDay);
        $mondays[] = date('Y-m-d', mktime(0, 0, 0, $month, 1 + $addDays, $year));

        $nextMonth = mktime(0, 0, 0, $month + 1, 1, $year);

        # Just add 7 days per iteration to get the date of the subsequent week
        for ($week = 1, $time = mktime(0, 0, 0, $month, 1 + $addDays + $week * 7, $year);
             $time < $nextMonth;
             ++$week, $time = mktime(0, 0, 0, $month, 1 + $addDays + $week * 7, $year))
        {
            $mondays[] = date('Y-m-d', $time);
        }

        return $mondays;
    }

    function getTuesdays($year, $month)
    {
        $tuesdays = array();
        # First weekday in specified month: 1 = monday, 7 = sunday
        $firstDay = date('N', mktime(0, 0, 0, $month, 2, $year));
        /* Add 0 days if monday ... 6 days if tuesday, 1 day if sunday
            to get the first monday in month */
        $addDays = (8 - $firstDay);
        $tuesdays[] = date('Y-m-d', mktime(0, 0, 0, $month, 2 + $addDays, $year));

        $nextMonth = mktime(0, 0, 0, $month + 1, 2, $year);

        # Just add 7 days per iteration to get the date of the subsequent week
        for ($week = 1, $time = mktime(0, 0, 0, $month, 2 + $addDays + $week * 7, $year);
             $time < $nextMonth;
             ++$week, $time = mktime(0, 0, 0, $month, 2 + $addDays + $week * 7, $year))
        {
            $tuesdays[] = date('Y-m-d', $time);
        }

        return $tuesdays;
    }

    function getWednesdays($year, $month)
    {
        $wednesdays = array();
        # First weekday in specified month: 1 = monday, 7 = sunday
        $firstDay = date('N', mktime(0, 0, 0, $month, 3, $year));
        /* Add 0 days if monday ... 6 days if tuesday, 1 day if sunday
            to get the first monday in month */
        $addDays = (8 - $firstDay);
        $wednesdays[] = date('Y-m-d', mktime(0, 0, 0, $month, 3 + $addDays, $year));

        $nextMonth = mktime(0, 0, 0, $month + 1, 3, $year);

        # Just add 7 days per iteration to get the date of the subsequent week
        for ($week = 1, $time = mktime(0, 0, 0, $month, 3 + $addDays + $week * 7, $year);
             $time < $nextMonth;
             ++$week, $time = mktime(0, 0, 0, $month, 3 + $addDays + $week * 7, $year))
        {
            $wednesdays[] = date('Y-m-d', $time);
        }

        return $wednesdays;
    }

    function getThursdays($year, $month)
    {
        $thursdays = array();
        # First weekday in specified month: 1 = monday, 7 = sunday
        $firstDay = date('N', mktime(0, 0, 0, $month, 4, $year));
        /* Add 0 days if monday ... 6 days if tuesday, 1 day if sunday
            to get the first monday in month */
        $addDays = (8 - $firstDay);
        $thursdays[] = date('Y-m-d', mktime(0, 0, 0, $month, 4 + $addDays, $year));

        $nextMonth = mktime(0, 0, 0, $month + 1, 4, $year);

        # Just add 7 days per iteration to get the date of the subsequent week
        for ($week = 1, $time = mktime(0, 0, 0, $month, 4 + $addDays + $week * 7, $year);
             $time < $nextMonth;
             ++$week, $time = mktime(0, 0, 0, $month, 4 + $addDays + $week * 7, $year))
        {
            $thursdays[] = date('Y-m-d', $time);
        }

        return $thursdays;
    }

    function getFridays($year, $month)
    {
        $fridays = array();
        # First weekday in specified month: 1 = monday, 7 = sunday
        $firstDay = date('N', mktime(0, 0, 0, $month, 5, $year));
        /* Add 0 days if monday ... 6 days if tuesday, 1 day if sunday
            to get the first monday in month */
        $addDays = (8 - $firstDay);
        $fridays[] = date('Y-m-d', mktime(0, 0, 0, $month, 5 + $addDays, $year));

        $nextMonth = mktime(0, 0, 0, $month + 1, 5, $year);

        # Just add 7 days per iteration to get the date of the subsequent week
        for ($week = 1, $time = mktime(0, 0, 0, $month, 5 + $addDays + $week * 7, $year);
             $time < $nextMonth;
             ++$week, $time = mktime(0, 0, 0, $month, 5 + $addDays + $week * 7, $year))
        {
            $fridays[] = date('Y-m-d', $time);
        }

        return $fridays;
    }

    function getSaturdays($year, $month)
    {
        $saturdays = array();
        # First weekday in specified month: 1 = monday, 7 = sunday
        $firstDay = date('N', mktime(0, 0, 0, $month, 6, $year));
        /* Add 0 days if monday ... 6 days if tuesday, 1 day if sunday
            to get the first monday in month */
        $addDays = (8 - $firstDay);
        $saturdays[] = date('Y-m-d', mktime(0, 0, 0, $month, 6 + $addDays, $year));

        $nextMonth = mktime(0, 0, 0, $month + 1, 6, $year);

        # Just add 7 days per iteration to get the date of the subsequent week
        for ($week = 1, $time = mktime(0, 0, 0, $month, 6 + $addDays + $week * 7, $year);
             $time < $nextMonth;
             ++$week, $time = mktime(0, 0, 0, $month, 6 + $addDays + $week * 7, $year))
        {
            $saturdays[] = date('Y-m-d', $time);
        }

        return $saturdays;
    }

    function getSundays($year, $month)
    {
        $sundays = array();
        # First weekday in specified month: 1 = monday, 7 = sunday
        $firstDay = date('N', mktime(0, 0, 0, $month, 7, $year));
        /* Add 0 days if monday ... 6 days if tuesday, 1 day if sunday
            to get the first monday in month */
        $addDays = (8 - $firstDay);
        $sundays[] = date('Y-m-d', mktime(0, 0, 0, $month, 7 + $addDays, $year));

        $nextMonth = mktime(0, 0, 0, $month + 1, 7, $year);

        # Just add 7 days per iteration to get the date of the subsequent week
        for ($week = 1, $time = mktime(0, 0, 0, $month, 7 + $addDays + $week * 7, $year);
             $time < $nextMonth;
             ++$week, $time = mktime(0, 0, 0, $month, 7 + $addDays + $week * 7, $year))
        {
            $sundays[] = date('Y-m-d', $time);
        }

        return $sundays;
    }
    public function generateSchedule() {

       // return $this->getTuesdays('2021',date('m',strtotime('first day of +1 month')));
        //Shift::truncate();
$results = DB::delete('delete from incident_entries'); 
$results = DB::delete('delete from medication_entries');        
$results = DB::delete('delete from shifts');

//ALTER TABLE mytest.instance AUTO_INCREMENT = 1;

        $shiftLayout = Shift_Layout_Template::all();
        foreach ($shiftLayout as $shifts) {
            $tmpDate = array();
//            echo date('Y-m-d', strtotime('next monday'));
            switch ($shifts->day_of_week) {
                case "Monday":
                    //$tmpDate = date('Y-m-d', strtotime('next monday'));
                   $tmpDate = $this->getMondays("2022",date('m',strtotime('first day of +1 month')) ); //get all Mondays of the next month based on today
                    //    $tmpDate = "2021-11-29T";

                    break;
                    case "Tuesday":
                        $tmpDate = $this->getTuesdays("2022",date('m',strtotime('first day of +1 month')) );
                    break;

                case "Wednesday":
                    $tmpDate = $this->getWednesdays("2022",date('m',strtotime('first day of +1 month')) );
                    break;

                case "Thursday":
                    $tmpDate = $this->getThursdays("2022",date('m',strtotime('first day of +1 month')) );
                    break;

                case "Friday":
                    $tmpDate = $this->getFridays("2022",date('m',strtotime('first day of +1 month')) );                    break;

                case "Saturday":
                    $tmpDate = $this->getSaturdays("2022",date('m',strtotime('first day of +1 month')) );                    break;

                case "Sunday":
                    $tmpDate = $this->getSundays("2022",date('m',strtotime('first day of +1 month')) );                    break;
            }
            //    $tmpDate = "2021-11-29T";
            foreach ($tmpDate as $tmpDateCreate) {
                $newShift = Shift::create([
                    'title' => $shifts->get_child->initials,
                    'start' => $tmpDateCreate . "T" . $shifts->start_time,
                    'end' => $tmpDateCreate . "T" . $shifts->end_time,
                    'fk_UserID' => $shifts->fk_UserID,
                    'fk_ChildID' => $shifts->fk_ChildID
                ]);
            }


        }
    return "Schedule Generated Successfully";
    }

    public function index(ShiftLayoutDataTable $dataTable, Request $request)
    {
        if($request->input('staffID')) {
            //$todos = Todo::where('user_id', '=', Auth::id())->get();
            $staff = User::all();

            $staffFilter = User::where('id', '=', $request->input('staffID'))->get();
            $homes = Home::all();
            $children = Child::all();

        } else {

        $staff = User::all();
        $homes = Home::all();
        $children = Child::all();
        $staffFilter = null;

    }

        return $dataTable->render('shiftlayout.index',compact('staff', 'homes', 'children', 'staffFilter', 'request'));


    }

    public function test (Request $request) {
        if ($request->ajax()) {


            $model = Shift_Layout_Template::with('get_user', 'get_child');
            return DataTables::query($model)
                ->addColumn('getUser', function (Shift_Layout_Template $shift) {
                    return $shift->get_user->fullname;;
                })->toJson();
        }
            return view('shiftlayouttest');
        }

    public function show($id, ShiftLayoutDataTable $dataTable)
    {

        $staff = User::all();
        $homes = Home::all();
        $children = Child::all();

        //"showing shift layout record: " . $id;
        $test = Shift_Layout_Template::where('fk_UserID','=',$id);
      //  echo $test->query();

//$test = $dataTable->query(Shift_Layout_Template::where('id', '=', '1'));
//dd ($test->newQuery());

//return $test_return->render('shiftlayout.index');

        $test2 = $dataTable->query('test');
        $test = DataTables::of($test)->toJson();
        return View::make('shiftlayout.show')
        ->with('dataTable', $test)
            ->with('staff', $staff)
            ->with('homes', $homes)
            ->with('children',$children);

        //return $dataTable->render('shiftlayout.index');


        }


    public function store(ShiftLayoutDataTableEditor $editor)
    {
        return $editor->process(request());
    }

}
