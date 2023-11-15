<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use Modules\Article\Entities\Article;

class ArticleController extends Controller
{

    public function index($page)
    {

        $articles = null;

        // если компонент страницы активен
        if($page->componentActive('articles')){
            $paginate = config('article.article.paginate', 10);
            $articles = Article::joinPage(true, true)
                        ->latestPublished()
                        ->withGallery()
                        ->paginate($paginate);
        }

        return view('web.article.index', compact( 'page','articles'));
    }

    public function view($page)  // Страница статьи
    {
        // Статья
        $article = $page->pageable;
        // Корневая страница - Новости ...
        $root = $article->rootPage;

        return view('web.article.view', compact('root','page', 'article'));
    }
}