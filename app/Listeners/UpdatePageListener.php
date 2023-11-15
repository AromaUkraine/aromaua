<?php

namespace App\Listeners;


use App\Models\PageComponent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Developer\Listeners\UpdatePageComponentsListener;

class UpdatePageListener
{

    public function handle( $event )
    {

        try{

            \DB::beginTransaction();

            // обновление страницы
            $event->origin_pageable_id = $event->page->pageable_id;
            $event->data['pageable_type'] = get_class($event->pageable);
            $event->data['pageable_id'] = $event->pageable->id;

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
                    $event->data[$key] = $value;
                }
            }

            $event->page->update($event->data);

            // добавление модулей к странице
            (new UpdatePageComponentsListener())->handle($event);

            // обновление доступов
            (new UpdatePermissionListener())->handle($event);

            // обновление пункта в меню
            (new UpdateMenuItemListener())->handle($event);

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }
    }
}
