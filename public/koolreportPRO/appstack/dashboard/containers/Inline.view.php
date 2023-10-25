<div style="<?php echo $this->_props()["cssStyle"]?$this->_props()["cssStyle"]:""; ?>" class="inline-container <?php echo $this->_props()["cssClass"]?$this->_props()["cssClass"]:""; ?>">
<?php foreach($this->master()->sub() as $item): ?>
    <?php if($item->enabled()): ?>        
        <?php echo $this->renderItem($item);?>
    <?php endif; ?>
<?php endforeach; ?>
</div>