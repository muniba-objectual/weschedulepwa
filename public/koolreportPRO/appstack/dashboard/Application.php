<?php

namespace koolreport\appstack\dashboard;

class Application extends \koolreport\KoolReport
{
    use \koolreport\dashboard\TStaticCreate;
    use \koolreport\dashboard\theme\TRender;
    use \koolreport\dashboard\theme\TParamsToMethods;
    use \koolreport\dashboard\theme\TAssets;
    // use \koolreport\clients\jQuery;
    use \koolreport\appstack\Theme;
    
    protected function onAppStackThemeInit()
    {
        $this->theme->withoutLoader();
        $themeSettings = $this->themeSettings();
        foreach($themeSettings as $propName=>$value) {
            if(!in_array($propName,["viewSpace","assets"])) {
                $this->theme->$propName = $value;
            }
        }
    }

    protected function OnInit()
    {
        $this->registerEvent(
            'OnResourceInit',
            function () {

                //Register the main app js
                $coreAssetsUrl = $this->coreAssetsUrl();
                $this->getResourceManager()->addScriptFileOnBegin($coreAssetsUrl."/app.js");


                //Loading the theme js and css
                $themeAssetsUrl = $this->themeAssetsUrl();
                $this->getResourceManager()->addScriptFileOnBegin($themeAssetsUrl."/spin.min.js");
                $this->getResourceManager()->addScriptFileOnBegin($themeAssetsUrl."/ladda.min.js");
                $this->getResourceManager()->addScriptFileOnBegin($themeAssetsUrl."/theme.js");
                $this->getResourceManager()->addCssFile($themeAssetsUrl."/theme.css");
                $this->getResourceManager()->addCssFile($themeAssetsUrl."/ladda-themeless.min.css");
                

                //Additional css, require to provide ready url
                $css = $this->app()->css();
                if($css!==null) {
                    if(gettype($css)==="string") {
                        $this->getResourceManager()->addCssFile($css);
                    } else if (gettype($css)==="array") {
                        foreach($css as $url) {
                            $this->getResourceManager()->addCssFile($url);
                        }
                    }
                }

                //Additional js, required to provide ready url
                $js = $this->app()->js();
                if($js!==null) {
                    if(gettype($js)==="string") {
                        $this->getResourceManager()->addScriptFileOnBegin($js);
                    } else if (gettype($js)==="array") {
                        foreach($js as $url) {
                            $this->getResourceManager()->addScriptFileOnBegin($url);
                        }
                    }
                }
            }
        );
    }
}