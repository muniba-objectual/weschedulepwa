# Change Log

## Version 7.7.0

1. Fix: reset rows when searching while there're collapse row groups.
2. Add "complexHeaderLabels" property to create complex (merged) headers using column labels instead of column key.

## Version 7.6.0

1. Add: "smart" searchMode which uses DataTables' default smart search beside "or|and" regular expression search.
2. Change: make "smart" searchMode default.

## Version 7.5.0

1. Add: column's `aggregates` meta for multiple columns, operators to show in footer. Works even when "serverSide" => true. 
2. Add: `serverSideInstantSearch` property to force instant search when "serverSide" => true.
3. Change: `clientRowGroup` to work when "serverSide" => true.
4. Change: column's `footer` meta to work when "serverSide" => true.
5. Change: column's `orderable` meta to work when "serverSide" => true.
6. Change: column's `formatValue` meta to work when "serverSide" => true.
7. Fix: when there are multiple DataTables with "serverSide" => true.
8. Add: `cssStyle`, similar to `cssClass` and `attributes`.
9. Add: subproperties `trJs` and `tdJs` of `cssClass`, `cssStyle`, `attributes` for accessing client row data object when "fastRender" => true
10. Add: `overrideSearchInput` property for some plugins like mark.js (highlighting input search) to work.
11. Add: ability to load custom plugin js in either "DataTables" subdirectory or anywhere.
12. Update DataTables' Bootstrap4 CSS for option "pagingType" => "input".

## Version 7.0.0

1. Make `clientRowGroup`'s groups expand/collapse and show/hide states persistent across sorting, filtering.
2. Add methods `expandAllGroups`, `collapseAllGroups`, `toggleAllGroups`, `expandRowDetail`, `collapseRowDetail`, `toggleRowDetail`, `expandAllRowDetails`, `collapseAllRowDetails`, `toggleAllRowDetails` for the js KR table object.
3. Add property `rowspan` (alias `removeDuplicate`, `groupCellsInColumns`) to merge continuous cells with the same value for certain columns.
4. Bug fixed: `avg` aggregate for `clientRowGroup`.
5. Add `ajaxUrl` property for server side processing for use in Single Page App.

## Version 6.0.0

1. Update `clientRowGroup` to make child row group replace parent group names.
2. Add FixedHeader plugin's css file by default to work in Laravel.
3. Bug fix for FixedHeader plugin style in Bootstrap 4.
4. Bug fix for argument row (use original datastore's row with all columns) in cssClass and attributes.
5. Bug fix for `scope` when using serverSide = true.
6. Add option for server side: only search searchable columns and order orderable ones.
7. Add `searchQuery` property with "{datatables_search}" place holder to allow users to optimize server side searching.
8. Add "exact", "and" modes to `searchMode` ("or|and|exact") for both server side and client side searching.
9. Change search behavior, if `serverSide` = true, always search on enter.

## Version 5.0.2

1. Fix some resource files copying and loading when assets path and url are set.

## Version 5.0.1

1. Fix a bug when a column's formatValue is callable return a widget.

## Version 5.0.0

1. Add "clientRowGroup" property.
2. Add "fastRender" property.
3. Add "rowDetailData" property.
4. Add a number of columnDefs' client options to columns' server options

## Version 4.0.1

1. Fix DataTables' bootstrap4 css and js.

## Version 4.0.0

1. Add "defaultPlugins" and "plugins" properties to load various DataTables' plugins.

## Version 3.3.0
1. Add client-side `onBeforeInit` event.

## Version 3.2.1
1. Fix server-side sorting bug
2. Adding dutch (nl) localization for DataTables

## Version 3.2.0
1. Add callable "attributes" map for table, th, tf, tr, td elements in DataTables.
2. Change serverSide's data rendering from using html comment to using custom tag.

## Version 3.1.0
1. Fix server side's request processing
2. Update DataTables' client css, js and resources to latest version

## Version 3.0.0
1. Add ability to display complex headers
2. Add option to only search when clicking enter
3. Add searching mode to use OR operator when searching: searchOnEnter
4. Make server side searching work similarly to client side one: searchMode

## Version 2.5.1

1. Fix the datatables css name

## Version 2.5.0

1. Fix the bs4 theme for DataTables
2. Fix the onReady client event handler

## Version 2.0.0

1. DataTables: Support bootstrap 4


## Version 1.5.0

1. Update footer formatValue
2. Use Utility::jsonEncode() to enable writing anonymous js function in options
3. Add data-order and data-search to DataTables' columns setting like this:
    'columns' => [
        'customerName' => [
            'data-order' => 'customerNumber',
            'data-search' => 'customerFullName',
        ],
    ]
    
## Version 1.2.0

1. DataTables: Add: cssClass option for table, th, tr, td, tf.
2. DataTables: Fix: tfooter -> tfoot.
3. DataTables: Fix: clientEvents like "select" not run.


## Version 1.1.0

1. DataTables:Remove dataStore and use the default dataSource/dataStore f1m Widget
2. DataTables: Adding formatValue capability
3. Improve the client library loading.

## Version 1.0.0

1. Adding `DataTables` widget.