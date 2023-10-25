<?php

namespace koolreport\appstack;

trait Theme
{
    public function __constructAppStackTheme()
    {
        $this->theme = new AppStackTheme($this);
        if(method_exists($this,"onAppStackThemeInit")) {
            $this->onAppStackThemeInit();
        }
        $this->theme->apply();
    }
}