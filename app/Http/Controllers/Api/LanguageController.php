<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LanguageController extends Controller
{

    public function switch(Request $request)
    {
        if(isset($request->lang)):
           session()->put('cms_locale',$request->lang);
            return response()->json(session()->all());
        endif;
    }
}
