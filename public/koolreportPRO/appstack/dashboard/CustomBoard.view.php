<dashboard name="<?php echo $this->board()->name(); ?>">
    <script>
        KoolReport.dashboard.dboard.start("<?php echo $this->board()->name(); ?>","<?php echo $this->board()->_title(); ?>");
        <?php if($this->board()->params()!==null): ?>
        KoolReport.dashboard.dboard.saveState("<?php echo $this->board()->name()."__params";?>",<?php echo json_encode($this->board()->params())?>);
        <?php endif ?>
        KoolReport.dashboard.headerTitle("<?php echo $this->board()->_title()." - ".$this->board()->app()->_title(); ?>");
    </script>

    <?php include($this->viewFile());?>
    
    <script>KoolReport.dashboard.dboard.custom.initForms("<?php echo $this->board()->name(); ?>_form");</script>
</dashboard>