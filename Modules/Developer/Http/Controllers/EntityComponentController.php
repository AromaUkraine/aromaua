<?php

namespace Modules\Developer\Http\Controllers;

use App\Models\EntityComponent;
use App\Models\Permission;
use App\Services\ModelService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Developer\DataTables\EntityComponentDataTable;
use Modules\Developer\Http\Requests\EntityComponentRequest;
use Modules\Developer\Service\ModulesService;



class EntityComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param EntityComponentDataTable $dataTable
     * @return Renderable
     */
    public function index( EntityComponentDataTable $dataTable)
    {
//       $tables = \DB::select('SHOW TABLES');
//
//       $permissions = Permission::where('action','index')->where('type','module')->get();

//        $name = 'products';
//        app(ModelService::class)->getClassFromTable($name);
//
//        foreach( get_declared_classes() as $class ) {
//
//            if( is_subclass_of( $class, 'Illuminate\Database\Eloquent\Model' ) ) {
//
//                // $model = new $class;
//                //dump($class);
//            }
//        }
//
//
//       $entity = app(ModelService::class)->getClassFromTable($name);

//       dump(get_declared_classes());

   //    $methods = collect(get_class_methods($entity));
//        category_feature
//       $test = $methods->filter(function ($item){
//           return str_is('gallery*',$item);
//       });
//        dump($test);
//
//       dump($methods);

        return $dataTable->render('developer::entity_component.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('developer::entity_component.create');
    }

    /**
     * @param EntityComponentRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EntityComponentRequest $request)
    {

        EntityComponent::create($request->all());
        return redirect(route('developer.entity_component.index'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param EntityComponent $item
     * @return Renderable
     */
    public function edit(EntityComponent $item)
    {
        return view('developer::entity_component.edit', compact('item'));
    }


    /**
     * @param EntityComponentRequest $request
     * @param EntityComponent $item
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EntityComponentRequest $request, EntityComponent $item)
    {

        $item->update($request->all());
        return redirect(route('developer.entity_component.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param EntityComponent $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EntityComponent $item)
    {
        $class = $item->model;

        if(class_exists($class) && method_exists($class, $item->relation)) :

            $rel = $item->relation;
            //находим все записи модели $class к которой были прикреплен $item->relation компонент
            $entities = $class::all();
            if($entities->count()) :
                foreach ($entities as $entity) :

                    // раз удаляется полностью связь записи с компонентом - удаляем окончательно
                    foreach ($entity->$rel as $component) :
                        $component->forceDelete();
                    endforeach;

                endforeach;
            endif;
        endif;
        $item->delete();
        return response()->json(['message' => __('toastr.deleted.message')]);
    }
}
