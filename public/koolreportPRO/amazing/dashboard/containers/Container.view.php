<?php foreach($this->master()->sub() as $item): ?>
    <?php if($item->enabled()): ?>        
        <?php echo $this->renderItem($item);?>
    <?php endif; ?>
<?php endforeach; ?>