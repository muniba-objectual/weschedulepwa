<?php $_props = $this->_props();?>
<div id="<?php echo $this->master()->name(); ?>" class="btn-group <?php echo $_props["cssClass"]; ?>" <?php echo ($_props["cssStyle"]!==null)?"style='".$_props["cssStyle"]."'":""; ?>>
    <button <?php echo $_props["disabled"]===true?"disabled":""; ?> class="btn <?php echo $_props["blockLevel"]?"btn-block":"";?> btn<?php echo $_props["outline"]===true?"-outline":""; ?><?php echo "-".$_props["type"];?> <?php echo $_props["size"]!==null?"btn-".$_props["size"]:""; ?> dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $_props["icon"]!==null?"<i class='".$_props["icon"]."'></i>":""; ?>
        <?php echo $_props["title"]; ?>
    </button>
    <div class="dropdown-menu<?php echo ($_props["align"]=="right")?" dropdown-menu-right":"";?><?php echo $_props["lgBox"]?" dropdown-menu-lg":"";?>">
        <form disabled>
            <?php foreach($this->master()->sub() as $item): ?>
                <?php if($item->enabled()): ?>
                    <?php echo $this->renderItem($item);?>
                <?php endif; ?>
            <?php endforeach; ?>
        </form>
    </div>
</div>
<script>$("#<?php echo $this->master()->name(); ?> form[disabled]").on("submit",function(e){e.preventDefault();}).click(function(e){e.stopPropagation();});</script>