<?php

namespace Modules\Information\Http\Controllers\Cms;

use App\Events\DestroyEntityEvent;
use App\Models\Page;
use App\Models\PageComponent;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Information\DataTables\PageInformationDataTable;
use Modules\Information\Entities\Information;
use Modules\Information\Http\Requests\CreatePageInformationRequest;
use Modules\Information\Http\Requests\PageInformationRequest;

class PageInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Page $page
     * @param PageComponent $pageComponent
     * @param PageInformationDataTable $dataTable
     * @return Renderable
     */
    public function index(Page $page, PageComponent $pageComponent, PageInformationDataTable $dataTable)
    {
        return $dataTable->render('information::cms.page_info.index', compact('page','pageComponent'));
    }

    /**
     * Show the form for creating a new resource.
     * @param Page $page
     * @param PageComponent $pageComponent
     * @return Renderable
     */
    public function create(Page $page, PageComponent $pageComponent)
    {
        return view('information::cms.page_info.create', compact('page','pageComponent'));
    }

    /**
     * Store a newly created resource in storage.
     * @param PageInformationRequest $request
     * @param Page $page
     * @param PageComponent $pageComponent
     * @return \Illuminate\Contracts\Foundation\Application|Renderable|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(PageInformationRequest $request, Page $page, PageComponent $pageComponent)
    {

        $data = $request->all();
        $data['parent_page_id']=$page->id;
        $data['page_component_id']=$pageComponent->id;

        Information::create($data);

        toastr()->success(__('toastr.created.message'));

        return redirect(route('module.page_info.index', [$page->id, $pageComponent->alias]));
    }


    /**
     * Show the form for editing the specified resource.
     * @param Page $page
     * @param PageComponent $pageComponent
     * @param Information $info
     * @return Renderable
     */
    public function edit(Page $page, PageComponent $pageComponent, Information $info)
    {
        return view('information::cms.page_info.edit', compact('page','pageComponent','info'));
    }

    /**
     * Update the specified resource in storage.
     * @param PageInformationRequest $request
     * @param Page $page
     * @param PageComponent $pageComponent
     * @param Information $info
     * @return \Illuminate\Contracts\Foundation\Application|Renderable|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PageInformationRequest $request, Information $info)
    {

        $info->update($request->all());

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.page_info.index', [$info->parent_page_id, $info->component->alias]));

    }


    /**
     * @param Information $info
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Information $info)
    {
        $info->update(['active'=>!$info->active]);
        return response()->json(['message'=>__('toastr.updated.message')]);
    }


    /**
     * Remove the specified resource from storage.
     * @param Information $info
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Information $info)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($info, config('information.softDelete') ?? false));
        return response()->json(['message'=>__('toastr.deleted.message')]);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($id )
    {
        $info = Information::withTrashed()->findOrFail($id);
        $info->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.page_info.index', [$info->parent_page_id, $info->component->alias]));
    }
}
