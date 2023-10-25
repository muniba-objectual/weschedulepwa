<?php
use \koolreport\dashboard\Client;
$this->widgetResources([
    "js"=>["widgets/checkbox/checkbox.js"],
]);
$_props = $this->_props();
$name = $this->master()->name();
$_props["onChange"] = Client::exec($_props["onChange"]);
?>
<div title="<?php echo $_props["title"]; ?>" style="<?php echo $_props["cssStyle"];?>" class="checkbox form-check <?php echo $_props["inline"]===true?"form-check-inline":"";?> <?php echo $_props["cssClass"] ?>">
    <input id="<?php echo $name;?>" onchange="<?php echo $_props["onChange"]; ?>" name="<?php echo $name; ?>" type="checkbox" class="form-check-input" <?php echo $_props["value"]==1?"checked":"";?> <?php echo $_props["disabled"]===true?"disabled":""; ?> />
    <?php if($_props["text"]!==null): ?>
    <label for="<?php echo $name;?>" class="form-check-label"><?php echo $_props["text"]; ?></label>
    <?php endif ?>
</div>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->widgetResources()); ?>,function(){
    <?php echo $name ?> = new KoolReport.dashboard.widgets.CheckBox("<?php echo $name; ?>");
});
</script>