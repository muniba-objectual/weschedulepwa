<?php

namespace koolreport\appstack\dashboard;

use koolreport\dashboard\Theme;

class AppStack extends Theme
{
    protected function beforeOnCreated()
    {
        parent::beforeOnCreated();
        $this->props([
            "dark"=>false,
            "colorScheme"=>"default",//"default","colored","dark","light"
            "sidebarPosition"=>"left",//"left","right"
            "sidebarBehavior"=>"sticky",//"sticky","fixed","compact"
            "layout"=>"fluid",//"fluid", "boxed"
        ]);
    }
}