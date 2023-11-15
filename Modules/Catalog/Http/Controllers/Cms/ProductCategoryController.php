<?php


namespace Modules\Catalog\Http\Controllers\Cms;


use App\Events\DestroyEntityEvent;
use App\Models\Page;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\DataTables\ProductCategoryDataTable;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Catalog\Events\CatalogCategoryProductCreateEvent;
use Modules\Catalog\Events\CategoryProductPageCreateEvent;
use Modules\Catalog\Events\CategoryProductPageUpdateEvent;
use Modules\Catalog\Http\Requests\CategoryProductRequest;
use Modules\Catalog\Transformers\ProductCategoryResource;
use Modules\Developer\Entities\Template;

class ProductCategoryController extends Controller
{
    /**
     * @param ProductCategoryDataTable $dataTable
     * @return mixed
     */
    public function index(ProductCategoryDataTable $dataTable)
    {
        return $dataTable->render('catalog::cms.product_category.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('catalog::cms.product_category.create');
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CategoryProductRequest $request)
    {
        try{
            \DB::beginTransaction();

            $category = ProductCategory::create([
                'parent_page_id'=>$data['parent_page_id'] ?? null,
            ]);

            event(new CategoryProductPageCreateEvent($request->all(), $category));

            toastr()->success(__('toastr.created.message'));

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('catalog.product_category.edit', $category->id));
    }

    /**
     * Show the form for editing the specified resource.
     * @param ProductCategoryController $category
     * @return Renderable
     */
    public function edit(ProductCategory $category)
    {
        return view('catalog::cms.product_category.edit', compact('category'));
    }


    /**
     * @param CategoryProductRequest $request
     * @param ProductCategory $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update(CategoryProductRequest $request, ProductCategory $category)
    {
        $category->page->update($request->all());

        event(new CategoryProductPageUpdateEvent());

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('catalog.product_category.edit', $category->id));
    }


    /**
     * @param ProductCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(ProductCategory $category)
    {
        $category->page->update(['active' => !$category->page->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }


    /**
     * @param ProductCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ProductCategory $category)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        $softDelete = config('app.softDelete');

        if (!$softDelete) {
            Page::where('pageable_type', ProductCategory::class)
                ->where('pageable_id', $category->id)->forceDelete();
        }

        event(new DestroyEntityEvent($category, $softDelete));

        return response()->json(['message' => __('toastr.deleted.message')]);
    }

    public function restore($id)
    {
        try {
            \DB::beginTransaction();

            $category = ProductCategory::withTrashed()->find($id);

            $category->page()->restore();
            $category->restore();

            \DB::commit();

            toastr()->success(__('toastr.updated.message'));
        } catch (\Exception $e) {

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('catalog.product_category.index'));
    }


    public function tree()
    {
        if(isset(request()->parent_id)  ) {

            $categories = ProductCategory::defaultOrder()
                ->get()->toTree();

           return ProductCategoryResource::collection($categories);
        }

        return view('catalog::cms.product_category.tree');
    }
}
