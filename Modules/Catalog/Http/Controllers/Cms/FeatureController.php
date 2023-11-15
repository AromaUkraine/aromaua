<?php

namespace Modules\Catalog\Http\Controllers\Cms;

use App\Events\DestroyEntityEvent;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\DataTables\FeatureDataTable;
use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Http\Requests\FeatureRequest;


class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param FeatureDataTable $dataTable
     * @return Renderable
     */
    public function index(FeatureDataTable $dataTable)
    {
        return $dataTable->render('catalog::cms.feature.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('catalog::cms.feature.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    /**
     * @param FeatureRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FeatureRequest $request)
    {
        $data = app(PublishAttribute::class)->make();

        Feature::create($data);

        toastr()->success(__('toastr.created.message'));

        return redirect(route('catalog.feature.index'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param Feature $feature
     * @return Renderable
     */
    public function edit(Feature $feature)
    {
        return view('catalog::cms.feature.edit', compact('feature'));
    }

    /**
     *  Update the specified resource in storage.
     * @param FeatureRequest $request
     * @param Feature $feature
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FeatureRequest $request, Feature $feature)
    {
        $data = app(PublishAttribute::class)->make();

//        $data = $request->all();

        if(!isset($data['filter']))
            $data['filter'] = false;

        if(!isset($data['preview']))
            $data['preview'] = false;

        if(!isset($data['page']))
            $data['page'] = false;

        $feature->update($data);

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('catalog.feature.index'));
    }


    /**
     * Enabled / disabled feature
     * @param Feature $feature
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Feature $feature)
    {
        $feature->update(['active' => !$feature->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }


    /**
     * Remove the specified resource from storage.
     * @param Feature $feature
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Feature $feature)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($feature, config('feature.softDelete') ?? false));
        return response()->json(['message' => __('toastr.deleted.message')]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($id)
    {
        $feature = Feature::withTrashed()->find($id);
        $feature->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('catalog.feature.index'));
    }
}
