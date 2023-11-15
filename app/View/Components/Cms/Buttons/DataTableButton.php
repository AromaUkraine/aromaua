<?php

namespace App\View\Components\Cms\Buttons;

use Illuminate\View\Component;

class DataTableButton extends Component
{
    public $attributes;

    protected $class = 'btn-outline-';

    protected $btn = 'rounded-circle';

    protected $placement = 'top';


    /**
     * Create a new component instance.
     *
     * @return void
     */
    /**
     * Button constructor.
     * @param $attributes
     */
    public function __construct($attributes)
    {

        $this->attributes['class'] = isset( $attributes['class'] ) ?  $this->class.$attributes['class'] : null;
        $this->attributes['btn'] = isset( $attributes['btn'] ) ?  $attributes['btn'] : $this->btn;
        $this->attributes['name'] = isset( $attributes['name'] ) ?  $attributes['name'] : null;
        $this->attributes['tooltip'] = isset( $attributes['tooltip'] ) ? $attributes['tooltip'] : true;
        $this->attributes['icon'] = isset( $attributes['icon'] ) ? $attributes['icon'] : null;
        $this->attributes['placement'] = isset( $attributes['placement'] ) ? $attributes['placement'] : $this->placement;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(){
        return view('components.cms.buttons.data-table-button');
    }


    public static function make($attributes = []){

        return new static($attributes);
    }


    /**
     * @param string|null $route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit( ?string $route=null )
    {
        $this->attributes['route'] = $route;
        $this->attributes['class'] = ($this->attributes['class']) ?? $this->class.'primary';
        $this->attributes['name'] = ($this->attributes['name']) ?? __('cms.buttons.edit');
        $this->attributes['icon'] = ($this->attributes['icon']) ?? 'bx bx-paint';

        return view('components.cms.buttons.data-table-button' )->with($this->attributes);
    }



    /**
     * @param string|null $route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete( ?string $route=null )
    {
        $this->attributes['route'] = $route;
        $this->attributes['class'] = ($this->attributes['class']) ?? $this->class.'danger ';

        if($route){
            $this->attributes['toggle'] = "data-action=delete";
        }

        $this->attributes['name'] = ($this->attributes['name']) ?? __('cms.buttons.delete');
        $this->attributes['icon'] = ($this->attributes['icon']) ?? 'bx bx-trash';

        return view('components.cms.buttons.data-table-button' )->with($this->attributes);
    }


    public function toggleActive( ?bool $active = false, ?string $route=null){

        $this->attributes['route'] = $route;
        $name = (!$active) ? __('cms.buttons.not_active') : __('cms.buttons.active');
        $icon = (!$active) ? 'bx bx-hide' : 'bx bx-show-alt';
        $class = (!$active) ? 'danger' : 'success';

        if($route){
            $this->attributes['toggle'] = 'data-action=enabled';
        }

        return $this->toggle($name, $icon, $class);
    }

    
    public function toggle(string $name, string $icon, string $class)
    {

        $this->attributes['name'] = ($this->attributes['name']) ?? $name;

        $this->attributes['icon'] = ($this->attributes['icon']) ?? $icon;

        $this->attributes['class'] = ($this->attributes['class']) ?? $this->class.$class;

        return view('components.cms.buttons.data-table-button' )->with($this->attributes);
    }


    /**
     * Добавление свойства disabled к классу кнопки
     * @return $this
     */
    public function disabled(){
        $this->attributes['class'] .= " disabled ";

        return $this;
    }
}
