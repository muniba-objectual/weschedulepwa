<div id="<?php echo $this->master()->name(); ?>" class="card card-accent-secondary card-value">
    <div class="card-body pb-3">
        <div class="row">
            <div class="col">
                <div class="loading" style="height:1.5rem"></div>
            </div>
            <div class="col">
                <div class="loading" style="float:right;width:60%;height:1.6rem"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <small>
                <ul  class="list-inline mt-1">
                    <li>
                        <i class="fa fa-circle" style="color:#e2e2e2"></i>
                        <div class="loading" style="display:inline-block;width:50px;height:10px;margin-left:5px;position:relative;top:1px;"></div>
                    </li>
                    <li>
                        <i class="fa fa-circle" style="color:#e2e2e2"></i>
                        <div class="loading" style="display:inline-block;width:60px;height:10px;margin-left:5px;position:relative;top:1px;"></div>
                    </li>
                    <li>
                        <i class="fa fa-circle" style="color:#e2e2e2"></i>
                        <div class="loading" style="display:inline-block;width:70px;height:10px;margin-left:5px;position:relative;top:1px;"></div>
                    </li>
                </ul>
                </small>
            </div>
            <div class="col">
                <div class="mt-2 loading" style="float:right;width:<?php echo $this->master()->pieSize()-15; ?>px;height:<?php echo $this->master()->pieSize()-15; ?>px;border-radius:50%;"></div>
            </div>
        </div>
    </div>
</div>