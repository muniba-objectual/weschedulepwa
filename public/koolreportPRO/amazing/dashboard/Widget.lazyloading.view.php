<?php
$skeleton = $this->widget()->skeletonView(); 
echo $skeleton?$skeleton:"<i class='fa fa-spin fa-spinner'></i>"; 
?>
<script>
    setTimeout(
        function(){
            KoolReport.dashboard.dboard.widgetAction(
                "<?php echo $this->widget()->name();?>",
                null,
                {lazyLoading:1}
            );
        },
    500);
</script>