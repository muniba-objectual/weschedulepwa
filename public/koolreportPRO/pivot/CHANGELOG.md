# Change Log

## Version 9.0.1
1. Fix undefined index in PivotUtil when data is empty.

## Version 9.0.0
1. Add "count distinct", "sum distinct", "count not null" operators for Pivot and Pivot2D processes.
2. Add "computations" for Pivot / Pivot2D processes' aggregates.
3. Add "computations" for Pivot / Pivot2D processes' dimension fields.
4. Add "rowTotalAtBeginning" and "columnTotalAtBeginning" properties for PivotTable / PivotMatrix.
5. Merge "measures" array values of PivotTable / PivotMatrix to their datastore's column meta.
6. Fix PivotTable's / PivotMatrix's "rowSort", "columnSort" bug when there're multiple rows / columns with the same data values.
7. Fix Bug in PivotTable's / PivotMatrix's Total number when there are more than 2 dimensions in Pivot process.

## Version 8.5.0

1. Add more information for row, column, and data header info argument in `map` of "rowHeader", "columnHeader", "dataHeader".
2. Optimize memory usage (by a factor of 2 to 10 times less) for PivotUtil processing for Pivot rendering or exporting.
3. Add PivotTable's map's `dataFieldZone` to customize the whole zone instead of just individual data field.
4. Fix PivotMatrix column headers height in Firefox.
5. Add multiple events for config, viewstate, command, update.
6. Add `serverPaging` property for PivotMatrix.

## Version 8.1.0

1. Fix meta for "count", "count percent", "sum percent" fields.
2. Fix "ajaxUrl" typo PivotMatrix.js.

## Version 8.0.0

1. Add "initVisible" property to disable PivotTable's initial display=none until after loading.
2. Fix sql error in PivotSQL process for some databases like SQL Server.
3. Fix cache bug when users change sql query for PivotSQL.
4. Add query params support for PivotSQL.
5. Some minor bug fixes for null check in Pivot process and PivotMatrix js.
6. Deep convert scope to post string.
7. Add custom Pivot process' id.
8. Bug fix for PivotSQL to be able to sort by measures.
9. Add "ajaxUrl" property for PivotMatrix to customize its update ajax url instead of the default current location href.

## Version 7.0.0

1. Add PivotSQL process for handling large datasets.

## Version 6.3.0

1. add "{finalValue}" option for custom aggregate.

## Version 6.2.1

1. Bug fix for some edge cases.

## Version 6.2.0

1. Fix font-awesome 5 icons
2. Add div wrapper for data field zone of PivotTable
3. Keep PivotMatrix's field state even when data is empty
4. Make PivotUtil's headerMap and map compatible

## Version 6.1.2

1. Revert PivotTable's javascript es6 for it to work with Phantomjs
2. Add pivotRows and pivotColumns to PivotMatrix's javascript object

## Version 6.1.1

1. Fix PivotUtil's headerMap property compatibility
2. Fix PivotMatrix's update when there're multiple matrixes per page

## Version 6.1.0

1. Add "rowCollapseLevels" and "columnCollapseLevels" to PivotMatrix
2. Add class names and attributes to PivotMatrix's elements to support customization
3. Fix some possible js bug in PivotMatrix.js and PivotTable.js
4. Fix mappedNode in PivotUtil's getDataAttributes to show data cells' formatted values
5. Fix PivotMatrix's paging bug with first row

## Version 6.0.1

1. Fix PivotMatrix's Bun template error

## Version 6.0.0

1. Add process Pivot2D to create pivot datastore in normal table format.
2. Add custom aggregate to Pivot and Pivot2D processes.
3. Add "cssClass" map for PivotTable and PivotMatrix.
4. Add "hideGrandTotalRow" and "hideGrandTotalColumn" to PivotTable and PivotMatrix.

## Version 5.0.0

1. Add Bun template for both PivotMatrix and PivotTable.
2. Fix PivotMatrix's hideSubtotalRow when there're a lot of them.

## Version 4.3.0

1. Fix pivot's excel export.

## Version 4.2.0

1. Add 'hideSubtotalRow' and 'hideSubtotalColumn' to PivotTable and PivotMatrix widgets.

## Version 4.1.0

1. Add 'sum percent' and 'count percent' to Pivot process.


## Version 4.0.0

1. PivotMatrix: Fix: getTotalOffset in PivotMatrix.js. 
2. PivotMatrix: Fix: escape quote in header's dataset.node and in json_encode($config). 
3. PivotMatrix: Add: column header, row header and data cell Total css classes. 
4. PivotMatrix: Add: dataset row-field and column-field for data cells. 
5. PivotMatrix: Add: event 'afterFieldMove' AFTER each field move update. 
6. PivotMatrix: Add: expandUptoLevel function. 
7. PivotMatrix: Add: krpmRowHeaderTotal, krpmColumnHeaderTotal, krpmDataCellRowTotal, krpmDataCellColumnTotal, krmpDataCellRowTotalTr class to to help hide subtotal row.  
8. Pivot: Add: command "expand" => level. 


## Version 3.3.0

1. Bug fix: Move field to empty row or column zones.
2. Feature: Add PivotExtract process to extract tabular data from pivot data.

## Version 3.2.0

1. Minor javascript bug fixes.
2. Add property "partialProcessing" for Pivot process to increase speed.
3. Add property 'columnWidth' for PivotMatrix widget.
 
## Version 3.0.1

1. Fix the average calculation in Pivot    

## Version 3.0.0

1. Add PivotMatrix widget for dragging and dropping fields, sorting, paging, scrolling. 
2. Incremental processing: only compute necessary pivot data at the visible level. Compute more when users click expand/collapse.