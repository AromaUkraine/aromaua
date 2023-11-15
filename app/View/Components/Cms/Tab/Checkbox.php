<?php

namespace App\View\Components\Cms\Tab;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $name;
    public $lang;
    public $label;
    public $group;
    /**
     * @var null
     */
    public $checked;
    public $class;
    /**
     * @var string|string[]
     */
    public $id;
    /**
     * @var null
     */
    public $glow;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param $lang
     * @param $label
     * @param $group
     * @param null $glow
     * @param null $checked
     */
    public function __construct($name, $lang, $label, $group, $glow = null, $checked = null)
    {
        //
        $this->name = $name;
        $this->lang = $lang;
        $this->label = $label;
        $this->group = $group;
        $this->checked = $checked;
        $this->glow = $glow;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $this->setAttributes();
        return view('components.cms.tab.checkbox');
    }

    protected function setAttributes()
    {
        $this->id = str_replace('.',"_", $this->name);
        if($this->group){
            $this->name = $this->group."[".$this->name."]";
            $this->id = $this->group."_".$this->id;
        }
        if(!$this->class){
            $this->class = "primary";
        }
    }
}
