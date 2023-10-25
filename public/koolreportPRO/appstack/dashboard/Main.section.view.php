<?php 
use \koolreport\dashboard\Dashboard;
use \koolreport\dashboard\menu\Group;
use koolreport\dashboard\menu\MenuItem;

?>
<li class="sidebar-header"><?php echo $section->_title(); ?></li>
<?php foreach($section->getSubItems() as $item) {
    if($item->enabled()) {
        $p = array_merge($path,[$item->_title()]);
        if($item instanceof Group) {
            $this->innerView("Main.group",["group"=>$item,"path"=>$p]);
        } else if ($item instanceof Dashboard) {
            $this->innerView("Main.dashboard",["dashboard"=>$item,"path"=>$p]);
        } else if ($item instanceof MenuItem) {
            $this->innerView("Main.menuitem",["menuItem"=>$item,"path"=>$p]);
        }    
    }
}?>