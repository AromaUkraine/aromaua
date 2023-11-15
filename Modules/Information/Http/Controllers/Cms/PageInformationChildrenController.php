<?php


namespace Modules\Information\Http\Controllers\Cms;


use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageComponent;
use App\Services\PublishAttribute;
use Modules\Information\DataTables\PageInformationChildrenDataTable;
use Modules\Information\Entities\Information;
use Modules\Information\Http\Requests\PageInformationChildrenRequest;

class PageInformationChildrenController extends Controller
{

    public function index(Page $page, PageComponent $pageComponent, Information $parent, PageInformationChildrenDataTable $dataTable)
    {
        return $dataTable->render('information::cms.page_info_child.index', compact('page','pageComponent', 'parent'));
    }



    public function create(Page $page, PageComponent $pageComponent, Information $parent)
    {
        return view('information::cms.page_info_child.create', compact('page','pageComponent', 'parent'));
    }


    public function store(PageInformationChildrenRequest $request, Page $page, PageComponent $pageComponent, Information $parent)
    {
        $data = $request->all();
        $data['parent_information_id'] = $parent->id;
        Information::create($data);

        toastr()->success(__('toastr.created.message'));

        return redirect(route('module.page_info_child.index', [$page->id, $pageComponent->alias, $parent->id]));
    }


    public function edit(Page $page, PageComponent $pageComponent, Information $parent, Information $child)
    {

        return view('information::cms.page_info_child.edit', compact('page','pageComponent', 'parent','child'));
    }


    public function update(PageInformationChildrenRequest $request, Page $page, PageComponent $pageComponent, Information $parent, Information $child)
    {

        $child->update($request->all());

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.page_info_child.index', [$page->id, $pageComponent->alias, $parent->id]));
    }


    /**
     * @param Information $child
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Information $child)
    {
        $child->update(['active'=>!$child->active]);
        return response()->json(['message'=>__('toastr.updated.message')]);
    }

    public function destroy(Information $child)
    {
        $child->delete();
        return response()->json(['message'=>__('toastr.deleted.message')]);
    }

    public function restore( Page $page, PageComponent $pageComponent, Information $parent, $id )
    {
        $info = Information::withTrashed()->findOrFail($id);
        $info->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.page_info_child.index', [$page->id, $pageComponent->alias, $parent->id]));
    }
}
