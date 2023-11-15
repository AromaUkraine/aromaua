<?php

namespace App\View\Components\Web\Social;

use Illuminate\View\Component;

class SocialLinks extends Component
{
    public $items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->items =app()->settings->group('social_links');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.social.social-links');
    }

    public function getLink($item)
    {
        return $item->translateOrDefault()->value ?? '#';
    }
}
