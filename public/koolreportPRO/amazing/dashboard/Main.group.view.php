<?php 
use \koolreport\dashboard\Dashboard;
use koolreport\dashboard\menu\MenuItem;

?>
<li class="nav-item nav-dropdown<?php echo $group->_hidden()===true?" d-none":""; ?>">
    <a class="nav-link nav-dropdown-toggle">
        <i class="<?php echo $group->_icon(); ?>"></i> <?php echo $group->_title(); ?>
        <?php
            $badge = $group->_badge();
            if($badge!==null) {
                if(!is_array($badge)) {
                    $badge = [$badge,"danger"];
                }
                echo "<span class='badge badge-$badge[1]'>$badge[0]</span>";
            }
        ?>
    </a>
    <ul class="nav-dropdown-items">
    <?php
        foreach($group->getSubItems() as $item) {
            if($item->enabled()) {
                $p = array_merge($path,[$item->_title()]);
                if ($item instanceof Dashboard) {
                    $this->innerView("Main.dashboard",["dashboard"=>$item,"path"=>$p]);
                } else if ($item instanceof MenuItem) {
                    $this->innerView("Main.menuitem",["menuItem"=>$item,"path"=>$p]);
                }
            }
        }
    ?>
    </ul>
</li>
