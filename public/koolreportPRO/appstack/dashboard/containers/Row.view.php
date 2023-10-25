<?php
$_props = $this->_props();
$cssClass = $_props["cssClass"];
$cssStyle = $_props["cssStyle"];
?>
<div class="row <?php echo $cssClass?$cssClass:"";?>" <?php echo $cssStyle?"style='$cssStyle'":"";?>>
    <?php foreach($this->master()->sub() as $item): ?>
        <?php if($item->enabled()): ?>
            <div class="mt-1 mb-1 <?php echo $this->master()->itemWidth($item); ?>">
                <?php echo $this->renderItem($item);?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>