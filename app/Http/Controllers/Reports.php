<?php

namespace App\Http\Controllers;

use App\Models\UserChildrenHistory;
use Illuminate\Http\Request;
use PdfReport;
use App\Models\User;
use App\Models\Shift;
use App\Models\Child;
use Carbon\Carbon;
use Auth;

class Reports extends Controller
{
   public $children;
   public $users;

    public function index() {
        if (Auth::user()->user_type == 1) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::where('user_type','=','1')->get();
        $children = Child::all();
    return view('reports', compact('users','children'));
    }

    public function PayrollReport(Request $request)
    {

        if (Auth::user()->user_type == 1) {
            abort(403, 'Unauthorized action.');

        }

        $salaryHistory = UserChildrenHistory::GetAllSalariesWithHistory(true);

        $fromDate = $request->input('from_date', (new Carbon)->startOfYear());
        $toDate = $request->input('to_date', (new Carbon)->endOfYear());
        $sortBy = $request->input('sort_by', 'asc');

        $title = 'We-Schedule.ca - Payroll Report'; // Report title

        $meta = [ // For displaying filters description on header
            'Pay Period' => $fromDate . ' To ' . $toDate,
            //'Sort By' => $sortBy
        ];

        //$queryBuilder = User::select(['name', 'user_type', 'created_at']) // Do some querying..
        $queryBuilder = Shift::select(['id', 'title', 'fk_UserID', 'fk_ChildID', 'start', 'end', 'actual_shift_start', 'actual_shift_end', 'validated', 'status'])
        //->whereBetween('created_at', [$fromDate, $toDate]);
            ->where('validated','=','1')
            ->where('start','>=',$fromDate)
            ->where('end','<=',$toDate)
            ->orderBy('title', $sortBy)
            ->orderBy('start', $sortBy);


        $columns = [ // Set Column to be displayed
            'Child' => function($shift) {
                $child = Child::find($shift->fk_ChildID)->firstOrFail();
                return $child->initials;
            },
            'CYSW' => function($shift) {
                $user = User::where('id','=',$shift->fk_UserID)->firstOrFail();
                return $user->name;
            },
            'Salary' => function($shift) use ($salaryHistory) {
                $user = User::where('id','=',$shift->fk_UserID)->firstOrFail();
                $child = Child::where('id','=',$shift->fk_ChildID)->firstOrFail();
                if ($child->getAssignedUser->contains($user)) {
                    return "$" .
                        UserChildrenHistory::getSalaryForShift(
                            $user->id,
                            $child->id,
                            $shift->start,
                            $shift->end,
                            $salaryHistory
                        )
                        ;
                }
                    else {
                        return "$" . 0.00;
                    }
            },
            'Start Date' => 'start',
            'End Date' => 'end',
            'TS Hours' => function($shift) {
                $SD = Carbon::parse($shift->start);
                $ED = Carbon::parse($shift->end);

            return $SD->diffInHours($ED);
            },
            'Actual Start Date' => 'actual_shift_start',
            'Actual End Date' => 'actual_shift_end',
            'TA Hours' => function($shift) {
                $SD = Carbon::parse($shift->actual_shift_start);
                $ED = Carbon::parse($shift->actual_shift_end);

                return $SD->diffInHours($ED);
            },
            'Total Wages' => function($shift) use ($salaryHistory) {

                //get TA Hours
                $SD = Carbon::parse($shift->actual_shift_start);
                $ED = Carbon::parse($shift->actual_shift_end);
                $TA_Hours = $SD->diffInHours($ED);

                $user = User::where('id','=',$shift->fk_UserID)->firstOrFail();
                $child = Child::where('id','=',$shift->fk_ChildID)->firstOrFail();
                if ($child->getAssignedUser->contains($user)) {
                    return ($TA_Hours *
                        UserChildrenHistory::getSalaryForShift(
                            $user->id,
                            $child->id,
                            $shift->start,
                            $shift->end,
                            $salaryHistory
                        )
                    );
                }
                else {
                    return 0.00;
                }
            }
            //'Created At' => 'created_at', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result

            //'Status' => function($result) { // You can do if statement or any action do you want inside this closure
            //    return ($result->balance > 100000) ? 'Rich Man' : 'Normal Guy';
            //}
        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($title, $meta, $queryBuilder, $columns)

         /*
            ->editColumn('Created At', [ // Change column class or manipulate its data for displaying to report
                'displayAs' => function($result) {
                    return $result->created_at->format('d M Y');
                },
                'class' => 'left'
            ])
         */

            ->editColumns(['CYSW'], [ // Mass edit column
                'class' => 'blue center'
            ])
            ->editColumns(['Child'], [ // Mass edit column
                'class' => 'green center'
            ])
            ->editColumns(['TS Hours', 'TA Hours' , 'Total Wages'], [ // Mass edit column
                'class' => 'center'
            ])
            ->editColumns(['Total Wages'], [ // Mass edit column
                'class' => 'red center'
            ])
            ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                'TA Hours' => 'point', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                'TS Hours' => 'point', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                'Total Wages' => '$', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->groupBy('CYSW')
            //->limit(20) // Limit record to be showed
            ->showNumColumn(false) // Hide number column
            ->setOrientation('landscape')
            ->setCss([
                '.bolder' => 'font-weight: 800;',
                '.red' => 'color: red;',
                '.blue' => 'color: blue;',
                '.green' => 'color: green;',
                '.center' => 'text-align: center;'
            ])
            ->make()

            ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    }

    public function PayrollReportbyCYSW(Request $request)
    {

        if (Auth::user()->user_type == 1) {
            abort(403, 'Unauthorized action.');

        }

        $salaryHistory = UserChildrenHistory::GetAllSalariesWithHistory(true);

        $fromDate = $request->input('from_date', (new Carbon)->startOfYear());
        $toDate = $request->input('to_date', (new Carbon)->endOfYear());
        $CYSW = $request->input('CYSW', '');
        $sortBy = $request->input('sort_by', 'asc');

        $title = 'We-Schedule.ca - Payroll Report by CYSW'; // Report title

        $user = User::where('id','=',$CYSW)->firstOrFail();
        $meta = [ // For displaying filters description on header
            'Pay Period' => $fromDate . ' To ' . $toDate,
            'CYSW' => $user->name
        ];

        //$queryBuilder = User::select(['name', 'user_type', 'created_at']) // Do some querying..
        $queryBuilder = Shift::select(['id', 'title', 'fk_UserID', 'fk_ChildID', 'start', 'end', 'actual_shift_start', 'actual_shift_end', 'validated', 'status'])
            //->whereBetween('created_at', [$fromDate, $toDate]);
            ->where('validated','=','1')
            ->where('start','>=',$fromDate)
            ->where('end','<=',$toDate)
            ->where('fk_UserID','=',$CYSW)
            ->orderBy('title', $sortBy)
            ->orderBy('start', $sortBy);


        $columns = [ // Set Column to be displayed
            'Child' => function($shift) {
                $child = Child::find($shift->fk_ChildID)->firstOrFail();
                return $child->initials;
            },
            'CYSW' => function($shift) {
                $user = User::where('id','=',$shift->fk_UserID)->firstOrFail();
                return $user->name;
            },
            'Salary' => function($shift) use ($salaryHistory){
                $user = User::where('id','=',$shift->fk_UserID)->firstOrFail();
                $child = Child::where('id','=',$shift->fk_ChildID)->firstOrFail();
                if ($child->getAssignedUser->contains($user)) {
                    return "$" .
                        UserChildrenHistory::getSalaryForShift(
                            $user->id,
                            $child->id,
                            $shift->start,
                            $shift->end,
                            $salaryHistory
                        );
                }
                else {
                    return "$" . 0.00;
                }
            },
            'Start Date' => 'start',
            'End Date' => 'end',
            'TS Hours' => function($shift) {
                $SD = Carbon::parse($shift->start);
                $ED = Carbon::parse($shift->end);

                return $SD->diffInHours($ED);
            },
            'Actual Start Date' => 'actual_shift_start',
            'Actual End Date' => 'actual_shift_end',
            'TA Hours' => function($shift) {
                $SD = Carbon::parse($shift->actual_shift_start);
                $ED = Carbon::parse($shift->actual_shift_end);

                return $SD->diffInHours($ED);
            },
            'Total Wages' => function($shift) use ($salaryHistory) {

                //get TA Hours
                $SD = Carbon::parse($shift->actual_shift_start);
                $ED = Carbon::parse($shift->actual_shift_end);
                $TA_Hours = $SD->diffInHours($ED);

                $user = User::where('id','=',$shift->fk_UserID)->firstOrFail();
                $child = Child::where('id','=',$shift->fk_ChildID)->firstOrFail();
                if ($child->getAssignedUser->contains($user)) {
                    return ($TA_Hours *
                        UserChildrenHistory::getSalaryForShift(
                            $user->id,
                            $child->id,
                            $shift->start,
                            $shift->end,
                            $salaryHistory
                        )
                    );
                }
                else {
                    return 0.00;
                }
            }
            //'Created At' => 'created_at', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result

            //'Status' => function($result) { // You can do if statement or any action do you want inside this closure
            //    return ($result->balance > 100000) ? 'Rich Man' : 'Normal Guy';
            //}
        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($title, $meta, $queryBuilder, $columns)

            /*
               ->editColumn('Created At', [ // Change column class or manipulate its data for displaying to report
                   'displayAs' => function($result) {
                       return $result->created_at->format('d M Y');
                   },
                   'class' => 'left'
               ])
            */

            ->editColumns(['CYSW'], [ // Mass edit column
                'class' => 'blue center'
            ])
            ->editColumns(['Child'], [ // Mass edit column
                'class' => 'green center'
            ])
            ->editColumns(['TS Hours', 'TA Hours' , 'Total Wages'], [ // Mass edit column
                'class' => 'center'
            ])
            ->editColumns(['Total Wages'], [ // Mass edit column
                'class' => 'red center'
            ])
            ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                'TA Hours' => 'point', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                'TS Hours' => 'point', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                'Total Wages' => '$', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->groupBy('CYSW')
            //->limit(20) // Limit record to be showed
            ->showNumColumn(false) // Hide number column
            ->setOrientation('landscape')
            ->setCss([
                '.bolder' => 'font-weight: 800;',
                '.red' => 'color: red;',
                '.blue' => 'color: blue;',
                '.green' => 'color: green;',
                '.center' => 'text-align: center;'
            ])
            ->make()

            ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    }

    public function PayrollReportbyChild(Request $request)
    {

        if (Auth::user()->user_type == 1) {
            abort(403, 'Unauthorized action.');

        }


        $salaryHistory = UserChildrenHistory::GetAllSalariesWithHistory(true);

        $fromDate = $request->input('from_date', (new Carbon)->startOfYear());
        $toDate = $request->input('to_date', (new Carbon)->endOfYear());

        $Child = $request->input('Child', '');
        $sortBy = $request->input('sort_by', 'asc');

        $title = 'We-Schedule.ca - Payroll Report by Child'; // Report title

        $ChildInitials = Child::where('id','=',$Child)->firstOrFail()->initials;

        $meta = [ // For displaying filters description on header
            'Pay Period' => $fromDate . ' To ' . $toDate,
            'Child' => $ChildInitials
        ];

        //$queryBuilder = User::select(['name', 'user_type', 'created_at']) // Do some querying..
        $queryBuilder = Shift::select(['id', 'title', 'fk_UserID', 'fk_ChildID', 'start', 'end', 'actual_shift_start', 'actual_shift_end', 'validated', 'status'])
            //->whereBetween('created_at', [$fromDate, $toDate]);
            ->where('validated','=','1')
            ->where('start','>=',$fromDate)
            ->where('end','<=',$toDate)
            ->where('fk_ChildID','=',$Child)
            ->orderBy('fk_ChildID', $sortBy)
            ->orderBy('start', $sortBy);


        $columns = [ // Set Column to be displayed
            'Child' => function($shift) {
                $child = Child::find($shift->fk_ChildID)->firstOrFail();
                return $child->initials;
            },
            'CYSW' => function($shift) {
                $user = User::where('id','=',$shift->fk_UserID)->firstOrFail();
                return $user->name;
            },
            'Salary' => function($shift) use ($salaryHistory) {
                $user = User::where('id','=',$shift->fk_UserID)->firstOrFail();
                $child = Child::where('id','=',$shift->fk_ChildID)->firstOrFail();
                if ($child->getAssignedUser->contains($user)) {
                    return "$" .
                        UserChildrenHistory::getSalaryForShift(
                            $user->id,
                            $child->id,
                            $shift->start,
                            $shift->end,
                            $salaryHistory
                        );
                }
                else {
                    return "$" . 0.00;
                }
            },
            'Start Date' => 'start',
            'End Date' => 'end',
            'TS Hours' => function($shift) {
                $SD = Carbon::parse($shift->start);
                $ED = Carbon::parse($shift->end);

                return $SD->diffInHours($ED);
            },
            'Actual Start Date' => 'actual_shift_start',
            'Actual End Date' => 'actual_shift_end',
            'TA Hours' => function($shift) {
                $SD = Carbon::parse($shift->actual_shift_start);
                $ED = Carbon::parse($shift->actual_shift_end);

                return $SD->diffInHours($ED);
            },
            'Total Wages' => function($shift) use ($salaryHistory) {

                //get TA Hours
                $SD = Carbon::parse($shift->actual_shift_start);
                $ED = Carbon::parse($shift->actual_shift_end);
                $TA_Hours = $SD->diffInHours($ED);

                $user = User::where('id','=',$shift->fk_UserID)->firstOrFail();
                $child = Child::where('id','=',$shift->fk_ChildID)->firstOrFail();
                if ($child->getAssignedUser->contains($user)) {
                    return ($TA_Hours *
                        UserChildrenHistory::getSalaryForShift(
                            $user->id,
                            $child->id,
                            $shift->start,
                            $shift->end,
                            $salaryHistory
                        )
                    );
                }
                else {
                    return 0.00;
                }
            }
            //'Created At' => 'created_at', // if no column_name specified, this will automatically seach for snake_case of column name (will be registered_at) column from query result

            //'Status' => function($result) { // You can do if statement or any action do you want inside this closure
            //    return ($result->balance > 100000) ? 'Rich Man' : 'Normal Guy';
            //}
        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($title, $meta, $queryBuilder, $columns)

            /*
               ->editColumn('Created At', [ // Change column class or manipulate its data for displaying to report
                   'displayAs' => function($result) {
                       return $result->created_at->format('d M Y');
                   },
                   'class' => 'left'
               ])
            */

            ->editColumns(['CYSW'], [ // Mass edit column
                'class' => 'blue center'
            ])
            ->editColumns(['Child'], [ // Mass edit column
                'class' => 'green center'
            ])
            ->editColumns(['TS Hours', 'TA Hours' , 'Total Wages'], [ // Mass edit column
                'class' => 'center'
            ])
            ->editColumns(['Total Wages'], [ // Mass edit column
                'class' => 'red center'
            ])
            ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                'TA Hours' => 'point', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                'TS Hours' => 'point', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
                'Total Wages' => '$', // if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->groupBy('CYSW')
            //->limit(20) // Limit record to be showed
            ->showNumColumn(false) // Hide number column
            ->setOrientation('landscape')
            ->setCss([
                '.bolder' => 'font-weight: 800;',
                '.red' => 'color: red;',
                '.blue' => 'color: blue;',
                '.green' => 'color: green;',
                '.center' => 'text-align: center;'
            ])
            ->make()

            ->stream(); // other available method: store('path/to/file.pdf') to save to disk, download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    }
}
