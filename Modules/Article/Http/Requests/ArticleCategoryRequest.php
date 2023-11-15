<?php

namespace Modules\Article\Http\Requests;


use App\Traits\PageValidationRequestTrait;
use Illuminate\Foundation\Http\FormRequest;


class ArticleCategoryRequest extends FormRequest
{
    use PageValidationRequestTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->call(request()->category);
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
