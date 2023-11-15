<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Transliterate;

class SlugController extends Controller
{

    public function index(Request $request)
    {

        if(isset($request->value) ){

            $slug = Transliterate::slugify($request->value);
            return response()->json(["slug" => $slug], 200);
        }
    }
}
