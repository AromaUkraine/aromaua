<?php

namespace App\Http\Requests;

use App\Models\Settings;
use App\Services\ImageService;
use App\Services\LanguageRules;
use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends CustomFormRequest
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
        $rules = [];


        if(request()->component == 'image') {
            $requestData = app(ImageService::class)->make('value',$this->request->all());
            $this->request->replace($requestData);
        }


        if($this->method() === "POST" ){
            $rules = [
                "name" =>["required","max:255"],
                "key" => ["required", "max:255", "unique:settings"],
                "component" => ["required"],
                "group" => [ "max:255"],
                "%value%" => ["gt:0"]
            ];
        }

        if($this->method() === "PATCH" ){
            $setting = Settings::findOrFail((int) request()->setting->id);
            $rules["key"] = ["required","max:255", 'unique:settings,key,'.$setting->id];
        }

        return LanguageRules::make($rules);
    }
}
