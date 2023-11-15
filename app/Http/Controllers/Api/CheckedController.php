<?php


namespace App\Http\Controllers\Api;


use App\Services\ModelService;

class CheckedController
{
    public function index()
    {

        if(request()->params){

            $data = json_decode(request()->params, true);

            if(isset($data['table']) && isset($data['field']) && isset($data['id']))
            {
                $class = $data['table'];
                if(class_exists($class)){
                    $entity = $class::findOrFail($data['id']);
                    $toggleField = $data['field'];

                    $entity->update([$toggleField => !$entity->$toggleField ]);

                    return response()->json(['message' => __('toastr.updated.message')]);
                }
            }
        }

    }
}
