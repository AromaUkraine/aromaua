<?php

namespace App\Listeners;

use App\Events\CreateSectionEvent;
use App\Models\Page;
use App\Models\PageComponent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Developer\Listeners\UpdatePageComponentsListener;

class CreatePageListener
{

    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle( $event )
    {

        try{

            \DB::beginTransaction();

            $data = $event->data;

            $module = null;
            // ищем добавленый к шаблону модуль
            if($event->pageable->components){
                $components = collect($event->pageable->data['components']);
                $module = $components->where('type',PageComponent::TYPE_MODULE)->first();
            }

            // добавляем к странице роутинг модуля
            if($module && isset($module['data']['routes']['web'][0])) {
                $route = $module['data']['routes']['web'][0];
                foreach ($route as $key=>$value){
                    $data[$key] = $value;
                }
            }


            $event->page = $event->pageable->page()->create($data);

            // добавление модулей к странице
            (new UpdatePageComponentsListener())->handle($event);

            // добавление доступов
            (new CreatePermissionListener())->handle($event);

            // создание пункта в меню
            (new CreateMenuItemListener())->handle($event);

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }
    }
}
