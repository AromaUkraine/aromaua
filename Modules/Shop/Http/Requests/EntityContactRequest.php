<?php

namespace Modules\Shop\Http\Requests;

use App\Services\LanguageRules;
use App\Http\Requests\CustomFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class EntityContactRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'type'=>['required'],
            'value'=>['required'],
            '%description%' => ['max:255'],
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
