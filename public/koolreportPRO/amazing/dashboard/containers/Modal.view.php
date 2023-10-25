<?php $modal = $this->master(); ?>
<?php $_props = $this->_props(); ?>
<div id="<?php echo $modal->name(); ?>" <?php echo $_props["closeOnBackdropClick"]===true?"":"data-backdrop='static'"; ?>
    class="modal <?php echo $_props["animation"]; ?>" 
    tabindex="-1" role="dialog" 
    aria-labelledby="<?php echo $modal->name(); ?>" aria-hidden="true">
    <div class="modal-dialog
        <?php echo $_props["type"]!==null?"modal-".$_props["type"]:""; ?> 
        <?php echo $_props["centered"]===true?"modal-dialog-centered":""; ?> 
        <?php echo $_props["size"]!==null?"modal-".$_props["size"]:""; ?>" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $_props["title"]; ?></h5>
                <?php if($_props["showCloseIcon"]===true): ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                <?php endif ?>
            </div>
            <div class="modal-body">
                <?php foreach($modal->sub() as $item): ?>
                    <?php echo $item->enabled()?$this->renderItem($item):null; ?>
                <?php endforeach; ?>
            </div>
            <?php if(count($modal->footer())>0): ?>
                <div class="modal-footer">
                    <?php foreach($_props["footer"] as $item): ?>
                        <?php echo $item->enabled()?$this->renderItem($item):null; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#<?php echo $modal->name(); ?>').on('shown.bs.modal',function(){mimicResize();});
<?php foreach(["show","shown","hide","hidden"] as $name): ?>
    <?php if($_props["on".ucfirst($name)]!==null): ?>
        $('#<?php echo $modal->name(); ?>').on('<?php echo $name; ?>.bs.modal',function(){<?php echo $_props["on".ucfirst($name)]; ?>});
    <?php endif ?>
<?php endforeach ?>
<?php if($modal->open()===true): ?>
$('#<?php echo $modal->name(); ?>').modal('show');
<?php endif ?>
</script>