<?php


namespace App\View\Components\Cms\Fields;


use App\View\Components\Cms\BaseCmsComponent;
use Modules\ColorScheme\Entities\ColorScheme;
use Nwidart\Modules\Facades\Module;


class ColorPicker extends BaseCmsComponent
{

    public function render()
    {
        if(Module::find('ColorScheme')) :
            return view('components.cms.fields.color-picker.select');
        else:
            return view('components.cms.fields.color-picker.picker');
        endif;

    }


    public function getColors()
    {
        return ColorScheme::all();
    }

    public function setSelected($color_scheme_id)
    {
        if($this->model && $this->model->colorable):
            return ($color_scheme_id == $this->model->colorable->color_scheme_id) ? 'selected' : '';
        endif;

        return '';
    }

    public function getCode()
    {
        if(!$this->model):
            return '#FFFFFF';
        else:
            return $this->model->colorable->color_scheme_id;
        endif;
    }
}
