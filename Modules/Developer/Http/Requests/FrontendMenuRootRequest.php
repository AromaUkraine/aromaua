<?php

namespace Modules\Developer\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use App\Models\Menu;
use App\Services\LanguageRules;
use Illuminate\Foundation\Http\FormRequest;

class FrontendMenuRootRequest extends CustomFormRequest
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
            "from" =>["required","max:255"],
            "type" =>["required", 'string', "max:255",'unique:menus'],
        ];

        if($this->method() === "PATCH" ){
            $menu = Menu::findOrFail((int) request()->menu->id);
            $rules["type"] = ["required",'string',"max:255","unique:menus,type,".$menu->id];
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
