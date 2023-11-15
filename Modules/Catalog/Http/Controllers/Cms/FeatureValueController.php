<?php

namespace Modules\Catalog\Http\Controllers\Cms;

use App\Events\DestroyEntityEvent;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\DataTables\FeatureValueDataTable;
use Modules\Catalog\Entities\FeatureKind;
use Modules\Catalog\Entities\FeatureValue;
use Modules\Catalog\Events\CreateFeatureValueEvent;
use Modules\Catalog\Events\UpdateFeatureValueEvent;
use Modules\Catalog\Http\Requests\FeatureValueRequest;

class FeatureValueController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param FeatureValueDataTable $dataTable
     * @param FeatureKind $kind
     * @return Renderable
     */
    public function index(FeatureValueDataTable $dataTable,FeatureKind $kind)
    {
        return $dataTable->render('catalog::cms.feature_value.index', compact('kind'));
    }

    /**
     * Show the form for creating a new resource.
     * @param FeatureKind $kind
     * @return Renderable
     */
    public function create( FeatureKind $kind)
    {
        return view('catalog::cms.feature_value.create', compact('kind'));
    }

    /**
     * Store a newly created resource in storage.
     * @param FeatureValueRequest $request
     * @param FeatureKind $kind
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FeatureValueRequest $request, FeatureKind $kind)
    {

        try{
            \DB::beginTransaction();

            event(new CreateFeatureValueEvent($kind, $request->all()));
            toastr()->success(__('toastr.created.message'));

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('module.feature_value.index', $kind->id));
    }

    /**
     * Show the form for editing the specified resource.
     * @param FeatureKind $kind
     * @param FeatureValue $value
     * @return Renderable
     */
    public function edit(FeatureKind $kind, FeatureValue $value)
    {
        return view('catalog::cms.feature_value.edit',compact('kind', 'value'));
    }


    /**
     * Update the specified resource in storage.
     * @param FeatureValueRequest $request
     * @param FeatureKind $kind
     * @param FeatureValue $value
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FeatureValueRequest $request, FeatureKind $kind, FeatureValue $value)
    {

        try{
            \DB::beginTransaction();

            event(new UpdateFeatureValueEvent($value, $request->all()));
            toastr()->success(__('toastr.updated.message'));

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }

        return redirect(route('module.feature_value.index', $kind->id));
    }

    /**
     * @param FeatureValue $value
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(FeatureValue $value)
    {
        $value->update(['active' => !$value->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }

    /**
     * Remove the specified resource from storage.
     * @param FeatureValue $value
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(FeatureValue $value)
    {

        // нужно придумать как дописать
        // (в DestroyEntityEvent есть метод который выбирает все методы модели (нужно найти полиморфные связи таблиц))
        // и удалить по полиморфной связи
        $value->colorable->delete();
        if(isset( $value->colorable)) :
            $value->colorable->delete();
        endif;

        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($value, config('feature.softDelete') ?? false));

        return response()->json(['message' => __('toastr.deleted.message')]);

    }

    public function restore(FeatureKind $kind, $id)
    {

        $value = FeatureValue::withTrashed()->find($id);
        $value->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.feature_value.index', $kind->id));
    }
}
