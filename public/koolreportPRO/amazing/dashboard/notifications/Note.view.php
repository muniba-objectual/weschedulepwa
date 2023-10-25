<?php
$this->widgetResources([
    "js"=>["widgets/toastr/toastr.min.js"],
    "css"=>["widgets/toastr/toastr.css"],
]);
$_props = $this->_props();
?>
<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->widgetResources()); ?>,function(){
    toastr.options = {
        "closeButton": <?php echo $_props["closeButton"]?"true":"false"; ?>,
        "newestOnTop": <?php echo $_props["closeButton"]?"true":"false"; ?>,
        "progressBar": <?php echo $_props["closeButton"]?"true":"false"; ?>,
        "positionClass": "toast-<?php echo $_props["position"]; ?>",
        "timeOut":"<?php echo $_props["duration"]; ?>"
    };
    toastr.<?php echo strtolower($_props["type"]); ?>(`<?php echo $_props["text"]; ?>`,`<?php echo $_props["title"];?>`);
});
</script>