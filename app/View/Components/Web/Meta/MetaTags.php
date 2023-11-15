<?php

namespace App\View\Components\Web\Meta;

use Illuminate\View\Component;

class MetaTags extends Component
{
    public $page;

    public $googleMapApiKey;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($page)
    {
        $this->page = $page;

        $this->googleMapApiKey = app()->settings->key('google-map-api-key')->translateOrDefault()->value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.meta.meta-tags');
    }
}
