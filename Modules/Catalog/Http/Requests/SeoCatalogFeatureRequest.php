<?php

namespace Modules\Catalog\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use App\Services\ModelService;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Catalog\Entities\SeoCatalog;

class SeoCatalogFeatureRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $seo_page = SeoCatalog::findOrFail(request()->input('id'));

        $rules = [
            'feature.*'  => 'required|min:1',
        ];

        if($seo_page->is_brand):
            $rules['country_id'] = 'required' ;
//        else:
//            $rules[ 'product_category_id'] = 'required';
        endif;

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
