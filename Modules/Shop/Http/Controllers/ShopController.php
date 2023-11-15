<?php

namespace Modules\Shop\Http\Controllers;

use App\Events\DestroyEntityEvent;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Shop\DataTables\ShopDataTable;
use Modules\Shop\Entities\Shop;
use Modules\Shop\Http\Requests\ShopRequest;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param ShopDataTable $dataTable
     * @return Renderable
     */
    public function index(ShopDataTable $dataTable)
    {
        return $dataTable->render('shop::shop.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('shop::shop.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Renderable|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ShopRequest $request)
    {
        $shop = Shop::create($request->all());

        toastr()->success(__('toastr.created.message'));

        return redirect(route('root.shop.edit', $shop->id));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Shop $shop
     * @return Renderable
     */
    public function edit(Shop $shop)
    {
        return view('shop::shop.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     * @param ShopRequest $request
     * @param Shop $shop
     * @return \Illuminate\Contracts\Foundation\Application|Renderable|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ShopRequest $request, Shop $shop)
    {

        $shop->update($request->all());

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('root.shop.edit', $shop->id));
    }


    /**
     * @param Shop $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Shop $shop)
    {
        $shop->update(['active'=>!$shop->active]);
        return response()->json(['message'=>__('toastr.updated.message')]);
    }

    /**
     * @param Shop $shop
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Shop $shop)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($shop));
        return response()->json(['message'=>__('toastr.deleted.message')]);
    }


    public function restore($id)
    {
        $shop = Shop::withTrashed()->findOrFail($id);
        $shop->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('developer.shop.index'));
    }

    public function change(Shop $shop)
    {
        Shop::where('id','!=', $shop->id)->update(['default'=>false]);
        $shop->update(['default'=>true]);

        return response()->json(['message'=>__('toastr.updated.message')]);
    }
}
