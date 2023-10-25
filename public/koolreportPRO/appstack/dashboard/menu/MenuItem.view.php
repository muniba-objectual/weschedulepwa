<?php
    use koolreport\dashboard\Client;
    use koolreport\core\Utility;
    $_itemProps = $item->_getProps(["icon","text","onClick","href","cssStyle","cssClass","target","badge","disabled"]); 
    $_itemProps["onClick"] = Client::exec($_itemProps["onClick"]);
?>
<a onclick="<?php echo $_itemProps["onClick"]; ?>" target="<?php echo $_itemProps["target"]; ?>" style="<?php echo $_itemProps["cssStyle"]; ?>" class="<?php echo isset($aCssClass)?$aCssClass:""; ?> <?php echo $_itemProps["cssClass"]; ?><?php echo $_itemProps["disabled"]===true?" disabled":"";?>" href="<?php echo $_itemProps["href"]; ?>">
    <?php if($_itemProps["icon"]!==null): ?>
        <i class="<?php echo $_itemProps["icon"]; ?>"></i> 
    <?php endif ?>
    <?php echo $_itemProps["text"]; ?>
    <?php if($_itemProps["badge"]!==null): ?>
        <?php if (is_string($_itemProps["badge"])): ?>
            <span class="badge badge-danger"><?php echo $_itemProps["badge"]; ?></span>
        <?php elseif(is_array($_itemProps["badge"])): ?>
            <span class="badge badge-<?php echo Utility::get($_itemProps["badge"],1); ?>"><?php echo Utility::get($_itemProps["badge"],0); ?></span>
        <?php endif ?>
    <?php endif ?>
</a>
