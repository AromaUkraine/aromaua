<?php

namespace Modules\Gallery\Http\Requests;

use App\Http\Requests\CustomFormRequest;
use App\Services\ImageService;
use App\Services\LanguageRules;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Gallery\Entities\Gallery;

class GalleryRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =[];

        if(request()->type === Gallery::TYPE_VIDEO){
            $rules = [
                'link' => 'required',
                '%name%' =>  "max:255",
                '%alt%' =>  "max:255",
            ];
        }


        if(request()->type === Gallery::TYPE_PHOTO && $this->method() === "PATCH"){
            // содержание поля image приходит в формате json как массив
            // ImageService преобразует его в нормальное значение и возвращает в поле image строку - путь к картинке
            // если нужен массив картинок то нужно указать 3ий параметр ImageService::MULTIPLE
            $requestData = app(ImageService::class)->make('image',$this->request->all());

            $this->request->replace($requestData);

            $rules = [
                '%image%' => 'required',
                '%name%' =>  "max:255",
                '%alt%' =>  "max:255",
            ];
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
