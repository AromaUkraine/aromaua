<?php


namespace Modules\Developer\Service;


use App\Models\PageComponent;


class TemplateService
{


    // добавляет в json data список включенных модулей, уничтожает лишнее
    public function compareJsonData($event)
    {

        if (isset($event->data['used']) && !empty($event->data['used'])) {

            $model = new PageComponent();
            $fields = $model->getFillable();

            $used = json_decode($event->data['used'], true);

            // выбераем данные для сохраниния в page_components
            $components = [];
            foreach ($used as $key=>$value) {

                foreach ($value as $k=>$v){
                    if(in_array($k, $fields)){
                        $components[$key][$k] = $v;
                    }
                }
            }

            //помещает в json data под ключем components данные
            $event->data['data']['components'] = $components;

            unset($event->data['used']);
        }

        return $event->data;
    }
}
