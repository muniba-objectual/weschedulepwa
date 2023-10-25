<?php
//$report->render();
//    dd($report);
use App\Reports\MyReport;
use Illuminate\Support\Facades\Auth;
use \koolreport\datagrid\DataTables;
use Illuminate\Http\Request;

$MonthYear = $_GET['MonthYear'];
$user = $_GET['user'];
?>

<style>
    /*.reportHeader {visibility:hidden;}*/
    table.dataTable {margin-top: 0px !important;}
    .title_table {margin-bottom: 0px !important; text-align: center }
    .highlight {background-color: yellow !important;}
    .statHoliday {background:#2997CE; color:white;}
    .footer-hours {text-align:left !important;)

    .header-hours {text-align: left !important);
    .hours, .HolidayHours {width: 50px !important;}
    th {border: 1px solid;}
    <?php if (Auth::user()->user_type != 10) {
//    echo ".footer-hours {display: none !important;}";
    }
    ?>
    }

</style>
<div class="report-content mt-0 mb-0">
    <div class="text-center mt-1 mb-0">
<!--        <img src="img/ws_orig.png" height="15%"/>-->
        <h1>Statutory Holiday Report</h1>

        <table class="table title_table" style="width:100%;border-bottom:1px solid black;">
            <tbody>

            <tr>
                <td>Date of Report: <b><?php echo date("F", strtotime('m'));?></b></td>
                <td>Month: <b><?php echo $MonthYear;?></b></td>
                <td>Requested By: <b><?php echo $user;?></b></td>
            </tr>
            </tbody>
        </table>
    </div>

            <div id="tblContainer" style="width:100%; height:85%; overflow-y:auto; visibility: hidden;">
                <?php
                DataTables::create(array(
                    "name" => "MyTable1",
                    "dataSource"=>$report->dataStore("StatHoliday"),
                    "showFooter"=>true,
                    "serverSide"=>false,
        //        "rowDetailData" => function($row) {
        //            return "Shift Date: " . $row['start'] . " - " . $row['end'];
        //        },
        //        "rowDetailIcon" => true,

                    "themeBase"=>"bs4", // Optional option to work with Bootsrap 4
                    "cssClass"=>array(
                        "table"=>"table table-striped mb-0 mt-0",
                        'th' => 'reportHeader',
        //            'th' => function($colName) {
        //                return $colName;
        //            },
        //            "td"=>function($row,$columnName){
        //                if($columnName=="statHoliday"){
        //                    if (!$row['statHoliday'] != "Regular") {
        ////                       @dd($row['statHoliday']);
        //                        return "statHoliday";
        //                    }
        //
        //                } else {
        //                    return "";
        //                }
        //            }

                    ),
                    "cssStyle"=>array(
        //            'tr' => 'text-align: center',

                        'tr'=>function($row, $columnName) {


                            return "text-align: center";

                        },
                        'th' =>function($row, $columnName) {
                            if ($row == "hours") {
                                return 'text-align: left;';
                            }
                            return 'text-align: center; white-space: nowrap;';
                        },

                        'td'=>function($row, $columnName) {
                          Debugbar::info($columnName);
                            if ($columnName == "hours") {
                                return 'text-align: left';
                            }
                            return '';
                        }




                    ),
                    "plugins"=>array("FixedHeader"),


                    "options"=>array(
                        'autoWidth' => true,

                        "columnDefs" => array(
                            array(
        //                    "visible" => false,
        //                    "targets" => [0,1,2,5,6,9,12,13],
        //                    "orderData"=>[1,2,7,8,9,11,13],
        //                    "width"=>"10px",
        //                    "targets"=>["_all"]
                            ),

                        ),
                        "fixedHeader"=>true,
                        "ordering"=>false,

                    ),
                    "columns" =>array (
                        "groupCol" => ["label" => "RowGroup", "visible"=>false, "formatValue" => function($value, $row) { return ""; }],
                        "name"=>array(
                            "visible"=>true,
                            "label"=>"CYSW",
                            "width"=>"500",
                        ),


                        "initials"=>array(
                            "label"=>"Child",
                            "visible"=>false,
                        ),
                        "hours"=>array(
                            "type"=>"number",
                            "decimals"=>2,
                            "label"=>"Hours",
                            "width"=>"100",
                            "visible"=>true,
                        "formatValue"=>function($value, $row) {
                                $newValue = (($value / 20)*1.04);
                            return number_format($newValue,2);
        //                    "Hours: <b>@value</b>"
                        },
                            "footer"=>"sum",
                            "footerText"=>"Total Hours: <b>@value</b>"
                        ),


                        "ShiftDateTime"=>array(
                            "label"=>"Shift Date/Time",
                            "visible"=>false,
                            "width"=>"500",
        //                    "footer"=>function($store)
        //                    {
        //                        return "$".number_format($store->sum("totalRegular") + $store->sum("salaryHolidayCalc"));
        //                    },
        //                    "footerText"=>"Total Payroll: <b>@value</b>",
                        ),
                        "holiday"=>array(
                            "label"=>"Holiday",
                            "visible"=>false,
                            "width"=>"100",
        //                    "footer"=>function($store)
        //                    {
        //                        return "$".number_format($store->sum("totalRegular") + $store->sum("salaryHolidayCalc"));
        //                    },
        //                    "footerText"=>"Total Payroll: <b>@value</b>",
                        ),

                        "totalStatPay"=>array(
                            "label"=>"Statutory Pay",
                            "visible"=>false,
                            "width"=>"100",
                            "footer"=>"sum",

                            "formatValue"=>function($value, $row) {

        //                        Debugbar::info(number_format($value,2));
//                                 Debugbar::info($value);
                                return "$" . number_format($value,2);
//                                 return $value;
                            },

                            "footerText"=>"Total Statutory Holiday Pay: <b>@value</b>",
                        ),


                    ),

        //      "rowspan" => [10,11], // ["total regular", "total holiday"]
        //        "rowspan" => ["statHoliday"], // ["total regular", "total holiday"]
                    "clientRowGroup" => [

                        "holiday" => [
                            'direction' => 'asc', //'asc', 'desc'
                            "top" => "<td colspan='999'>Statutory Holiday: {holiday}</td>",
//                            "aggregate" => "function(rows,group,aggFieldIndex) {
//                            console.log(rows)
//                            return 'test'
//                            }
//                            "
                        ],
                        "name" => [
                            'direction' => 'asc', //'asc', 'desc'
                            'calculate' => [
                                'totalStatPayCalc' => [
                                    'sum', //'sum', 'count', 'avg', 'min', 'max'
                                    'totalStatPay',
                                    "format" => "function(value) {return '$' + value.toFixed(2);}",
                                ],

                                'totalHours' => [
                                    'sum', //'sum', 'count', 'avg', 'min', 'max'
                                    'hours',
                                    "format" => "function(value) {return value.toFixed(2);}",
                                ],



                            ],
//                            "top" => "<td colspan='999'>CYSW: {name} - Total Hours: {totalHours}</td>",
//                            "bottom" => "<td colspan='999' align='right' class='highlight'>{name} Total Hours: {totalHours}</td>",
                        ],

                        "hours" => [
                            'direction' => 'asc', //'asc', 'desc'
                            ]
//                        "initials" => [
//                            'direction' => 'asc',
//                            'calculate' => [
//
//
//
//                                'ShiftTotalHours' => [
//                                    'sum',
//                                    'hours',
//                                    "format" => "function(value) {return value.toFixed(2);}",
//
//
//                                ],
//
//
//                                'totalStatPay' => [
//                                    'sum',
//                                    'totalStatPay',
//                                    'format' => 'function(value) {
//                                    newValue = "$" + value.toFixed(2)
//                                    return newValue;}',
//
//
//                                ],
//
//                            ],
//                            "top" => "<td colspan='999'>{expandCollapseIcon} Child: {initials} | Total Hours: {ShiftTotalHours} x 1.04 (Vacation Pay) / 20 = {totalStatPay} </td>  ",
//                        ],



        //            "statHoliday" => [
        //                'direction' => 'asc',
        //                'calculate' => [
        //                    'TotalStatHolidayAmt' => [
        //                        'sum',
        //                        'total',
        //                        "format" => "function(value) {
        //
        //                    newValue = '$' + value.toFixed(2)
        //                    return newValue;
        //
        //                    }",
        //
        //                    ],
        //                ],
        //                'top'=>'<td colspan="999" style="background:#2997CE; color:white;">{statHoliday} [Total Pay: {TotalStatHolidayAmt}]</td>',
        //
        //            ],



                    ],
                    "onReady" => "function() {
                MyTable1.on( 'draw.dt', function () {


                    console.log( 'event draw' );
                    console.log (MyTable1.DataTables());
                    KRMyTable1.collapseAllGroups(0);
                    KRMyTable1.collapseAllGroups(1);
                    KRMyTable1.collapseAllGroups(2);
                } );
                KRMyTable1.collapseAllGroups(0);
                KRMyTable1.collapseAllGroups(1);
                KRMyTable1.collapseAllGroups(2);
                $('#tblContainer').css('visibility', 'visible');
    }",

        ));

        //    $report = new MyReport(array(
        //        "from_date"=>$_GET['from_date'],
        //        "to_date"=>$_GET['to_date'],
        //        "user"=>$_GET['user']
        //    ));
        //    $report->run()->render();
        ?>
    </div>
</div>

