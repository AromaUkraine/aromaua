<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends FormRequest
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
        // @todo дописать правила валидации!!!
        $rules =  [
            "name" => ["required","max:255","unique:templates"],
//            "is_main" =>true only on
//            "controller" => ["required","max:255","regex:/^([A-Z][a-z]+)(Controller)$/"],
//            "action" => ["required","max:255","regex:/^([a-z][A-Za-z_]+)$/"],

        ];


        return $rules;
    }
}
