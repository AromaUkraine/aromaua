<?php

namespace Modules\Catalog\Http\Controllers\Cms;

use App\Events\DestroyEntityEvent;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Catalog\DataTables\ProductDataTable;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Catalog\Events\CatalogProductCreateEvent;

use Modules\Catalog\Events\CatalogProductUpdateEvent;
use Modules\Catalog\Events\FeatureModifyChangeParentProductEvent;
use Modules\Catalog\Http\Requests\ProductRequest;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param ProductDataTable $dataTable
     * @return Renderable
     */
    public function index(ProductDataTable $dataTable)
    {
        $totalCount = $dataTable->totalCount;
        return $dataTable->render('catalog::cms.product.index', compact('totalCount'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('catalog::cms.product.create');
    }


    /**
     * Store a newly created resource in storage.
     * @param ProductRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ProductRequest $request)
    {
        try{
            \DB::beginTransaction();


            $product = Product::create($request->all());
            $product->update(['parent_product_id'=>$product->id]);

            event(new CatalogProductCreateEvent($product, $request->all()));

            toastr()->success(__('toastr.created.message'));

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('catalog.product.edit', $product->id));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('catalog::cms.product.edit', compact('product'));
    }


    /**
     *  Update the specified resource in storage.
     * @param ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProductRequest $request, Product $product)
    {

        try{
            \DB::beginTransaction();

            event(new CatalogProductUpdateEvent($request->all(), $product));
            toastr()->success(__('toastr.updated.message'));

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
             dd($e->getMessage());
        }

        return redirect(route('catalog.product.edit', $product->id));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Product $product)
    {
        $product->page->update(['active' => !$product->page->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }



    /**
     * Remove the specified resource from storage.
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        // сменить родительскую модификацию.
        if($product->children->count()){
            $parent_before_id = $product->id;
            $parent_new_id = $product->children->first()->id;
            event(new FeatureModifyChangeParentProductEvent($parent_before_id, $parent_new_id));
        }


        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($product));

        return response()->json(['message' => __('toastr.deleted.message')]);
    }


    public function restore($id)
    {
        try {
            \DB::beginTransaction();

            $product = Product::withTrashed()->find($id);

            $product->page()->restore();
            $product->restore();

            \DB::commit();

            toastr()->success(__('toastr.updated.message'));
        } catch (\Exception $e) {

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('catalog.product.index'));
    }
}
