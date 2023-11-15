<?php


namespace Modules\Catalog\View\Cms\FeatureValues;


use Illuminate\View\Component;
use Modules\Catalog\Entities\FeatureKind;
use Nwidart\Modules\Facades\Module;

class CustomInput extends Component
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $key;
    /**
     * @var bool
     */
    public $lang;
    /**
     * @var string|null
     */
    public $label;
    /**
     * @var string|null
     */
    public $options;
    /**
     * @var object|null
     */
    public $model;

    public function __construct(string $name,
                                string $key,
                                bool   $lang=false,
                                ?string $label=null,
                                ?string $options=null,
                                ?object $model = null
    )
    {
        $this->name = $name;
        $this->key = $key;
        $this->lang = $lang;
        $this->label = $label;
        $this->options = $options;
        $this->model = $model;
    }

    public function render()
    {
        if($this->key == FeatureKind::IS_COLOR && Module::find('ColorScheme')){
            $this->options = json_decode($this->options, true);
            unset($this->options['maxlength']);
            $this->options = json_encode($this->options);
            return view('catalog::cms.components.feature_value.color-picker');
        }

        return view('catalog::cms.components.feature_value.input');
    }
}
