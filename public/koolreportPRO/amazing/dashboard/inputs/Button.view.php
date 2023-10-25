<?php 
    use \koolreport\dashboard\Client;
    $_props = $this->_props();
    $_props["onClick"] = Client::exec($_props["onClick"]);
?>
<button 
    id="<?php echo $this->buttonName(); ?>" 
    type="button" 
    <?php echo $_props["disabled"]===true?"disabled":""; ?>
    <?php echo ($_props["laddaOnAction"]===true && $_props["laddaStyle"]!==null)?"data-style='".$_props["laddaStyle"]."'":""; ?>
    class="btn <?php echo $_props["blockLevel"]?"btn-block":"";?> btn-<?php echo $_props["outline"]?"outline-":""; ?><?php echo $_props["type"]; ?> btn-<?php echo $_props["size"]; ?><?php echo $_props["cssClass"]!==null?" ".$_props["cssClass"]:""; ?>"
    <?php echo $_props["cssStyle"]!==null?" ".$_props["cssStyle"]:""; ?>
    <?php foreach($_props["attributes"] as $k=>$v) { echo " $k='$v'"; }?>
    onclick="<?php echo $_props["onClick"]; ?>"
    <?php echo $_props["disabled"]?"disabled":""; ?>>
    <?php echo $_props["icon"]!==null?"<i class='".$_props["icon"]."'></i> ":"";?><?php echo $_props["text"]; ?>
</button>
<?php if($_props["laddaOnAction"]===true): ?>
    <script type="text/javascript">Ladda.bind('#<?php echo $this->buttonName(); ?>');</script>
<?php endif ?>