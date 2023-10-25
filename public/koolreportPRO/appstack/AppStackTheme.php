<?php

namespace koolreport\appstack;

use koolreport\core\Theme;

class AppStackTheme extends Theme
{
    protected $useLoader = true;

    public $dark = false;
    public $colorScheme="default";//"default","colored","dark","light"
    public $sidebarPosition="left";//"left","right"
    public $sidebarBehavior="sticky";//"sticky","fixed","compact"
    public $layout = "fluid";//"fluid", "boxed"

    public function withoutLoader()
    {
        $this->useLoader = false;
    }

    public function themeInfo()
    {
        return array(
            "name"=>"AppStack Theme",
            "version"=>"1.0.0",
            "base"=>"bs4",
            "cssClass"=>"appstack"
        );
    }
    public function apply()
    {
        $report = $this->getReport();
        if($report)
        {
            $report->registerEvent("OnResourceInit",function() use ($report){
                $mainCss = $this->dark?"dark":"light";
                $assetsFolderUrl = $report->getResourceManager()->publishAssetFolder(realpath(dirname(__FILE__)."/assets"));
                $resources = array(
                    "js"=>array(
                        $assetsFolderUrl."/js/appstack.js"
                    ),
                    "css"=>array(
                        $assetsFolderUrl."/css/$mainCss.css"
                    )
                );

                if($this->useLoader) {
                    $report->getResourceManager()->addScriptOnBegin("KoolReport.load.resources(".json_encode($resources).");");
                } else {
                    $report->getResourceManager()->addScriptFileOnBegin($assetsFolderUrl."/js/appstack.js");
                    $report->getResourceManager()->addCssFile($assetsFolderUrl."/css/$mainCss.css");
                    //Apply theme settings
                    $report->getResourceManager()->addScriptOnEnd("$('body').attr('data-theme','$this->colorScheme').attr('data-layout','$this->layout').attr('data-sidebar-position','$this->sidebarPosition').attr('data-sidebar-behavior','$this->sidebarBehavior');");
                }
            });    
        }
    }


    protected function allColorSchemes()
    {
        return array(
            "default"=>array(
                "#F98766",
                "#FF410D",
                "#80BD9D",
                "#87D857",
                "#8FAFC4",
                "#336A86",
                "#293132",
                "#753625",
                "#753625",
                "#753625",
                "#693C3C",
                "#45201A",
                "#4F5060",
                "#67819D",
                "#ADBD37",
                "#588133",
                "#003B45",
                "#06575B",
                "#66A4AC",
                "#66A4AC",
                "#2E4500",
                "#476A00",
                "#A2C423",
                "#7D4426",
            ),
            "more"=>array(
                "#011B1D",
                "#004445",
                "#2B7873",
                "#6FB98F",
                "#375D96",
                "#FA6541",
                "#FFBA00",
                "#3F671B",
                "#324750",
                "#86AB40",
                "#33665C",
                "#7DA2A1",
                "#4BB4F5",
                "#B6B8B5",
                "#203F49",
                "#B3C100",
                "#F3CC6F",
                "#DE7921",
                "#20948B",
                "#6AB086",
                "#8C230E",
                "#1D424B",
                "#9A4E0E",
                "#C89D0F",
            )
        );
    }

}