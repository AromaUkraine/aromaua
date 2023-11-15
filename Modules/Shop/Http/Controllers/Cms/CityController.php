<?php


namespace Modules\Shop\Http\Controllers\Cms;


use App\Events\DestroyEntityEvent;
use App\Http\Controllers\Controller;
use App\Services\PublishAttribute;
use Modules\Shop\DataTables\CityDataTable;
use Modules\Shop\Entities\City;
use Modules\Shop\Http\Requests\CityRequest;

class CityController extends Controller
{


    /**
     * @param CityDataTable $dataTable
     * @return mixed
     */
    public function index(CityDataTable $dataTable)
    {
        return $dataTable->render('shop::cms.city.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('shop::cms.city.create');
    }

    public function store(CityRequest $request)
    {
        $data = app(PublishAttribute::class)->make($request);

        City::create($data);

        toastr()->success(__('toastr.created.message'));

        return redirect(route('developer.city.index'));
    }

    public function edit(City $city)
    {
        return view('shop::cms.city.edit', compact('city'));
    }

    public function update(CityRequest $request, City $city)
    {
        $data = app(PublishAttribute::class)->make($request);

        $city->update($data);

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('developer.city.index'));
    }


    public function active(City $city)
    {
        $city->update(['active'=>!$city->active]);
        return response()->json(['message'=>__('toastr.updated.message')]);
    }


    public function destroy(City $city)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($city, config('shop.softDelete') ?? false));
        return response()->json(['message'=>__('toastr.deleted.message')]);
    }


    public function restore($id)
    {
        $city = City::withTrashed()->findOrFail($id);
        $city->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('developer.city.index'));
    }
}
