# Change Log

## Version 10.5.1
1. Fix CSV export's column label setting in export command.

## Version 10.5.0
1. Fix TableBuilder's cellMap in buildTableBodyRow.
2. Fix TableBuilder's row group's missing bottom row.
3. Fix CSV export's columns order issue.
4. Add `complexHeaders` property for Table in Excel and BigSpreadsheet export.
5. Fix `rowspan` bug if all rows have the same value.
6. Add `rowspan` property for BigSpreadsheet table export
7. Add `footer` (possible values: "sum", "count", "avg", "min", "max"), `footerText`, `footerFormat` subproperties for `columns` settings to export to CSV

## Version 10.0.0
1. Add `mergeCells` property for PivotTable, PivotMatrix to increase exporting speed by a lot when setting "mergeCells" => false.
2. Add `showDuplicateRowHeaders` and `showDuplicateColumnHeaders` properties for PivotTable, PivotMatrix when "mergeCells" => false.
3. Optimize memory and speed when exporting Table to BigSpreadsheet (90.000 rows, 9 columns in about 25 seconds).
4. Optimize memory when exporting Table to Excel.
5. Add `columnAutoSize` property (default = true) for Table.
6. Add PivotTable/PivotMatrix export to BigSpreadsheet
7. Add support for all table and pivottable options when exporting datastores directly.
8. ExportToCSV: add `enclosure`, `typeEnclosures`, `headerEnclosure`, `nullEnclosure`, `nullString`, `escape`, `eol`, `buffer` in setting.
9. ExportToCSV: add `enclosure`, `typeEnclosures`, `headerEnclosure`, `nullEnclosure`, `nullString`, `escape` in columns setting to override general setting.
10. Add Table's row group calculate's `format` property.
11. Add `autoDeleteTempFile` and `autoDeleteLocalTempFile` settings.
12. Support `useLocalTempFolder` to be a custom directory.
13. Rename method `exportToCSV` of trait BigSpreadsheetExportable to `exportToBigCSV` to avoid duplication of ExcelExportable's exportToCSV.
 
## Version 9.0.0
1. Fix Tabble's footerText when there's no footer map.
2. Fix "cell" range for PivotTableBuilder.
3. Make default footer value to be empty instead of column label.
4. Excel Table: Add alias `rowspan` and `groupCellsInColumns` to `removeDupliate`.
5. Excel Table: Make `removeDupliate` work with both column names and column orders.
6. Add `PivotMatrix` widget.

## Version 8.5.1
1. Update phpspreadsheet version to 1.*

## Version 8.5.0
1. Add "removeDuplicate" for Table widget.
2. Add "excelFormatCode" for Table's column meta.
3. Bug fix for Table's row group builder.
4. Bug fix for Table's number format code.
5. Add group value argument to excelStyle's "rowGroup" style.

## Version 8.0.1
1. Change PHPSpreadSheet version to work with PHP 7.1

## Version 8.0.0
1. Add `rowGroup` property for exporting Table widget to excel and big spreadsheet.
2. Fix Chart bug not showing in MS Excel since PHPSpreadsheet 1.10

## Version 7.2.0
1. Several bug fixes for chart axis and big spreadsheet's column setting.
2. Add more axis options for excel chart.
3. Add "hideChartDataSheet" setting when exporting with excel template.
4. Update "phpoffice/phpspreadsheet" and "box/spout" versions.

## Version 7.1.1
1. Fix bug for ExportHandler when data is empty.

## Version 7.1.0
1. Fix `PieChart` and some single-series charts to be correct format in MS Office.

## Version 7.0.0
1. Add BigSpreadsheetDataSource to read huge excel, ods and csv files.
2. Add BigSpreadsheetExportable trait to export to huge excel, ods and csv files.

## Version 6.0.0
1. Change excel template file from <file>.excel.php to standard <file>.view.file
2. Add "filtering", "sorting", "paging", "showHeader", "showBottomHeader", "shotFooter", "map" and "excelStyle" to Excel's Table widget
3. Add "hideSubTotalRows", "hideSubTotalColumns", "hideGrandTotalRow", "hideGrandTotalColumn", "showDataHeaders" and "excelStyle" to Excel's PivotTable widget
4. Add Excel's Text widget

## Version 5.1.0
1. Internal: move functions from exportable trait to export handler object to prevent polluting report object
2. Fix excel export column order problem

## Version 5.0.0

1. Export to Excel using php template file.
2. Support text, table, pivot table and multiple chart types in template export.
3. Customize style including font, alignment, border and fill for text, table.

## Version 3.2.0

1. CSVExportable: Adding BOM options.

## Version 3.0.0

1. CSVExportable: New trait allows exporting to CSV files.
2. Add option like 'columns' for ExcelExportable.

## Version 2.1.0

1. ExcelDataSource: Add: sheetName and sheetIndex properties for loading only those sheets.