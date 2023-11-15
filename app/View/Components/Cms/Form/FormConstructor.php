<?php

namespace App\View\Components\Cms\Form;

use Illuminate\View\Component;

class FormConstructor extends Component
{
    /**
     * @var string|null
     */
    public $title;
    /**
     * @var bool|null
     */
    public $collapse;
    /**
     * @var bool|null
     */
    public $expand;
    /**
     * @var bool|null
     */
    public $reload;
    /**
     * @var string
     */
    public $options = [];

    /**
     * Form constructor.
     * @param array $options
     * @param string|null $title
     * @param bool|null $collapse
     * @param bool|null $expand
     * @param bool|null $reload
     * @param string|null $type
     */
    public function __construct(
        ?string $options = null,
        ?string $title = null,
        ?bool $collapse = null,
        ?bool $expand = null,
        ?bool $reload = null
    ) {

        $this->title = $title;
        $this->collapse = ($collapse) ??  false;
        $this->expand = ($expand) ??  false;
        $this->reload = ($reload) ??  false;


        $this->setOptions(json_decode($options, true));
    }

    public function setOptions($options)
    {

        if($options){
            $options['novalidate'] = 'novalidate';
            $this->options['class'] = 'form';

            if(isset($options['class'])) {
                $this->options['class'] .= ' ' . $options['class'];
                unset($options['class']);
            }

            $this->options = array_merge($this->options, $options);
        }
    }

    public function render(){
        throw new \Exception('This is just a class constructor');
    }
}
