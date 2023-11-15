<?php


namespace Modules\Banner\Http\Requests;


use App\Http\Requests\CustomFormRequest;
use App\Services\ImageService;
use App\Services\LanguageRules;

class EntityBannerRequest extends CustomFormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // содержание поля image приходит в формате json как массив
        // ImageService преобразует его в нормальное значение и возвращает в поле image строку - путь к картинке
        // если нужен массив картинок то нужно указать 3ий параметр ImageService::MULTIPLE
        $requestData = app(ImageService::class)->make('image',$this->request->all());
        $this->request->replace($requestData);

        $rules = [
            'type'=>'required',
            '%image%' => 'required',
            '%name%' =>  "max:255",
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
