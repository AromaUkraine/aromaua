<?php

namespace App\View\Components\Cms\Form;



class Form extends FormConstructor
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.form.form');
    }
}
