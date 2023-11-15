<?php

namespace App\View\Components\Web\Article;

use App\Models\Page;
use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;
use Modules\Article\Entities\Article;

class ArticleView extends WebComponents
{

    /**
     * @var Page
     */
    public $page;
    /**
     * @var Article
     */
    public $article;

    /**
     * Create a new component instance.
     * @param Page $page
     * @param Article $article
     */
    public function __construct(Page $page, Article $article)
    {
        $this->page = $page;
        $this->article = $article;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.article.article-view');
    }


    public function getWebpImage($item)
    {
        return $this->getWebp($item->image);
    }
}
