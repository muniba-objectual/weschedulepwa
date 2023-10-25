<?php

use \koolreport\dashboard\Client;

$_props = $this->_props();

$class = "btn ";
if($_props["size"]!==null) {
    $class .= "btn-".$_props["size"];
}
if($_props["type"]!==null) {
    $class .= " btn-".($_props["outline"]===true?"outline-":"").$_props["type"];
}
if($_props["blockLevel"]===true) {
    $class.=" btn-block";
}
$icon = "";
if($_props["icon"]!==null) {
    $icon = "<i class='".$_props["icon"]."'></i>";
}
$_props["onClick"] = Client::exec($_props["onClick"]);
?>
<button 
    id="<?php echo $this->buttonId(); ?>"
    type="button"
    class="<?php echo $class; ?>"
    onclick="<?php echo $_props["onClick"]; ?>"    
    <?php foreach($_props["attributes"] as $k=>$v) { echo " $k='$v'"; }?>
    <?php echo $_props["disabled"]===true?"disabled":""; ?>>
<?php echo $icon; ?><?php echo $_props["text"]; ?>
</button>