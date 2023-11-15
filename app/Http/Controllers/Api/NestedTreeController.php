<?php


namespace App\Http\Controllers\Api;


use App\Services\ModelService;
use Illuminate\Http\Request;

class NestedTreeController
{
    public $namespace = "\\App\\Models";

    public function move(Request $request)
    {


        if($request->has('class')):
            $class = $request->class;
            $model = new $class;
        else:
            if(!isset($request->model) || empty($request->model)){
                return response()->json(["errors" => ["Sortable class name not found"]], 422);
            }

            //        dd($request->all());
            /* $request->model = \Str::camel($request->model);
             $class_name = ucfirst($request->model);
             $name = $this->namespace.'\\'.class_basename($class_name);*/
            $class = app(ModelService::class)->getClassFromTable($request->model);

            if($class):
                $model = new $class;
            else:
                $request->model = \Str::camel($request->model);
                $class_name = ucfirst($request->model);
                $class = $this->namespace.'\\'.class_basename($class_name);
                $model = new $class;

            endif;
        endif;



        if(class_exists($model)) {
            return response()->json(["errors" => ["Class $class not found"]], 400);
        }

        if(!method_exists($model,'move')) {
            return response()->json(["errors" => ["Function move in ". $class . " class not  found"]], 422);
        }

        $model->move();

        return response()->json(['message'=>__('toastr.updated.message')]);
    }
}
