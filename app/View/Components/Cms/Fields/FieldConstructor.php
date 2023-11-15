<?php

namespace App\View\Components\Cms\Fields;

use Illuminate\View\Component;

class FieldConstructor extends Component
{
    /**
     * @var string
     */
    public $id;

    /**
     * Имя поля, свойства класса модели
     * @var string
     */
    public $name;

    /**
     * Объект класса модели (при update) или null (при create)
     * @var object|null
     */
    public $model;

    /**
     * значение выбранного языка ( только для для языковых полей )
     *
     * @var string|null
     */
    public $lang;

    /**
     * Для добавления полю label
     * @var string|null
     */
    public $label;

    /**
     * Для добавления полю value значения
     * @var mixed
     */
    public $value;

    /**
     * Для добавления полю аттрибута required
     * @var int
     */
    public $required;

    /**
     * Для добавления полю аттрибута readonly
     * @var bool
     */
    public $readonly;

    /**
     * Для добавления полю аттрибута disabled
     * @var bool
     */
    public $disabled;

    /**
     *  Установка типа поля input, по умолчанию - text
     * @var string
     */
    public $type;

    /**
     * Для добавления полю счетчика количества введенных символов (input, textarea)
     * @var int
     */
    public $maxlength;

    /**
     * Для добавления полю аттрибута placeholder
     * @var string|null
     */
    public $placeholder;

    /**
     * Для добавления к дефолтному аттрибуту поля class своих значений
     * @var string
     */
    public $class;

    /**
     * Свойство для языковых полей (полей значение которых зависит от выбранного языка)
     * @var \Illuminate\Config\Repository
     */
    public $default_language;

    /**
     * Свойство select - массив значений
     * @var array
     */
    public $options =[];

    /**
     * Свойство option значение option
     * @var string
     * @default id
     */
    public $option_value;

    /**
     * Свойство option содержание option
     * @var string
     * @default name
     */
    public $option_name;

    /**
     * Свойство select надпись в пустом option (по умолчанию)
     * @var string|null
     */
    public $empty;


    /**
     * Свойство checkbox
     * @var bool|null
     */

    public $checked;

    /**
     * Свойство checkbox если нужно сгруппировать чекбоксы под одним ключем
     * @var string|null
     */
    public $group;

    /**
     * Свойство checkbox добавляет тень checked checkbox
     * @var bool|null
     */
    public $glow;

    /**
     * Подсказка
     * @var string|null
     */
    public $hint;

    /**
     * Inputs constructor.
     * @param string $name
     * @param string $type
     * @param string $class
     * @param int|null $maxlength
     * @param object|null $model
     * @param object|null $options
     * @param string|null $option_value
     * @param string|null $option_name
     * @param string|null $value
     * @param string|null $lang
     * @param string|null $label
     * @param bool|null $required
     * @param bool|null $readonly
     * @param bool|null $disabled
     * @param string|null $placeholder
     * @param string|null $empty
     * @param bool|null $checked
     * @param bool|null $glow
     * @param string|null $group
     * @param string|null $hint
     */
    public function __construct( string $name,
                                 string $type = "text",
                                 ?string $class = null,
                                 ?int $maxlength = 0,
                                 ?object $model = null,
                                 ?object $options = null,
                                 ?string $option_value = 'id',
                                 ?string $option_name = 'name',
                                 ?string $value = null,
                                 ?string $lang = null,
                                 ?string $label = null,
                                 ?bool $required = null,
                                 ?bool $readonly = null,
                                 ?bool $disabled = null,
                                 ?string $placeholder=null,
                                 ?string $empty=null,
                                 ?bool $checked=null,
                                 ?bool $glow=null,
                                 ?string $group='',
                                 ?string $hint=null
    ) {

        $this->name = $name;
        $this->type = $type;
        $this->class = $class;
        $this->model = $model;
        $this->maxlength = ($maxlength) ? (int)$maxlength : false;

        $this->options = $options;
        $this->option_value = $option_value;
        $this->option_name = $option_name;

        $this->value = $value;
        $this->lang = ( $lang ) ? $lang : null;
        $this->label = ($label) ? $label : null;
        $this->required = ($required) ?? false;
        $this->readonly = ($readonly) ?? false;
        $this->disabled = ($disabled) ?? false;
        $this->checked = ($checked) ?? false;


        if($placeholder && is_string($placeholder)){
            $this->placeholder = $placeholder;
        }else{
            $this->placeholder = false;
        }

        $this->empty= $empty?? null;
        $this->default_language = config('app.locale');
        $this->group = ($group) ?? null;
        $this->glow = ($glow) ?? false;
        $this->hint = $hint;
    }

    /**
     * @throws \Exception
     */
    public function render() {
        throw new \Exception('This is just a class constructor');
    }


    protected function setValue()
    {
        $name = $this->name;

        // если значение поля зависит от языка
        if ($this->lang && in_array($this->lang, app()->languages->all()->slug())) {

            $this->name = $this->id = $this->lang . "[$name]";
            $this->attr = $this->lang . "." . $name;

            if ($this->model) {
                $this->value = old($this->attr, $this->model->translate($this->lang)->$name ?? '');
            } else {
                $this->value = old($this->attr ?? '');
            }

        } else {

            $this->id = $this->name;

            if ($this->model) {
                $this->value = old($this->name, $this->model->$name ?? '');
            } else {
                $this->value = old($this->name ?? '');
            }
        }
    }
}
