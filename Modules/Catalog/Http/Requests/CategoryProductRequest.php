<?php

namespace Modules\Catalog\Http\Requests;


use App\Traits\PageValidationRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class CategoryProductRequest extends FormRequest
{

    use PageValidationRequestTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules( )
    {
        //1 параметр который передается в валидатор - это модель , 2ой - дополнительные правила валидации
        return $this->call(request()->category,[
            //'parent_page_id' => ["required"]
        ]);
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
