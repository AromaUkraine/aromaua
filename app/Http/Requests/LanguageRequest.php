<?php

namespace App\Http\Requests;

use App\Models\Language;
use App\Services\LanguageRules;
use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends CustomFormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return true;
    }

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
            "short_code" =>["required","max:3",'unique:languages'],
        ];


        if($this->method() === "PATCH" ){
            $language = Language::findOrFail((int) request()->language->id);
            $rules["short_code"] = ["required","max:3",'unique:languages,short_code,'.$language->id];
        }

        return LanguageRules::make($rules);
    }
}
