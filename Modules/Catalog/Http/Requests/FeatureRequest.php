<?php

namespace Modules\Catalog\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use App\Services\LanguageRules;
use Illuminate\Foundation\Http\FormRequest;

class FeatureRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "%name%" =>["required","max:255"],
            "feature_kind_id" =>["required"],
        ];

        return LanguageRules::make($rules);
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
