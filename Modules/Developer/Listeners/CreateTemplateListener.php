<?php

namespace Modules\Developer\Listeners;


use App\Models\Component;
use Modules\Developer\Entities\Template;
use Modules\Developer\Service\TemplateService;


class CreateTemplateListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        try{

            \DB::beginTransaction();

            $data = app(TemplateService::class)->compareJsonData($event);

            if($data['module']){

                $module = Component::where('alias',$data['module'])->firstOrFail()->toArray();
                array_push($data['data']['components'], $module);
                unset($data['module']);
            }

            // создаем шаблон с данными о динамических роутингах для backend и frontend части,
            // а так же  информации о используемых для этого шаблона модулей
            $template = Template::create($data);

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }
    }
}
