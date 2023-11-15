<?php

namespace App\View\Components\Web\Article;

use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;
use Modules\Article\Entities\Article;

class ArticleLatest extends WebComponents
{
    public $items;

    /**
     * Create a new component instance.
     *
     * @param int $limit
     */
    public function __construct($limit = 3)
    {
        $this->items = Article::joinPage()
            ->withGallery()
            ->latestPublished($limit)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.article.article-latest');
    }


    public function getRootPageRoute()
    {
        if (isset($this->items[0]->rootPage)) {
            return route('page', $this->items[0]->rootPage->slug);
        }
        return '#';
    }
}