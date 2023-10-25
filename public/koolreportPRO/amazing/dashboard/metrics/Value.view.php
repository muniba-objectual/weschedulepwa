<?php use \koolreport\dashboard\Lang; ?>
<div id="<?php echo $this->master()->name(); ?>" class="card card-accent-<?php echo $this->master()->type(); ?> card-value">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="text-muted text-uppercase font-weight-bold font-xs"><?php echo $this->master()->title(); ?></div>
            </div>
            <div class="col">
                <select <?php echo $this->disableRangeSelect()?"disabled":"";?> onChange="widgetAction('<?php echo $this->master()->name(); ?>','rangeSelect',{selectedRange:$(this).val()});<?php echo $this->master()->showLoaderOnAction()?"showLoader(true);":""; ?>" class="form-control form-control-sm float-right" style="width:auto;">
                    <?php foreach($this->rangeKeys() as $key ): ?>
                        <option value="<?php echo $key; ?>" <?php echo ($this->master()->getSelectedRangeKey()===$key)?"selected":""; ?>><?php Lang::echo($key); ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="h3 text-<?php echo $this->master()->type(); ?>"><?php echo $this->currentValue(); ?></div>
        <div style="margin-top:17px;margin-bottom:6px">
            <?php if($this->indicatorField()->originalValue()===null): ?>
                <span class="font-italic text-muted font-xs"><?php echo Lang::t("No prior data");?></span>    
            <?php elseif($this->indicatorField()->value()>=0): ?>
                <i class="fa fa-level-up-alt text-success"></i>
                <span class="ml-2 font-weight-bold text-muted font-xs"><?php echo $this->indicatorField()->formattedValue(); ?> <?php echo Lang::t("Increase"); ?></span>
            <?php elseif($this->indicatorField()->value()<0): ?>
                <i class="fa fa-level-down-alt text-danger"></i>
                <span class="ml-2 font-weight-bold text-muted font-xs"><?php echo $this->indicatorField()->formatValue(abs($this->indicatorField()->value())); ?> <?php echo Lang::t("Decrease"); ?></span>
            <?php endif ?>
        </div>
    </div>
</div>