<?php


namespace Modules\Catalog\Http\Controllers\Cms;


use App\Events\DestroyEntityEvent;
use App\Http\Controllers\Controller;
use App\Services\PublishAttribute;
use Modules\Catalog\DataTables\SeoCatalogDataTable;
use Modules\Catalog\Entities\SeoCatalog;
use Modules\Catalog\Events\SeoCatalogCreateEvent;
use Modules\Catalog\Http\Requests\SeoCatalogRequest;

class SeoCatalogController extends Controller
{

    public function index(SeoCatalogDataTable $dataTable)
    {
        return $dataTable->render('catalog::cms.seo_catalog.index');
    }



    public function create()
    {
        return view('catalog::cms.seo_catalog.create');
    }



    public function store(SeoCatalogRequest $request)
    {

        try{
            \DB::beginTransaction();

            $data = app(PublishAttribute::class)->make();

            $seo = SeoCatalog::create([
                'parent_page_id' => $data['parent_page_id'] ?? null,
                'product_category_id'=>$data['product_category_id'] ?? null,
                'is_brand' => $data['is_brand'] ?? false
            ]);

            event(new SeoCatalogCreateEvent($data, $seo));

            toastr()->success(__('toastr.created.message'));

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('catalog.seo_catalog.edit', $seo->id));
    }


    public function edit(SeoCatalog $seo)
    {
        return view('catalog::cms.seo_catalog.edit', compact('seo'));
    }



    public function update(SeoCatalogRequest $request, SeoCatalog $seo)
    {

        $data = app(PublishAttribute::class)->make();

        $seo->update([
            'product_category_id'=>$data['product_category_id'],
            'is_brand' => $data['is_brand'] ?? false
        ]);

        $seo->page->update($data);

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('catalog.seo_catalog.edit', $seo->id));
    }


    /**
     * @param SeoCatalog $seo
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(SeoCatalog $seo)
    {
        $seo->page->update(['active' => !$seo->page->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }


    public function destroy(SeoCatalog $seo)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($seo, config('catalog.softDelete') ?? false));

        return response()->json(['message' => __('toastr.deleted.message')]);
    }


    public function restore($id)
    {
        try {
            \DB::beginTransaction();

            $seo = SeoCatalog::withTrashed()->find($id);

            $seo->page()->restore();
            $seo->restore();

            \DB::commit();

            toastr()->success(__('toastr.updated.message'));
        } catch (\Exception $e) {

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('catalog.seo_catalog.index'));
    }
}
