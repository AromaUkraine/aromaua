<?php

namespace App\Rules;

use App\Models\Page;
use Illuminate\Contracts\Validation\Rule;

class SlugUnique implements Rule
{

    protected $locales;

    private $model;

    /**
     * Create a new rule instance.
     *
     * @param $model
     */
    public function __construct( $model=null )
    {
        $this->model = $model;
        $this->locales = app()->languages->all()->slug();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $arr = explode('.', $attribute);
        $locale = array_shift($arr);
        // ищу страницу по языку и по slug
        $page = Page::whereTranslation('slug',$value,$locale)->first();


        if(!$page){
            return true;
        }else{

            // если идет процесс создания страницы и страница с таким slug уже существует - однозначно возвращаем ошибку валидации
            if($page && !$this->model){
                return false;
            }else{

                // редактируется сама страница
                if(isset($this->model->pageable_id) && isset($this->model->pageable_type)) {
                    if($page->pageable_id === $this->model->pageable_id && $page->pageable_type === $this->model->pageable_type){
                        return true;
                    }
                }

                // если все совпадает -  значит редактирование записи
                if($page->pageable_id === $this->model->id && $page->pageable_type === get_class($this->model)){
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.slug_not_unique');//Такой url уже существует.
    }
}
