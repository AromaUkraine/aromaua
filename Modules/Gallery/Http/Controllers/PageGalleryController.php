<?php


namespace Modules\Gallery\Http\Controllers;


use App\Events\DestroyEntityEvent;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageComponent;
use App\Services\PublishAttribute;
use Modules\Gallery\DataTables\PageGalleryDataTable;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Events\CreatePageGalleryEvent;
use Modules\Gallery\Events\UpdatePageGalleryEvent;
use Modules\Gallery\Http\Requests\GalleryRequest;

class PageGalleryController extends Controller
{

    /**
     * @param Page $page
     * @param PageComponent $pageComponent
     * @param PageGalleryDataTable $dataTable
     * @return mixed
     */
    public function index(Page $page, PageComponent $pageComponent, PageGalleryDataTable $dataTable)
    {

        return $dataTable->render('gallery::page_gallery.index', compact('page', 'pageComponent'));
    }


    /**
     * @param Page $page
     * @param PageComponent $pageComponent
     * @param $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Page $page, PageComponent $pageComponent, $type)
    {
        return view('gallery::page_gallery.create', compact('page', 'pageComponent', 'type'));
    }


    /**
     * @param GalleryRequest $request
     * @param Page $page
     * @param PageComponent $pageComponent
     * @param $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(GalleryRequest $request, Page $page, $alias, $type)
    {

        event(new CreatePageGalleryEvent($request, $page, $alias, $type));

        toastr()->success(__('toastr.created.message'));

        return redirect(route('module.page_gallery.index', [$page->id, $alias]));
    }


    /**
     * @param Page $page
     * @param PageComponent $pageComponent
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Page $page, PageComponent $pageComponent, Gallery $gallery)
    {
        return view('gallery::page_gallery.edit', compact('page', 'pageComponent', 'gallery'));
    }


    /**
     * @param GalleryRequest $request
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(GalleryRequest $request, Gallery $gallery)
    {
        event(new UpdatePageGalleryEvent($request, $gallery));

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.page_gallery.index', [$gallery->parent_page_id, $gallery->component->alias]));
    }


    /**
     * @param Gallery $gallery
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Gallery $gallery): \Illuminate\Http\JsonResponse
    {
        $gallery->update(['active' => !$gallery->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }


    /**
     * @param Gallery $gallery
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Gallery $gallery)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($gallery));
        return response()->json(['message' => __('toastr.deleted.message')]);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($id)
    {
        $gallery = Gallery::withTrashed()->findOrFail($id);
        $gallery->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.page_gallery.index', [$gallery->parent_page_id, $gallery->component->alias]));
    }
}