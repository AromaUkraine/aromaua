<?php

namespace Modules\Catalog\Http\Controllers\Cms;

use App\Events\DestroyEntityEvent;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\DataTables\CurrencyDataTable;
use Modules\Catalog\Entities\Currency;
use Modules\Catalog\Http\Requests\CurrencyRequest;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param CurrencyDataTable $dataTable
     * @return Renderable
     */
    public function index(CurrencyDataTable $dataTable)
    {
        return $dataTable->render('catalog::cms.currency.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('catalog::cms.currency.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CurrencyRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CurrencyRequest $request)
    {
        Currency::create($request->all());

        toastr()->success(__('toastr.created.message'));

        return redirect(route('admin.currency.index'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param Currency $currency
     * @return Renderable
     */
    public function edit(Currency $currency)
    {
        return view('catalog::cms.currency.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     * @param CurrencyRequest $request
     * @param Currency $currency
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CurrencyRequest $request, Currency $currency)
    {
        $currency->update($request->all());

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('admin.currency.index'));
    }

    /**
     * @param Currency $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Currency $currency)
    {
        $currency->update(['active' => !$currency->active]);
        return response()->json(['message' => __('toastr.updated.message')]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Currency $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Currency $currency)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($currency, config('catalog.softDelete') ?? false));

        return response()->json(['message' => __('toastr.deleted.message')]);
    }

    public function restore($id)
    {
        $currency = Currency::withTrashed()->find($id);
        $currency->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('admin.currency.index'));
    }
}
