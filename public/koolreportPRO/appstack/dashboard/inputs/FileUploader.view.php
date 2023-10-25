<?php

use koolreport\dashboard\Lang;

$this->widgetResources([
    "js"=>["widgets/fileuploader/fileuploader.js"],
]);
$_props = $this->_props();
$value = $this->master()->value();
?>
<div id="<?php echo $this->master()->name(); ?>" class="file-uploader">    
    
    <input class="file" type="file" hidden/>

    
    <div class="input-group">
        <div class="input-group-prepend">
            <button class="btn btn-<?php echo $_props["type"]; ?> btn-select"><?php echo $_props["selectFileText"]; ?></button>
        </div>
        <div class="form-control border-<?php echo $_props["type"]; ?> p-0">
            <div class="status-content">
            <?php if($_props["errorMessage"]): ?>
                <span class="text-danger"><?php echo $_props["errorMessage"]; ?></span>
            <?php elseif ($value!==null): ?>
                <span><?php echo $value; ?></span>
            <?php else: ?>
                <span><?php echo $_props["noFileSelectedText"]; ?></span>
            <?php endif ?>
            </div>
        </div>
        <?php if($_props["errorMessage"]===null && $value!==null): ?>
            <div class="input-group-append">
                <?php if($_props["showDownloadLink"]===true): ?>
                    <a class="btn border-left-0 border-<?php echo $_props["type"]; ?> btn-download" href="<?php echo $this->master()->getUrl(); ?>" download>
                        <i class="fas fa-cloud-download-alt"></i>
                    </a>
                <?php endif ?>
                <button <?php echo $value===null?"disabled":""; ?> class="btn border-left-0 border-<?php echo $_props["type"]; ?> btn-remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif ?>
    </div>

    <?php if($_props["imagePreview"]===true && $value!==null && $this->master()->isImage($value)): ?>
        <div class="image-preview">
            <img src="<?php echo $this->master()->getUrl(); ?>" />
        </div>
    <?php endif ?>
</div>

<script type="text/javascript">
KoolReport.widget.init(<?php echo json_encode($this->widgetResources()); ?>,function(){
    <?php echo $this->master()->name(); ?> = new KoolReport.dashboard.widgets.FileUploader(
        "<?php echo $this->master()->name(); ?>",
        <?php echo json_encode([
            "maxFileSize"=>$_props["maxFileSize"],
            "accept"=>$_props["accept"],
            "notAccept"=>$_props["notAccept"],
            "disabled"=>$_props["disabled"],
            "messages"=>[
                "fileNotAllowedError"=>$_props["fileNotAllowedError"],
                "fileSizeLmitError"=>$_props["fileSizeLmitError"],
                "unknownError"=>$_props["unknownError"],
                "noFileError"=>$_props["noFileError"],
                "noFileSelectedText"=>$_props["noFileSelectedText"],
            ],
        ]); ?>);
});
</script>