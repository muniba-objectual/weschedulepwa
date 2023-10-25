<?php 
    use koolreport\dashboard\Client;
    $buttons = $this->buttons();
    $showingKeys = $this->showingKeys();
    $disabledKeys = $this->disabledKeys();
    $params = $this->funcParams();
?>
<div <?php echo $this->cssStyle()!==null?"style='".$this->cssStyle()."'":""; ?> class="actions-field <?php echo $this->cssClass()!==null?$this->cssClass():""; ?>">
    <?php foreach($showingKeys as $key): ?>
        <?php 
            $button = $buttons[$key];
            $_props = $button->_getProps(["type","cssStyle","cssClass","size","onClick","icon","text","title"],$params);
            $_props["onClick"] = Client::exec($_props["onClick"]);
            $disabled = in_array($key,$disabledKeys);
        ?>
        <button title="<?php echo $_props["title"]; ?>" <?php echo $disabled?"disabled":"";?> onclick="<?php echo $_props["onClick"]; ?>" class="btn btn-<?php echo $_props["size"]; ?> btn-<?php echo $_props["type"]; ?> <?php echo $_props["cssClass"]; ?>" style="<?php echo $_props["cssStyle"] ?>">
            <?php echo ($_props["icon"]!==null)?"<i class='".$_props["icon"]."'></i>":""?>
            <?php echo $_props["text"]; ?>
        </button>
    <?php endforeach ?>
</div>