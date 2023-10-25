<?php use koolreport\dashboard\Client;?>
<dashboard name="<?php echo $this->master()->name(); ?>">
    <script type="text/javascript">
        KoolReport.dashboard.dboard.start("<?php echo $this->master()->name(); ?>","<?php echo $this->master()->_title(); ?>");
        KoolReport.dashboard.headerTitle("<?php echo $this->master()->_title()." - ".$this->master()->app()->_title(); ?>");
        KoolReport.dashboard.dboard.setState(<?php echo $this->master()->state()!==[]?Client::jsonParams($this->master()->state()):"{}";?>);
    </script>
    <?php if($this->master()->onClientLoading()!==null): ?>
        <script><?php echo $this->master()->_onClientLoading(); ?></script>
    <?php endif ?>
    <?php
    foreach($this->items() as $item) {
        echo $this->renderItem($item);
    } 
    ?>
    <?php if($this->master()->onClientLoaded()!==null): ?>
        <script><?php echo $this->master()->_onClientLoaded(); ?></script>
    <?php endif ?>
</dashboard>