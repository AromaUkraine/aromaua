<?php

namespace Modules\Article\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use App\Http\Requests\PageRequest;
use App\Rules\SlugUnique;
use App\Services\LanguageRules;

use App\Traits\PageValidationRequestTrait;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{

    use PageValidationRequestTrait;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->call(request()->article);
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
