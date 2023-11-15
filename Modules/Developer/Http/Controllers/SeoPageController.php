<?php


namespace Modules\Developer\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Modules\Catalog\Entities\SeoCatalog;
use Modules\Developer\DataTables\SeoPageDataTable;
use Modules\Developer\Events\CreateTemplateBySeoPageEvent;

class SeoPageController extends Controller
{
    public function index(SeoPageDataTable $dataTable)
    {
        return $dataTable->render('developer::seo_page.index');
    }


    public function create()
    {
        $pages = Page::where('pageable_type', SeoCatalog::class)->get();
        return view('developer::seo_page.create', compact('pages'));
    }


    public function store(Request $request)
    {

        try{
            \DB::beginTransaction();

            $page = Page::where('pageable_id', $request->pageable_id)
                ->where('pageable_type', SeoCatalog::class)->firstOrFail();

            event(new CreateTemplateBySeoPageEvent($page, $request->all()));

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd('Update failed with class "'.get_class($this).'" error : '.$e->getMessage());
        }

        toastr()->success(__('toastr.created.message'));

        return redirect(route('developer.seo_page.index'));
    }


    public function edit(Page $page)
    {
        return view('developer::seo_page.edit', compact('page'));
    }
}
