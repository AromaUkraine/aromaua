<?php

namespace App\Http\Requests;


class RoleRequest extends CustomFormRequest
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
            "name" =>["required","max:255"],
            "slug" =>["required"]
        ];

        if($this->method() === "POST" ){
            $rules['slug'] = ['required', 'string', 'max:255', 'unique:roles'];
        }

        return $rules;
    }
}
