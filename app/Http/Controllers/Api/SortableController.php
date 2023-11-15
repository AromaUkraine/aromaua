<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SortableController extends Controller
{


    public function index(Request $request)
    {

        if(!isset($request->model) || empty($request->model)){
            return response()->json(["errors" => ["Sortable class name not found"]], 422);
        }

        $class_name = ucfirst($request->model);

        $model = new $class_name;

        if(class_exists($model)) {
            return response()->json(["errors" => ["Class $class_name not found"]], 400);
        }

        if(!method_exists($model,'sortable')) {
            return response()->json(["errors" => ["Function sortable in ". $class_name . " class not  found"]], 422);
        }

        if(isset($request->order)) {
            return response()->json($model->sortable($request->order));
        }
    }
}
