<?php
    $activeTab = $this->master()->getActiveTab();
    $tabs = $this->master()->sub();
?>
<div id="<?php echo $this->master()->name(); ?>" class="tab <?php echo $this->master()->_cssClass(); ?>" style="<?php echo $this->master()->_cssStyle(); ?>">
    <ul class="nav nav-tabs" role="tablist">
        <?php foreach($tabs as $tab): ?>
            <li class="nav-item">
                <a class="<?php echo $tab->name(); ?> nav-link<?php echo($tab===$activeTab)?" active":""; ?>" data-toggle="tab" href="#<?php echo $tab->name(); ?>" role="tab">
                    <?php echo $tab->icon()!==null?"<i class='".$tab->_icon()."'></i> ":""; ?>
                    <?php echo $tab->_title(); ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
    <div class="tab-content">
        <?php foreach($this->master()->sub() as $tab): ?>
            <div class="tab-pane fade<?php echo($tab===$activeTab)?" show active":""; ?>" id="<?php echo $tab->name(); ?>" role="tabpanel">
                <?php foreach($tab->sub() as $item): ?>
                    <?php echo $item->enabled()?$this->renderItem($item):null; ?>
                <?php endforeach; ?>
            </div>
        <?php endforeach ?>
    </div>
</div>
<script>
$("#<?php echo $this->master()->name(); ?> a[data-toggle='tab']").on('shown.bs.tab', function (e) {mimicResize();});
<?php foreach($tabs as $tab): ?>
    <?php foreach(["show","shown","hide","hidden"] as $key): ?>
        <?php if($tab->getProp("on".ucfirst($key))!==null):?>
$("a.<?php echo $tab->name(); ?>").on("<?php echo $key; ?>.bs.tab",function(){<?php echo $tab->_getProp("on".ucfirst($key)); ?>});
        <?php endif; ?>
    <?php endforeach ?>
<?php endforeach?>
</script>