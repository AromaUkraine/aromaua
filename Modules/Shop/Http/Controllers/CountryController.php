<?php


namespace Modules\Shop\Http\Controllers;


use App\Events\DestroyEntityEvent;
use App\Http\Controllers\Controller;
use Modules\Shop\DataTables\CountryDataTable;
use Modules\Shop\Entities\Country;
use Modules\Shop\Http\Requests\CountryRequest;

class CountryController extends Controller
{


    public function index(CountryDataTable $dataTable)
    {
        return $dataTable->render('shop::country.index');
    }


    public function create()
    {
        return view('shop::country.create');
    }


    public function show(Country $country)
    {
        $country->update(['show'=>!$country->show]);
        return response()->json(['message'=>__('toastr.updated.message')]);
    }


    public function active(Country $country)
    {
        $country->update(['active'=>!$country->active]);
        return response()->json(['message'=>__('toastr.updated.message')]);
    }


    public function store(CountryRequest $request)
    {
        Country::create($request->all());
        toastr()->success(__('toastr.created.message'));

        return redirect(route('root.country.index'));
    }

    public function edit(Country $country)
    {
        return view('shop::country.edit', compact('country'));
    }

    public function update(CountryRequest $request, Country $country)
    {
        $country->update($request->all());
        toastr()->success(__('toastr.updated.message'));

        return redirect(route('root.country.index'));
    }


    public function destroy(Country $country)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($country));
        return response()->json(['message'=>__('toastr.deleted.message')]);
    }


    public function restore($id)
    {
        $country = Country::withTrashed()->findOrFail($id);
        $country->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('root.country.index'));
    }
}
