<div id="Main" class="wrapper">
    <script type="text/javascript">KoolReport.dashboard.page.start("<?php echo $this->page()->name(); ?>");</script>
    <?php $this->innerView("Main.sidebar"); ?>    
    <div class="main">
        <?php $this->innerView("Main.header"); ?>
        <ol id="Main_Breadcrumb" class="breadcrumb"></ol>
        <main class="content">
            <div class="container-fluid p-0">
                <?php 
                    if($this->dashboard()!==null) {
                        echo $this->page()->ajaxPanel("Dashboard",$this->dashboard()->view()); 
                    }
                ?>
            </div>
        </main>
        <?php $this->innerView("Main.footer"); ?>
    </div>
    <script type="text/javascript">KoolReport.dashboard.page.end();</script>    
</div>
