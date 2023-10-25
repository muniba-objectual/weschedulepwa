<?php 
use \koolreport\dashboard\Dashboard;
use \koolreport\dashboard\menu\Group;
use koolreport\dashboard\menu\MenuItem;
use \koolreport\dashboard\menu\Section;
?>
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
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
    </nav>
    <span class="sidebar-foot"></span>
</div>