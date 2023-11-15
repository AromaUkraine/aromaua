<?php

namespace Modules\Catalog\Http\Controllers\Cms;

use App\Events\DestroyEntityEvent;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\DataTables\FeatureKindDataTable;
use Modules\Catalog\Entities\FeatureKind;
use Modules\Catalog\Http\Requests\FeatureKindRequest;

class FeatureKindController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param FeatureKindDataTable $dataTable
     * @return Renderable
     */
    public function index(FeatureKindDataTable $dataTable)
    {
        return $dataTable->render('catalog::cms.feature_kind.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('catalog::cms.feature_kind.create');
    }


    /**
     * Store a newly created resource in storage.
     * @param FeatureKindRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FeatureKindRequest $request)
    {
        $data = app(PublishAttribute::class)->make();

        FeatureKind::create($data);

        toastr()->success(__('toastr.created.message'));

        return redirect(route('catalog.feature_kind.index'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param FeatureKind $kind
     * @return Renderable
     */
    public function edit(FeatureKind $kind)
    {
        return view('catalog::cms.feature_kind.edit', compact('kind'));
    }

    /**
     *  Update the specified resource in storage.
     * @param FeatureKindRequest $request
     * @param FeatureKind $kind
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FeatureKindRequest $request, FeatureKind $kind)
    {
        $data = app(PublishAttribute::class)->make();

        $kind->update($data);

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('catalog.feature_kind.index'));
    }

    /**
     * Enabled / disabled feature_kind
     * @param FeatureKind $kind
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(FeatureKind $kind)
    {
        $kind->update(['active' => !$kind->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }

    /**
     * Remove the specified resource from storage.
     * @param FeatureKind $kind
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(FeatureKind $kind)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($kind, config('feature.softDelete') ?? false));
        return response()->json(['message' => __('toastr.deleted.message')]);

    }


    public function restore($id)
    {

        $kind = FeatureKind::withTrashed()->find($id);
        $kind->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('catalog.feature_kind.index'));
    }
}
