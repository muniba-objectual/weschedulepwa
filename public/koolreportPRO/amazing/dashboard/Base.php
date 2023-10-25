<?php

namespace koolreport\amazing\dashboard;

class Base extends \koolreport\KoolReport
{
    use \koolreport\dashboard\TStaticCreate;
    use \koolreport\dashboard\theme\TWithoutLoader;
    use \koolreport\dashboard\theme\TParamsToMethods;
    use \koolreport\dashboard\theme\TRender;
    use \koolreport\dashboard\theme\TAssets;
}