<?php

namespace App\View\Components\Cms\Buttons;

use Illuminate\View\Component;

class Button extends Component
{
    /**
     * @var string
     */
    public $type;
    /**
     * @var string|null
     */
    public $class;
    /**
     * @var string|null
     */
    public $title;
    /**
     * @var string|null
     */
    public $icon;
    /**
     * @var string|null
     */
    public $href;
    /**
     * @var array|null
     */
    public $options = "";

    public $htmlOptions = '';

    public function __construct(
        string $type="button",
        ?string $class="",
        ?string $title="",
        ?string $icon="",
        ?string $href="#",
        ?string $options = ""
    ) {

        $this->type = $type;
        $this->class = $class;
        $this->title = $title;
        $this->icon = $icon;
        $this->href = $href;
        $this->options = ($options) ? json_decode($options, true) : [];
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if( is_array($this->options) && count($this->options) ){

            foreach ($this->options as $key=>$value){
                $this->htmlOptions .= "{$key}={$value}";
            }
        }

        return view('components.cms.buttons.button');
    }
}
