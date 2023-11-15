<?php

namespace Modules\Developer\Http\Requests;

use App\Models\Component;
use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'=>["required","max:255"],
            'alias'=>["required","unique:components","regex:/^[a-zA-Z\d_-]+$/"]
        ];

        if($this->method() === "PATCH" ){
            $component = Component::findOrFail((int) request()->module->id);
            $rules["alias"] = ["required",'unique:components,id,'.$component->id];
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
