<?php


namespace Modules\Map\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\ModelService;
use App\Http\Controllers\Controller;
use Modules\Map\Entities\EntityMap;

class EntityMapController extends Controller
{

    public function index($table, $id)
    {
        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);
        return view('map::entity_map.index', compact('entity','table', 'id'));
    }

    public function create(Request $request, $table, $id)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);
        $entity->map()->create($request->all());
        toastr()->success(__('toastr.created.message'));

        return redirect(route('module.entity_map.index',[$table, $id]));
    }


    public function update(Request $request, $table, $id)
    {

        $entity = app(ModelService::class)->findEntityByTableId($table, $id);
        $entity->map->update($request->all());
        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.entity_map.index',[$table, $id]));
    }


    public function destroy($table, $id, EntityMap $map)
    {

        $map->delete();
        toastr()->success(__('toastr.deleted.message'));

        return redirect(route('module.entity_map.index',[$table, $id, 'delete']));
    }

}
