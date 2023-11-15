<?php


namespace Modules\Catalog\Http\Controllers\Cms;


use App\Http\Controllers\Controller;
use App\Services\ModelService;
use Illuminate\Http\Request;
use Modules\Catalog\DataTables\FeatureModifyDataTable;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Events\FeatureModifyChangeParentProductEvent;
use Modules\Catalog\Events\FeatureModifyCopyProductFeatureEvent;
use Modules\Catalog\Events\FeatureModifyCreateEvent;
use Modules\Catalog\Events\FeatureModifyUpdateEvent;
use Modules\Catalog\Events\JoinProductToParentProductEvent;
use Modules\Catalog\Http\Requests\FeatureModifyRequest;
use Modules\Catalog\Http\Requests\JoinedRequest;
use Modules\Catalog\Listeners\JoinProductToParentProductListener;
use Modules\Catalog\Listeners\SetParentForChildesListener;


class FeatureModifyController extends Controller
{



    /**
     * @param $table
     * @param $id
     * @param FeatureModifyDataTable $dataTable
     * @return mixed
     */
    public function index($table, $id, FeatureModifyDataTable $dataTable)
    {
        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return $dataTable->render('catalog::cms.feature_modify.index', compact('table', 'id', 'entity'));
    }



    /**
     * @param $table
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($table, $id)
    {
        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return view('catalog::cms.feature_modify.create', compact('table', 'id', 'entity'));
    }



    /**
     * @param FeatureModifyRequest $request
     * @param $table
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FeatureModifyRequest $request, $table, $id)
    {
        try {
            \DB::beginTransaction();

            $product = app(ModelService::class)->findEntityByTableId($table, $id);

            event(new FeatureModifyCreateEvent($product, $request->all()));

            toastr()->success(__('toastr.created.message'));

            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollback();
            dd($e->getMessage());
        }
        return redirect()->route('module.feature_modify.index', [$table, $id]);
    }




    /**
     * @param $table
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($table, $id)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return view('catalog::cms.feature_modify.edit', compact('table', 'id', 'entity'));
    }



    /**
     * @param FeatureModifyRequest $request
     * @param $table
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FeatureModifyRequest $request, $table, $id)
    {

        try {
            \DB::beginTransaction();

            $product = app(ModelService::class)->findEntityByTableId($table, $id);

            event(new FeatureModifyUpdateEvent($product, $request->all()));

            toastr()->success(__('toastr.updated.message'));

            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollback();
            dd($e->getMessage());
        }
        return redirect()->route('module.feature_modify.index', [$table, $id]);

    }



    /**
     * @param $table
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function copy($table, $id)
    {

        $product = app(ModelService::class)->findEntityByTableId($table, $id);

        event(new FeatureModifyCopyProductFeatureEvent($product));

        toastr()->success(__('toastr.updated.message'));

        return redirect()->route('module.feature_modify.index', [$table, $id]);
    }


    public function join($table, $id)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return view('catalog::cms.feature_modify.join', compact('table', 'id', 'entity'));
    }


    public function joined(JoinedRequest $request, $table, $id)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);


        event(new JoinProductToParentProductEvent($entity, $request->all()));

        toastr()->success(__('toastr.updated.message'));

        return redirect()->route('module.feature_modify.index', [$table, $id]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function change_parent(Request $request)
    {
        if (request()->parent_before && request()->parent_now && request()->parent_before !== request()->parent_now) {
            try {
                \DB::beginTransaction();

                event(new FeatureModifyChangeParentProductEvent(request()->parent_before, request()->parent_now));

                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
                dd($e->getMessage());
            }
        }

        return response()->json(['message' => __('toastr.updated.message')]);
    }
}
