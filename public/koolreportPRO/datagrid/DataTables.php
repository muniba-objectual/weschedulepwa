<?php

namespace koolreport\datagrid;

use \koolreport\core\Widget;
use \koolreport\core\Utility as Util;
use \koolreport\core\DataStore;

class DataTables extends Widget
{
    protected $name;
    protected $columns;
    protected $data;
    protected $options;
    protected $emptyValue;
    protected $showFooter;
    protected $clientEvents;
    protected $trueColKeys = [];

    public function version()
    {
        return "7.5.0";
    }

    protected function resourceSettings()
    {
        $resources = [];
        $themeBase = $this->getThemeBase();
        switch ($themeBase) {
            case "bs4":
                $resources = array(
                    "library" => array("jQuery"),
                    "folder" => "DataTables",
                    "js" => array(
                        "KRDataTables.js",
                        "datatables.min.js",
                        // "dataTables1.10.25.js",
                        array(
                            "pagination/input.js",
                            "datatables.bs4.min.js"
                        )
                    ),
                    "css" => array(
                        "KRDataTables.css",
                        "datatables.bs4.min.css",
                    )
                );
                break;
            case "bs3":
            default:
                $resources = array(
                    "library" => array("jQuery"),
                    "folder" => "DataTables",
                    "js" => array(
                        "KRDataTables.js",
                        "datatables.min.js",
                        // "dataTables1.10.25.js",
                        [
                            "pagination/input.js"
                        ]
                    ),
                    "css" => array(
                        "KRDataTables.css",
                        "datatables.min.css",
                    )
                );
        }

        $pluginNameToFiles = array(
            "AutoFill" => array(
                "AutoFill-2.3.5/js/dataTables.autoFill.min.js"
            ),
            "Buttons" => array(
                "Buttons-1.6.2/js/dataTables.buttons.min.js",
                "Buttons-1.6.2/js/buttons.colVis.min.js",
                "Buttons-1.6.2/js/buttons.html5.min.js",
                "Buttons-1.6.2/js/buttons.print.min.js",
                "JSZip-2.5.0/jszip.min.js",
                "pdfmake-0.1.36/pdfmake.min.js",
                ["pdfmake-0.1.36/vfs_fonts.js"], //vfs_fonts must be loaded after pdfmake.min.js
            ),
            "ColReorder" => array(
                "ColReorder-1.5.2/js/dataTables.colReorder.min.js",
            ),
            "FixedColumns" => array(
                "FixedColumns-3.3.1/js/dataTables.fixedColumns.min.js",
            ),
            "FixedHeader" => array(
                "FixedHeader-3.1.7/js/dataTables.fixedHeader.min.js"
            ),
            "KeyTable" => array(
                "KeyTable-2.5.2/js/dataTables.keyTable.min.js"
            ),
            "Responsive" => array(
                "Responsive-2.2.4/js/dataTables.responsive.min.js"
            ),
            "RowGroup" => array(
                "RowGroup-1.1.2/js/dataTables.rowGroup.min.js"
            ),
            "RowReorder" => array(
                "RowReorder-1.2.7/js/dataTables.rowReorder.min.js"
            ),
            "Scroller" => array(
                "Scroller-2.0.2/js/dataTables.scroller.min.js"
            ),
            "SearchPanes" => array(
                "SearchPanes-1.1.0/js/dataTables.searchPanes.min.js"
            ),
            "Select" => array(
                "Select-1.3.1/js/dataTables.select.min.js"
            ),
            "RowsGroup" => array(
                "RowsGroup-2.0.0/js/dataTables.rowsGroup.js"
            ),
        );

        $pluginJs = [];
        foreach ($this->plugins as $name) {
            if (isset($pluginNameToFiles[$name])) {
                foreach ($pluginNameToFiles[$name] as $jsfile) {
                    array_push($pluginJs, $jsfile);
                }
            } else if (is_string($name)) {
                array_push($pluginJs, $name);
            }
        }
        $resources['js'][2] = array_merge($resources['js'][2], $pluginJs);

        $pluginNameToCsses = array(
            "FixedHeader" => array(
                "FixedHeader-3.1.7/css/fixedHeader.dataTables.min.css",
            ),
            "Buttons" => $themeBase === "bs4" ? array(
                "Buttons-1.6.2/css/buttons.dataTables.min.css",
                "Buttons-1.6.2/css/buttons.bootstrap4.min.css",
            ) : array(
                "Buttons-1.6.2/css/buttons.dataTables.min.css",
                "Buttons-1.6.2/css/buttons.bootstrap.min.css",
            ),
        );

        if ($themeBase === "bs4") {
            $pluginNameToCsses["FixedHeader"][] = "FixedHeader-3.1.7/css/fixedHeader.bootstrap4.min.css";
        }

        $pluginCsses = [];
        foreach ($this->plugins as $name) {
            $cssFiles = Util::get($pluginNameToCsses, $name, []);
            $pluginCsses = array_merge($pluginCsses, $cssFiles);
        }
        $resources['css'] = array_merge($resources['css'], $pluginCsses);

        if (!empty($this->clientRowGroup) || !empty($this->rowDetailData)) {
            $resources['library'][] = 'font-awesome';
        }

        return $resources;
    }

    protected function onInit()
    {
        $this->useLanguage();
        $params = $this->params;
        $scope = Util::get($params, "scope", array());
        $this->scope = is_callable($scope) ? $scope() : $scope;
        $this->name = Util::get($params, "name");
        $this->template = Util::get($params, 'template', 'DataTables');
        $this->fastRender = Util::get($params, 'fastRender', false);
        $this->columns = Util::get($params, "columns", array());
        $this->showFooter = Util::get($params, "showFooter", false);
        $this->clientEvents = Util::get($params, "clientEvents", []);
        $this->serverSide = Util::get($params, "serverSide", false);
        $this->method = strtoupper(Util::get($params, "method", 'get'));
        $this->submitType = $this->method === 'POST' ? $_POST : $_GET;
        $this->complexHeaderLabels = Util::get($params, "complexHeaderLabels", false);
        $this->complexHeaders = Util::get($params, "complexHeaders", $this->complexHeaderLabels);
        $this->headerSeparator = Util::get($params, "headerSeparator", '-');
        $this->searchOnEnter = Util::get($params, "searchOnEnter", false);
        $this->serverSideInstantSearch = Util::get($params, "serverSideInstantSearch", false);
        $this->overrideSearchInput = Util::get($params, "overrideSearchInput", true);
        $this->searchMode = strtolower(Util::get($params, "searchMode", "smart"));
        if (!is_array($this->searchMode)) {
            $this->searchMode = array_flip(explode("|", $this->searchMode));
        }
        $this->emptyValue = Util::get($params, "emptyValue", "-");
        $this->cssClass = Util::get($params, "cssClass", array());
        $this->cssStyle = Util::get($params, "cssStyle", array());
        $this->attributes = Util::get($params, "attributes", array());
        $this->onBeforeInit = Util::get($params, "onBeforeInit");
        $this->defaultPlugins = Util::get($params, "defaultPlugins", [
            "AutoFill", "ColReorder", "RowGroup", "Select"
        ]);
        $this->plugins = Util::get($params, "plugins", []);
        $this->plugins = array_merge($this->plugins, $this->defaultPlugins);
        $this->clientRowGroup = Util::get($params, "clientRowGroup", []);
        if (!empty($this->clientRowGroup) && !in_array("RowGroup", $this->plugins)) {
            $this->plugins[] = "RowGroup";
        }
        $this->rowDetailData = Util::get($params, "rowDetailData");
        $this->rowDetailIcon = Util::get($params, "rowDetailIcon", true);
        $this->rowDetailSelector = Util::get($params, "rowDetailSelector", "");

        $removeDuplicate = Util::get($params, "removeDuplicate", []);
        $rowspan = Util::get($params, "rowspan", $removeDuplicate);
        $this->groupCellsInColumns = Util::get($params, "groupCellsInColumns", $rowspan);

        $this->useDataSource($this->scope);
        if ($this->dataStore == null) {
            $data = Util::get($this->params, "data");
            if (is_array($data)) {
                if (count($data) > 0) {
                    $this->dataStore = new DataStore;
                    $this->dataStore->data($data);
                    $row = $data[0];
                    $meta = array("columns" => array());
                    foreach ($row as $cKey => $cValue) {
                        $meta["columns"][$cKey] = array(
                            "type" => Util::guessType($cValue),
                        );
                    }
                    $this->dataStore->meta($meta);
                } else {
                    $this->dataStore = new DataStore;
                    $this->dataStore->data(array());
                    $metaColumns = array();
                    foreach ($this->columns as $cKey => $cValue) {
                        if (gettype($cValue) == "array") {
                            $metaColumns[$cKey] = $cValue;
                        } else {
                            $metaColumns[$cValue] = array();
                        }
                    }
                    $this->dataStore->meta(array("columns" => $metaColumns));
                }
            }
            if ($this->dataStore == null) {
                throw new \Exception("dataSource or data is required for DataTables");
                return;
            }
        }

        if (!$this->name) {
            $this->name = "datatables" . Util::getUniqueId();
        }

        $this->options = array(
            "searching" => false,
            "paging" => false,
        );


        if ($this->languageMap != null) {
            $this->options["language"] = $this->languageMap;
        }

        $this->options = array_merge(
            $this->options,
            Util::get($params, "options", array())
        );
    }

    protected function formatValue($value, $format, $row = null, $cKey = null)
    {
        $formatValue = Util::get($format, "formatValue", null);

        if (is_string($formatValue)) {
            eval('$fv="' . str_replace('@value', '$value', $formatValue) . '";');
            return $fv;
        } else if (is_callable($formatValue)) {
            return $formatValue($value, $row, $cKey);
        } else {
            return Util::format($value, $format);
        }
    }

    protected function buildRowspan()
    {
        $groupCellsInColOrders = [];
        foreach ($this->groupCellsInColumns as $groupCellsInColumn) {
            $columnIndex = array_search($groupCellsInColumn, $this->columns);
            if ($columnIndex !== false) $groupCellsInColOrders[] = $columnIndex;
            else if (is_numeric($groupCellsInColumn)) {
                if (1 * $groupCellsInColumn < count($this->columns))
                    $groupCellsInColOrders[] = $groupCellsInColumn;
            }
        }

        if (!in_array("RowsGroup", $this->plugins)) {
            $this->plugins[] = "RowsGroup";
        }
        Util::init($this->options, "rowsGroup", $groupCellsInColOrders);
    }

    protected function buildServerSide()
    {
        $columnsData = [];
        foreach ($this->showColumnKeys as $colKey)
            $columnsData[] = ['data' => $colKey];
        $scopeJson = json_encode($this->scope);
        $this->options = array_merge($this->options, [
            'serverSide' => true,
            'ajax' => [
                'url' => Util::get($this->params, 'ajaxUrl', ''),
                'data' => "function(d) {
                    d.id = '{$this->name}';
                    var scope = {$scopeJson};
					for (var p in scope)
						if (scope.hasOwnProperty(p))
							d[p] = scope[p];
                }",
                'type' => "{$this->method}",
                'dataFilter' => "function(data) {
                    var markStart = \"<dt-ajax id='dt_$this->name'>\";
                    var markEnd = '</dt-ajax>';
                    var start = data.indexOf(markStart);
                    var end = data.indexOf(markEnd, start);
                    var s = data.substring(start + markStart.length, end);
                    
                    var ajaxResult = JSON.parse(s);
                    // console.log(ajaxResult);

                    var footers = ajaxResult.footers || {};
                    // console.log(footers);
                    for (var cKey in footers) {
                        var footerValue = footers[cKey];
                        var selector = '#{$this->name}_wrapper .footer-' + cKey + ' .footer-content-wrapper';
                        var footerEl = document.querySelector(selector);
                        if (footerEl) {
                            var footerServerSideEl = footerEl.querySelector('.footer-server-side');
                            if (footerServerSideEl) {
                                var div = document.createElement('div');
                                div.innerHTML = footerValue;
                                var newFooterServerSideEl = div.querySelector('.footer-server-side');
                                footerServerSideEl.innerHTML = newFooterServerSideEl.innerHTML;
                            } else {
                                footerEl.innerHTML = footerValue;
                            }
                        }
                    }
                    
                    return s;
                }",
            ],
            "columns" => $columnsData
        ]);
    }

    protected function buildComplexHeaders()
    {
        $showColumnKeys = $this->showColumnKeys;
        if ($this->complexHeaderLabels) {
            $showColumnLabels = [];
            foreach ($showColumnKeys as $cKey) {
                $label = Util::get($this->cMetas, [$cKey, "label"], $cKey);
                $showColumnLabels[] = $label;
            }
            $showColumnKeys = $showColumnLabels;
        }
        $sep = $this->headerSeparator;
        $headerRows = [];
        //Create empty header rows array
        foreach ($showColumnKeys as $cKey) {
            $cKey = explode($sep, $cKey);
            if (count($headerRows) < count($cKey)) {
                $aHeaderRow = [];
                array_push($headerRows, $aHeaderRow);
            }
        }
        $numRow = count($headerRows);
        //Fill in header row values from column names
        foreach ($showColumnKeys as $cKey) {
            $cKey = explode($sep, $cKey);
            for ($i = 0; $i < $numRow; $i++) {
                $header = Util::get($cKey, $i, null);
                array_push($headerRows[$i], [
                    'text' => $header
                ]);
            }
        }
        $lastSameHeaderIndexes = [];
        $lastNotNullHeaderIndexes = [];
        // Util::prettyPrint($headerRows); 
        $newHeaderRows = $headerRows;
        foreach ($headerRows as $rowIndex => $aHeaderRow) {
            foreach ($aHeaderRow as $colIndex => $header) {
                $currentText = $header['text'];
                if (!isset($currentText)) {
                    if ($rowIndex === 0) continue;
                    $lastNotNull = $lastNotNullHeaderIndexes[$colIndex];
                    $rowspan = (int) Util::init(
                        $newHeaderRows,
                        [$lastNotNull, $colIndex, 'rowspan'],
                        1
                    );
                    $newHeaderRows[$lastNotNull][$colIndex]['rowspan'] = $rowspan + 1;
                } else {
                    $lastNotNullHeaderIndexes[$colIndex] = $rowIndex;
                    if (!isset($lastSameHeaderIndexes[$rowIndex])) {
                        $lastSameHeaderIndexes[$rowIndex] = $colIndex;
                        continue;
                    };
                    $lastIndex = $lastSameHeaderIndexes[$rowIndex];
                    $lastSameHeader = $aHeaderRow[$lastIndex]['text'];

                    // echo "$currentText - $lastSameHeader <br>";
                    $isEqual = ($currentText === $lastSameHeader);
                    $isSameParents = true;
                    for ($k = $rowIndex - 1; $k > -1; $k--) {
                        $currentParent = $headerRows[$k][$colIndex]['text'];
                        $lastParent = $headerRows[$k][$lastIndex]['text'];
                        // echo "$currentParent - $lastParent <br>";
                        if ($currentParent !== $lastParent) {
                            $isSameParents = false;
                            break;
                        }
                    }
                    // echo "isEqual = $isEqual<br>";
                    // echo "isSameParents = $isSameParents<br>";

                    if (!$isEqual || !$isSameParents) {
                        $lastSameHeaderIndexes[$rowIndex] = $colIndex;
                    } else if ($colIndex < count($aHeaderRow) - 1) {
                        // echo "is equal and same parent <br>";
                        $colspan = (int) Util::init(
                            $newHeaderRows,
                            [$rowIndex, $lastIndex, 'colspan'],
                            1
                        );
                        // echo "i=$rowIndex lastIndex=$lastIndex colspan=$colspan<br>";
                        $newHeaderRows[$rowIndex][$lastIndex]['colspan'] = $colspan + 1;
                        $newHeaderRows[$rowIndex][$colIndex]['text'] = null;
                    } else {
                        $colspan = (int) Util::init(
                            $newHeaderRows,
                            [$rowIndex, $lastIndex, 'colspan'],
                            1
                        );
                        $newHeaderRows[$rowIndex][$lastIndex]['colspan'] = $colspan + 1;
                        $newHeaderRows[$rowIndex][$colIndex]['text'] = null;
                    }
                }
            }
        }
        // Util::prettyPrint($newHeaderRows);  
        return $newHeaderRows;
    }

    protected function buildClientRowGroup()
    {
        $columnDefs = Util::init($this->options, "columnDefs", []);

        $showColumnKeysIndex = array_flip($this->showColumnKeys);
        $orderOption = [];
        $rowGroupOption = [
            'dataSrc' => []
        ];
        $startRender = $endRender = "var startRenderLevels = endRenderLevels = {}; ";
        $expandIcon = Util::get($this->params, 'expandIcon', "<i class=\'far fa-plus-square\' aria-hidden=\'true\'></i>");
        $collapseIcon = Util::get($this->params, 'collapseIcon', "<i class=\'far fa-minus-square\' aria-hidden=\'true\'></i>");
        $grLevel = 0;
        $grCols = [];
        $columnDefsOrderData = [];
        foreach ($this->clientRowGroup as $grCol => $grOption) {
            $grCols[$grLevel] = $grCol;
            $colIndex = $showColumnKeysIndex[$grCol];
            $dir = Util::get($grOption, 'direction', 'asc');
            $orderOption[] = [$colIndex, $dir];
            $rowGroupOption['dataSrc'][] = $colIndex;
            $columnDefsOrderData[] = $colIndex;
            $columnDefs[] = [
                "targets" => $colIndex,
                "orderData" => $columnDefsOrderData,
            ];

            //Build agg values
            $calculate = Util::get($grOption, 'calculate', []);
            $aggValues = [];
            foreach ($calculate as $aggName => $aggConfig) {
                $aggOp = Util::get($aggConfig, 0, Util::get($aggConfig, 'operator'));
                $aggFunc = Util::get($aggConfig, 'aggregate');
                $aggField = Util::get($aggConfig, 1, Util::get($aggConfig, 'field'));
                $aggColIndex = $showColumnKeysIndex[$aggField];
                if ($aggFunc) {
                    $aggVarName = "{$aggField}AggValue{$grLevel}" . md5($aggFunc);
                    $aggValue = "
                    var $aggVarName = $aggFunc(rows, group, $aggColIndex);
                    ";
                } else {
                    $aggVarName = "{$aggField}AggValue{$grLevel}" . md5($aggOp);
                    switch ($aggOp) {
                        case "avg":
                        case "sum":
                            $reduceFunc = "return a + 1*b.replace(/[^\d\.\-]/g, '');";
                            $initValue = 0;
                            break;
                        case "count":
                            $reduceFunc = "return a + 1;";
                            $initValue = 0;
                            break;
                        case "min":
                            $reduceFunc = "return a < b ? a : b;";
                            $initValue = "Number.MAX_VALUE";
                            break;
                        case "max":
                            $reduceFunc = "return a > b ? a : b;";
                            $initValue = "- Number.MAX_VALUE";
                            break;
                    }
                    $aggValue = "
                        var $aggVarName = rows
                            .data()
                            .pluck($aggColIndex)
                            // .pluck('$aggField')
                            .reduce( function (a, b) {
                                $reduceFunc
                            }, $initValue);
                    ";
                    if ($aggOp === 'avg') $aggValue .= " $aggVarName = $aggVarName / rows.count(); ";
                }

                $formatFunc = Util::get($aggConfig, 'format');
                if ($formatFunc) {
                    $aggValue .= "$aggVarName = $formatFunc($aggVarName);";
                }

                $aggValues[$aggName] = [
                    'name' => $aggVarName,
                    'value' => $aggValue
                ];
            }

            //Replace agg place holders
            $top = addslashes(Util::get($grOption, "top", ""));
            $bottom = addslashes(Util::get($grOption, "bottom", ""));
            foreach ($calculate as $aggName => $aggConfig) {
                $aggValue = $aggValues[$aggName]['value'];
                $startRender .= " $aggValue ";
                $endRender .= " $aggValue ";
                $aggVarName = $aggValues[$aggName]['name'];
                $top = str_replace("{{$aggName}}", "' + $aggVarName + '", $top);
                $bottom = str_replace("{{$aggName}}", "' + $aggVarName + '", $bottom);
            }
            $onclick = "onclick=\'KR{$this->name}.expandCollapse(this);\'";
            $top = str_replace("{expandCollapseIcon}", "<span class=\'group-expand\' style=\'display:{expandDisplay};\' $onclick >$expandIcon</span>"
                . "<span class=\'group-collapse\' style=\'display:{collapseDisplay};\' $onclick >$collapseIcon</span>", $top);
            $replaceTop = "
                var top = '$top';
                var isGroupCollapsed = dtState.dtrg[groupSignature].collapse;
                // console.log(level, groupSignature, 'is group collapsed: ', isGroupCollapsed);
                if (isGroupCollapsed) {
                    top = top.replace('{expandDisplay}', '');
                    top = top.replace('{collapseDisplay}', 'none');
                } else {
                    top = top.replace('{expandDisplay}', 'none');
                    top = top.replace('{collapseDisplay}', '');
                }
            ";
            for ($i = 0; $i <= $grLevel; $i++) {
                $replaceTop .= "
                    top = top.replace(/{{$grCols[$i]}}/g, group);
                ";
            }
            $startRender .= "
                $replaceTop
                var layer = dtState.dtrg[groupSignature].layer || 1;
                layer = 1 * layer;
                var trDisplay = layer < 1 ? 'none' : '';
                var trTag = '<tr data-dtrg-signature=\"' + groupSignature + '\" data-layer=\"' + layer + '\" style=\"display:' + trDisplay + ';\" />'
                startRenderLevels[{$grLevel}] = $(trTag)
                    .append( top )
                ;
            ";

            $bottom = str_replace("{expandCollapseIcon}", "<span class=\'group-expand\' style=\'display:{expandDisplay};\' $onclick >$expandIcon</span>"
                . "<span class=\'group-collapse\' style=\'display:{collapseDisplay};\' $onclick >$collapseIcon</span>", $bottom);
            $replaceBottom = "
                var bottom = '$bottom';
                var isGroupCollapsed = dtState.dtrg[groupSignature].collapse;
                if (isGroupCollapsed) {
                    bottom = bottom.replace('{expandDisplay}', '');
                    bottom = bottom.replace('{collapseDisplay}', 'none');
                } else {
                    bottom = bottom.replace('{expandDisplay}', 'none');
                    bottom = bottom.replace('{collapseDisplay}', '');
                }
            ";
            for ($i = 0; $i <= $grLevel; $i++) {
                $replaceBottom .= "
                    bottom = bottom.replace(/{{$grCols[$i]}}/g, group);
                ";
            }
            $endRender .= "
                $replaceBottom
                var layer = dtState.dtrg[groupSignature].layer || 1;
                // console.log(groupSignature);
                layer = 1 * layer;
                var trDisplay = layer < 1 ? 'none' : '';
                var trTag = '<tr data-dtrg-signature=\"' + groupSignature + '\" data-layer=\"' + layer + '\" style=\"display:' + trDisplay + ';\" />'
                endRenderLevels[{$grLevel}] = $(trTag)
                    .append( bottom )
                ;
            ";

            $grLevel++;
        }

        $aggColIndexes = json_encode($rowGroupOption['dataSrc']);
        $setupGroupSignature = "
            var rowData0 = rows.data()[0];
            // console.log('rowData0 = ', rowData0);
            var aggColIndexes = {$aggColIndexes};
            var groupSignature = [];
            function htmlDecode(input) {
                var doc = new DOMParser().parseFromString(input, 'text/html');
                return doc.documentElement.textContent;
            }
            for (var i = 0; i <= level; i+=1) {
                var groupElementValue = htmlDecode(rowData0[aggColIndexes[i]]); //htmlDecode back converts &amp; to &
                groupSignature.push(groupElementValue);
            }
            groupSignature = groupSignature.join(' || ');

            var dtState = window['{$this->name}_state'];
            dtState.dtrg = dtState.dtrg || {};
            if (typeof dtState.dtrg[groupSignature] === 'undefined')
                dtState.dtrg[groupSignature] = {};
        ";
        $startRenderFunc = "
            function ( rows, group, level ) {
                // console.log('start render group row');
                // console.log(rows, group, level);
                // console.log('rows = ', rows);                
                {$setupGroupSignature}
                {$startRender}
                return startRenderLevels[level];
            }
        ";
        $rowGroupOption['startRender'] = $startRenderFunc;
        $endRenderFunc = "
            function ( rows, group, level ) {
                // console.log(rows, group, level);
                {$setupGroupSignature}
                {$endRender}                
                return endRenderLevels[level];
            }
        ";
        $rowGroupOption['endRender'] = $endRenderFunc;

        $this->options['order'] = $orderOption;
        $this->options['rowGroup'] = $rowGroupOption;

        foreach ($this->showColumnKeys as $i => $colKey) {
            if (in_array($i, $columnDefsOrderData)) continue;
            $thisColumnDefsOrderData = $columnDefsOrderData;
            $thisColumnDefsOrderData[] = $i;
            $columnDefs[] = [
                "targets" => $i,
                "orderData" => $thisColumnDefsOrderData,
            ];
        }
        $this->options["columnDefs"] = $columnDefs;

        $checkPaging = "
            var pInfo = window['{$this->name}'].page.info();
            var isPaging = pInfo.recordsTotal != pInfo.end - pInfo.start;
            if (!isPaging) return;
        ";
        $deleteGroupsState = "
            var dtState = window['{$this->name}_state'];
            if (!dtState.dtrg) dtState.dtrg = {};
            for (var p in dtState.dtrg) {
                delete dtState.dtrg[p];
            }
        ";
        $resetRows = "
            var rows = document.querySelectorAll('#{$this->name} tr[role=\"row\"]');
            rows.forEach(row => {
                delete row.dataset.layer;
                row.style.display = '';
            });
        ";
        // When changing page, delete all groups' states (including collapse and layer)
        // because data rows are all reset
        $this->clientEvents["page.dt"] = "function() {
            console.log('client row group page change event');
            {$checkPaging}
            {$deleteGroupsState}
            {$resetRows}
        }";
        $this->clientEvents["order.dt"] = "function() {
            // console.log('client row group order event');
            {$checkPaging}
            {$deleteGroupsState}
            {$resetRows}
        }";
        $this->clientEvents["search.dt"] = "function() {
            // console.log('client row group search event');
            {$checkPaging}
            {$deleteGroupsState}
            {$resetRows}
        }";
    }

    protected function buildColumnDefs()
    {
        $columnDefs = Util::init($this->options, "columnDefs", []);
        $defs = [
            'width', 'visible', 'createdCell', 'render', 'searchable',
            'type', 'title', 'orderData', 'orderDataType', 'orderable', 'name',
            'defaultContent', 'data', 'contentPadding', 'className', 'cellType'
        ];
        foreach ($this->showColumnKeys as $i => $cKey) {
            $cMeta = Util::get($this->cMetas, $cKey, []);
            foreach ($defs as $def) {
                if (isset($cMeta[$def])) {
                    $columnDef = [
                        'targets' => $i,
                        $def => $cMeta[$def]
                    ];
                    $columnDefs[] = $columnDef;
                }
            }
        }
        $this->options["columnDefs"] = $columnDefs;
    }

    protected function buildFastRender()
    {
        $getMappedProperty = function ($mappedProperty, $default) {
            $args = func_get_args();
            $args = array_slice($args, 2);
            $property = is_callable($mappedProperty) ?
                call_user_func_array($mappedProperty, $args) : $mappedProperty;
            if (!isset($property)) $property = $default;
            return $property;
        };

        Util::init($this->options, 'deferRender', true);
        Util::init($this->options, 'columns', []);
        
        $tdClass = Util::get($this->cssClass, "td", "");
        $tdJsClass = Util::get($this->cssClass, "tdJs", "function(){}");
        $tdAttr = Util::get($this->attributes, "td", []);
        $tdJsAttr = Util::get($this->attributes, "tdJs", "function(){}");
        $tdStyle = Util::get($this->cssStyle, "td", "");
        $tdJsStyle = Util::get($this->cssStyle, "tdJs", "function(){}");

        $cMetasJson = json_encode($this->cMetas);
        foreach ($this->showColumnKeys as $ci => $cKey) {
            $cMeta = Util::get($this->cMetas, $cKey, []);
            $cMetaJson = json_encode($cMeta);
            $tdClassStr = is_callable($tdClass) ? 
                $getMappedProperty($tdClass, "", [], $cKey, $cMeta) : $tdClass;
            $tdAttrArr = is_callable($tdAttr) ? 
                $getMappedProperty($tdAttr, [], [], $cKey, $cMeta) : $tdAttr;
            $tdAttrArrJson = json_encode($tdAttrArr);
            $tdStyleStr = is_callable($tdStyle) ? 
                $getMappedProperty($tdStyle, "", [], $cKey, $cMeta) : $tdStyle;
            $colOption = [
                // 'title' => Util::get($cMetas,[$cKey, "label"], $cKey),
                'data' => $ci,
                // 'name' => $cKey,
                // "className" => $tdClassStr,
                "createdCell" => "function (td, cellData, rowData, row, col) {
                    // console.log('createdCell');
                    var colName = '{$cKey}';
                    var colMeta = {$cMetaJson};

                    var tdClassStr = '{$tdClassStr}';
                    var tdJsClass = {$tdJsClass};
                    var tdJsClassStr = tdJsClass(rowData, colName, colMeta);
                    console.log(tdJsClassStr, tdClassStr);
                    $(td).addClass( tdJsClassStr || tdClassStr);

                    var tdAttrArr = {$tdAttrArrJson};
                    var tdJsAttr = {$tdJsAttr};
                    var tdJsAttrArr = tdJsAttr(rowData, colName, colMeta);
                    var attrs = tdJsAttrArr || tdAttrArr;
                    console.log(tdJsAttrArr, tdAttrArr);
                    if (!attrs) attrs = [];
                    for (var p in attrs)
                        $(td).attr(p, attrs[p]);

                    var tdStyleStr = '{$tdStyleStr}';
                    var tdJsStyle = {$tdJsStyle};
                    var tdJsStyleStr = tdJsStyle(rowData, colName, colMeta);
                    console.log(tdJsStyleStr, tdStyleStr);
                    $(td).attr('style', tdJsStyleStr || tdStyleStr);
                }",
            ];
            $this->options['columns'][] = $colOption;
        }

        $trClass = Util::get($this->cssClass, "tr", "");
        $trJsClass = Util::get($this->cssClass, "trJs", "function(){}");
        $trAttr = Util::get($this->attributes, "tr", []);
        $trJsAttr = Util::get($this->attributes, "trJs", "function(){}");
        $trStyle = Util::get($this->cssStyle, "tr", "");
        $trJsStyle = Util::get($this->cssStyle, "trJs", "function(){}");

        $trClassStr = is_callable($trClass) ? 
            $getMappedProperty($trClass, "", [], $cMeta) : $trClass;
        $trAttrArr = is_callable($trAttr) ? 
            $getMappedProperty($trAttr, [], [], $cMeta) : $trAttr;
        $trAttrArrJson = json_encode($trAttrArr);
        $trStyleStr = is_callable($trStyle) ? 
            $getMappedProperty($trStyle, "", [], $cKey) : $trClass;
        Util::set($this->options, 'createdRow', "function( row, rowData, dataIndex ) {
            var colMetas = {$cMetasJson}; 

            var trClassStr = '{$trClassStr}';
            var trJsClass = {$trJsClass};
            var trJsClassStr = trJsClass(rowData, colMetas);
            $(row).addClass(trJsClassStr || trClassStr);

            var trAttrArr = {$trAttrArrJson};
            var trJsAttr = {$trJsAttr};
            var trJsAttrArr = trJsAttr(rowData, colMetas);
            var attrs = trJsAttrArr || trJsAttr;
            console.log(trJsAttrArr, trJsAttr);
            if (!attrs) attrs = [];
            for (var p in attrs)
                $(row).attr(p, attrs[p]);

            var trStyleStr = '{$trStyleStr}';
            var trJsStyle = {$trJsStyle};
            var trJsStyleStr = trJsStyle(rowData, colMetas);
            console.log(trJsStyleStr, trStyleStr);
            $(row).attr('style', trJsStyleStr || trStyleStr);
        }");
    }

    protected function buildRowDetailData()
    {
        $rowDetailData = $this->rowDetailData;
        if (is_callable($rowDetailData)) {
            foreach ($this->dataRows as $i => $row) {
                // $row = array_combine($this->showColumnKeys, $row);
                $this->dataRows[$i]['{rowDetailData}'] =
                    $rowDetailData($this->dataStore->get($i));
            }
            $this->options['rowDetailData'] = "function(row) { return row['{rowDetailData}']; }";
        } else if (is_string($rowDetailData)) {
            $this->options['rowDetailData'] = $rowDetailData;
        }

        $columnDefs = Util::init($this->options, "columnDefs", []);
        if ($this->fastRender) {
            array_unshift($this->options['columns'], [
                "data" => 'rowDetailIcon',
            ]);
        } else {
            if (is_callable($rowDetailData)) {
                //Add invisible {rowDetailData} column
                array_push($this->showColumnKeys, '{rowDetailData}');
                $rowDetailDataOrder =  count($this->showColumnKeys);
                $columnDefs[] = [
                    'targets' => $rowDetailDataOrder,
                    "visible" => false,
                ];
                $this->options['rowDetailData'] = "function(row) { return row[$rowDetailDataOrder]; }";
            }
        }
        $columnDefs[] = [
            'targets' => 0,
            "title" => "",
            "className" => 'details-control',
            "orderable" => false,
            "width" => "1px",
            "visible" => $this->rowDetailIcon,
        ];
        $this->options["columnDefs"] = $columnDefs;

        array_unshift($this->showColumnKeys, 'rowDetailIcon');
        foreach ($this->dataRows as $i => $row) {
            $this->dataRows[$i]['rowDetailIcon'] =  "<i class='far fa-plus-square expand-collapse-detail-icon' aria-hidden='true'></i>";
        }
    }

    protected function buildDataRows($rowType = 'assoc')
    {
        $this->rawData = [];
        $this->dataRows = [];
        $this->dataStore->popStart();
        while ($row = $this->dataStore->pop()) {
            $dataRow = $row;
            foreach ($this->showColumnKeys as $ci => $cKey) {
                $cMeta = Util::get($this->cMetas, $cKey, []);
                $formatValue = Util::get($cMeta, "formatValue", null);
                if (isset($row[$cKey]) || is_callable($formatValue)) {
                    $value = ($cKey !== "#") ?
                        Util::get($row, $cKey, $this->emptyValue)
                        : ($ci + $cMeta["start"]);
                    ob_start();
                    echo $this->formatValue($value, $cMeta, $row, $cKey);
                    $dataRow[$cKey] = ob_get_clean();
                } else {
                    $dataRow[$cKey] = $this->emptyValue;
                }

                if ($rowType === "array") {
                    $dataRow[$ci] = $dataRow[$cKey];
                }
            }
            $this->rawData[] = $row;
            $this->dataRows[] = $dataRow;
        }
    }

    protected function onRender()
    {
        $this->buildRoleColumns();

        $meta = $this->dataStore->meta();
        $cMetas = Util::init($meta, 'columns', []);

        $showColumnKeys = array();
        if ($this->columns == array()) {
            $this->dataStore->popStart();
            $row = $this->dataStore->pop();
            if ($row) {
                $showColumnKeys = array_keys($row);
            } else {
                $showColumnKeys = array_keys($cMetas);
            }
        } else {
            foreach ($this->columns as $cKey => $cValue) {
                if (gettype($cValue) == "array") {
                    if ($cKey === "#") {
                        $cMetas[$cKey] = array(
                            "type" => "number",
                            "label" => "#",
                            "start" => 1,
                        );
                    }
                    if (!isset($cMetas[$cKey])) $cMetas[$cKey] = [];
                    $cMetas[$cKey] =  array_merge($cMetas[$cKey], $cValue);
                    if (!in_array($cKey, $showColumnKeys)) {
                        array_push($showColumnKeys, $cKey);
                    }
                } else {
                    if ($cValue === "#") {
                        $cMetas[$cValue] = array(
                            "type" => "number",
                            "label" => "#",
                            "start" => 1,
                        );
                    }
                    if (!in_array($cValue, $showColumnKeys)) {
                        array_push($showColumnKeys, $cValue);
                    }
                }
            }
        }
        $this->showColumnKeys = $showColumnKeys;
        $meta["columns"] = $this->cMetas = $cMetas;

        $this->buildRoleColumnDefs();

        $this->handleRowEdit();

        if ($this->serverSide) $this->buildServerSide();

        $headerRows = $this->complexHeaders ? $this->buildComplexHeaders() : [];

        if (!empty($this->groupCellsInColumns)) $this->buildRowspan();

        if (!empty($this->clientRowGroup)) $this->buildClientRowGroup();

        if ($this->fastRender || $this->serverSide) {
            // Add both string and numeric keys so that row group and features based on numeric columns work
            $this->buildDataRows('array');
        } else {
            $this->buildDataRows('assoc');
        }

        if ($this->fastRender) {
            $this->buildFastRender();
        }

        if ($this->rowDetailData) $this->buildRowDetailData();


        $this->buildColumnDefs();

        $this->meta = $meta;
        $this->template($this->template, array(
            "uniqueId" => $this->name,
            "showColumnKeys" => $this->showColumnKeys,
            "headerRows" => $headerRows,
            "meta" => $meta,
        ));
    }

    protected static function getFinalSources($node)
    {
        $finalSources = [];
        $sources = [];
        $index = 0;
        while ($source = $node->previous($index)) {
            $sources[] = $source;
            $index++;
        }
        if (empty($sources)) {
            return [$node];
        }
        foreach ($sources as $source) {
            $finalSources = array_merge(
                $finalSources,
                self::getFinalSources($source)
            );
        }
        return $finalSources;
    } 

    protected static function setNodeEnded($node, $bool)
    {
        $node->setEnded($bool);
        $index = 0;
        while ($source = $node->previous($index)) {
            self::setNodeEnded($source, $bool);
            $index++;
        }
    }

    protected function onFurtherProcessRequest($node)
    {
        if (!$this->serverSide) {
            return $node;
        }
        
        $finalSources = self::getFinalSources($node);

        if (empty($this->columns)) {
            $queryParams = [
                'start' => 0,
                'length' => 1
            ];
            $dataStore = new \koolreport\core\DataStore();
            foreach ($finalSources as $finalSource) {
                if (method_exists($finalSource, 'queryProcessing')) {
                    $finalSource->queryProcessing($queryParams);
                    $dataStore = $node->pipe($dataStore);
                    $dataStore->requestDataSending();
                    self::setNodeEnded($node, false);
                }
            }
            // $dataStore->popStart();
            // $row = $dataStore->pop();
            // if($row) {
            //     $this->trueColKeys = array_keys($row);
            // } else {
            // 	$this->trueColKeys = [];
            // }
            $this->trueColKeys = array_keys($dataStore->meta()["columns"]);
        } else {
            $this->trueColKeys = array_keys($this->columns);
        }

        foreach ($finalSources as $finalSource) {
            if (!method_exists($finalSource, 'queryProcessing')) continue;
            $queryParams = $this->parseRequest($finalSource, $this->name, $this->method);
            $originalQuery = $finalSource->originalQuery;
            $searchQuery = Util::get($this->params, "searchQuery", $originalQuery);
            if (stripos($searchQuery, "{datatables_search}") !== false) {
                $occurenceCount = 0;
                $allSearchParams = [];
                $searchParams = Util::get($queryParams, "searchParams", []);
                // echo "searchParams="; print_r($searchParams); echo "<br>";
                while (stripos($searchQuery, "{datatables_search}") !== false) {
                    $searchSql = Util::get($queryParams, "search", "1=1");
                    foreach ($searchParams as $param => $value) {
                        $searchSql = str_ireplace($param, $param . "_" . $occurenceCount, $searchSql);
                        $allSearchParams[$param . "_" . $occurenceCount] = $value;
                    }
                    // echo "searchSql=$searchSql<br>";
                    $searchQuery = $this->replaceFirstOccurence($searchQuery, "{datatables_search}", $searchSql);
                    $occurenceCount++;
                }
                // echo "searchQuery=$searchQuery<br>";
                $queryParams["search"] = null;
                $queryParams["searchParams"] = [];
                $sqlParams = $finalSource->getSqlParams();
                $sqlParams = array_merge($sqlParams, $allSearchParams);
                $query = $finalSource->getQuery();
                $finalSource->query($query, $sqlParams);
                $finalSource->originalQuery = $searchQuery;
            }
            $finalSource->queryProcessing($queryParams);
        }
        return $node;
    }

    protected function replaceFirstOccurence($haystack, $needle, $replace)
    {
        $pos = stripos($haystack, $needle);
        if ($pos !== false) {
            $newstring = substr_replace($haystack, $replace, $pos, strlen($needle));
        }
        return $newstring;
    }

    protected function getSearchAllSql(
        $datasource,
        $columns,
        $searchAllString,
        &$queryParams
    ) {
        $searchMode = $this->searchMode;
        $strToSql = function ($datasource, $columns, $searchStr, $searchOrder = 0, $searchAndOrder = 0)
        use (&$queryParams, $searchMode) {
            $trueColKeys = $this->trueColKeys;
            $phrases = [];
            $searchStr = preg_replace_callback('/"([^"]*)"/', function ($matches)
            use (&$phrases) {
                if (!empty($matches[1])) {
                    array_push($phrases, $matches[1]);
                }
                return "";
            }, $searchStr);
            $searchStr = preg_replace_callback('/([^\s\t]*)/', function ($matches)
            use (&$phrases) {
                if (!empty($matches[1])) {
                    array_push($phrases, $matches[1]);
                }
                return "";
            }, $searchStr);
            $sql = "";
            foreach ($phrases as $i => $phrase) {
                $phraseSql = "";
                foreach ($columns as $col) {
                    $searchable = Util::get($col, 'searchable', true);
                    if ($searchable !== "true") continue;
                    $colKey = $col['data'];
                    if (!in_array($colKey, $trueColKeys)) continue;
                    $paramName = ":{$colKey}_search_all_{$searchOrder}_{$searchAndOrder}_$i";
                    $this->addSqlCondition($phraseSql, "OR", "{$colKey} like $paramName");
                    $phrase = isset($searchMode["exact"]) ? $phrase : "%{$phrase}%";
                    $queryParams['searchParams'][$paramName] = $phrase;
                }
                $this->addSqlCondition($sql, "AND", $phraseSql);
            }
            return $sql;
        };

        if (isset($searchMode["or"])) {
            $searchAllString = preg_replace('/^\s*or\s+/i', '', $searchAllString);
            $searchAllString = preg_replace('/\s+or\s*$/i', '', $searchAllString);
            $searchAllString = preg_replace('/^\s*or\s+/i', '', $searchAllString);
            $searchStrings = preg_split('/\sor\s/i', $searchAllString);
            $searchAllSql = "";
            foreach ($searchStrings as $searchOrder => $searchStr) {
                if (isset($searchMode["and"])) {
                    $searchAndStrs = $searchStr;
                    // echo "searchAndStrs=$searchAndStrs<br>";
                    $searchAndStrs = preg_replace('/^\s*and\s+/i', '', $searchAndStrs);
                    $searchAndStrs = preg_replace('/\s+and\s*$/i', '', $searchAndStrs);
                    $searchAndStrs = preg_replace('/^\s*and\s+/i', '', $searchAndStrs);
                    $searchAndStrs = preg_split('/\sand\s/i', $searchAndStrs);
                    // echo "searchAndStrs="; print_r($searchAndStrs); echo "<br>";
                    $searchAllAndSql = "";
                    foreach ($searchAndStrs as $searchAndOrder => $searchAndStr) {
                        $searchAndSql = $strToSql(
                            $datasource,
                            $columns,
                            $searchAndStr,
                            $searchOrder,
                            $searchAndOrder
                        );
                        $this->addSqlCondition($searchAllAndSql, "AND", $searchAndSql);
                    }
                    // echo "searchAllAndSql=$searchAllAndSql<br>";
                    $this->addSqlCondition($searchAllSql, "OR", $searchAllAndSql);
                } else {
                    $searchSql = $strToSql($datasource, $columns, $searchStr, $searchOrder);
                    $this->addSqlCondition($searchAllSql, "OR", $searchSql);
                }
            }
        }

        if (!isset($searchMode["or"]) && !isset($searchMode["and"])) {
            $searchAllSql = $strToSql($datasource, $columns, $searchAllString, 0);
        }
        // echo "searchAllSql=$searchAllSql<br>";
        // echo "queryParams="; print_r($queryParams); echo "<br>";
        return $searchAllSql;
    }

    protected function addSqlCondition(&$sqlCondition, $andOr, $addedCondition)
    {
        if (!empty(trim($addedCondition))) {
            if (stripos($addedCondition, " OR ") !== false && $andOr !== "OR")
                $addedCondition = "($addedCondition)";
            $sqlCondition .= (empty($sqlCondition) ? "" : " $andOr ") . $addedCondition;
        }
    }

    protected function parseRequest($datasource, $dtId, $method = 'get')
    {
        $trueColKeys = $this->trueColKeys;
        $queryParams = [
            'start' => 0,
            'length' => 1,
            'searchParams' => [],
        ];
        $request = strtolower($method) === 'post' ? $_POST : $_GET;
        $id = Util::get($request, 'id', null);
        if ($id == $dtId) {
            $searchSql = "";
            $columns = Util::get($request, 'columns', []);
            // echo "columns = "; print_r($columns); echo "<br>";
            $searchColsSql = "";
            foreach ($columns as $colMeta) {
                // echo "col="; print_r($col);
                $searchable = Util::get($colMeta, 'searchable', true);
                if ($searchable !== "true") continue;
                $colKey = $colMeta['data'];
                if (!in_array($colKey, $trueColKeys)) continue;
                $colSearchVal = Util::get($colMeta, ['search', 'value'], null);
                if (empty($colSearchVal)) continue;
                $paramName = ":{$colKey}_search";
                $this->addSqlCondition($searchColsSql, "AND", "$colKey like $paramName");
                $searchColPhrase = isset($this->searchMode["exact"]) ?
                    $colSearchVal : "%{$colSearchVal}%";
                $queryParams['searchParams'][$paramName] = $searchColPhrase;
            }
            $this->addSqlCondition($searchSql, "AND", $searchColsSql);
            // echo "searchSql=$searchSql<br>";

            $searchAll = Util::get($request, 'search', []);
            $searchAllString = Util::get($searchAll, 'value', null);
            $searchAllSql = $this->getSearchAllSql(
                $datasource,
                $columns,
                $searchAllString,
                $queryParams
            );
            // echo "searchAllSql=$searchAllSql<br>";

            $this->addSqlCondition($searchSql, "AND", $searchAllSql);
            $queryParams['search'] = $searchSql;
            // echo "searchSql=$searchSql<br>";

            $orders = Util::get($request, 'order', []);
            // echo "orders = "; print_r($orders); echo "<br>";
            $orderSql = "";
            foreach ($orders as $order) {
                $colNum = $order['column'];
                $colMeta = Util::get($columns, $colNum, []);
                $colKey = Util::get($colMeta, 'data');
                if (!in_array($colKey, $trueColKeys)) continue;
                $orderable = Util::get($colMeta, 'orderable', true);
                if ($orderable !== "true") continue;

                $dir = strtolower($order['dir']);
                if ($dir !== "asc"  && $dir !== "desc") continue;
                $orderSql .= $colKey . " " . $dir . ",";
            }
            if (!empty($orderSql)) {
                $orderSql = substr($orderSql, 0, -1);
                $queryParams['order'] = $orderSql;
            }

            $start = (int) Util::get($request, 'start', 0);
            $length = (int) Util::get($request, 'length', 1);
            $queryParams['start'] = $start;
            $queryParams['length'] = $length;

            $queryParams['countTotal'] = true;
            $queryParams['countFilter'] = true;

            foreach ($this->columns as $cKey => $cSetting) {
                $footerMethod = strtolower(Util::get($cSetting, "footer"));
                if (!in_array($footerMethod, ["sum", "count", "avg", "min", "max"])) continue;
                // $footerText = Util::get($this->columns, [$cKey, "footerText"]);
                Util::init($queryParams, ["aggregates", $footerMethod], []);
                $queryParams["aggregates"][$footerMethod][] = $cKey;

                $aggregates = Util::get($this->columns, [$cKey, "aggregates"], []);
                // echo 'parseRequest aggregates='; Util::prettyPrint($aggregates); 
                foreach ($aggregates as $agg) {
                    $aggMethod = strtolower(Util::get($agg, 0));
                    $aggField = Util::get($agg, 1);
                    // echo "aggMethod=$aggMethod<br>";
                    // echo "aggField=$aggField<br>";
                    if (!in_array($aggMethod, ["sum", "count", "avg", "min", "max"])) continue;
                    Util::init($queryParams, ["aggregates", $aggMethod], []);
                    $queryParams["aggregates"][$aggMethod][] = $aggField;
                }
            }
        }
        // echo 'parseRequest queryParams='; Util::prettyPrint($queryParams); 
        return $queryParams;
    }

    protected function buildRoleColumns()
    {
        $this->defaultEditButtons = [
            "add" => "<button class='btn btn-secondary' type='button' >Add</button>",
            "edit" => "<button class='btn btn-secondary' type='button' >Edit</button>",
            "cancelEdit" => "<button class='btn btn-secondary' type='button' >Cancel</button>",
            "update" => "<button class='btn btn-secondary' type='button' >Update</button>",
            "delete" => "<button class='btn btn-secondary' type='button' >Delete</button>",
            "insert" => "<button class='btn btn-secondary' type='button' >Insert</button>",
            "cancelInsert" => "<button class='btn btn-secondary' type='button' >Cancel</button>",
        ];
        $this->editButtons = Util::get($this->params, "editButtons", []);
        $this->editButtons = array_merge($this->defaultEditButtons, $this->editButtons);
        foreach ($this->editButtons as $k => $editButton) {
            if ($k == "cancelEdit" || $k == "update") {
                $this->editButtons[$k] = "<div class='btn-{$k}-wrapper' style='display: none'>{$editButton}</div>";
            } else {
                $this->editButtons[$k] = "<div class='btn-{$k}-wrapper'>{$editButton}</div>";
            }
        }
        $editButtons = $this->editButtons;

        // echo "this->columns = "; print_r($this->columns); echo "<br>";
        foreach ($this->columns as $k => $colSetting) {
            if (!is_array($colSetting)) continue;
            $role = strtolower((string) Util::get($colSetting, "role"));
            if (!empty($role)) {
                $roles = explode("|", $role);

                // print_r($roles); echo "<br>";
                $isAddEditDelete = true;
                foreach ($roles as $role) {
                    if (!in_array($role, ["add", "edit", "delete"])) $isAddEditDelete = false;
                }
                if ($isAddEditDelete) {
                    $colSetting["formatValue"] = function () use ($roles, $editButtons) {
                        $buttonStr = "";
                        foreach ($roles as $role) {
                            $buttonStr .= Util::get($editButtons, $role, "");
                            if ($role == "edit") {
                                $buttonStr .= Util::get($editButtons, "cancelEdit", "");
                                $buttonStr .= Util::get($editButtons, "update", "");
                            }
                        }
                        return $buttonStr;
                    };
                    $this->columns[$k] = $colSetting;
                }
            }
        }
        // print_r($this->columns); echo "<br>";
    }

    protected function buildRoleColumnDefs()
    {
        $columnDefs = Util::init($this->options, "columnDefs", []);
        foreach ($this->showColumnKeys as $i => $cKey) {
            $role = Util::get($this->cMetas, [$cKey, "role"]);
            $roles = explode("|", (string) $role);
            foreach ($roles as $role) {
                if (!in_array($role, ["add", "edit", "delete"])) continue;
                $columnDef = [
                    "targets" => $i,
                    "className" => "{$role}-column",
                ];
                $columnDefs[] = $columnDef;
            }
        }
        $this->options["columnDefs"] = $columnDefs;
    }

    protected function handleRowEdit()
    {
        $insertFunc = Util::get($this->params, "insertFunction");
        $deleteFunc = Util::get($this->params, "deleteFunction");
        $updateFunc = Util::get($this->params, "updateFunction");
        $insertParams = Util::get($_POST, [$this->name, "insertParams"]);
        $deleteParams = Util::get($_POST, [$this->name, "deleteParams"]);
        $updateParams = Util::get($_POST, [$this->name, "updateParams"]);
        // echo "deleteParams = "; var_dump($deleteParams); echo "<br>";
        if (is_callable($insertFunc) && !empty($insertParams)) {
            $row = $formattedRow = [];
            foreach ($insertParams as $paramName => $paramValue) {
                $cKey = trim($paramName, ":");
                $row[$cKey] = $paramValue;
            }
            foreach ($this->showColumnKeys as $ci => $cKey) {
                if (!isset($insertParams[":" . $cKey])) continue;
                $value = $row[$cKey];
                $cMeta = Util::get($this->cMetas, $cKey, []);
                ob_start();
                echo $this->formatValue($value, $cMeta, $row, $cKey);
                $formattedRow[$cKey] = ob_get_clean();
            }
            $result = $insertFunc($insertParams);
            $result["formattedRow"] = $formattedRow;
            echo "<dt-ajax-edit id='{$this->name}'>" . json_encode($result) . "</dt-ajax-edit>";
            exit;
        }

        if (is_callable($updateFunc) && !empty($updateParams)) {
            $row = $formattedRow = [];
            foreach ($updateParams as $paramName => $paramValue) {
                $cKey = trim($paramName, ":");
                $row[$cKey] = $paramValue;
            }
            foreach ($this->showColumnKeys as $ci => $cKey) {
                if (!isset($updateParams[":" . $cKey])) continue;
                $value = $row[$cKey];
                $cMeta = Util::get($this->cMetas, $cKey, []);
                ob_start();
                echo $this->formatValue($value, $cMeta, $row, $cKey);
                $formattedRow[$cKey] = ob_get_clean();
            }
            $result = $updateFunc($updateParams);
            $result["formattedRow"] = $formattedRow;
            echo "<dt-ajax-edit id='{$this->name}'>" . json_encode($result) . "</dt-ajax-edit>";
            exit;
        }

        if (is_callable($deleteFunc) && !empty($deleteParams)) {
            $result = $deleteFunc($deleteParams);
            echo "<dt-ajax-edit id='{$this->name}'>" . json_encode($result) . "</dt-ajax-edit>";
            exit;
        }
    }

    protected function getColumnFooter($cKey, $aggregateResults = [])
    {
        $cMeta = Util::get($this->meta, ["columns", $cKey], []);
        $method = Util::get($cMeta, "footer");
        $footerText = Util::get($cMeta, "footerText");
        $footerValue = "";
        if (gettype($method) != "string" && is_callable($method)) {
            $footerValue = $method($this->dataStore);
        } else if (gettype($method) == "string") {
            $method = strtolower($method);
            if (in_array($method, array("count", "sum", "avg", "min", "max", "mode"))) {
                $footerValue = Util::get($aggregateResults, [$method, $cKey]);
                if (!isset($footerValue)) $footerValue = $this->dataStore->$method($cKey);
                $aggMeta = $cMeta;
                if ($method === "count") {
                    unset($aggMeta["prefix"]);
                    unset($aggMeta["suffix"]);
                }
                $footerValue = $this->formatValue($footerValue, $aggMeta, $cKey);
            }
        }

        $aggValues = [];
        $aggregates = Util::get($cMeta, "aggregates", []);
        foreach ($aggregates as $aggName => $agg) {
            if (is_callable($agg)) {
                $aggValues[$aggName] = $agg($this->dataStore);
            } else if (gettype($agg) == "array") {
                $method = strtolower($agg[0]);
                $cKey = $agg[1];
                $cMeta = Util::get($this->meta, ["columns", $cKey], []);
                if (in_array($method, array("count", "sum", "avg", "min", "max", "mode"))) {
                    $aggValue = Util::get($aggregateResults, [$method, $cKey]);
                    if (!isset($aggValue)) $aggValue = $this->dataStore->$method($cKey);
                    $aggMeta = $cMeta;
                    if ($method === "count") {
                        unset($aggMeta["prefix"]);
                        unset($aggMeta["suffix"]);
                    }
                    $aggValue = $this->formatValue($aggValue, $aggMeta, $cKey);
                    $aggValues[$aggName] = $aggValue;
                }
            }
        }

        if ($footerText) {
            $footerText = str_replace("@value", $footerValue, $footerText);
            foreach ($aggValues as $aggName => $aggValue) {
                $footerText = str_replace("@" . $aggName, $aggValue, $footerText);
            }
            return $footerText;
        } else {
            return $footerValue;
        }
    }

    /**
     * Render javascript code to implement user's custom script 
     * just before init DataTables
     * 
     * @return null
     */
    protected function clientSideBeforeInit()
    {
        if ($this->onBeforeInit != null) {
            echo "(" . $this->onBeforeInit . ")();";
        }
    }
}
