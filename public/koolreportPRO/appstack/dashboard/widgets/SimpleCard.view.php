<?php

use koolreport\dashboard\Client;

$_props = $this->_props();
    if($_props["onClick"]!=null) {
        $_props["cssStyle"] = "cursor:pointer;".$_props["cssStyle"]; 
    }
?>
<div title="<?php echo $_props["title"]; ?>" <?php echo ($_props["onClick"]!=null)?"onclick=\"".Client::exec($_props["onClick"])."\"":""; ?> class="card simple-card <?php echo $_props["cssClass"]; ?>" style="<?php echo $_props["cssStyle"]; ?>">
    <div class="card-body p-0 clearfix">
        <i class="<?php echo $_props["icon"]; ?> bg-<?php echo $_props["type"]; ?> p-4 font-2xl mr-3 float-left"></i>
        <div class="h5 text-<?php echo $_props["type"]; ?> mb-0 pt-3"><?php echo $this->formattedValue(); ?></div>
        <div class="text-muted text-uppercase font-weight-bold font-xs"><?php echo $_props["text"]; ?></div>
    </div>
</div>