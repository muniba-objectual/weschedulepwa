<?php use \koolreport\core\Utility; ?>
<div class="card card-accent-danger">
    <div class="card-header">
        <span class="badge badge-dark" style="font-size:14px;">[Application] <?php echo $this->master()->name(); ?></span>
    </div>
    <div class="card-body">
        <error-message>
            <div><b>Message:</b> <?php echo $this->exception()->getMessage(); ?></div>
            <div><b>Line:</b> <?php echo $this->exception()->getLine(); ?></div>
            <div><b>File:</b> <?php echo $this->exception()->getFile(); ?></div>
            <a style="text-decoration:none" onclick="traces_toggle(this)" href="javascript: void 0"><i class="far fa-plus-square"></i> Expand</a>
            <div id="exception-traces" class="d-none">
                <?php foreach($this->exception()->getTrace() as $i=>$trace): ?>
                    <div>#<?php echo $i; ?>: <?php echo Utility::get($trace,"file");?> <b>Line <?php echo Utility::get($trace,"line"); ?></b>
                    : <?php echo Utility::get($trace,"function");?>(<?php echo json_encode(Utility::get($trace,"args"));?>)
                    </div>
                <?php endforeach ?>
            </div>
        </error-message>
        <div class="mt-3">
            <button onclick="location.reload()" class="btn btn-primary"><i class="fa fa-redo-alt"></i> Refresh</button>
        </div>
    </div>
</div>