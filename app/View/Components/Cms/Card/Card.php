<?php

namespace App\View\Components\Cms\Card;



class Card extends CardConstructor
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.card.card');
    }
}
