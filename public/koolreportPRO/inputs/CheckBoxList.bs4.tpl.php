<?php

use koolreport\core\Utility;

foreach($this->data as $item)
{
    $value = $item["value"];
    $text = $item["text"];
    $id = "chkitem".Utility::getUniqueId();
?>
    <div class="form-check <?php echo $this->display=="horizontal"?"form-check-inline":""; ?>">
        <input id="<?php echo $id; ?>" class="form-check-input" type="checkbox" aName="<?php echo $this->name; ?>" name="<?php echo $this->name."[]"; ?>" value="<?php echo $value ?>" <?php echo(in_array($value,$this->value))?"checked":""; ?><?php echo $this->disabled?" disabled":"";?>>
        <label class="form-check-label" for="<?php echo $id; ?>"><?php echo $text; ?></label>
    </div>
<?php
}
?>
<input type="hidden" name="__<?php echo $this->name; ?>" value='<?php echo json_encode($this->value); ?>'/>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->getResources()); ?>,function(){
    <?php echo $this->name; ?> = new CheckBoxList("<?php echo $this->name; ?>");
    var name = <?php echo $this->name; ?>;
    <?php
    if($this->clientEvents)
    {
        foreach($this->clientEvents as $eventName=>$function)
        {
        ?>
            <?php echo $this->name; ?>.on('<?php echo $eventName; ?>',<?php echo $function; ?>);
        <?php
        }    
    }
    ?>
    <?php $this->clientSideReady();?>
});
</script>