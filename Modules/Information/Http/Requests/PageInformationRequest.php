<?php

namespace Modules\Information\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use App\Services\LanguageRules;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Information\Entities\Information;

class PageInformationRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            '%title%' => ['required', 'max:255'],
            'type' =>  ['required', 'unique:information'],
        ];

        if($this->method() === "PATCH" ){
            $info = Information::findOrFail((int) request()->info->id);
            $rules["type"] = ["required","max:255", 'unique:information,type,'.$info->id];
        }

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
