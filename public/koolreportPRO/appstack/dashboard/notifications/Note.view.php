<?php 
$_props = $this->_props();
$position = explode("-",$_props["position"]);
?>
<script type="text/javascript">
    notyf.open({
        type:"<?php echo strtolower($_props["type"]); ?>",
        message:"<?php echo $_props["text"]; ?>",
        duration:<?php echo $_props["duration"] ?>,
        ripple:true,
        dismissible:<?php echo $_props["closeButton"]?"true":"false"; ?>,
        position: {
            x: "<?php echo trim(strtolower($position[1])); ?>",
            y: "<?php echo trim(strtolower($position[0])); ?>",
        }
    });
</script>