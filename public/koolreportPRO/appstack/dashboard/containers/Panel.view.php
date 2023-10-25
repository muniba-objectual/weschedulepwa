<?php 
use \koolreport\core\Utility;
use \koolreport\dashboard\Client;
?>
<?php $_props = $this->_props(); ?>
<div class="mt-2 mb-2 card <?php echo $_props["type"]?"card-accent-".$_props["type"]:"";?> <?php echo $_props["cssClass"];?>">
    <?php if($_props["header"]!==null):?>
    <div class="card-header <?php echo $_props["headerCssClass"]; ?>">        
        <?php 
        if(is_string($_props["header"])) {
            echo $_props["header"]; 
        } else if (is_array($_props["header"])) {
            foreach($_props["header"] as $item) {
                echo $item->enabled()?$this->renderItem($item):null;
            }
        } else if ($_props["header"]!==null) {
            $item = $_props["header"];
            echo $item->enabled()?$this->renderItem($item):null;
        }
        ?>
        <?php if($_props["menu"]!==null): ?>
            <div class="card-actions">
                <div class="btn-group">
                    <button class="btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="menu-icon <?php echo $_props["menuIcon"]; ?>"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php foreach($_props["menu"] as $item): ?>
                            <?php $this->innerView("menu/MenuItem",["item"=>$item,"aCssClass"=>"dropdown-item"]); ?>
                            <?php endforeach ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
    <?php endif; ?>
    <div class="card-body<?php echo $_props["bodyCssClass"]!==null?$_props["bodyCssClass"]:""; ?>">
        <?php foreach($this->master()->sub() as $item): ?>
            <?php echo $item->enabled()?$this->renderItem($item):null; ?>
        <?php endforeach; ?>
    </div>
    <?php if($_props["footer"]!==null): ?>
    <div class="card-footer <?php echo $_props["footerCssClass"]; ?>">
        <?php 
        if(is_string($_props["footer"])) {
            echo $_props["footer"]; 
        } else if (is_array($_props["footer"])) {
            foreach($_props["footer"] as $item) {
                echo $item->enabled()?$this->renderItem($item):null;
            }
        } else if ($_props["footer"]!==null) {
            $item = $_props["footer"];
            echo $item->enabled()?$this->renderItem($item):null;
        }
        ?>
    </div>
    <?php endif; ?>
</div>