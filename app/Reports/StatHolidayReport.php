<?php
namespace App\Reports;

require_once ($_SERVER['DOCUMENT_ROOT']) . "/koolreportPRO/core/autoload.php"; // No need, if you install KoolReport through composer

use App\Models\StatutoryHolidays;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use \koolreport\processes\Filter;
use \koolreport\laravel\Friendship;
use \koolreport\processes\Group;
use \koolreport\processes\Join;

use \koolreport\processes\AggregatedColumn;
use \koolreport\processes\CalculatedColumn;
use \koolreport\processes\ColumnMeta;
use \koolreport\processes\Custom;



use Carbon\Carbon;
use koolreport\processes\Sort;

class StatHolidayReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
//    use \koolreport\clients\Bootstrap; //remove if embedding the report within @extend adminlte page


    function settings()
    {
        return array(
            "dataSources"=>array(
                "elo"=>array(
                    "class"=>'\koolreport\laravel\Eloquent', // This is important
                ),
                "statHolidays"=>array(
                    "class"=>'\koolreport\laravel\Eloquent', // This is important

                )
            )
        );
    }
    function setup()
    {


        //Get STAT Holidays
        //https://canada-holidays.ca/api/v1/provinces/ON?year=2025
        //https://github.com/pcraig3/hols/blob/main/API.md
        //https://www.convertjson.com/json-to-sql.htm

        $statHolidays = \App\Models\StatutoryHolidays::all();
        $GLOBALS['isStatHoliday'] = false;
        $GLOBALS['holidayHours'] = 0;

//        $statHolidays = $this->src('statHolidays')->query(
//            \App\Models\StatutoryHolidays::all()
//        );


        //Now you can use Eloquent inside query() like you normally do

        //find all shifts based on holiday week

        //using October as example

        //filter holidays based on date
        $filteredStatHolidays = $statHolidays->filter(function($item) {
            if (Carbon::parse($item->date)->between(Carbon::parse($this->params['MonthYear'])->startOfMonth()->toDateString() . " 00:00:00",Carbon::parse($this->params['MonthYear'])->endOfMonth()->toDateString() . " 23:59:59")) {
                return $item;
            }
        });

        //for each holiday that falls within that filtered date range, get the shifts
        foreach ($filteredStatHolidays as $Holiday) {


//            if ($Holiday->date == "2022-10-10") {

                Carbon::setWeekStartsAt(CarbonInterface::MONDAY);

                $weekNumberOfHoliday =  Carbon::parse($Holiday->date)->weekNumberInMonth;
            $tmpSD = Carbon::parse($Holiday->date)->subWeeks(4)->startOfWeek()->toDateString();
            $tmpED = Carbon::parse($Holiday->date)->subWeeks(4)->startOfWeek()->addWeeks(3)->endOfWeek()->toDateString();

//            https://www.ontario.ca/page/public-holiday-pay-calculator

//            dd ("tmpSD = " . $tmpSD . "; " . "tmpED = " . $tmpED . "; ");

//            }
            $shifts = $this->src("elo")->query(
                \App\Models\Shift::where('validated', '=', '1')->where('start', '>=', $tmpSD . " 00:00:00")->where('start', '<=', $tmpED . " 23:59:59")->orderBy('start')

            )



                ->pipe(new CalculatedColumn(array(
                    "hours" => function ($data) {
                        $SD = Carbon::parse($data['start']);
                        $ED = Carbon::parse($data['end']);


                            return ($SD->floatdiffInHours($ED, true));


                        //return $data["fk_UserID"]*100;
                    }
                )))
                ->pipe(new Custom(function ($row) use ($Holiday) {

                    $row['holiday'] = $Holiday->nameEn;
                    return $row;
                }

                ));
            $salaries = $this->src("mysql")->query(
                "select * from users_children"
            );

            $CYSWs = $this->src("elo")->query(
                \App\Models\User::whereRaw('1=1')
            );

            $children = $this->src('elo')->query(
                \App\Models\Child::whereRaw('1=1')
            );



            //  $CYSWs->pipe($this->dataStore('CYSWs'));
            //   $children->pipe($this->dataStore('children'));

            $join = new Join($shifts,$CYSWs,array("fk_UserID"=>"id"));
            $join_shifts_cysws_children = new Join($join,$children,array("fk_ChildID"=>"id"));



            $join_shifts_cysws_children->pipe(new Custom(function($row){
                $row['ShiftDateTime'] = Carbon::parse($row['start'])->toDayDateTimeString() . " - " . Carbon::parse($row['end'])->toDayDateTimeString();

                return $row;
            }))
                ->pipe(new CalculatedColumn(array(
                    "totalStatPay"=>array(
                        "exp"=>function($data) {
//                        if ($GLOBALS['splitShiftMidnight']){
//                            return $data['salary'] * $data['hours'];
//                        }

                            return number_format((($data['hours'] * 1.04)),2)/20;

                        },
//                    "exp"=>"{salary}*{hours}",
                        "type"=>"number",
                        "prefix"=>"$",
                        "decimal"=>2
                    ))))

                ->pipe(new Group(array(
                    "by"=>["holiday", "name"],
//                    "sum"=>["hours","totalStatPay"],
                    "sum"=>["hours"],
                )))

//            $join_shifts_cysws_children
//                ->pipe(new Sort(array(
//                    "holiday"=>"asc",
//                    "name"=>"asc",
//                    "initials"=>"asc",
//                    "start"=>"asc",
//
//
//                )))


                ->pipe($this->dataStore("StatHoliday"));

        }

//dd($this->dataStore("StatHoliday"))->data();

            //
//            $dataStore = $this->dataStore('Payroll');


    }
}
