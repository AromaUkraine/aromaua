<?php


namespace Modules\Catalog\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Modules\ColorScheme\Entities\ColorScheme;
use Nwidart\Modules\Facades\Module;

class FeatureValueController extends Controller
{

    public function get_name(Request $request)
    {
        if($request->has('color_scheme_id')):

            if(Module::find('ColorScheme')):

                $color = ColorScheme::find($request->color_scheme_id);
                if($color):
                    $locales = app()->languages->all()->slug();

                    $data = [];
                    foreach ($locales as $locale){

                        if($color->hasTranslation($locale)){
                            $data[$locale]['name'] = $color->translate($locale)->name;
                        }else{
                            $data[$locale]['name'] = '';
                        }
                    }

                    return response()->json($data);
                endif;

            endif;

        endif;
    }

}
