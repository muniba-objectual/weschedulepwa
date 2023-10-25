<?php
use koolreport\dashboard\Client;
$_itemProps = $menuItem->_getProps(["hidden","icon","title","onClick","href","cssStyle","cssClass","target","badge"]); 
$_itemProps["onClick"] = Client::exec($_itemProps["onClick"]);
?>
<li class="sidebar-item<?php echo $_itemProps["hidden"]===true?" d-none":"";?>">
    <a data-path="<?php echo htmlspecialchars(json_encode($path)); ?>" data-name="<?php echo $menuItem->name(); ?>" onclick="<?php echo $_itemProps["onClick"]; ?>" target="<?php echo $_itemProps["target"]; ?>" style="<?php echo $_itemProps["cssStyle"]; ?>" class="sidebar-link<?php echo " ".$_itemProps["cssClass"]; ?>" href="<?php echo $_itemProps["href"]; ?>">
        <?php if($_itemProps["icon"]!==null): ?>
            <i class="<?php echo $_itemProps["icon"]; ?>"></i> 
        <?php endif ?>
        <?php echo $_itemProps["title"]; ?>
        <?php if($_itemProps["badge"]!==null): ?>
            <?php if (is_string($_itemProps["badge"])): ?>
                <span class="badge badge-danger"><?php echo $_itemProps["badge"]; ?></span>
            <?php elseif(is_array($_itemProps["badge"])): ?>
                <span class="badge badge-<?php echo Utility::get($_itemProps["badge"],1); ?>"><?php echo Utility::get($_itemProps["badge"],0); ?></span>
            <?php endif ?>
        <?php endif ?>
    </a>
</li>