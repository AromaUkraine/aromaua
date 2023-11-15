<?php


namespace Modules\Developer\Http\Controllers\Api;


use App\Models\Page;
use Illuminate\Http\Request;
use Modules\Catalog\Entities\SeoCatalog;

class SeoPageController
{
    public function get(Request $request)
    {
        if($request->has('pageable_id')) {
            $class= SeoCatalog::class;
            $page = Page::where('pageable_id', $request->pageable_id)
                ->where('pageable_type', $class)->first();

            if(!$page)
                return response()->json(['error'=>"SeoPage by pageable_id {$request->pageable_id} and pageable_type {$class} not found"], 401);

            $data = [
                'slug' => $page->slug,
                'controller' => $page->controller
            ];
            return response()->json($data);
        }

        return response()->json(['error'=>'request pageable_id not found'], 401);
    }
}
