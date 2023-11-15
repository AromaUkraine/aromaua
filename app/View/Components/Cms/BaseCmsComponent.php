<?php


namespace App\View\Components\Cms;


use Illuminate\View\Component;
/***
 Базовый класс компонентов
 ***/


class BaseCmsComponent extends  Component
{
    /**
     * @var mixed
     * Модель содержит в себе объект модели (при редактировании) или же null (при создании)
     */
    public $model = null;

    /**
     * @var string|null
     * Имя поля в базе данных
     */
    public $name = null;

    /**
     * @var mixed
     * Массив языков приложения для создания мультиязычности или же null (если перевод не требуется)
     */
    public $languages = null;

    /**
     * @var mixed
     *  Json-объект содержащий в себе опциональную конфигурацию полей
     */
    public $options;

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     * Язык приложения по умолчанию
     */
    public $default_language;

    /**
     * @var string|null
     * Значение поля (Если value не указано -  то оно вычисляется с помощью model->$name)
     */
    public $value;

    /**
     * @var string|null
     * Заголовок поля ввода
     */
    public $label;


    /**
     * @var string|null
     *  Дополнительный параметр для js отслеживания значения поля watch (использует id-поля для слежения)
     */
    public $watch;


    /**
     * @var bool
     * Параметр указывает на мультиязычность поля
     */
    public $lang=false;


    /**
     * BaseCmsComponent constructor.
     * @param object|null $model
     * @param string|null $name
     * @param string|null $value
     * @param string|null $rel
     * @param string|null $watch
     * @param bool $lang
     * @param string|null $label
     * @param string|null $options
     */
    public function __construct(object $model = null,
                                string $name=null,
                                string $value=null,
                                string $rel=null,
                                string $watch=null,
                                bool   $lang=false,
                                string $label=null,
                                string $options=null
    )
    {

        $this->setModel($model, $rel);
        $this->setLanguages($lang);
        $this->setOptions($options);

        $this->default_language = app()->getLocale();
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->watch = $watch;
        $this->lang = $lang;
    }

    protected function setOptions($options)
    {
        if($options){
            $this->options = json_decode($options, true);
        }
    }

    protected function setLanguages($lang)
    {
        if($lang){

            $this->languages = collect();
            app()->languages->all()->get()->each(function ($lang){
                if($lang->short_code == app()->getLocale()){
                    $this->languages->push($lang);
                }
            })->each(function ($lang) {
                if($lang->short_code != app()->getLocale()){
                    $this->languages->push($lang);
                }
            });
        }
    }

    /***
     * @param $model
     * @param $rel - ссылка на связанную таблицу DEPRECATED!!! вместо этого используем аттрибут value
     */
    protected function setModel($model, $rel)
    {
        if($model) {
            if($rel){
                $this->model = $model->$rel;
            }else{
                $this->model = $model;
            }
        }
    }


    /**
     * Undocumented function
     *
     * @return void
     */
    public function getMaxLength()
    {
        if(isset($this->options['maxlength'])){

            return 'maxlength';
        }
        return '';
    }


    public function setId($lang=false)
    {
        if($lang){
            return $this->options['id'] ??  $lang."_".$this->name;
        }else{
            return  $this->options['id'] ?? $this->name;
        }
    }

    public function setName($lang=false)
    {
        if($lang){
            return $lang."[".$this->name."]";
        }else{
            return $this->name;
        }
    }


    public function getWatchId($lang=false)
    {
        if($lang){
            return $this->options['id'] ??  $lang."_".$this->watch;
        }else{
            return  $this->options['id'] ?? $this->watch;
        }
    }


    public function setValue($lang=null)
    {
        if($lang)
            return $this->getValueByLang($lang);
        else
            return $this->getValue();
    }

    public function isChecked($lang=null)
    {
        return empty($this->setValue($lang)) ? 0 : 1;
    }

    private function getValueByLang($lang)
    {
        $name = $this->name;

        if($this->value ) {
            return old($lang.".".$name) ?? $this->value;
        }

        if($this->model) {
            if($this->model->hasTranslation($lang)){
                return old($lang.".".$name) ?? $this->model->translate($lang)->$name;
            }
        }

        return old($lang.".".$name) ?? '';
    }


    protected function getValue()
    {
        $name = $this->name;
        if($this->value ) {
            return old($name) ?? $this->value;
        }

        if($this->model) {
            return old($name) ?? $this->model->$name;
        }

        return old($name) ?? '';
    }

    /**
     * @throws \Exception
     */
    public function render() {
        throw new \Exception('This is just a class constructor');
    }
}
