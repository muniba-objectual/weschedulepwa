<?php

namespace koolreport\appstack\dashboard;

class Export extends \koolreport\KoolReport
{
    use \koolreport\cloudexport\Exportable;
    use \koolreport\export\Exportable;
    use \koolreport\dashboard\TStaticCreate;
    use \koolreport\dashboard\theme\TRender;
    use \koolreport\dashboard\theme\TParamsToMethods;
    use \koolreport\dashboard\theme\TAssets;
    use \koolreport\clients\jQuery;
    use \koolreport\amazing\Theme;

    protected function onAmazingThemeInit()
    {
        $this->theme->withoutLoader();
    }

    

}