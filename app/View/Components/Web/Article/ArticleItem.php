<?php

namespace App\View\Components\Web\Article;

use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;

class ArticleItem extends WebComponents
{
    public $item;

    /**
     * Create a new component instance.
     *
     * @param $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.article.article-item');
    }
}
