<?php

namespace Modules\Article\Http\Controllers\Cms;


use App\Events\DestroyEntityEvent;
use App\Models\Page;
use App\Services\PageAttributesService;
use App\Services\PublishAttribute;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Article\DataTables\ArticleDataTable;
use Modules\Article\Entities\Article;
use Modules\Article\Entities\ArticleCategory;
use Modules\Article\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{

    /**
     * @param Page $page
     * @param ArticleDataTable $dataTable
     * @return mixed
     */
    public function index(Page $page, ArticleDataTable $dataTable)
    {
        return $dataTable->render('article::cms.article.index', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     * @param Page $page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Page $page)
    {
        $categories = ArticleCategory::where('parent_page_id', request()->page->id)->get();

        return view('article::cms.article.create', compact('page', 'categories'));
    }

    /**
     *  Store a newly created resource in storage.
     * @param Request $request
     * @param Page $page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ArticleRequest $request, Page $page)
    {

        try {
            \DB::beginTransaction();


            $data = array_merge([
                'method' => $page->method,
                'controller' => $page->controller,
                'action' => 'view'
            ], $request->all());

            $article = Article::create([
                'parent_page_id' => $page->id,
                'published_at' => $request->published_at
            ]);

            $article->categories()->detach();
            if (isset($data['categories'])) {
                $article->categories()->attach($data['categories']);
            }

            $article->page()->create($data);

            toastr()->success(__('toastr.created.message'));

            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('module.article.edit', [$page->id, $article->id]));
    }


    public function restore(Page $page, $id)
    {
        try {
            \DB::beginTransaction();

            $article = Article::withTrashed()->find($id);

            $article->page()->restore();
            $article->restore();

            \DB::commit();

            toastr()->success(__('toastr.updated.message'));
        } catch (\Exception $e) {

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('module.article.index', $page->id));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Page $page
     * @param Article $article
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Page $page, Article $article)
    {
        $categories = ArticleCategory::where('parent_page_id', request()->page->id)->get();

        return view('article::cms.article.edit', compact('page', 'article', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Page $page
     * @param Article $article
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ArticleRequest $request, Page $page, Article $article)
    {

        try {
            \DB::beginTransaction();

            $article->update([
                'published_at' => $request->published_at
            ]);

            $article->page->update($request->all());

            $article->categories()->detach();
            if (isset($data['categories'])) {
                $article->categories()->attach($data['categories']);
            }

            toastr()->success(__('toastr.updated.message'));

            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('module.article.edit', [$page->id, $article->id]));
    }


    /**
     * Enabled / disabled article
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Article $article)
    {
        $article->page->update(['active' => !$article->page->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }


    /**
     * Remove the specified resource from storage.
     * @param Article $article
     */
    public function destroy(Article $article)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($article, config('article.softDelete') ?? false));
        return response()->json(['message' => __('toastr.deleted.message')]);
    }
}
