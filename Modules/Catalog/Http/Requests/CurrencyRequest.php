<?php

namespace Modules\Catalog\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use App\Services\LanguageRules;


class CurrencyRequest extends CustomFormRequest
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
            "%short_name%" =>["required","max:255"],
            "iso" =>["max:255"],
            "html_code" =>["max:255"],
            "unicode" =>["max:255"],
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
