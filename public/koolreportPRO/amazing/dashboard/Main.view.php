<div id="Main" class="app header-fixed sidebar-fixed">
    <script type="text/javascript">KoolReport.dashboard.page.start("<?php echo $this->page()->name(); ?>");</script>
    <?php $this->innerView("Main.header"); ?>
    <div class="app-body">
        <?php $this->innerView("Main.sidebar"); ?>
        <main class="main">
            <ol id="Main_Breadcrumb" class="breadcrumb"></ol>
            <div class="container-fluid app-container pb-2">
                <?php 
                    if($this->dashboard()!==null) {
                        echo $this->page()->ajaxPanel("Dashboard",$this->dashboard()->view()); 
                    }
                ?>
            </div>
        </main>
    </div>
    <?php $this->innerView("Main.footer"); ?>
    <script type="text/javascript">KoolReport.dashboard.page.end();</script>
</div>