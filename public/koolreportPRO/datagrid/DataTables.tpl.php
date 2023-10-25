<?php

use \koolreport\core\Utility as Util;

$cMetas = Util::get($meta, "columns", []);

$tableCss = Util::get($this->cssClass, "table");
$trClass = Util::get($this->cssClass, "tr");
$tdClass = Util::get($this->cssClass, "td");
$thClass = Util::get($this->cssClass, "th");
$tfClass = Util::get($this->cssClass, "tf");

$tableAttrs = Util::get($this->attributes, "table");
$trAttrs = Util::get($this->attributes, "tr");
$tdAttrs = Util::get($this->attributes, "td");
$thAttrs = Util::get($this->attributes, "th");
$tfAttrs = Util::get($this->attributes, "tf");

$tableStyle = Util::get($this->cssStyle, "table");
$trStyle = Util::get($this->cssStyle, "tr");
$tdStyle = Util::get($this->cssStyle, "td");
$thStyle = Util::get($this->cssStyle, "th");
$tfStyle = Util::get($this->cssStyle, "tf");

$getMappedProperty = function ($mappedProperty, $default) {
    $args = func_get_args();
    $args = array_slice($args, 2);
    $property = is_callable($mappedProperty) ?
        call_user_func_array($mappedProperty, $args) : $mappedProperty;
    if (!isset($property)) $property = $default;
    return $property;
};

$draw = (int) Util::get($this->submitType, 'draw', 0);
$id = Util::get($this->submitType, 'id', null);
$ajax = $this->serverSide && $id == $this->name;
$aggregateResults = [];
if ($ajax) {
    $aggregateResults = Util::get($meta, 'aggregates', []);
    $footers = [];
    foreach ($this->columns as $cKey => $cSetting) {
        $footers[$cKey] = $this->getColumnFooter($cKey, $aggregateResults);
    }
    echo "<dt-ajax id='dt_{$this->name}'>";
    $resData = [
        'draw' => $draw + 1,
        'recordsTotal' => Util::get($meta, 'totalRecords', 0),
        'recordsFiltered' => Util::get($meta, 'filterRecords', 0),
        'aggregates' => $aggregateResults,
        'footers' => $footers,
        'data' => $this->dataRows,
    ];
    echo json_encode($resData);
    echo "</dt-ajax>";
    return;
}
?>
<table id="<?php echo $this->name; ?>" <?php
                                        $attrs = $getMappedProperty($tableAttrs, [], $this->dataStore);
                                        foreach ($attrs as $k => $v) echo "$k='$v'";
                                        $cssClass = $getMappedProperty($tableCss, "table display", $this->dataStore);
                                        echo "class='$cssClass'";

                                        $cssStyle = $getMappedProperty($tableStyle, "", $this->dataStore);
                                        echo "style='$cssStyle'";
                                        ?>>
    <thead>
        <?php if (!$this->complexHeaders) { ?>
            <tr>
                <?php
                foreach ($showColumnKeys as $ci => $cKey) {
                    $label = Util::get($cMetas, [$cKey, "label"], $cKey);
                    $cMeta = Util::get($cMetas, $cKey, []);
                ?>
                    <th <?php
                        $attrs = $getMappedProperty($thAttrs, [], $cKey, $cMeta);
                        foreach ($attrs as $k => $v) echo "$k='$v'";
                        $cssClass = $getMappedProperty($thClass, "", $cKey, $cMeta);
                        echo "class='$cssClass header-$cKey'";
                        $cssStyle = $getMappedProperty($thStyle, "", $cKey, $cMeta);
                        echo "style='$cssStyle'";
                        ?>>
                        <div class='header-content-wrapper'>
                            <?php echo $label; ?>
                        </div>
                    </th>
                <?php
                }
                ?>
            </tr>
        <?php } else {
            foreach ($headerRows as $aHeaderRow) {
                echo "<tr>";
                foreach ($aHeaderRow as $header) {
                    if (isset($header['text'])) {
                        $text = $header['text'];
                        $colspan = Util::get($header, 'colspan', 1);
                        $rowspan = Util::get($header, 'rowspan', 1);
                        $cssClass = $getMappedProperty($thClass, "", $text, []);
                        echo "<th class='$cssClass' colspan='$colspan' rowspan='$rowspan'>
                    $text</th>";
                    }
                }
                echo "</tr>";
            }
        } ?>
    </thead>
    <?php if (!$this->serverSide && !$this->fastRender) { ?>
        <tbody>
            <?php foreach ($this->dataRows as $i => $row) { ?>
                <tr <?php
                    $attrs = $getMappedProperty($trAttrs, [], $row, $cMetas);
                    foreach ($attrs as $k => $v) echo "$k='$v'";
                    $cssClass = $getMappedProperty($trClass, "", $row, $cMetas);
                    echo "class='$cssClass'";
                    $cssStyle = $getMappedProperty($trStyle, "", $row, $cMetas);
                    echo "style='$cssStyle'";
                    ?>>
                    <?php
                    foreach ($showColumnKeys as $cKey) {
                        $cMeta = Util::get($cMetas, $cKey, []);
                    ?>
                        <td <?php
                            $attrs = $getMappedProperty($tdAttrs, [], $row, $cKey, $cMeta);
                            foreach ($attrs as $k => $v) echo "$k='$v'";
                            $cssClass = $getMappedProperty($tdClass, "", $row, $cKey, $cMeta);
                            echo "class='$cssClass'";
                            $cssStyle = $getMappedProperty($tdStyle, "", $row, $cKey, $cMeta);
                            echo "style='$cssStyle'";
                            foreach (['data-order', 'data-search'] as $d)
                                if (isset($cMeta[$d]))
                                    echo "$d='" . Util::get($row, $cMeta[$d], '') . "'";
                            ?>>
                            <?php
                            echo $row[$cKey];
                            ?>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
            <?php
            }
            ?>
        </tbody>
    <?php } ?>
    <?php
    if ($this->showFooter) {
    ?>
        <tfoot>
            <tr>
                <?php
                foreach ($showColumnKeys as $cKey) {
                    $cMeta = Util::get($cMetas, $cKey, []);
                ?>
                    <td <?php
                        $attrs = $getMappedProperty($tfAttrs, [], $cKey, $cMeta);
                        foreach ($attrs as $k => $v) echo "$k='$v'";
                        $cssClass = $getMappedProperty($tfClass, "", $cKey, $cMeta);
                        echo "class='$cssClass footer-$cKey'";
                        $cssStyle = $getMappedProperty($tfStyle, "", $cKey, $cMeta);
                        echo "style='$cssStyle'";
                        ?>>
                        <div class='footer-content-wrapper'>
                            <?php
                            echo $this->getcolumnFooter($cKey, $aggregateResults);
                            ?>
                        </div>
                    </td>
                <?php
                }
                ?>
            </tr>
        </tfoot>
    <?php
    }
    ?>
</table>
<script type="text/javascript">
    KoolReport.widget.init(
        <?php echo json_encode($this->getResources()); ?>,
        function() {
            <?php $this->clientSideBeforeInit(); ?>

            var name = '<?php echo $uniqueId; ?>';
            var dtOptions = <?php echo ($this->options == array()) ? "" : Util::jsonEncode($this->options); ?>;
            var fastRender = <?php echo $this->fastRender ? 1 : 0; ?>;
            if (fastRender) {
                var dataRows = <?php echo json_encode($this->dataRows); ?>;
                dtOptions.data = dataRows;
                // <?php echo $uniqueId; ?>_data.dataRows = dataRows;
            }
            window[name + '_state'] = {};
            var dt = window[name] = $('#' + name).DataTable(dtOptions);

            var <?php echo $uniqueId; ?>_data = {
                id: '<?php echo $uniqueId; ?>',
                searchOnEnter: <?php echo $this->searchOnEnter ? 1 : 0; ?>,
                searchMode: <?php echo json_encode($this->searchMode); ?>,
                serverSide: <?php echo $this->serverSide ? 1 : 0; ?>,
                serverSideInstantSearch: <?php echo $this->serverSideInstantSearch ? 1 : 0; ?>,
                overrideSearchInput: <?php echo $this->overrideSearchInput ? 1 : 0; ?>,
                rowDetailData: dtOptions.rowDetailData,
                showColumnKeys: <?php echo json_encode($showColumnKeys); ?>,
                columns: <?php echo json_encode($this->columns); ?>,
                editButtons: <?php echo json_encode($this->editButtons); ?>,
                editUrl: '<?php echo Util::get($this->params, "editUrl"); ?>',
                fastRender: fastRender,
                rowDetailIcon: <?php echo $this->rowDetailIcon ? 1 : 0; ?>,
                rowDetailSelector: '<?php echo $this->rowDetailSelector; ?>',
            };
            <?php echo $uniqueId; ?>_data.rawData = <?php echo json_encode($this->rawData); ?>;
            KR<?php echo $uniqueId; ?> = KoolReport.KRDataTables.create(
                <?php echo $uniqueId; ?>_data);

            <?php if ($this->clientEvents) {
                foreach ($this->clientEvents as $eventName => $function) { ?>
                    dt.on("<?php echo $eventName; ?>", <?php echo $function; ?>);
            <?php }
            } ?>

            <?php $this->clientSideReady(); ?>
        }
    );
</script>