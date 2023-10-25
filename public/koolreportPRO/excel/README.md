# Introduction

`Excel` package helps you to work with Excel. It can help to pull data from Excel file as well as push data to Excel file. Underline of `ExcelDataSource` is the open-source library called `phpoffice/PHPExcel` which helps us to read various Excel version.

# Installation

1. Unzip folder
2. Copy the `excel` folder to `koolreport\packages`

# Documentation

## Get data from Excel (version >= 1.0.0)

`ExcelDataSource` helps you to get data from your current Microsoft Excel file.

### Settings

|Name|type|default|description|
|----|---|---|---|
|class|string||	Must set to '\koolreport\datasources\ExcelDataSource'|
|filePath|string||The full file path to your Excel file.|
|charset|string|`"utf8"`|Charset of your Excel file|
|firstRowData|boolean|`false`|Whether the first row is data. Normally the first row contain the field name so default value of this property is false.|
|sheetName|string|null|Set a sheet name to load instead of all sheets. (version >= 2.1.0)|
|sheetIndex|number|null|Set a sheet index to load instead of all sheets. If both sheetName and sheetIndex are set, priority is given to sheetName first.  (version >= 2.1.0)|

### Example

```
class MyReport extends \koolreport\KoolReport
{
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sale_source"=>array(
                    "class"=>"\koolreport\excel\ExcelDataSource",
                    "filePath"=>"../data/my_file.xlsx",
                    "charset"=>"utf8",
                    "firstRowData"=>false,//Set true if first row is data and not the header,
                    "sheetName"=>"sheet1", // (version >= 2.1.0)
                    "sheetIndex"=>0, // (version >= 2.1.0)
                )
            )
        );
    }

    public function setup()
    {
        $this->src('sale_source')
        ->pipe(...)
    }
}

```

## Get data from huge xlsx, ods and csv files (version >= 7.0.0)

`BigSpreadsheetDataSource` helps you to get data from huge spreadsheet files of type xlsx, ods or csv.

### Settings

|Name|type|default|description|
|----|---|---|---|
|class|string||	Must set to '\koolreport\datasources\BigSpreadsheetDataSource'|
|filePath|string||The full file path to your spreadsheet file.|
|fileType|string||"xlsx", "ods" or "csv". Only needed if file extension is different from its type.|
|charset|string|`"utf8"`|Charset of your spreadsheet file|
|firstRowData|boolean|`false`|Whether the first row is data. Normally the first row contain the field name so default value of this property is false.|
|fieldSeparator|string|`,`|Used for setting a csv file's delimiter|
|sheetName|string|null|Set a sheet name to load instead of all sheets. Not applicable for csv files.|
|sheetIndex|number|null|Set a sheet index to load instead of all sheets. If both sheetName and sheetIndex are set, priority is given to sheetName first. Not applicable for csv files.|

### Example

```
class MyReport extends \koolreport\KoolReport
{
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sale_source"=>array(
                    "class"=>"\koolreport\excel\BigSpreadsheetDataSource",
                    "filePath"=>"../data/my_file.xlsx",
                    "firstRowData"=>false,//Set true if first row is data and not the header,
                    "sheetName"=>"sheet1",
                    "sheetIndex"=>0,
                )
            )
        );
    }

    public function setup()
    {
        $this->src('sale_source')
        ->pipe(...)
    }
}

```

## Export to Excel (version >= 1.0.0)

To use the export feature in report, you need to register the `ExcelExportable` in your report like below code

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\excel\ExcelExportable;
    ...
}
```

Then now you can export your report to excel like this:

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(...)->toBrowser("myreport.xlsx");
```

### General exporting options

When exporting to excel, you could set a number of property for the excel file.

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
    "properties" => array(
        "creator" => "",
        "title" => "",
        "description" => "",
        "subject" => "",
        "keywords" => "",
        "category" => "",
    )
))->toBrowser("myreport.xlsx");
```

### Normal Excel exporting options (version >= 3.0.0)

Defines datastores for exporting:

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
    "dataStores" => array(
        'salesReport' => array(
            "columns"=>array(
                0, 1, 2, 'column3', 'column4' //if not specifying, all columns are exported
            )
        )
    )
))->toBrowser("myreport.xlsx");
```

### Pivot excel exporting options 

Beside general options, when exporting a pivot data store you could set several options similar to when viewing a pivot table widget.

```
<?php
$report = new MyReport;
$report->run()->exportToExcel(array(
    "dataStores" => array(
        'salesReport' => array(
            'rowDimension' => 'column',
            'columnDimension' => 'row',
            "measures"=>array(
                "dollar_sales - sum", 
            )
        )
    )
))->toBrowser("myreport.xlsx");
```

## Save file vs push file to browser

After exporting, you have two options to do with the file. First, you can save the file to local drive and can use it later for example attaching file to email. Second, you can push to file to browser for user to download.

To save file, you do:

```
$report->run()->exportToExcel(...)->saveAs("../storage/myreport.xlsx"); // State the path of file
```

To push file to browser, you do:

```
$report->run()->exportToExcel()->toBrowser("myreport.xlsx"); // Input the filename
```

## Excel export template (version >= 6.0.0)

You could programmatically set up a template file for excel export similar to a report's view file.

```
<?php
//exportExcel.php
include "MyReport.php";
$report = new MyReport;
$report->run();
$setting = ['useLocalTempFolder' => true];
$report->exportToExcel('MyReportExcel', $setting)->toBrowser("MyReport.xls");
```

```
<?php
//MyReportExcel.view.php
<?php
    use \koolreport\excel\Table;
    use \koolreport\excel\PivotTable;
    use \koolreport\excel\BarChart;
    use \koolreport\excel\LineChart;
?>
<div sheet-name="<?php echo $sheetName; ?>">
    <div cell="A1">
        <?php echo $reportName; ?>
    </div>
    <div>
        <?php
        Table::create(array(
            "dataSource" => $this->dataStore('orders'),
        ));
        ?>
    </div>
    <div range="A25:H45">
        <?php
        LineChart::create(array(
            "dataSource" => $this->dataStore('salesQuarterProduct'),
        ));
        ?>
    </div>
    <div>
        <?php
        PivotTable::create(array(
            "dataSource" => 'salesPivot',
        ));
        ?>
    </div>
</div>
```

To use an excel export template file, pass its name (without the extension '.view.php') to the exportToExcel() method.

In the template file, have access to your report via $this as well as its parameters $this->params and datastore $this->datastore().

The template file consists of 2 level of div tags. Each first level div represents a separated excel worksheet.

```
<div sheet-name="sheet1">
</div>
```

Second level divs represents blocks of content in each worksheet. A block of content could be some text, a table, a chart, a pivot table. Each block of content could have its top-left cell set via the div's `cell` attribute or its range set via the div's `range` attribute. The range attribute would work for text and chart and for neither table nor pivot table.

 
```
<div sheet-name="sheet1">
    <div cell="A1" range="A1:E1">
        <?php echo $reportName; ?>
    </div>
</div>
```

In the excel package, we have table, pivot table and chart widgets which are similar to the same name widgets in other packages of KoolReport. 

When setting a datasource for a widget, you could use either a datastore name or a datastore object of the your report. 

```
<?php
//MyReportExcel.view.php
<?php
    use \koolreport\excel\Table;
    use \koolreport\excel\PivotTable;
?>
<div sheet-name="sheet1">
    <div>
        <?php
        Table::create(array(
            "dataSource" => $this->dataStore('orders'),
        ));
        ?>
    </div>
    <div>
        <?php
        PivotTable::create(array(
            "dataSource" => 'salesPivot',
        ));
        ?>
    </div>
</div>
```

With chart widget, there's another property called "excelDataSource" which could be set to be the name of a table widget in the template. In this case data for the chart would be drawn from the table widget instead of from a datastore.

```
<?php
//MyReportExcel.view.php
<?php
    use \koolreport\excel\Table;
    use \koolreport\excel\BarChart;
?>
<div sheet-name="<?php echo $sheetName; ?>">
    <div range="A25:H45">
        <?php
        Table::create(array(
            "name" => "customerSales",
            "dataSource" => $this->dataStore('sales'),
        ));
        ?>
    </div>
    <div range="A25:H45">
        <?php
        BarChart::create(array(
            'excelDataSource' => 'customerSales', 
        ));
        ?>
    </div>
</div>
```

### Excel style array

For some elements in the template file you could set their excel style. A style array can dictate some main excel styles: 

```
<?php
    $styleArray = [
        'font' => [
            'name' => 'Calibri', //'Verdana', 'Arial'
            'size' => 30,
            'bold' => false,
            'italic' => FALSE,
            'underline' => 'none', //'double', 'doubleAccounting', 'single', 'singleAccounting'
            'strikethrough' => FALSE,
            'superscript' => false,
            'subscript' => false,
            'color' => [
                'rgb' => '000000',
                'argb' => 'FF000000',
            ]
        ],
        'alignment' => [
            'horizontal' => 'general',//left, right, center, centerContinuous, justify, fill, distributed
            'vertical' => 'bottom',//top, center, justify, distributed
            'textRotation' => 0,
            'wrapText' => false,
            'shrinkToFit' => false,
            'indent' => 0,
            'readOrder' => 0,
        ],
        'borders' => [
            'top' => [
                'borderStyle' => 'none', //dashDot, dashDotDot, dashed, dotted, double, hair, medium, mediumDashDot, mediumDashDotDot, mediumDashed, slantDashDot, thick, thin
                'color' => [
                    'rgb' => '808080',
                    'argb' => 'FF808080',
                ]
            ],
            //left, right, bottom, diagonal, allBorders, outline, inside, vertical, horizontal
        ],
        'fill' => [
            'fillType' => 'none', //'solid', 'linear', 'path', 'darkDown', 'darkGray', 'darkGrid', 'darkHorizontal', 'darkTrellis', 'darkUp', 'darkVertical', 'gray0625', 'gray125', 'lightDown', 'lightGray', 'lightGrid', 'lightHorizontal', 'lightTrellis', 'lightUp', 'lightVertical', 'mediumGray'
            'rotation' => 90,
            'color' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'startColor' => [
                'rgb' => 'A0A0A0',
                'argb' => 'FFA0A0A0',
            ],
            'endColor' => [
                'argb' => 'FFFFFF',
                'argb' => 'FFFFFFFF',
            ],
        ],
    ];
?>
```

## Export setting

In normal export command you could set export option like "dataStores" or setting like "useLocalTempFolder" together in the first parameter. 

```
$optionAndSetting = [
    "dataStores" => ...,
    "useLocalTempFolder" => true,
];
$report->run()
->exportToExcel($optionAndSetting)
// ->exportToCSV($optionAndSetting)
->toBrowser("myreport.xlsx");
```
With template export you could set export setting using the second parameter.

```
$setting = [
    "useLocalTempFolder" => true,
];
$report->run()
->exportToExcel($template, $setting)
// ->exportToXLSX($template, $setting)
// ->exportToODS($template, $setting)
->toBrowser("myreport.xlsx");
```

### useLocalTempFolder

By default export uses system temporary directory to save temp files. If you set "useLocalTempFolder" = true, a "tmp" directory in the current report direction would be created and used instead. Since version 10.0.0, you could set "useLocalTempFolder" to be a path to any directory to be used as a temporary one.

```
$setting = [
    "useLocalTempFolder" => "../../temp", // a relative or an absolute path
];
$report->run()
->exportToExcel($template, $setting)
...
```

### autoDeleteTempFile (version >= 10.0.0)

Be default export temporary files are generated and kept in temporary directory. You could choose to delete them after export finishes with "autoDeleteTempFile" = true.

```
$setting = [
    "useLocalTempFolder" => "../../temp",
    "autoDeleteTempFile" => true
];
$report->run()
->exportToExcel($template, $setting)
...
```

## Export to huge xlsx, ods and csv files (version >= 7.0.0)

If you don't need chart or pivottable in your spreadsheet file, `BigSpreadsheetExportable` trait helps you to export huge data faster and uses much less memory than ExcelExportable or CSVExportable.

Since version 10.0.0, BigSpreadsheetExportable trait's csv export function is renamed to `exportToBigCSV` to avoid duplicate name with CSVExportable trait's one. Since this version CSVExportable's `exportToCSV` is noticeably faster than BigSpreadsheetExportable's `exportToBigCSV` and has many more options like "enclosure", "nullString", etc.

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\excel\BigSpreadsheetExportable;
    ...
}
```

Then now you can export your report to spreadsheet like this:

```
<?php
$report = new MyReport;
$report->run()
->exportToXLSX()
//->exportToODS()
//->exportToBigCSV()
->toBrowser("myreport.xlsx");
```

### Normal spreadsheeet exporting options

Defines datastores for exporting:

```
<?php
$report = new MyReport;
$report->run()
->exportToXLSX(
//->exportToODS(
//->exportToBigCSV(
    array(
        "dataStores" => array(
            'salesReport' => array(
                // all columns are exported
            )
        )
    )
)->toBrowser("myreport.xlsx");
```

Columns option:

```
<?php
$report = new MyReport;
$report->run()->exportToXLSX(array(
    "dataStores" => array(
        'salesReport' => array(
            "columns"=>array(
                0, 1, 2, 'column3', 'column4' // the 1st, 2nd, 3rd columns and column with names "column3", "column4" are exported
            )
        )
    )
))->toBrowser("myreport.xlsx");
```

### Pivot spreadsheet exporting options 

Since version 10.0.0, BigSpreadsheetExportable supports Pivot datastore export and PivotTable/PivotMatrix widget.

## Spreadsheet export template

You could programmatically set up a template file for spreadsheet export similar to a report's view file.

```
<?php
//exportSpreadsheet.php
include "MyReport.php";
$report = new MyReport;
$report->run();
$setting = ['useLocalTempFolder' => true];
$report
->exportToXLSX(
//->exportToODS(
    'MyReportSpreadsheet', $setting
)
->toBrowser("MyReport.xlsx");

$report->exportToBigCSV(array(
    'dataStores' => array(
        'orders' => array(
            'columns' => array('Customer', 'Total', 0, 1),
        ),
    ),
    'BOM' => false,
    'fieldDelimiter' => ';',
    'useLocalTempFolder' => true,
))
->toBrowser("MyReport.csv");
```

```
<?php
//MyReportSpreadsheet.view.php
<?php
    use \koolreport\excel\Text;
    use \koolreport\excel\Table;
?>
<div sheet-name="<?php echo $sheetName; ?>">
    <div>
        Report <?php echo $reportName; ?>
    </div>

    <div translation="2:4">
        Text::create([
            "text" => "Orders List of Sales"
        ]);
    </div>

    <div translation="3:5">
        <?php
        Table::create(array(
            "dataSource" => $this->dataStore('orders'),
        ));
        ?>
    </div>
</div>
```

To use a spreadsheet export template file, pass its name (without the extension '.view.php') to the exportToXLSX(), exportToODS() or exportToCSV() method.

In the template file, have access to your report via $this as well as its parameters $this->params and datastore $this->datastore().

The template file consists of 2 level of div tags. Each first level div represents a separated worksheet (applicable for xlsx and ods files only).

```
<div sheet-name="sheet1">
</div>
```

Second level divs represents blocks of content in each worksheet. A block of content could be some text or a table. Each block of content could have its top-left cell set via the div's `translation` attribute. This attribute translates content by {number of columns}:{number of rows}.

 
```
<div sheet-name="sheet1">
    <div translation="2:4">
        Report <?php echo $reportName; ?>
    </div>
</div>
```

Unlike excel export, for big spreadsheet export we can only use the Table and Text widgets. It's because big spreadsheet utilizes streaming data to file to reduce memory footprint when exporting millions of data rows. This type of streaming rows doesn't allow for chart or pivot table formats.

When setting a datasource for a Table, you could use either a datastore name or a datastore object of the your report. 

```
<?php
//MyReportExcel.view.php
<?php
    use \koolreport\excel\Table;
?>
<div sheet-name="sheet1">
    <div>
        <?php
        Table::create(array(
            "dataSource" => $this->dataStore('orders'),
        ));
        ?>
    </div>
</div>
```

### Spreadsheet style array

For some elements in the template file you could set their spreadsheet style. A style array can dictate some main spreadsheet styles: 

```
<?php
    $spreadsheetStyleArray = [
        'font' => [
            'bold' => false,
            'italic' => true,
            'underline' => false,
            'strikethrough' => true,
            'name' => 'Arial',
            'size' => '14',
            'color' => '808080',
        ],
        'border' => [
            // 'color' => '000000',
            'width' => 'thick', //'thin', 'medium', 'thick'
            // 'style' => 'solid', //'none', 'solid', 'dashed', 'dotted', 'double'.
            'top' => [
                'color' => '000000',
                'width' => 'medium', //'thin', 'medium', 'thick'
                'style' => 'solid', //'none', 'solid', 'dashed', 'dotted', 'double'.
            ],
            'right' => [],
            'bottom' => [],
            'left' => [],
        ],
        'backgroundColor' => '00ff00',
        'wrapText' => true,
    ];;


?>
```

## Text widget (version >= 6.0.0)

Using an Excel's Text widget for exporting text content together with some properties. This widget works in both Excel and spreadsheet template files.

```
<div>
    <?php
    \koolreport\excel\Text::create([
        "text" => "Orders",
        "excelStyle" => $styleArray,//used in ExcelExportable's template
        "spreadsheetStyle" => $spreadsheetStyleArray // used in ExcelExportable's template
    ]);
    ?>    
</div>
```

### Text
A string to define the displayed text value. This widget works in both Excel and spreadsheet template files.

### excelStyle
A style array to define style of the text cell when using ExcelExportable

### spreadsheetStyle (version >= 7.0.0)
A style array to define style of the text cell when using BigSpreadsheetExportable


## Table widget (version >= 6.0.0)

Using an Excel's Table widget for exporting a table using a datasource and other properties. This widget works in both Excel and spreadsheet template files.

```
<div>
    <?php
    \koolreport\excel\Table::create(array(
        "dataSource" => 'orders',
        //"dataSource" => $this->dataStore('orders'),
        
        "filtering" => function($row, $index) { 
            if (stripos($row['customerName'], "Baane Mini Imports") !== false)
                return false;
            return true;
        },
        //"filtering" => ['age','between',45,65],

        "sorting" => ['dollar_sales' => function($a, $b) {
            return $a >= $b;
        }],
        //"sorting" => ['dollar_sales' => 'desc'],

        "paging" => [5, 2],

        "showHeader" => false, //default: true

        "showBottomHeader" => true, //default: false

        "showFooter" => true, //default: false

        "map" => [
            "header" => function($colName) { return $colName; },
            "bottomHeader" => function($colName) { return $colName; },
            "cell" => function($colName, $value, $row) { return $value; },
            "footer" => function($colName, $footerValue) { return $footerValue; },
        ],

        "excelStyle" => [ //used in ExcelExportable's template
            "header" => function($colName) { 
                return $styleArray; 
            },
            "bottomHeader" => function($colName) { return []; },
            "cell" => function($colName, $value, $row) { 
                return $styleArray; 
            },
            "footer" => function($colName, $footerValue) { return []; },
        ],

        "spreadsheetStyle" => [ //used in BigSpreadsheetExportable's template
            "header" => function($colName) { 
                return $styleArray; 
            },
            "bottomHeader" => function($colName) { return []; },
            "cell" => function($colName, $value, $row) { 
                return $styleArray; 
            },
            "footer" => function($colName, $footerValue) { return []; },
        ],

        "rowGroup" => [
            "customerName" => [
                'direction' => 'desc',
                'calculate' => [
                    'totalSales' => ['sum', 'dollar_sales']
                ],
                "top" => "Customers: {customerName}",
                "columnTops" => [
                    "dollar_sales" => "Total sales: {totalSales}"
                ],
                "bottom" => "Customers: {customerName}",
                "columnBottoms" => [
                    "dollar_sales" => "Total sales: {totalSales}"
                ],
            ],
            "productLine" => [
                "top" => "Product line: {productLine}",
            ]
        ]
    ));
    ?>
</div>
```

### filtering
Filtering data with either an array in the form of [field, operator, value1, ...] or a function returning true or false on a row. Inherit from a DataStore's filter method.

### sorting
Sorting data with an array in the form of [[field1, direction1], ...] where direction is either "asc" or "desc" or a comparing function. Inherit from a DataStore's sort method.

### paging
Paging data with an array in the form of [page size, page number]. Inherit from a DataStore's paging method.

### showHeader
A boolean value to either show or hide the table's header. Default value is true.

### showBottomHeader
A boolean value to either show or hide the table's bottom header. Default value is false.

### showFooter
A boolean value to either show or hide the table's footer which shows each column's footerText and/or aggregate method like "sum", "count", etc. The footer properties should be defined in the datastore's columns' metadata. Default value is false.

```
 ->pipe(new ColumnMeta(array(
    "amount"=>array(
        "name"=>"sale_amount"
        "footer"=>"sum",
        "footerText"=>"Total: @value",
    ),
 )))
```

### map
An array of functions returning string value to map the table's headers, bottom headers, footers and cells values

```
    "map" => [
        "header" => function($colName) { return $colName; },
        "bottomHeader" => function($colName) { return $colName; },
        "cell" => function($colName, $value, $row) { return $value; },
        "footer" => function($colName, $footerValue) { return $footerValue; },
    ],
```

### excelStyle

An array of functions returning excel style array to set the excel style of the table's headers, bottom headers, footers and cells when using ExcelExportable

```
    "excelStyle" => [
        "header" => function($colName) { 
            ...
            return $styleArray; 
        },
        "bottomHeader" => function($colName) { 
            ...
            return $styleArray; 
        },
        "cell" => function($colName, $value, $row) { 
            ...
            return $styleArray; 
        },
        "footer" => function($colName, $footerValue) { 
            ...
            return $styleArray;  
        },
    ]
```

### spreadsheetStyle (version >= 7.0.0)

An array of functions returning style array to set the style of the table's headers, bottom headers, footers and cells when using BigSpreadsheetExportable

```
    "spreadsheetStyle" => [
        "header" => function($colName) { 
            ...
            return $styleArray; 
        },
        "bottomHeader" => function($colName) { 
            ...
            return $styleArray; 
        },
        "cell" => function($colName, $value, $row) { 
            ...
            return $styleArray; 
        },
        "footer" => function($colName, $footerValue) { 
            ...
            return $styleArray;  
        },
    ]
```

### rowGroup (version >= 8.0.0)

You could define multiple row groups for the Table widget like this example:

```
    <?php
    \koolreport\excel\Table::create(array(
        ...
        "rowGroup" => [
            "customerName" => [
                'direction' => 'desc',
                'calculate' => [
                    'totalSales' => ['sum', 'dollar_sales']
                ],
                "top" => "Customers: {customerName}",
                "columnTops" => [
                    "dollar_sales" => "Total sales: {totalSales}"
                ],
                "bottom" => "Customers: {customerName}",
                "columnBottoms" => [
                    "dollar_sales" => "Total sales: {totalSales}"
                ],
            ],
            "productLine" => [
                "top" => "Product line: {productLine}",
            ]
        ]
    ));
    ?>
```
In each row group, you have the following properties:

| Property   |      Default value      |  Meaning | Example values |
|----------|-------------|------|-----|
| direction |  "asc" | Sorting direction of a row group | "asc", "desc" |
| calculate |    []   |   List of aggregated measurement in the form of [$aggregatedOperator, $field] | ["totalSales" => ["sum", "dollar_sales", "numberOfOrders" => ["count", "orderId"]] |
| top | "" |    Template string to fill in the main column of a top group row | Customer: {customerName} |
| bottom | "" |    Template string to fill in the main column of a bottom group row | Product: {productName}  |
| columnTops | [] |    List of template strings to fill in table columns of a top group row | ["customerName" => "Number of sales: {numberOfOrders}"]     |
| columnBottoms | [] |    List of template strings to fill in table columns of a bottom group row |  ["customerName" => "Total sales: {totalSales}"] |

Since version 10.0.0 you could format rowGroup's values by setting the calculated column meta type, decimals, decimalPoint, thousandSeparator or set "format" directly in "calculate":

```
    \koolreport\excel\Table::create(array(
        ...
        "rowGroup" => [
            "customerName" => [
                'direction' => 'desc',
                'calculate' => [
                    'totalSales' => [
                        'sum', 'dollar_sales', 
                        'format' => [
                            "type" => "number",
                            "decimals" => 2,
                            "decimalPoint" => ",",
                            "thousandSeparator" => ".",
                            "suffix" => "%" 
                        ]
                    ]
                ],
```


### removeDuplicate (version >= 8.5.0)

Similarly to core\Table widget's `removeDuplicate`, this property if set true would merge continuous row cells with the same values. Since version 9.0.0 this property works with both column names and column orders:

```
    \koolreport\excel\Table::create(array(
        ...
        "removeDuplicate" => [0, 1] // ["customerName", "productLine"]
    ));
```
Since version 10.5.0 this property works for both excel and bigspreadsheet exports.

### rowspan (version >= 9.0.0)

An alias for `removeDuplicate`.

### groupCellsInColumns (version >= 9.0.0)

An alias for `removeDuplicate`.

### complexHeaders (version >= 10.5.0)

Similarly to Datagrid's DataTables widget's "complexHeaders" property, this property of excel Table will merge similar prefix parts of continuous columns. For example, "Name - First" and "Name - Last" columns will have the same parent header called "Name":

```
    \koolreport\excel\Table::create(array(
        ...
        "columns" => ["Name - First", "Name - Last"]
        "complexHeaders" => true,
        "headerSeparator" => " - ", // by default "headerSeparator" = " - " though you can set it to any string you want
    ));
```
This property works for both excel and bigspreadsheet exports.

### complexHeaderLabels (version >= 10.5.0)

Similar to "complexHeaders" but it merges headers based on column labels instead of column keys:

```
    \koolreport\excel\Table::create(array(
        ...
        "columns" => [
            "firstName" => [
                "label" => "Name - First"
            ], 
            "lastName" => [
                "label" => "Name - Last"
            ]
        ],
        "complexHeaderLabels" => true,
        "headerSeparator" => " - ",
    ));
```

### mergeCells (version >= 10.5.0)

By default "mergeCells" = true for Table's merged cells such as "complexHeaders" or "rowspan". If you export very large tables it's advisable to disable "mergeCells" to increase export speed. When "mergeCells" = false, we use blank borders to simulate merging cells so that visually a pivot table looks the same.

```
    \koolreport\excel\Table::create(array(
        ...
        "rowspan" => [0, 1] // ["customerName", "productLine"]
        "mergeCells" => false,
    ));
```

### excelFormatCode (version >= 8.5.0)

When your column is of type number (meta: "type" => "number") Table widget uses a default excel format code. But now users have further ability to set a custom excel format code like this:

```
    //MyReportExcel.view.php
    \koolreport\excel\Table::create(array(
        ...
        "columns" => array(
            "column1" => array(
                "type" => "number",
                "excelFormatCode" => "\"{$prefix}\"" . "+#,##0.00" . "\"{$suffix}\"",
            )
        )
    ));
```

### columnAutoSize (version >= 10.0.0)

By default "columnAutoSize" = true for Table widget when exporting to excel (no autosize option is availabe for big spreadsheet). You could disable it like this:

```
    //MyReportExcel.view.php
    \koolreport\excel\Table::create(array(
        ...
        "columnAutoSize" => false,
    ));
```

## Chart widget (version >= 6.0.0)

Using an Excel's Chart widget for displaying a chart with several properties. This widget only works in Excel template and not in spreadsheet template.

### dataSource

Either a datastore name or a datastore to act as a chart's data

### excelDataSource

An excel table name to act as a chart's data

### title

A string to be set as a chart's title

### xAxisTitle

A string to be set as a chart's X axis title

### yAxisTitle

A string to be set as a chart's Y axis title

### stacked

A boolean indicating whether a chart's bars, columns should be stacked or not. Default value is false

### direction

An enum string ('horizontal' or 'vertical') indicating a chart's X, Y axes. Default value is 'vertical'

```
<div>
    <?php
    \koolreport\excel\Table::create(array(
        "name" => "TableOrders",
        "dataSource" => 'Orders',
    ));
</div>

<div range="A2:H2">
    \koolreport\excel\LineChart::create([
        "dataSource" => $this->dataStore('Orders'),
        "dataSource" => "Orders",
        "excelDataSource" => "TableOrders",
        'title' => 'Sales Orders',
        'xAxisTitle' => 'Orders List',
        'yAxisTitle' => 'Sales($)',
        'stacked' => true, //default: true
        'direction' => 'horizontal', //default: 'vertical'
    ]);
    ?>    
</div>
```

## PivotTable widget (version >= 6.0.0)

Using an Excel's PivotTable widget for exporting a pivot table with several properties. This Excel package's PivotTable shares most of the properties with Pivot package's PivotTable widget including: "dataSource", "rowDimension", "columnDimension", "measure", "rowSort", "columnSort", "hideSubTotalRows", "hideSubTotalColumns", "hideTotalRow", "hideTotalColumn", "hideGrandTotalRow", "hideGrandTotalColumn", "showDataHeaders", "map". One difference between Excel's PivotTable and Pivot's one is that the former replace the later's "cssClass" map with "excelStyle" map. This widget only works in Excel template and not in spreadsheet template.

### excelStyle

An array of functions returning excel style array for a PivotTable's dataFields zone, column headers, row headers and data cells.

```
<div range="A2:H2">
    <?php
    \koolreport\excel\PivotTable::create(array(
        "dataSource" => 'salesPivot',
        "rowDimension" => "row",
        "columnDimension" => "column",
        "measures"=>array(
            ...
        ),
        'rowSort' => array(
            ...
        ),
        'columnSort' => array(
            ...
        ),
        'hideTotalRow' => true,
        'hideTotalColumn' => true,
        'hideSubTotalRows' => true,
        'hideSubTotalColumns' => true,
        'showDataHeaders' => true,
        'map' => array(
            'rowField' => function($rowField, $fieldInfo) {
                return $rowField;
            },
            'columnField' => function($colField, $fieldInfo) {
                return $colField;
            },
            'dataField' => function($dataField, $fieldInfo) {
                $v = $dataField;
            },
            'waitingField' => function($waitingField, $fieldInfo) {
                return $waitingField;
            },
            'rowHeader' => function($rowHeader, $headerInfo) {
                $v = $rowHeader;
                return $v;
            },
            'columnHeader' => function($colHeader, $headerInfo) {
                $v = $colHeader;
                return $v;
            },
            'dataCell' => function($value, $cellInfo) {
                return $value;
            },
        ),
        'excelStyle' => array(
            "dataFields" => function($dataFields) {
                ...
                return $styleArray;
            },
            'columnHeader' => function($header, $headerInfo) {
                ...
                return $styleArray;
            },
            'rowHeader' => function($header, $headerInfo) {
                ...
                return $styleArray;
            },
            'dataCell' => function($value, $cellInfo) {                    
                ...
                return $styleArray;
            },
        )
    ));
    ?>    
</div>
```

### mergeCells (version >= 10.0.0)

By default "mergeCells" = true for PivotTable's excel export. If you export very large pivot tables it's advisable to disable "mergeCells" to increase export speed. When "mergeCells" = false, we use blank borders to simulate merging cells so that visually a pivot table looks the same.

```
    \koolreport\excel\PivotTable::create(array(
        ...
        "mergeCells" => false,
    ));
```

### showDuplicateRowHeaders and showDuplicateColumnHeaders (version >= 10.0.0)

When "mergeCells" = false, you have options to show duplicate row/column headers.

```
    \koolreport\excel\PivotTable::create(array(
        ...
        "mergeCells" => false,
        "showDuplicateRowHeaders" => true,
        "showDuplicateColumnHeaders" => true,
    ));
```

## PivotMatrix widget (version >= 9.0.0)

This widget is similar to the PivotTable one except that it uses a little different template which shows both the row and column fields.

## Export to CSV (version >= 3.0.0)

CSVExportable trait allows you to export datastores to CSV files. Since version 10.0.0, this is the preferable CSV export function because it's much faster than BigSpreadsheetExportable trait's exportToBigCSV and has a lot more options.

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\excel\CSVExportable; // preferable since version 10.0.0
    // use \koolreport\excel\BigSpreadsheetExportable;
    ...
}
```

### CSV exporting options

`delimiter`, `fieldDelimiter`, `separator`, `fieldSeparator` option defines a string used to separate columns in the exported CSV file. Default value is a comma.
`'columns'` option is an array defining a list of columns in the exported CSV file. Values could be either column indexes, column keys or column labels. if not specified, all columns are exported. `"BOM"` parameter takes boolean value, default is `false`, BOM determine whether exported CSV will use UTF8 Bit Order Mark (BOM).

```
<?php
$report = new MyReport;
$report->run()->exportToCSV('salesReport', array(
    'delimiter' => ';',
    "columns"=>array(
        0, 1, 2, 'column3', 'column4'
    )
    "BOM"=>false,
))->toBrowser("myreport.csv");
```
Since version 10.0.0, there're a whole lot of CSV export options added:

```
$report = new MyReport;
$report->run();
$report->exportToCSV(
    array(
        "dataStores" => array(
            "ordersExport" => [
                "separator" => ",", // default separator = "," i.e. comma
                "enclosure" => "\"", // default general enclosure = "" i.e. empty string
                "enclosure" => ["(", ")"], // all enclosure property could be a 2 element array
                "typeEnclosures" => [
                    "string" => "\"", // default string enclosure is general enclosure
                    "date" => "\"", // default date enclosure is general enclosure
                    "datetime" => "\"", // default datetime enclosure is general enclosure
                    "number" => "", // default number enclosure = "" i.e. empty string
                    "boolean" => "", // default boolean enclosure = "" i.e. empty string
                ],
                'nullEnclosure' => "", // default = "" i.e empty string
                'nullString' => "NULL", // default = false i.e empty string for null value
                'useColumnFormat' => 1, // default = 1, set = 0 to increase export speed
                'useEnclosureEscape' => 1, // default = 1, set = 0 to increase export speed
                'useTypeEnclosure' => 1, // default = 1, set = 0 to increase export speed     
                "escape" => "\\", // if escape is empty/undefined, double enclosures will be used
                "eol" => "\n", // define End of line character, default eol is "\n"
                "columns"=>array(
					"customerName",
					"productName",
					"productLine",
					"orderDate",
					"orderMonth",
					"orderYear",
					"orderQuarter",
					"dollar_sales" => [
                        "type" => "number",
                        "enclosure" => ["<", ">"], // to apply custom column enclosure "useCustomColumnEnclosure" must be true
                        "headerEnclosure" => "\"",
                        "nullEnclosure" => "",
                        "nullString" => "nULL",
                        "enclosureEscape" => "\"",
                    ]
				),  
                'useCustomColumnEnclosure' => 0, // default = 0
                'useCustomColumnNullString' => 0, // default = 0
                'useCustomColumnEnclosureEscape' => 0, // default = 0             
            ],
        ),

        "useLocalTempFolder" => true,
        "BOM" => false, // default bom = false
        "buffer" => 1000, // unit: KB ~ 1000 bytes. Default buffer = 1000 KB
    ),
)
->toBrowser("orders.csv");
```
With version 10.0.0 CSV export speed is seriously optimized. Exporting hundreds of thousands of rows takes from seconds to more than ten seconds depending how many complex options you set.

Since version 10.5.0 we add "footer" (possible values: "sum", "count", "avg", "min", "max"), "footerText", and "footerFormat" for "columns" setting in CSV export:

```
$report = new MyReport();
$report->run()->exportToCSV(
    array(
        "dataStores" => array(
            "salesDatastore" => [
                "columns"=>array(
					...
					"dollar_sales" => [
                        "type" => "number",
                        "footer" => "sum",
                        "footerText" => "Total: @dollar_sales",
                        "footerFormat" => ["type" => "number", "decimals" => 2, "prefix" => "$"],
                        "footerFormat" => function($sum, $colMeta) { return ...; },
                    ]
				),  
            ],
        ),
    ),
)
->toBrowser("orders.csv");
```

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.
