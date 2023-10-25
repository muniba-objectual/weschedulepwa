# Introduction

`DataGrid` is a package to extend capability of displaying data in table format.

# Installation

1. Download and unzip the package.
2. Copy the `datagrid` folder into `koolreport` folder.

# Documentation

## DataTables

`DataTables` is an advanced solution to display data in table format. Beside the basic feature of displaying data, it supports features such as Row Search, Select, Column Reordering, Fixed Columns, Responsive, Row Group, Scrolling.

### Get started with DataTables

It is simple to setup `DataTables` to display data. Suppose you have had your dataStore and would like to display data in report's view.

__First, you need to declare the class at top of the view__

```
<?php
use \koolreport\datagrid\DataTables;
?>
```

__Second, you create the `DataTables` widget__

```
<?php
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders")
))
?>
```

Simple, isn't it? With above minimum settings, `DataTables` will load data from `orders` dataStore and display all data.

### Properties

|name|type|default|description|
|---|---|---|---|
|`name`|string||Optional. You can set the name for your data table if you want to refer to the table later on at client-side. If you don't set we will set random name for table|
|`columns`|array||Optional. List all the columns you want to display in data table together with its settings|
|`dataSource`|DataStore, Array, function||Optional. Specify a dataStore, an array or a function that data table will get data from. If you do not set this, thed data table will get data from `data` property|
|`data`|array||Optional. You may set data directly here in form of associate array|
|`emptyValue`|string|"-"|Optional. Empty value is used to replace missing data in rows.|
|`options`|array||Optional. This property will hold all the extra settings for data tables|
|`cssClass`|array||Optional. You could set css classes for the table's table, th, tr, td, tf elemens.| 
|`attributes`|array||Optional. You could set custom attributes for the table's table, th, tr, td, tf elemens.| 
|`showFooter`|boolean||Optional. Show table footer or not, default value is false.| 
|`scope`|array||Optional. Data table will include the scope parameters in each of its ajax call to server-side operation.| 
|`serverSide`|boolean||Optional. Default value is false. Determine whether data table's operations are performed on server-side or client-side (default).| 
|`defaultPlugins`|array||Optional. Set DataTables' default plugins to load with.| 
|`plugins`|array||Optional. Set DataTables' additional plugins to load with.| 
|`searchOnEnter`|boolean|false|Optional. Make DataTables' filter only when users press Enter on the input field.| 
|`searchMode`|string|"and"|Optional. If `searchMode` == "or" DataTables'filter will treat string "or" as logic OR operator to split filter string into multiple filters.| 
|`complexHeaders`|boolean|false|Optional. Use DataTables' complex headers with rowspan and colspan.| 
|`complexHeaderLabels`|boolean|false|Optional. Apply complex headers on column labels instead of column keys.| 
|`headerSeparator`|string|" - "|Optional. If `complexHeaders` == true, use this separator to separate headers into groups.| 

### Use data property

If you have your own data in array format, you may use `data` property to display them in data table.

```
<?php 
DataTables::create(array(
    "data"=>array(
        array("name"=>"Peter","age"=>35),
        array("name"=>"Karl","age"=>31),
    )
))
?>
```

### Columns property

`columns` property is used to list columns you want to display and its settings.

```
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders"),
    "columns"=>array("orderNumber","customerName","productName","quantity")
))
```

__or more detail settings for each columns__


```
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders"),
    "columns"=>array(
        "orderNumber"=>array(
            "type"=>"number",
            "label"=>"Order#",
        ),
        "customerName"=>array(
            "label"=>"Customer Name",
            "type"=>"string",
            'data-order' => 'customerNumber', //order this column by customerNumber
            'data-search' => 'customerFullName', //search this column by customerFullName
        ),
        "productName"=>array(
            "label"=>"Product Name",
            "type"=>"string"
        ),
        "quantity"=>array(
            "label"=>"Quantity"
            "type"=>"number"
        ),
        "priceEach"=>array(
            "label"=>"Price",
            "type"=>"number",
            "prefix"=>"$",
            "decimals"=>2,
        )
    )
))
```

### Format column value

Normally, by settings `"type"` for column, the value of column will be formatted automatically. However, in some case, you may need manual format, you can do so with `"formatValue"` settings. `"formatValue"` can be a string or a function. For simple format, you may use string:

```
<?php 
    DataTables::create(array(
        ...
        "columns"=>array(
            "amount"=>array(
                'formatValue'=>'$ @value', // format to $12
            ),
        ),
        ...
    ));
?>
```
Or you can specify in function:

```
<?php 
    DataTables::create(array(
        ...
        "columns"=>array(
            "amount"=>array(
                'formatValue'=>function($value, $row, $cKey)
                {
                    if ($cKey === 'amount')
                        return $row["currency"]." ".number_format($value);
                    else
                        return $value;
                }
            ),
        ),
        ...
    ));
?>
```

### Columns' aggregated footer

Similarly to Table widget, DataTables has capability to show aggregated result of a column at footer. To do so you need to turn on footer by setting `"showFooter"=>true`. On the column you want to aggregate, you set `"footer"=>"sum"`. The Table support `"count"`, `"avg"`, `"min"`, `"max"` operation as well.

```
<?php 
    DataTables::create(array(
        ...
        "showFooter"=>true,
        "columns"=>array(
            "amount"=>array(
                "footer"=>"sum"
            ),
            "sale"=>array(
                "footer"=>"avg",
                "footerText"=>"Avg Sale: @value",
            )
        ),
        ...
    ));
?>
```

The `"footerText"` can be used to set any text at footer of column, it also can act as template. In above example, the @value will be replace with average of sale.

If you need more custom calculation for the footer, you may assign custom function to `"footer"` and do your own calculation and formatting. The custom function will receive a parameter which is the `DataStore`.


```
<?php 
    DataTables::create(array(
        ...
        "showFooter"=>true,
        "columns"=>array(
            "amount"=>array(
                "footer"=>function($store)
                {
                    return "$".number_format($store->sum("amount"));
                },
                "footerText"=>"Amount: @value",
            ),
        ),
        ...
    ));
?>
```

Since version 7.5.0, you can have multiple aggregates for each column by using "aggregates":

```
<?php 
    DataTables::create(array(
        ...
        "columns" => [
            "customerName" => [],
            "dollar_sales" => [
                "footer" => "sum",
                "aggregates" => [
                    "totalCount" => ["count", "customerName"],                    
                    "avgSale" => ["avg", "dollar_sales"],
                ],
                "footerText" => "Sum: @value | Avg: @avgSale | Count: @totalCount",
            ],
        ],
```

DataTables' "footer" and "footerText" event work with "serverSide" => true since version 7.5.0.

### Enable Searching

To enable searching box for `DataTables`, you do:

```
<?php 
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders")
    "options"=>array(
        "searching"=>true,
    )
))
?>
```

### Enable Paging

To enable paging for `DataTables`, you do:

```
<?php 
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders")
    "options"=>array(
        "paging"=>true,
    )
))
?>
```

### Sorting(ordering) preset

The column sorting is enabled by default, you may preset sorting(order):

```
<?php 
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders")
    "options"=>array(
        "order"=>array(
            array(0,"desc") //Sort by first column desc
            array(1,"asc") //Sort by second column asc
        ),
    )
))
?>
```

### Column Reorder

`DataTables` allows user to re-order columns by drag and drop, to enable the feature you do:

```
<?php 
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders")
    "options"=>array(
        "colReorder"=>true,
    )
))
?>
```

### Fixed Header

To get the fixed header on top of the page when scrolling, you set:


```
<?php 
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders")
    "options"=>array(
        "fixedHeader"=>true,
    )
))
?>
```

### Row Selection

To enable row selection in `DataTables`, we do:


```
<?php 
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders")
    "options"=>array(
        "select"=>true,
    )
))
?>
```

### Set custom CSS classes

Assign an array like this:

```
<?php 
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders")
    'cssClass'=>array(
        'table' => 'reportTable',
        'th' => 'reportHeader',
        'tr' => 'reportRow',
        'trJs' => "function(row, colMetas) { 
            return 'reportRow reportRowFromFunc'; 
        }", // client/js function, used when "fastRender" => true, to overide "tr" property
        'td' => 'reportCell',
        'td' => function($row, $colName, $colMeta) {
            return 'reportCell';
        },
        'tdJs' => "function(rowData, colName, colMeta) { 
            return colName;
        }", // client/js function, used when "fastRender" => true, to overide "td" property
        'tf' => 'reportFooter'
    )
));
?>
```

### Set custom CSS styles

Assign an array like this:

```
<?php 
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders")
    'cssStyle'=>array(
        'table' => 'color: blue; font-style: italic',
        'th' => 'color: blue; font-style: italic',
        'tr' => 'color: blue; font-style: italic',
        'trJs' => "function(rowData, colMetas} {
            return 'color: brown';
        }", // client/js function, used when "fastRender" => true, to overide "tr" property
        'td' => function($row, $colName) {
            return 'color: blue; font-style: italic';
        },
        'tdJs' => "function(rowData, colKey, colMeta) {
            return 'color: green';
        }", // client/js function, used when "fastRender" => true, to overide "td" property
        'tf' => 'color: blue; font-style: italic',
    )
));
?>
```

### Custom attributes

Assign an array like this:

```
<?php 
DataTables::create(array(
    "dataSource"=>$this->dataStore("orders")d
    "attributes" => [
        "table" => ["custom-attrs" => 1],
        "table" => function($dataStore) {
            return [
                "custom-attrs" => 1
            ];
        },
        "tr" => function($row, $colMetas) {
            return [
                "custom-attrs" => 1
            ];
        },
        "trJs" => "function(row, colMetas) {
            return {
                'custom-attr-1': 'value-1',
                'custom-attr-2': 'value-2',
            }; 
        }", // client/js function, used when "fastRender" => true, to overide "tr" property
        "td" => function($row, $colKey, $colMeta) {
            return [
                "custom-attrs" => $colKey
            ];
        },
        'tdJs' => "function(row, colName, colMeta) { 
            return {
                'custom-attr-1': 'value-1',
                'custom-attr-2': 'value-2',
            }; 
        }", // client/js function, used when "fastRender" => true, to overide "td" property
        "th" => function($colKey, $colMeta) {
            return [
                "custom-attrs" => 1
            ];
        },
        "tf" => function($colKey, $colMeta) {
            return [
                "custom-attrs" => 1
            ];
        },
    ],
));
?>
```

### serverSide

If set to false (default), all data is loaded to data table and operations like paging, filtering, sorting are performed on client-side. If set to true, those operations are performed on server-side. Server-side operations are only supported if data table's datasource is a function that returns data from a supported datasource class like this:


```
<?php 
DataTables::create(array(
    'name' => 'salesTable',
    'dataSource' => function() {
        return $this->src('mysql')
        ->query('select * from customer_product_dollarsales2');
    },
    "showFooter"=>true,
    "serverSide"=>true,
    // "method"=>'post', //default = 'get'
));
?>
```

Supported datasource classes include MySQLDataSource, SQLSRVDataSource, PostgreSQLDataSource, OracleDataSource and PdoDataSource (using with either mysql, sql server, postgresql or oracle).

#### serverSideInstantSearch (version >= 7.5.0)

By default, when "serverSide" => true DataTables disables isntant searching. To enable instant searching like when DataTables is client side you could force "serverSideInstantSearch" => true:

```
<?php 
DataTables::create(array(
    "serverSide"=>true,
    "serverSideInstantSearch" => true    
));
?>
```

#### overrideSearchInput (version >= 7.5.0)

By default datagrid\DataTables overrides search input for features like searchOnEnter, serverSide's no instant search to work. Some plugins like mark.js which highlights search input content requires the search input binding. In such case users could set "overrideSearchInput" => false for mark.js to work:

```
<?php 
DataTables::create(array(
    ...
    "overrideSearchInput" => false    
));
?>
```

#### ajaxUrl (version >= 7.0.0)

When `serverSide` => true, you can also set a property called `ajaxUrl` if your ajax url is different than the current report.

#### searchQuery (version >= 6.0.0)

`serverSide`'s searching works by wrapping the original query in a tmp table and add where conditions to create a search query like this:

```
select * (select * from customer_product_dollarsales2) tmp where {conditions}
```

This sometimes makes it slow. In some case you could insert the where condition directly to the original table with `searchQuery` property and "{datatables_search}" placeholder. For example:

```
<?php 
DataTables::create(array(
    'name' => 'salesTable',
    'searchQuery' => 'select * from customer_product_dollarsales2 where {datatables_search}',
    'dataSource' => function() {
        return $this->src('mysql')
        ->query('select * from customer_product_dollarsales2');
    },
    "showFooter"=>true,
    "serverSide"=>true,
    // "method"=>'post', //default = 'get'
));
```

With this setup, the search query would be like:

```
select * from customer_product_dollarsales2 where {conditions}
```

This is useful when your original query is already a complex one with multiple join, union, etc.

### `searchMode` ("or" since version >= 3.0.0, "and|exact" since version 6.0.0)

There're three search modes "or", "and", "exact" which could be enabled in any combination using "|" separator:

```
<?php 
DataTables::create(array(
    ...
    "searchMode" => "or|and", //"and|exact", "or|and|exact", "exact|or"
```    
These search modes work for both server side and client side. Noting that with client side, blanks (space, tab) always work like AND operator.

With "exact" mode, results would match the exact search. However, users could fill in totally custom sql wildcards (with server side) or regular expression (with client side) to search for patterns.

### Client-side objects

Beside standard DataTables javascript object's functions there's also a KoolReport DataTables js custom object which name is "KR" + DataTables' name:

```
<?php
    DataTables::create(array(
        "name" => "MyTable1",
        ...
    ));
?>
<script>
    var standardDT = MyTables; // standard DataTables javascript object
    var KoolReportDT = KRMyTable1; // KoolReport javascript custom object
</script>
```

### Client-side standdard functions

Here is the [full list of api function](https://datatables.net/reference/api/) which you can do with `DataTables`.

### Client-side custom functions

Here're client-side function of the KoolReport DataTables custom object:

#### expandAllGroups (version >= 7.0.0)

Expand all client row groups at a certain level.

```
<?php
    DataTables::create(array(
        "name" => "MyTable1",
        "clientRowGroup" => array(...)
    ));
?>
<script>
    KRMyTable1.expandAllGroups(0); // expand all the first level row groups
    KRMyTable1.expandAllGroups(1); // expand all the second level row groups
</script>
```

#### collapseAllGroups (version >= 7.0.0)

Expand all client row groups at a certain level.

#### toggleAllGroups (version >= 7.0.0)

Toggle (expand if being collapsed, collapse if being expanding) all client row groups at a certain level.

#### expandRowDetail (version >= 7.0.0)

Expand row detail at a certain row.

```
<?php
    DataTables::create(array(
        "name" => "MyTable1",
        "rowDetailData" => function($row) {...}
    ));
?>
<script>
    KRMyTable1.expandRowDetail(0); // expand row detail of the first row
    KRMyTable1.expandRowDetail(1); // expand row detail of the second row
</script>
```

#### collapseRowDetail (version >= 7.0.0)

Collapse row detail at a certain row.

#### toggleRowDetail (version >= 7.0.0)

Toggle (expand if being collapsed, collapse if being expanding) row detail at a certain row.

#### expandAllRowDetails (version >= 7.0.0)

Expand row detail of all rows.

```
<?php
    DataTables::create(array(
        "name" => "MyTable1",
        "rowDetailData" => function($row) {...}
    ));
?>
<script>
    KRMyTable1.expandAllRowDetails(); // expand row detail of all rows
</script>
```

#### collapseAllRowDetails (version >= 7.0.0)

Collapse row detail of all rows.

#### toggleAllRowDetails (version >= 7.0.0)

Toggle (expand if being collapsed, collapse if being expanding) row detail of all rows.

### Client-side events

`DataTables` support client-side event, below are example of using select event. Note that you should assign name to table so that you can refer to table at client-side:

```
<?php 
DataTables::create(array(
    "clientEvents"=>array(
        "select"=>"function(e,dt,type,indexes){
            var data = dt.rows( indexes ).data().pluck( 'id' );

            // do something with the ID of the selected items
        }"
    )
));
?>
```

Here is the [full list of events](https://datatables.net/reference/event/) which you can do with `DataTables`.

### defaultPlugins (version >= 4.0.1)

By default DataTables is loaded with these plugins: "AutoFill", "ColReorder", "RowGroup", "Select". You could override this with `defaultPlugins` property.

```
<?php 
DataTables::create(array(
    ...
    "defaultPlugins"=>array() // make DataTables load no plugins initially
));
?>
```

### plugins (version >= 4.0.1)

In addition to default plugins, you could set DataTables to load the following plugins: "Buttons", "FixedColumns", "FixedHeader", "KeyTable", "Responsive", "RowReorder", "Scroller", "SearchPanes" with the `plugins` property.

```
<?php 
DataTables::create(array(
    ...
    "plugins"=>array("Buttons", "FixedColumns", "FixedHeader", "KeyTable", "Responsive", "RowReorder", "Scroller", "SearchPanes")
));
?>
```

### clientRowGroup (version >= 5.0.0)

DataTables supports row grouping through its RowGroup plugin but its setting is a bit complicated. We simplify that row group setting with `clientRowGroup` property. For example:

```
<?php 
DataTables::create(array(
    ...
    "clientRowGroup" => [
        "customerName" => [
            'direction' => 'asc', //'asc', 'desc'
            'calculate' => [
                'totalSales' => [
                    'sum', //'sum', 'count', 'avg', 'min', 'max'
                    'dollar_sales'
                    "format" => "function(value) {return value.toFixed(2);}",
                ], 
            ],
            "top" => "<td colspan='999'>{expandCollapseIcon} Top: Customer: {customerName} | Total: {totalSales}</td>",
            "bottom" => "<td colspan='999'>{expandCollapseIcon} Bottom: Customer: {customerName} | Customer sales: {totalSales}</td>",
        ],
        "productLine" => [
            'calculate' => [
                'customAvgSales' => [
                    "aggregate" => "function(rows, group, aggFieldIndex) {
                        return rows
                        .data()
                        .pluck(aggFieldIndex)
                        .reduce( function (a, b) {
                            return a + 1*b.replace(/[^\d\.]/g, '');
                        }, 0) / rows.count()}
                    ",
                    'field' => 'dollar_sales',
                ],
            ],
            "top" => "<td colspan='999'>{expandCollapseIcon} Top: Line: {productLine} | Custom avg: {customAvgSales}",
        ],
    ],
));
?>
```

It contains a list of fields for data rows to group on. Each field has the following options:

|row group option|default|description| Example values |
|---|---|---|---|
|direction|"asc"|determines the group field's sorting order|"asc", "desc"|
|calculate|[]|defines aggregated values for grouped rows| ["totalSales" => ["sum", "dollar_sales", "numberOfOrders" => ["count", "orderId"]] |
|top|""|template string to appear at the top of a row group, can contain group name and aggregated values| Customer: {customerName}, Total sales: {totalSales} |
|bottom|""|template string to appear at the bottom of a row group, can contain group name and aggregated values| Customer: {customerName}, Number of orders: {numberOfOrders} |

Calculate is a list of aggregated values with the following options:

|calculate option|description| Example values |
|---|---|---|---|
|0 or operator| aggregate operator |"sum", "count", "avt", "min", "max|
|1 or field| a field to aggregate on | "dollar_sales", "orderNumber" |
|aggregate| string of custom javascript function to return custom aggregate on group rows | "function(rows, group, aggFieldIndex) { ... }" |
|format| string of javascript function to format aggregated value | "function(value) {return value.toFixed(5);}" |

### rowspan (version >= 7.0.0)

In case you only want to group/merge same-value continuous cells in certain columns there's a handle property called `rowspan` which is defined by an array of column names or column orders:

```
    DataTables::create(array(
        ...
        "rowspan" => [0, 1], // ["customerName", "productLine"]
    ));    
```

### removeDuplicate (version >= 7.0.0)

An alias for `rowspan`.

### groupCellsInColumns (version >= 7.0.0)

An alias for `rowspan`.

### fastRender (version >= 5.0.0)

If you have thousands or tens of thousands of rows, a normal rendering them all initially could be slow while using "serverSide" processing could be complicated and an overkill. In those cases "fastRender" together with paging could be a save:

```
    DataTables::create(array(
        ...
        "fastRender" => true,
        "options" => [
            "paging" => true,
            ...
        ]
        ...
    ));
```
When "fastRender" is true, only rows of the current active page are rendered while the rest of them are stored in a javascript object. 

It's cautioned that some few DataTables' options might not work or only work partially in "fastRender" mode because rows are rendered on client-side. They include "cssClass" (tr's and td's functions lack the row argument), "attributes".

### Row detail (version >= 5.0.0)

With table data presentation, there's a usual case of not showing all data in one row and showing full content in an expanded/collapsed row detail section instead. DataTables supports this feature with a really simple property `rowDetailData`, which could be a server-based (php) function:

```
    DataTables::create(array(
        ...
        "rowDetailData" => function($row) {
            return "Server-built row detail: " . $row['orderDate'];
        },
    ));
```
or a client-based (javascript) one:

```
    DataTables::create(array(
        ...
        "rowDetailData" => "function(row) {
            return 'Client-built row detail: ' + row.orderDate;
        }",
    ));
```
With client-based function, you can only access columns defined in `columns` property or if `columns` is empty (indicating that all columns of datasource are output.)

By default `rowDetailData` adds an expanding/collapsing icon for each row but you could disable the icons by setting `rowDetailIcon` property to false:

```
    DataTables::create(array(
        ...
        "rowDetailData" => ...,
        "rowDetailIcon" => false,
    ));
```
In that case, expanding/collapsing row detail is done by clicking the whole row, unless you set a `rowDetailSelector` property:

```
    DataTables::create(array(
        ...
        "rowDetailData" => ...,
        "rowDetailIcon" => false,
        "rowDetailSelector" => "td:first-child", //expand/collapse row detail by clicking the first column
        "rowDetailSelector" => "td.col-customer-name", //expand/collapse row detail by clicking column with class name col-customer-name
    ));
```

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.
