<?php
//$report->render();
//    dd($report);
use App\Reports\MyReport;
use Illuminate\Support\Facades\Auth;
use \koolreport\datagrid\DataTables;
use Illuminate\Http\Request;

//@dd ($this->dataStore("Payroll")->data());

$fromDate = $_GET['from_date'];
$toDate = $_GET['to_date'];
$user = $_GET['user'];
$type = isset($_GET['type']) ? $_GET['type'] : "cysw"  ;
?>


<style>
    /*.reportHeader {visibility:hidden;}*/
    table.dataTable {margin-top: 0px !important;}
    .title_table {margin-bottom: 0px !important; text-align: center }
    .highlight {background-color: yellow !important;}
    .statHoliday {background:#2997CE; color:white;}
    .footer-ShiftDateTime {text-align:center !important;)

.hours, .HolidayHours {width: 50px !important;}
    <?php if (Auth::user()->user_type != 10) {
//    echo ".footer-hours {display: none !important;}";
    }
    ?>
    }

</style>
<div class="report-content mt-0 mb-0">
    <div class="text-center mt-1 mb-0">
<!--        <img src="img/ws_orig.png" height="15%"/>-->
        <h1>Payroll Report</h1>

        <table class="table  title_table" style="width:100%;">
            <tbody>

            <tr>
                <td>Date of Report: <b><?php echo date("F", strtotime('m'));?></b></td>
                <td>From: <b><?php echo $fromDate;?></b></td>
                <td>To: <b><?php echo $toDate;?></b></td>
                <td>Requested By: <b><?php echo $user;?></b></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div id="tblContainer" style="width:100%; height:85%; overflow-y:auto; visibility: hidden;">
    <?php

    $data = array(
        "name" => "MyTable1",
        "dataSource"=>$report->dataStore("Payroll"),
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
                    if ($row['statHoliday'] != "Regular") {
                        return "text-align: center; color:blue;";
                    }
                 else {
                return "text-align: center";
                }
                return "text-align: center";

            },
            'th' => 'text-align: center; white-space: nowrap;',



        ),
       "plugins"=>['FixedHeader'],


        "options"=>array(
            "fixedHeader"=>true,

            "preDrawCallback" => "function () {
                   $('#tblContainer').css('visibility', 'visible');
                    }",

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
            "ordering"=>false,

        ),
        "columns" =>array (
            "groupCol" => ["label" => "RowGroup", "visible"=>false, "formatValue" => function($value, $row) { return ""; }],
            "initials"=>array(
                "label"=>"Child",
                "visible"=>false,
            ),
            "name"=>array(
                "visible"=>false,
            ),

            "hours"=>array(
                "type"=>"number",
                "decimals"=>2,
                "label"=>"Regular Hours",
                "width"=>"100",
                "visible"=>true,
//                "formatValue"=>function($value, $row) {
//
//                    return number_format($value,2);
////                    "Hours: <b>@value</b>"
//                },
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>"
            ),
            "HolidayHours"=>array(
                "type"=>"number",
                "decimals"=>2,
                "visible"=>true,
                "width"=>"100",

                "label"=>"Holiday Hours",
//                "formatValue"=>function($value, $row) {
//                    return number_format($value,2);
////                    "Hours: <b>@value</b>"
//                },
                "footer"=>"sum",
                "footerText"=>"<b>@value</b>"
            ),

            "totalHolidayHours"=>array(
                "footer"=>"sum",
                "visible"=>false,
//                "footerText"=>"Total Holiday Hours: <b>@value</b>",
//                "formatValue"=>function($value, $row) {
//                   Debugbar::info($value);
//                    if ($value != "-") {
//                       return number_format($value, 2);
//                   } else {
//                       return "";
//                   }
////                    "Hours: <b>@value</b>"
//                },
            ),
            "salary"=>array(
                "type"=>"number",
                "visible"=>false,
                "label"=>"Salary",

                "decimals"=>2,
//                "formatValue"=>function($value, $row) {
//                    return number_format($value,2);
////                    "Hours: <b>@value</b>"
//                },
                "prefix"=>"$",
            ),
            "rateRegular"=>array(
                "type"=>"number",
                "label"=>"Regular Rate",
                "visible"=>true,
                "width"=>"100",

                "decimals"=>2,
//                "formatValue"=>function($value, $row) {
//                    return number_format($value,2);
////                    "Hours: <b>@value</b>"
//                },
                "prefix"=>"$",
            ),
            "rateHoliday"=>array(
                "type"=>"number",
                "label"=>"Holiday Rate",
                "visible"=>true,
                "width"=>"100",

                "decimals"=>2,
//                "formatValue"=>function($value, $row) {
//                    return number_format($value,2);
////                    "Hours: <b>@value</b>"
//                },
                "prefix"=>"$",
            ),

            "total"=>array(
                "type"=>"number",
                "label"=>"Total",
                "visible"=>false,
                "decimals"=>2,
//                "formatValue"=>function($value, $row) {
//                    return number_format($value,2);
////                    "Hours: <b>@value</b>"
//                },
                "prefix"=>"$",
                "footer"=>"sum",
//                "footerText"=>"Total Payroll: <b>@value</b>"
            ),
            "totalRegular"=>array(
                "type"=>"number",
                "label"=>"Total Regular",
                "visible"=>true,
                "width"=>"100",

                "decimals"=>2,
//                "formatValue"=>function($value, $row) {
//                    return number_format($value,2);
////                    "Hours: <b>@value</b>"
//                },
                "prefix"=>"$",
                "footer"=>"sum",
//                "footerText"=>"Total Regular: <b>@value</b>"
            ),
            "salaryHolidayCalc"=>array(
                "type"=>"number",
                "label"=>"Total Holiday",
                "visible"=>true,
                "width"=>"100",

                "decimals"=>2,
//                "formatValue"=>function($value, $row) {
//                    return number_format($value,2);
////                    "Hours: <b>@value</b>"
//                },
                "prefix"=>"$",
                "footer"=>"sum",
//                "footerText"=>"Total Statutory Holiday: <b>@value</b>"
            ),


            "start"=>array(
                "type"=>"datetime",
                "visible"=>false,
                "label"=>"Shift Start",
//                "displayFormat"=>"D M d",
            ), "end"=>array(
                "type"=>"datetime",
                "visible"=>false,
                "label"=>"Shift End",
//                "displayFormat"=>"D M d"
            ),
            "statHoliday"=>array(
                "visible"=>true,
                "width"=>50,

                "formatValue"=>function($value, $row) {
                    if (!$value) {
                     return "Regular";
                 } else {
                     return $value;
                 }
                },
                "label"=>"Type"
                ),



             "ShiftDateTime"=>array(
                    "label"=>"Shift Date/Time",
                 "visible"=>true,
                 "width"=>"500",
                 "footer"=>function($store)
                 {
                     return "$".number_format($store->sum("totalRegular") + $store->sum("salaryHolidayCalc"));
                 },
                 "footerText"=>"Total Payroll: <b>@value</b>",
                 ),



        ),

//      "rowspan" => [10,11], // ["total regular", "total holiday"]
//        "rowspan" => ["statHoliday"], // ["total regular", "total holiday"]
        "clientRowGroup" => [


            "name" => [
                'direction' => 'asc', //'asc', 'desc'
                'calculate' => [
                    'totalPayroll' => [
                        'sum', //'sum', 'count', 'avg', 'min', 'max'
                        'total',
                        "format" => "function(value) {return value.toFixed(2);}",
                    ],
                    'totalRegHours' => [
                      'sum',
                        'hours',
                        'format' => "function(value) {return value.toFixed(2);}",

                    ],
                    'regRate' => [
                        'min',
                        'rateRegular',
                    ],
                    'totalRegCalc' => [
                        'sum',
                        'totalRegular',
                        'format' => "function(value) {return value.toFixed(2);}",

//                        'aggregate' => "function(rows, group, aggFieldIndex) { return 0; }"
                    ],
                    'totalHolidayHours' => [
                        'sum',
                        'HolidayHours',
                        'format' => "function(value) {return value.toFixed(2);}",

                    ],
                    'HolidayRate' => [
                        'max',
                        'rateHoliday',
//                        'format' => "function(value) {return value.toFixed(2);}",

//                        'aggregate' => "function(rows, group, aggFieldIndex) { return 0; }"
                    ],
                    'totalHolidayHoursCalc' => [
                        'sum',
                        'salaryHolidayCalc',
                        'format' => "function(value) {return value.toFixed(2);}",

                    ]

                ],
                "top" => "<td colspan='999'>CYSW: {name}</td>",
                "bottom" => "<td colspan='999'><div style='text-align: right;'>Total Reg: <span style='color:green;'>{totalRegHours}</span> x <span style='color:green'>{regRate}</span> = <span style='color:green'> {totalRegCalc} </span> <br /> Total Stat: <span style='color:blue;'>{totalHolidayHours}</span> x <span style='color:blue;'>{HolidayRate}</span> = <span style='color:blue;'>{totalHolidayHoursCalc}</span> <br /><span class='highlight'>{name} Total Payroll: $ {totalPayroll}</span>  </div></td> "
//                "bottom" => "<td colspan='999' align='right' class='highlight'>{name} - Total Reg {totalRegHours} x {regRate} =  Total Payroll: $ {totalPayroll}</td>",

            ],

            "initials" => [
                'direction' => 'asc',
                'calculate' => [
                    'TotalAmt' => [
                        'sum',
                        'total',
                        "format" => "function(value) {
                    newValue = '$' + value.toFixed(2)
                    return newValue;}",

                    ],
                    'TotalRegular' => [
                        'sum',
                        'totalRegular',
                        "format" => "function(value) {
                    newValue = '$' + value.toFixed(2)
                    return newValue;}",

                    ],
                    'ShiftTotalHours' => [
                        'sum',
                        'hours',
                        "format" => "function(value) {return value.toFixed(2);}",


                    ],
                    'ShiftTotalHolidayHours' => [
                        'sum',
                        'HolidayHours',
                        "format" => "function(value) {return value.toFixed(2);}",

                    ],
                    'salaryAmount' => [
                        'min',
                        'salary',

                    ],
                    'salaryAmountHoliday' => [
                        'max',
                        'salary'


                    ],
                    'salaryAmountHolidayCalc' => [
                        'sum',
                        'salaryHolidayCalc',
                        "format" => "function(value) {
                            newValue = '$' + value.toFixed(2)
                            return newValue;}",

                    ],

                ],
                "top" => "<td colspan='999'>{expandCollapseIcon} Child: {initials}  </td>  ",
            ],
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
        $('#tblContainer').css('visibility', 'shown');

        KRMyTable1.collapseAllGroups(0);
        KRMyTable1.collapseAllGroups(1);
    }",

    );

    if(isset($_GET['child']) && $_GET['child'] != "")
    $data['clientRowGroup'] = array_reverse($data['clientRowGroup'] );

    DataTables::create($data);

    //    $report = new MyReport(array(
    //        "from_date"=>$_GET['from_date'],
    //        "to_date"=>$_GET['to_date'],
    //        "user"=>$_GET['user']
    //    ));
    //    $report->run()->render();
    ?>
    </div>
</div>

