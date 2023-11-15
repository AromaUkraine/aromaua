<?php

namespace App\View\Components\Web\Info;

use Illuminate\View\Component;

class InfoAdvantages extends InfoConstructor
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        $info = $this->items->first()->children ?? [];

        return view('components.web.info.info-advantages', compact('info'));
    }
}
