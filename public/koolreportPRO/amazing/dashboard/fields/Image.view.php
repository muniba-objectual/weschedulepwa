<?php
$class = "";

$_props = $this->_props();

if($_props["roundedCircle"]===true) {
    $class.="rounded-circle ";
}
if($_props["rounded"]===true) {
    $class.="rounded ";
}
if($_props["thumbnail"]===true) {
    $class.="img-thumbnail ";
}
if($_props["responsive"]===true) {
    $class.="img-fluid ";
}
$class.=$_props["cssClass"];

$style="";

if($_props["maxSize"]===false) {
    if($_props["width"]!==null){
        $style.="width:".$_props["width"].";";
    }
    if($_props["height"]!==null){
        $style.="height:".$_props["height"].";";
    }
} else {
    $class .= "img-fluid";
}


$style.=$_props["cssStyle"];
?>
<img src="<?php echo $_props["url"]; ?>"<?php echo $class!==""?" class='$class'":""; ?><?php echo $style!==""?" style='$style'":""; ?>/>