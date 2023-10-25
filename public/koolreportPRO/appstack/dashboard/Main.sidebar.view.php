<?php 
use \koolreport\dashboard\Dashboard;
use \koolreport\dashboard\menu\Group;
use koolreport\dashboard\menu\MenuItem;
use \koolreport\dashboard\menu\Section;
$page = $this->page();
?>
<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">

        <a onClick="loadDashboard('<?php echo $page->getDefaultDashboard()?$page->getDefaultDashboard()->name():null; ?>')" class="sidebar-brand" href="javascript: void 0">
            <?php echo $page->app()->logo(); ?>
        </a>

        <ul class="sidebar-nav">
            <?php
            foreach($this->params["sidebar"] as $item) {
                if($item->enabled()) {
                    $path = [$item->title()];
                    if($item instanceof Section) {
                        $this->innerView("Main.section",["section"=>$item,"path"=>$path]);
                    } else if ($item instanceof Group) {
                        $this->innerView("Main.group",["group"=>$item,"path"=>$path]);
                    } else if ($item instanceof Dashboard) {
                        $this->innerView("Main.dashboard",["dashboard"=>$item,"path"=>$path]);
                    } else if ($item instanceof MenuItem) {
                        $this->innerView("Main.menuitem",["menuItem"=>$item,"path"=>$path]);
                    }
                }
            }
            ?>        
    
        </ul>
    </div>
</nav>