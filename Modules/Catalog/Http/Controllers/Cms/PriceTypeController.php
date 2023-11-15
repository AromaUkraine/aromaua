<?php

namespace Modules\Catalog\Http\Controllers\Cms;

use App\Events\DestroyEntityEvent;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\DataTables\PriceTypeDataTable;
use Modules\Catalog\Entities\PriceType;
use Modules\Catalog\Http\Requests\PriceTypeRequest;

class PriceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param PriceTypeDataTable $dataTable
     * @return Renderable
     */
    public function index(PriceTypeDataTable $dataTable)
    {
        return $dataTable->render('catalog::cms.price_type.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('catalog::cms.price_type.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param PriceTypeRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PriceTypeRequest $request)
    {
        PriceType::create($request->all());

        toastr()->success(__('toastr.created.message'));

        return redirect(route('admin.price_type.index'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param PriceType $type
     * @return Renderable
     */
    public function edit(PriceType $type)
    {
        return view('catalog::cms.price_type.edit', compact('type'));
    }


    /**
     *  Update the specified resource in storage.
     * @param PriceTypeRequest $request
     * @param PriceType $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PriceTypeRequest $request, PriceType $type)
    {
        $type->update($request->all());

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('admin.price_type.index'));
    }

    /**
     * @param PriceType $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(PriceType $type)
    {
        $type->update(['active' => !$type->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }


    /**
     * Remove the specified resource from storage.
     * @param PriceType $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PriceType $type)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($type, config('catalog.softDelete') ?? false));

        return response()->json(['message' => __('toastr.deleted.message')]);
    }

    public function restore($id)
    {
        $type = PriceType::withTrashed()->find($id);
        $type->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('admin.price_type.index'));
    }
}
