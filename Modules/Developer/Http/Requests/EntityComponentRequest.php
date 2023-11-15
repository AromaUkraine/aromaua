<?php

namespace Modules\Developer\Http\Requests;

use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;

class EntityComponentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'table'=>['required','max:255','isset_in_db'],
            'model'=>['required','max:255','isset_model'],
            'name'=>['required','max:255'],
            'slug'=>['required','max:255','isset_slug'],
            'route_key'=>['required','max:255','isset_route_key'],
            'relation'=>['required','max:255','isset_relation'],
            //
        ];
    }

    public function withValidator($validator)
    {
        $validator->addExtension('isset_in_db', function ($attribute, $value, $parameters, $validator) {
            $tables = \DB::select('SHOW TABLES');

            $result = false;
            foreach ($tables as $table) {
                foreach ($table as $key=>$val)
                {
                    if($val == $value)
                        $result = true;
                }
            }

            if(!$result)
                $validator->errors()->add('table','Таблица "'.$value.'" в базе данных не найдена');

            return $result;
        });

        $validator->addExtension('isset_model', function ($attribute, $value, $parameters, $validator) {

            $result = false;

            if(class_exists($value)) :
                // проверка что класс - модель
                if( is_subclass_of( $value, 'Illuminate\Database\Eloquent\Model' ) ) :
                    $model = new $value;
                    // проверяем что таблица модели и введенае имя таблицы совпадают
                    if ($model->getTable() === request()->table) :
                        $result = true;
                    else :
                        $validator->errors()->add('model','Таблица класса "'.$value.'" и введенное название таблицы "'.request()->table.'" не совпадают.');
                    endif;

                else :
                    $validator->errors()->add('model','Класс "'.$value.'" не модель. Не является наследником Illuminate\Database\Eloquent\Model');
                endif;
            else:
                $validator->errors()->add('model','Класс "'.$value.'" не найден');
            endif;


            return $result;
        });

        $validator->addExtension('isset_slug', function ($attribute, $value, $parameters, $validator) {

            $permission = Permission::where('slug',$value)->where('type','module')->first();
            $result = true;
            if(!$permission) :
                $result = false;
                $validator->errors()->add('slug','Имя роута "'.$value.'" не существует');
            endif;

            return $result;
        });

        $validator->addExtension('isset_route_key', function ($attribute, $value, $parameters, $validator) {

            $permission = Permission::where('slug','like',$value.'.%')->first();
            $result = true;
            if(!$permission) :
                $result = false;
                $validator->errors()->add('route_key','Ключ роута "'.$value.'" введен не верно');
            endif;


            return $result;
        });

        $validator->addExtension('isset_relation', function ($attribute, $value, $parameters, $validator) {

            $result = false;

            if(!request()->model):
                $validator->errors()->add('relation','Укажи путь к модели');

            else:
                if(class_exists(request()->model)) :
                    if( is_subclass_of( request()->model, 'Illuminate\Database\Eloquent\Model' ) ) :

                        if(method_exists(request()->model,$value)):
                            $result = true;
                        else:
                            $validator->errors()->add('relation','В модели "'.request()->model.'" метод "'.$value.'" не существует');
                        endif;
                    else :
                        $validator->errors()->add('relation','Класс "'.request()->model.'" не модель. Не является наследником Illuminate\Database\Eloquent\Model');
                    endif;
                else:
                    $validator->errors()->add('relation','Класс "'.request()->model.'" не найден');
                endif;

            endif;

            return $result;
        });
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
