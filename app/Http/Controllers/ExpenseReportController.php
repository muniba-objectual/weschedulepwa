<?php

namespace App\Http\Controllers;

use App\CustomClasses\DynamicExpenseBuilder\ExpenseCore;
use App\CustomClasses\DynamicExpenseBuilder\ExpenseTester;
use App\Models\ExpenseCategory;
use App\Models\Expenses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function seed(){
        //ExpenseTester::seed(request()->get('type')); //supported types: 'staff', 'CYSW', 'FosterParent'
        ExpenseTester::seedExpensesToAllUsers((bool) request()->get('truncate' , false));
    }

    public function scrumBoard(Request $request){
        //TODO::ashain, add a proper fix later
        $tabCollection = ExpenseCore::getTabHeads();
        session()->put('expense.report.active-tab', $request->get('tab_key'));

        return view('CaseManage.Modules.Expenses.ScrumBoard', compact(
        'tabCollection'
        ));
    }

    public function myExpenses(){
        return view('CaseManage.Modules.Expenses.MyExpenses', ['user' => \Auth::user()]);
    }

    public function show(Request $request) {
        //TODO::ashain, add a proper fix later
        $tabCollection = ExpenseCore::getTabHeads();
        session()->put('expense.report.active-tab', $request->get('tab_key', ($tabCollection[0]??null) ));

        $user = Auth::user();
        return view('CaseManage.Modules.Expenses.Report', compact( 'tabCollection','user', 'request'));
    }

    public function temporaryExpenseShow($expenseId){
        $user = Auth::user();
        return view('CaseManage.Modules.Expenses.TemporaryExpense', compact('user', 'expenseId'));
    }

    public function downloadCsvReport(Request $request){

        $categoryPrefix = 'Category ';
        $unclassifiedCategoryLabel = 'Other';


        //All Expenses
        $query = Expenses::query();
        if($request->get('month')){ //additional filters

            //Example:- "May 2023" => "2023-05"
            $yearMonth = Carbon::createFromFormat('F Y', $request->get('month'))->format('Y-m');

            // Apply the filter to fetch expenses for the specific month and year
            $query->where('datetime', 'LIKE', "{$yearMonth}%"); //TODO::Michello, feel free to add filters from the `Request`
        }
        $expenses = $query
            ->where('payment_type', Expenses::PAYMENT_METHOD__UNSPECIFIED)
            ->orderBy('created_at')
            ->get();

        //months in the report
        $globalMonths = $expenses->values()->groupBy('monthyear')->keys();
        $globalMonths->toArray();



        //categories
        $categories = ExpenseCategory::all()->pluck('name', 'id');


        //data containers
        $rows = [];
        /** @var Expenses $expense */


        //first row
        $rows['']['Categories'] = '';
        foreach ($globalMonths as $month){
            $rows[''][$month] = '';
        }

        //fill rows with 0 for all categories
        foreach ($categories as $name){
            $rows[$categoryPrefix . $name]['Categories'] = $categoryPrefix . $name;
            foreach ($globalMonths as $month){
                $rows[$categoryPrefix . $name][$month] = 0.00;
            }
        }

        //add Other and HST row
        foreach ([$unclassifiedCategoryLabel, 'HST'] as $name){
            $rows[$name]['Categories'] = $name;
            foreach ($globalMonths as $month){
                $rows[$name][$month] = 0.00;
            }
        }
        $rows['totals']['Categories'] = "Grand Totals";
        foreach ($globalMonths as $month){
            $rows['totals'][$month] = 0.00;
        }

        //loop through expenses and += totals & HST.
        foreach ($expenses as $expense) {
            foreach (json_decode($expense->line_items) as $lineItem) {

                //get category name
                if (isset($categories[$lineItem->category])) {
                    $catName = $categoryPrefix . $categories[$lineItem->category];
                } else {
                    $catName = $unclassifiedCategoryLabel;
                }

                //data collection
                $rows[$catName][$expense->monthyear] += (float)$lineItem->total;
                $rows['totals'][$month]+=(float)$lineItem->total;
            }
            $rows['HST'][$expense->monthyear] += (float)$expense->HST;
            $rows['totals'][$month]+=(float)$expense->HST;
        }

        return $this->arrayToCSV($rows, 'expenses.csv'); //TODO::Michello, feel free modify rhe file name
//        return \Maatwebsite\Excel\Facades\Excel::download($userWiseSummary->values()->toArray(), 'expenses.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    public function downloadCsvReportV2(Request $request){

        $categoryPrefix = 'Category ';
        $unclassifiedCategoryLabel = 'Other';


        //All Expenses
        $query = Expenses::query();
        if($request->has('month')){ //additional filters
            $query->where('datetime', "{$request->month}%"); //TODO::Michello, feel free to add filters from the `Request`
        }
        $expenses = $query->with('getUser')->get();

        //months in the report
        $globalMonths = $expenses->values()->groupBy('monthyear')->keys();
        $globalMonths->toArray();



        //categories
        $categories = ExpenseCategory::all()->pluck('name', 'id')->map(function ($name) use ($categoryPrefix){
            return $name; //replace any dots to avoid collection aggregation failures
        });


        //data containers
        $rows = [];
        /** @var Expenses $expense */
        $totalsCategoryWisePerUser= [];
        $totalsMonthWisePerUser= [];

        //last row
        $totalByColumns["staff_id"] = '';
        $totalByColumns["Staff Name"] = 'TOTAL';


        foreach ($expenses->groupBy('fk_UserID') as $userId => $expensesAllMonths){
            foreach ($expensesAllMonths->groupBy('monthyear') as $month => $expenses){
                foreach ($expenses as $expense){
                    foreach(json_decode($expense->line_items) as $lineItem) {

                        //get category name
                        if( isset($categories[$lineItem->category]) ){
                            $catName = $categoryPrefix.$categories[$lineItem->category];
                        }else{
                            $catName = $unclassifiedCategoryLabel;
                        }

                        //data collection
                        if( isset($totalsCategoryWisePerUser[$userId][$catName]) ){
                            $totalsCategoryWisePerUser[$userId][$catName] += (float)$lineItem->total;
                        }else{
                            $totalsCategoryWisePerUser[$userId][$catName] = (float)$lineItem->total;
                        }

                        //data collection
                        if( isset($totalsMonthWisePerUser[$userId][$month]) ){
                            $totalsMonthWisePerUser[$userId][$month] += (float)$lineItem->total;
                        }else{
                            $totalsMonthWisePerUser[$userId][$month] = (float)$lineItem->total;
                        }
                    }
                }
            }
            //end of row loop


            //build row
            $rows[$userId] = [
                "staff_id" => $expensesAllMonths->first()->fk_UserID,
                'Staff Name' => $expensesAllMonths->first()->getUser->name,
            ];

            foreach ($globalMonths as $month){
                $rows[$userId][$month] = $totalsMonthWisePerUser[$userId][$month]??0;
                $totalByColumns[$month] = ($totalByColumns[$month]??0) + ($totalsMonthWisePerUser[$userId][$month]??0);
            }

            $rows[$userId][$unclassifiedCategoryLabel] = $totalsCategoryWisePerUser[$userId][$unclassifiedCategoryLabel]??0;
            $totalByColumns[$unclassifiedCategoryLabel] = ($totalByColumns[$unclassifiedCategoryLabel]??0) + ($totalsCategoryWisePerUser[$userId][$unclassifiedCategoryLabel]??0);

            foreach ($categories as $categoryName){
                $rows[$userId][$categoryPrefix.$categoryName] = $totalsCategoryWisePerUser[$userId][$categoryPrefix.$categoryName]??0;
                $totalByColumns[$categoryPrefix.$categoryName] = ($totalByColumns[$categoryPrefix.$categoryName]??0) + ($totalsCategoryWisePerUser[$userId][$categoryPrefix.$categoryName]??0);
            }
        }

        //attach last row finally.
        $rows[]=$totalByColumns;

        return $this->arrayToCSV($rows, 'expenses.csv'); //TODO::Michello, feel free modify rhe file name
//        return \Maatwebsite\Excel\Facades\Excel::download($userWiseSummary->values()->toArray(), 'expenses.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function downloadCsvReportV1(Request $request){
        $categoryPrefix = 'Category ';
        $unclassifiedCategoryLabel = 'Other';
        $query = Expenses::query();

        //additional filters
        if($request->has('month')){
            $query->where('datetime', "{$request->month}%"); //TODO::Michello, feel free to add filters from the `Request`
        }

        $categories = ExpenseCategory::all()->pluck('name', 'id')->map(function ($name){
            return str_replace(".", "", $name); //replace any dots to avoid collection aggregation failures
        });

        $userWiseSummary = collect();

        //Expense Rows
        $query->with('getUser')->get()->map(function (Expenses $model)  use ($categories, $categoryPrefix, $unclassifiedCategoryLabel, &$userWiseSummary){
            $userRow = $userWiseSummary->get($model->fk_UserID, []); //creat new row or use existing row if created in a previous iteration

            //override each time
            $userRow['Staff ID'] = $model->fk_UserID;
            $userRow['Staff Name'] = $model->getUser->name;

            $copy = $userRow; //make a copy for later sorting

            //calculate category totals for expense
            foreach(json_decode($model->line_items) as $lineItem) {
                //handle undefined categories
                if( isset($categories[$lineItem->category]) ){
                    $catName = $categoryPrefix.$categories[$lineItem->category];
                }else{
                    $catName = $unclassifiedCategoryLabel;
                }

                //+= or = category total
                if( isset($copy[$catName]) ) {
                    $copy[$catName] += (float)$lineItem->total;
                } else {
                    $copy[$catName] = (float)$lineItem->total;
                }
            }

            //loop through all categories, inject missing categories
            foreach ($categories as $categoryName){
                $userRow[$categoryPrefix.$categoryName] = $copy[$categoryPrefix.$categoryName]??0;
            }
            $userRow[$unclassifiedCategoryLabel] = $copy[$unclassifiedCategoryLabel]??0;


            //HST
            if (isset( $userRow['Total HST'] )) {
                $userRow['Total HST'] += $model->HST;
            } else {
                $userRow['Total HST'] = $model->HST;
            }


            //Grand Total
            if (isset( $userRow['Grand Total'] )) {
                $userRow['Grand Total'] += $model->total;
            } else {
                $userRow['Grand Total'] = $model->total;
            }

            $userWiseSummary->put($model->fk_UserID, $userRow);
            return $model;
        });


        //Last Row
        $lastRow = [
            'Staff ID' => "",
            'Staff Name' => "TOTAL",
        ];
        //calculate final totals for expense
        foreach ($categories as $categoryName){
            $lastRow[$categoryPrefix.$categoryName] = $userWiseSummary->sum($categoryPrefix.$categoryName);
        }
        $lastRow[$unclassifiedCategoryLabel] = $userWiseSummary->sum($unclassifiedCategoryLabel);
        $lastRow['Total HST'] = $userWiseSummary->sum('Total HST');
        $lastRow['Grand Total'] = $userWiseSummary->sum('Grand Total');

        $userWiseSummary->push($lastRow);
        //End Last Row


        return $this->arrayToCSV($userWiseSummary->values()->toArray(), 'expenses.csv'); //TODO::Michello, feel free modify rhe file name
    }

    private function arrayToCSV(array $array, string $filename){

        // Set the headers
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename"
        );

        // Create a stream
        $stream = fopen('php://temp', 'w+');

        // Write the headers to the stream
        fputcsv($stream, array_keys( $array[0] ?? $array[array_key_first($array)] ));

        // Loop through the data and write each row to the stream
        foreach ($array as $row) {
            fputcsv($stream, $row);
        }

        // Rewind the stream
        rewind($stream);

        // Get the content of the stream
        $content = stream_get_contents($stream);

        // Close the stream
        fclose($stream);

        // Return the response with the CSV content and headers
        return new \Illuminate\Http\Response($content, 200, $headers);

    }
}
