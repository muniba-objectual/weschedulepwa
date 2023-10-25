<?php

namespace App\View\Components\CustomFormComponents;

use Illuminate\View\Component;

class RadioField extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.custom-form-components.radio-field');
    }
}
