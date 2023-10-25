<?php

namespace App\Reports;

require_once ($_SERVER['DOCUMENT_ROOT']) . "/koolreportPRO/core/autoload.php"; // No need, if you install KoolReport through composer

use App\Models\StatutoryHolidays;
use App\Models\UserChildrenHistory;
use Barryvdh\Debugbar\Facades\Debugbar;
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

class MyReport extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    //    use \koolreport\clients\Bootstrap; //remove if embedding the report within @extend adminlte page


    function settings()
    {
        return array(
            "dataSources" => array(
                "elo" => array(
                    "class" => '\koolreport\laravel\Eloquent', // This is important
                ),
                "statHolidays" => array(
                    "class" => '\koolreport\laravel\Eloquent', // This is important

                )
            )
        );
    }

    public function getSalary($data): ?float{
        return UserChildrenHistory::getSalaryForShift(
            $data['users_id'],
            $data['children_id'],
            $data['start'],
            $data['end'],
            $GLOBALS['salaryRates']
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
        $GLOBALS['splitShiftHours'] = 0;
        $GLOBALS['splitShiftMidnight'] = false;

        //fetchSalaryHistory
        $GLOBALS['salaryRates'] = UserChildrenHistory::GetAllSalariesWithHistory(true);

        //        $statHolidays = $this->src('statHolidays')->query(
        //            \App\Models\StatutoryHolidays::all()
        //        );

        //Now you can use Eloquent inside query() like you normally do
        $shifts = $this->src("elo")->query(
            \App\Models\Shift::where('validated', '=', '1')->where('start', '>=', $this->params['from_date'] . " 00:00:00")->where('start', '<=', $this->params['to_date'] . " 23:59:59")->orderBy('start')

        )

            ->pipe(new CalculatedColumn(array(
                "statHoliday" => array(
                    "exp" => function ($data) use ($statHolidays) {
                        $SD = Carbon::parse($data['start']);
                        $ED = Carbon::parse($data['end']);
                        $statHoliday = "";
                        $checkStatHoliday = ($statHolidays->contains(function ($row, $key) use ($SD, $ED) {


                            if (Carbon::parse($row['date'])->between(Carbon::parse($SD)->toDateString() . " 00:00:00", Carbon::parse($SD)->toDateString() . " 23:59:59")) {
                                $statHoliday = $row['nameEn'];
                                $GLOBALS['isStatHoliday'] = true;

                                return true;
                            } else {
                                $GLOBALS['isStatHoliday'] = false;

                                return false;
                            }
                        }));
                        if ($checkStatHoliday) {
                            //                dd($statHolidays->where('observedDate','=',$SD->toDateString())->first()->nameEn);
                            $checkStart = ($statHolidays->where('date', '=', $SD->toDateString())->first());
                            $checkEnd = ($statHolidays->where('date', '=', $ED->toDateString())->first());
                            if ($checkStart) {
                                return "Statutory Holiday: " . ($statHolidays->where('date', '=', $SD->toDateString())->first()->nameEn);
                            }
                            if ($checkEnd) {
                                return "Statutory Holiday: " . ($statHolidays->where('date', '=', $ED->toDateString())->first()->nameEn);
                            }
                        } else {
                            return false;
                        }
                    },
                    "type" => "string"
                )
            )))
            ->pipeIf(
                $GLOBALS['isStatHoliday'] = true,
                function ($node) use ($statHolidays) {
                    //if this row is a stat holiday, change the rate
                    return $node->pipe(new CalculatedColumn(array(
                        "HolidayHours" => array(
                            "exp" => function ($data) use ($statHolidays) {
                                $SD = Carbon::parse($data['start']);
                                $ED = Carbon::parse($data['end']);
                                $checkStatHoliday = ($statHolidays->contains(
                                    function ($row, $key) use ($SD, $ED, $data) {
                                        if ($row->date == $SD->toDateString() || $row->date == $ED->toDateString()) {
                                            //shift either started or ended on a stat holiday

                                            if ($row->date == $SD->toDateString() && $row->date == $ED->toDateString()) {
                                                //if shift started and ended on a stat holiday, calculate holiday hours for the whole shift



                                                $holidayHours = $SD->diffInHours($ED);
                                                $GLOBALS['holidayHours'] = $holidayHours;
                                                $GLOBALS['splitShiftHours'] = 0;


                                                return true;
                                            }

                                            if ($row->date == $SD->toDateString() && $row->date != $ED->toDateString()) {
                                                $holidayHours = $SD->diffInHours($SD->toDateString() . " 24:00:00");
                                                $GLOBALS['holidayHours'] = $holidayHours;


                                                $splitShiftHours = $ED->diffInHours($SD->toDateString() . "24:00:00", true);
                                                $GLOBALS['splitShiftHours'] = $splitShiftHours;

                                                return true;
                                            }

                                            if ($row->date != $SD->toDateString() && $row->date == $ED->toDateString()) {

                                                if ($ED->isMidnight()) {
                                                    $splitShiftHours = $SD->diffInHours($ED->toDateString(), true);
                                                    //                                            dd($splitShiftHours);
                                                    $GLOBALS['splitShiftHours'] = $splitShiftHours;
                                                    $GLOBALS['splitShiftMidnight'] = true;

                                                    return true;
                                                } else {

                                                    $holidayHours = $ED->diffInHours($ED->toDateString() . " 00:00:00");
                                                    $GLOBALS['holidayHours'] = $holidayHours;
                                                    $splitShiftHours = $ED->diffInHours($SD->toDateString() . "24:00:00", true);
                                                    $GLOBALS['splitShiftHours'] = $splitShiftHours;

                                                    return true;
                                                }
                                            }
                                        } else {
                                            $GLOBALS['splitShiftHours'] = 0;

                                            return false;
                                        }
                                    }

                                ));
                                if ($checkStatHoliday) {
                                    //                dd($statHolidays->where('observedDate','=',$SD->toDateString())->first()->nameEn);
                                    //                                Debugbar::info($GLOBALS['holidayHours']);
                                    $holidayHours = $GLOBALS['holidayHours'];
                                    $GLOBALS['holidayHours'] = 0;
                                    return $holidayHours;

                                    //                                return ($GLOBALS['holidayHours']);

                                } else {
                                    return false;
                                }
                            }
                        )
                    )));
                },
            )
            ->pipe(new CalculatedColumn(array(
                "hours" => function ($data) {
                    $SD = Carbon::parse($data['start'])->toImmutable();
                    $ED = Carbon::parse($data['end'])->toImmutable();

                    if ($data['id'] == "9023") {
                        DebugBar::info($data);
                        DebugBar::info($SD->floatdiffInHours($ED, true));
                    }
                    if ($GLOBALS['splitShiftHours'] != 0) {
                        return $GLOBALS['splitShiftHours'];
                    }
                    if ($GLOBALS['isStatHoliday']) {
                        //                        return ($data['HolidayHours']);
                        return 0;
                    } else {

                        return ($SD->floatdiffInHours($ED, true));
                    }
                    //return $data["fk_UserID"]*100;
                }
            )));





        $salaries = $this->src("mysql")->query(
            "select * from users_children"
        );

        if ($this->params['cysw']) {
            $CYSWs = $this->src("elo")->query(
                \App\Models\User::whereIn("id", explode(",",$this->params['cysw']))
            );
        } else {
            $CYSWs = $this->src("elo")->query(
                \App\Models\User::whereRaw('1=1')
            );
        }

        if ($this->params['child']) {
            $children = $this->src('elo')->query(
                \App\Models\Child::whereIn("id", explode(",",$this->params['child']))
            );
        } else {
            $children = $this->src('elo')->query(
                \App\Models\Child::whereRaw('1=1')
            );
        }





        //  $CYSWs->pipe($this->dataStore('CYSWs'));
        //   $children->pipe($this->dataStore('children'));

        $join = new Join($shifts, $CYSWs, array("fk_UserID" => "id"));
        $join_shifts_cysws_children = new Join($join, $children, array("fk_ChildID" => "id"));
        $join_shifts_cysws_children_salary = new Join($join_shifts_cysws_children, $salaries, array("fk_UserID" => "users_id", "fk_ChildID" => "children_id"));



        $join_shifts_cysws_children_salary->pipe(new CalculatedColumn(array(
            "total" => array(
                "exp" => function ($data) {
                    //                        if ($GLOBALS['splitShiftMidnight']){
                    //                            return $this->getSalary($data) * $data['hours'];
                    //                        }
                    if (!$data['statHoliday'] == "") {
                        return ($this->getSalary($data) * 1.5) * $data['HolidayHours'];
                    } else {

                        return ($this->getSalary($data) * $data['hours']);
                    }
                },
                //                    "exp"=>"{salary}*{hours}",
                "type" => "number",
                "prefix" => "$",
                "decimal" => 2
            ),
            "rateRegular" => array(
                "exp" => function ($data) {
                    return ($this->getSalary($data));
                }
            ),
            "rateHoliday" => array(
                "exp" => function ($data) {
                    return ($this->getSalary($data) * 1.5);
                }
            ),
            "totalRegular" => array(
                "exp" => function ($data) {



                    return ($this->getSalary($data) * $data['hours']);
                },
                //                    "exp"=>"{salary}*{hours}",
                "type" => "number",
                "prefix" => "$",
                "decimal" => 2
            ),

            "salary" => array(
                "exp" => function ($data) {


                    if (!$data['statHoliday'] == "") {
                        return ($this->getSalary($data) * 1.5);
                    } else {

                        return ($this->getSalary($data));
                    }
                },
                //                    "exp"=>"{salary}*{hours}",
                "type" => "number",
                "prefix" => "$",
                "decimal" => 2
            ),
            "salaryHoliday" => array(
                "exp" => function ($data) {
                    if ($data['statHoliday'] != "") {
                        return ($this->getSalary($data) * 1.5) * $data['HolidayHours'];
                    }
                },
                //                    "exp"=>"{salary}*{hours}",
                "type" => "number",
                "prefix" => "$",
                "decimal" => 2
            ),
            "salaryHolidayCalc" => array(
                "exp" => function ($data) {
                    if (!$data['statHoliday'] == "") {
                        return ($this->getSalary($data)  * $data['HolidayHours']);
                    } else {

                        return 0;
                    }
                },
            ),

            "totalHolidayHours" => array(
                "exp" => function ($data) {

                    if ($GLOBALS['isStatHoliday']) {
                        return ($data['HolidayHours']);
                    }
                },
            ),


            //        function($data){
            //
            //                    return $this->getSalary($data)*$data['hours'];
            //                    //return $data["fk_UserID"]*100;
            //                }



        )))
            ->pipe(new ColumnMeta(array(
                "start" => array(
                    "type" => "datetime",
                    "format" => "Y-m-d H:i:s"
                )
            )))
            ->pipe(new ColumnMeta(array(
                "end" => array(
                    "type" => "datetime",
                    "format" => "Y-m-d H:i:s"
                )
            )))

            ->pipe(new Custom(function ($row) {
                $row['ShiftDateTime'] = Carbon::parse($row['start'])->toDayDateTimeString() . " - " . Carbon::parse($row['end'])->toDayDateTimeString();
                return $row;
            }))




            //                ->pipe(new Group(array(
            //                "by"=>array('name',"initials"),
            //                "sum"=>array("hours","total")
            //            )))
            ->pipe(new Sort(array(
                "name" => "asc",
                "initials" => "asc",
                "start" => "asc",
                "statHoliday" => "asc"

            )))

            ->pipe(new \koolreport\processes\Map(array(
                '{value}' => function ($row, $metaData) {
                    if ($row['hours'] && !$row['HolidayHours']) {
                        $row['rateHoliday'] = "0";
                        return array($row);
                    }

                    if (!$row['hours'] && $row['HolidayHours']) {
                        $row['rateRegular'] = "0";
                        return array($row);
                    }

                    if ($row['hours'] && $row['HolidayHours']) {
                        //split shift
                        return array($row);
                    }
                },
                "{meta}" => function ($meta) {
                    $colMetas = $meta["columns"];
                    foreach ($colMetas as $colName => $colMetaValue) {
                        $colMetas[$colName]["formatValue"] = function ($value) use ($colName) {
                            if ($value == 0 || $value == "-" || $value == "0" || $value == "0.00") {

                                return "";
                            } else {
                                if ($colName == "hours" || $colName == "HolidayHours") {


                                    return number_format($value, 2);
                                }
                                if ($colName == "rateRegular" || $colName == "rateHoliday" || $colName == "totalRegular" || $colName == "salaryHolidayCalc") {
                                    return "$" . number_format($value, 2);
                                }
                                return $value;
                            }
                        }; // add semicolon here
                    }
                    $meta["columns"] = $colMetas;
                    return $meta;
                }
            )))
            ->pipe($this->dataStore("Payroll"));
        //
        //$dataStore = $this->dataStore('Payroll');
        //dd($this->dataStore("Payroll"))->data();

    }
}
