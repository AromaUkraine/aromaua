<?php


namespace Modules\Banner\Http\Controllers\Cms;


use App\Events\DestroyEntityEvent;
use App\Models\Page;
use App\Models\PageComponent;
use App\Services\PublishAttribute;
use Illuminate\Routing\Controller;

use Modules\Banner\DataTables\PageBannerDataTable;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Http\Requests\BannerRequest;

class PageBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Page $page
     * @param PageComponent $pageComponent
     * @param PageBannerDataTable $dataTable
     * @return void
     */
    public function index(Page $page, PageComponent $pageComponent, PageBannerDataTable $dataTable)
    {
        return $dataTable->render('banner::cms.page_banner.index', compact('page', 'pageComponent'));
    }


    public function create(Page $page, $alias)
    {
        return view('banner::cms.page_banner.create', compact('page', 'alias'));
    }


    public function store(BannerRequest $request, Page $page, $alias)
    {
        $data = $request->all();

        $data['parent_page_id'] = $page->id;
        $data['page_component_id'] = $page->components()->where('alias', $alias)->firstOrFail()->id;

        Banner::create($data);
        toastr()->success(__('toastr.created.message'));

        return redirect(route('module.page_banner.index', [$page->id, $alias]));
    }

    public function edit(Page $page, PageComponent $pageComponent, Banner $banner)
    {
        return view('banner::cms.page_banner.edit', compact('page', 'banner'));
    }

    public function update(BannerRequest $request, Banner $banner)
    {

        $banner->update($request->all());
        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.page_banner.index', [$banner->parent_page_id, $banner->component->alias]));
    }

    public function active(Banner $banner)
    {
        $banner->update(['active' => !$banner->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }


    public function destroy(Banner $banner)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($banner, config('banner.softDelete') ?? false));
        return response()->json(['message' => __('toastr.deleted.message')]);
    }

    public function restore($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        $banner->restore();

        return redirect(route('module.page_banner.index', [$banner->parent_page_id, $banner->component->alias]));
    }
}