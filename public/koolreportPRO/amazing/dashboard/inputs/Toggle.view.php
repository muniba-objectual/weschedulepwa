<?php
$_props = $this->_props();

$kind = "switch-default";
if($_props["is3D"]===true) {
    $kind = "switch-3d";
}
if($_props["showText"]===true) {
    $kind = "switch-text";
    $onText = $_props["onText"];
    $offText = $_props["offText"];
}
?>
<label <?php echo $_props["cssStyle"]?"style='".$_props["cssStyle"]."'":""; ?> class="switch <?php echo $kind; ?> <?php echo $_props["size"]!==null?"switch-".$_props["size"]:""; ?> switch-<?php echo $_props["type"] ?><?php echo $_props["outline"]===true?"-outline":""; ?><?php echo $_props["pill"]===true?" switch-pill":""; ?> <?php echo $_props["cssClass"]; ?>">
    <input id="<?php echo $this->toggleName(); ?>"
            <?php echo $_props["onClick"]!==null?'onclick="_exec(\''.base64_encode($_props["onClick"]).'\')"':""; ?>
            name="<?php echo $this->toggleName(); ?>" 
            type="checkbox"
            class="switch-input"
            <?php echo $_props["value"]==1?"checked":""; ?>>
    <span class="switch-label" <?php echo $_props["showText"]?"data-on='$onText' data-off='$offText'":"" ?>></span>
    <span class="switch-handle"></span>
</label>