<?php


namespace App\Http\Controllers\Cms;


use App\DataTables\PageComponentDataTable;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageComponent;
use Illuminate\Http\Request;

class PageComponentController extends Controller
{

    public function index(Page $page, PageComponentDataTable $dataTable)
    {
        return $dataTable->render('cms.page_component.index', compact('page'));
    }

    public function active($id)
    {
        $pageComponent = PageComponent::findOrFail($id);
        $pageComponent->update(['active' => !$pageComponent->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }
}
