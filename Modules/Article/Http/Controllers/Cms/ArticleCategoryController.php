<?php

namespace Modules\Article\Http\Controllers\Cms;

use App\Events\DestroyEntityEvent;
use App\Events\ToggleActivePageEvent;
use App\Models\Page;
use App\Models\PageComponent;
use App\Services\PageAttributesService;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Article\DataTables\ArticleCategoryDataTable;
use Modules\Article\Entities\ArticleCategory;
use Modules\Article\Http\Requests\ArticleCategoryRequest;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Page $page
     * @param PageComponent $pageComponent
     * @param ArticleCategoryDataTable $dataTable
     * @return mixed
     */
    public function index(Page $page, PageComponent $pageComponent, ArticleCategoryDataTable $dataTable)
    {
        return $dataTable->render('article::cms.category.index', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     * @param Page $page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Page $page)
    {
        return view('article::cms.category.create', compact('page'));
    }


    /**
     * Store a newly created resource in storage.
     * @param ArticleCategoryRequest $request
     * @param Page $page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ArticleCategoryRequest $request, Page $page)
    {

        try{
            \DB::beginTransaction();


            $data = app( PageAttributesService::class)->concat($page, 'view');

            $category = ArticleCategory::create([
                'parent_page_id'=>$page->id,
            ]);
            $category->page()->create($data);

            toastr()->success(__('toastr.created.message'));

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }
        return redirect(route('module.article_category.edit', [$page->id, $category->id]));
    }


    /**
     * Show the form for editing the specified resource.
     * @param Page $page
     * @param ArticleCategory $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Page $page, ArticleCategory $category)
    {
        return view('article::cms.category.edit', compact('page','category'));
    }


    /**
     * Update the specified resource in storage.
     * @param ArticleCategoryRequest $request
     * @param Page $page
     * @param ArticleCategory $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ArticleCategoryRequest $request, Page $page, ArticleCategory $category)
    {
        $data = app(PublishAttribute::class)->make();

        $category->page->update($data);

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.article_category.edit', [$page->id, $category->id]));
        //return redirect(route('module.article_category.index', $page->id));
    }


    /**
     * Enabled / disabled article
     * @param ArticleCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(ArticleCategory $category)
    {
        event(new ToggleActivePageEvent($category->page));

        return response()->json(['message'=>__('toastr.updated.message')]);
    }


    public function restore(Page $page, $id)
    {
        try{
            \DB::beginTransaction();

            $category = ArticleCategory::withTrashed()->find($id);

            $category->page()->restore();
            $category->restore();

            \DB::commit();

            toastr()->success(__('toastr.updated.message'));

        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('module.article_category.index', $page->id));
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param ArticleCategory $category
     */
    public function destroy(ArticleCategory $category)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($category, config('article.softDelete') ?? false));

        return response()->json(['message'=>__('toastr.deleted.message')]);
    }
}
