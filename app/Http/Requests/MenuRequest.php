<?php

namespace App\Http\Requests;

use App\Models\Menu;
use App\Services\LanguageRules;
use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends CustomFormRequest
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
        ];

        return LanguageRules::make($rules);
    }
}
