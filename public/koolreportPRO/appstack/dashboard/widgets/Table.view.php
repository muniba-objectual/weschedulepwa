<?php

use koolreport\dashboard\Client;
use \koolreport\dashboard\Lang;
$this->widgetResources([
    "js"=>["widgets/table/table.js"],
]);

$_props = $this->_props();
$clientRowClick = $this->clientRowClick();
$tableClass = "table";
if($_props["tableHover"]===true) {
    $tableClass.=" table-hover";
}
if($_props["tableOutline"]===true) {
    $tableClass.=" table-outline";
}
if($_props["tableStriped"]===true) {
    $tableClass.=" table-striped";
}
if($_props["tableSmall"]===true) {
    $tableClass.=" table-sm";
}
if($_props["tableBordered"]===true) {
    $tableClass.=" table-bordered";
}
$theadClass = "";
if($_props["headerDark"]===true) {
    $theadClass.="thead-light";
}
?>
<?php if($_props["searchable"]===true && $_props["showSearchBox"]===true): ?>
<div class="input-group mb-1" style="width:<?php echo $_props["searchWidth"]; ?>;float:<?php echo $_props["searchAlign"]; ?>">
    <div class="input-group-prepend">
        <span class="input-group-text" id="btnGroupAddon"><i class="fa fa-search"></i></span>
    </div>
    <input id="<?php echo $this->tableName(); ?>_searchBox" value="<?php echo $_props["searchText"]; ?>" onchange="<?php echo $this->tableName(); ?>.search(this)" type="text" placeholder="<?php echo Lang::t("Search..") ?>" class="form-control"/>
</div>
<?php endif ?>
<div id="<?php echo $this->tableName(); ?>" class="koolreport-dashboard-table<?php echo $_props["tableResponsive"]===true?" table-responsive":"";?>">
<table class="<?php echo $tableClass; ?>">
    <thead class="<?php echo $theadClass; ?>">
        <tr>
            <?php foreach($this->fields() as $field): ?>
                <?php 
                    $hasSort = $field->hasProp("sortable") && $field->sortable();
                ?>
                <th style="vertical-align:middle" class="text-<?php echo $field->_textAlign();?>" <?php 
                    if($hasSort) {
                        echo "onClick=\"".$this->tableName().".toggleSorting('".$field->name()."')\" ";
                        echo "style='cursor:pointer'";
                    }
                    ?>>
                    <?php echo $field->label(); ?>
                        <?php if($hasSort): ?>
                            <span style="margin-left:5px;">
                                <?php if ($field->sort()==="desc"): ?>
                                    <i class="fa fa-sort-up"></i>
                                <?php elseif($field->sort()==="asc"): ?>
                                    <i class="fa fa-sort-down"></i>
                                <?php else: ?>
                                    <i class="fa fa-sort" style="color:#ccc"></i>
                                <?php endif ?>
                            </span>
                        <?php endif ?>
                </th>
            <?php endforeach ?>
        </tr>    
    </thead>
    <tbody>
        <?php foreach($this->data() as $row): ?>
        <tr <?php echo $clientRowClick!==null?"onclick=\"".Client::exec($clientRowClick($row))."\"":""; ?>>
            <?php foreach($this->fields() as $field): ?>
                <?php $field->row($row); ?>
                <td <?php echo ($field->_onCellClick()!=null)?"onclick=\"".$field->_onCellClick($field->value(),$field->row())."\" ":""; ?>class="text-<?php echo $field->_textAlign();?>"><?php echo $field->view(); ?></td>
            <?php endforeach ?>
        </tr>
        <?php endforeach ?>    </tbody>
    <?php if($_props["showFooter"]===true): ?>
        <tfooter>
            <tr>
                <?php foreach($this->fields() as $field): ?>
                    <td class="text-<?php echo $field->_textAlign();?>">
                        <?php
                            if($field->footer()!==null || $field->footerText()!==null) {
                                echo str_replace(
                                    "@value",
                                    $field->footer()!==null?$field->formatValue($this->aggregates()[$field->colName()."_".strtolower($field->footer())]):"",
                                    $field->footerText()!==null?$field->footerText():"<b>@value</b>"
                                );
                            }
                        ?>
                    </td>
                <?php endforeach ?>
            </tr>
        </tfooter>
    <?php endif ?>
</table>
</div>
<?php if($_props["pageSize"]>0): ?>
    <div id="<?php echo $this->tableName(); ?>_paging" class="koolreport-dashboard-table-paging text-<?php echo $_props["pageAlign"]; ?>">
        
        <?php if(is_array($_props["pageSizeOptions"])):?>
            <div class="btn-group" style="margin-top:-4px;">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_props["pageSize"]; ?>
                </button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <?php foreach($_props["pageSizeOptions"] as $size): ?>
                        <a class="dropdown-item" href="javascript: void 0" onclick="<?php echo Client::exec($this->tableName().".changePageSize($size);"); ?>"><?php echo $size; ?></a>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endif ?>
        <nav style="display:inline-block"></nav>
    </div>
<?php endif ?>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->widgetResources()); ?>,function(){
    <?php echo $this->tableName(); ?> = new KoolReport.dashboard.widgets.Table(
        "<?php echo $this->tableName(); ?>",
        <?php echo json_encode([
            "paging"=>$this->paging()
        ]); ?>);
});
</script>