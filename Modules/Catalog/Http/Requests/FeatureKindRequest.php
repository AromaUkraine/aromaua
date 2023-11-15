<?php

namespace Modules\Catalog\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use App\Services\LanguageRules;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Catalog\Entities\FeatureKind;

class FeatureKindRequest extends CustomFormRequest
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
            "key" =>["required","max:255",'unique:feature_kinds'],
        ];

        if($this->method() === "PATCH" ){
            $kind = FeatureKind::findOrFail((int) request()->kind->id);
            $rules["key"] = ["required","max:255",'unique:feature_kinds,key,'.$kind->id];
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
