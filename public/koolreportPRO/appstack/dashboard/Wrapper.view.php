<?php $_props = $this->_props(); ?>
<div class="page<?php echo ($_props["cssClass"]!==null)?" ".$_props["cssClass"]:""; ?>"<?php echo $_props["cssStyle"]?" style='".$_props["cssStyle"]."'":""; ?>>
    <script type="text/javascript">KoolReport.dashboard.page.start("<?php echo $this->page()->name(); ?>");</script>
    <?php 
        if($this->dashboard()!==null) {
            echo $this->page()->ajaxPanel("Dashboard",$this->dashboard()->view()); 
        }
    ?>
    <script type="text/javascript">KoolReport.dashboard.page.end();</script>    
</div>