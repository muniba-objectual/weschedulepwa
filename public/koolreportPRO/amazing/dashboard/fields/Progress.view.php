<div>
    <b><?php echo $this->progress()->formattedValue(); ?></b>
</div>
<div class="progress progress-xs">
    <div class="progress-bar bg-<?php echo $this->type()?$this->type():"secondary"; ?>" role="progressbar" style="width: <?php echo $this->progress()->value(); ?>%" aria-valuenow="<?php echo $this->progress()->value(); ?>" aria-valuemin="0" aria-valuemax="100"></div>
</div>