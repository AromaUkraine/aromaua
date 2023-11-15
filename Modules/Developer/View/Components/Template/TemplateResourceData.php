<?php

namespace Modules\Developer\View\Components\Template;

use App\View\Components\Cms\BaseCmsComponent;

use Modules\Developer\Entities\Template;

class TemplateResourceData extends BaseCmsComponent
{
    public $jsonData = [];
    public $countItem = 0;
    public $col = 1;

    public $default;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        $this->default = (new Template())->default_json_data;

        $this->setData();

        return view('developer::components.template.template-resource-data');
    }

    private function setData()
    {
        $route = $this->value;

        if ($this->model && $this->model->$route) {
            $data = $this->model->$route;
        } else {
            $data = $this->default['routes'][$this->value];
        }

        foreach ($data as $k => $val) {

            $this->jsonData[$k]['method'] = $k;
            foreach ($val as $i => $j) {
                $this->jsonData[$k][$i] = $j;
            }
            $this->countItem = count($this->jsonData[$k]);
        }

        ++$this->countItem;

        if (12 % $this->countItem == 0) {
            $this->col = 12 / $this->countItem;
        } else {

            if (12 / 2 > $this->countItem) {
                $this->col = 2;
            }
        }
    }

    public function getId($lang=false)
    {
        return $this->value;
    }
}
