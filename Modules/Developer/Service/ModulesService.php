<?php


namespace Modules\Developer\Service;


use App\Helpers\ArrayHelper;
use App\Models\Component;
use Illuminate\Support\Facades\Artisan;

class ModulesService
{
    private $modules;
    private $_components;
    /**
     * Получает все созданные модули в директории Modules
     * ModulesService constructor.
     */
    public function __construct()
    {

        $this->modules = collect(\Module::getCached());

        $this->_components = Component::all();
    }

    public function getModules()
    {
        return $this->_components->where('type', 'module');
    }

    public function getWidgets()
    {
        return $this->_components->where('type', 'widget');
    }


    /**
     * Возвращает все модули связанные со страницами
     * по аттрибуту type  в файле module.json
     * @param $type
     * @return \Illuminate\Support\Collection
     */

    public function getPageComponents()
    {
        $result = [];

        $data = $this->modules->where('component', "page");

        foreach ($data as $item) {
            if(isset($item['alias'])){
                foreach (config($item['alias'], []) as $component) {
                    $result[] = $component;
                }
            }
        }

        // Фильтр - если результат не пустой и существует тип компонента
        $this->modules = collect($result)->filter(function ($value) {

            return is_array($value) && isset($value['type']);
        });
        return $this->modules;

    }

    /**
     * Возвращает все не используемые модули в модели
     * @param $template
     * @return array|\Illuminate\Support\Collection
     */
    public function getAvailable($template = null)
    {
//        $components = Component::all();

        $available=[];
        foreach ($this->_components->except('id') as $component){
            $available[] = $component;
        }

        if(!isset($template->data['components']) || empty($template->data['components'])) {
            return $available;
        } else {
            $usedAlias = collect($template->data['components'])->pluck('alias');
            return  collect($available)->whereNotIn('alias', $usedAlias)->toArray();
        }
    }

    /**
     * Возвращает все используемые модули в модели
     * @param $template
     * @return array|null
     */
    public function getUsed($template)
    {

        if(isset($template->data['components']) && !empty($template->data['components'])) {
            return $template->data['components'];
        }

        return null;
    }

}
