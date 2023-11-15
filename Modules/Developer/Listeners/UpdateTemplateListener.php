<?php

namespace Modules\Developer\Listeners;


use App\Models\Component;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Developer\Service\TemplateService;

class UpdateTemplateListener
{
    public function handle( $event )
    {

        // подготовка данных для сохранения
        $data = app(TemplateService::class)->compareJsonData($event);

        if(isset($data['module']) && $data['module']){

            $module = Component::where('alias',$data['module'])->first();
            if($module) {
                array_push($data['data']['components'], $module->toArray());
                unset($data['module']);
            }
        }

        // сохраняем в шаблон данные о динамических роутингах для backend и frontend части,
        // а так же сохраняем информацию о используемых для этого шаблона модулей
        $event->pageable->update($data);
    }

}
