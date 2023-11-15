<?php

namespace Modules\Catalog\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Catalog\Entities\PriceType;

class PriceTypeRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "currency_id"=> ["required"],
            "name" => ["required","max:255"],
            "key" => ["required","unique:price_types"]
        ];

        if($this->method() === "PATCH" ){
            $type = PriceType::findOrFail((int) request()->type->id);
            $rules["key"] = ["required",'unique:price_types,key,'.$type->id];
        }

        return $rules;
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
