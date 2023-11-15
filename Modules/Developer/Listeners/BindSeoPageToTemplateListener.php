<?php

namespace Modules\Developer\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BindSeoPageToTemplateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        // берем все хар-тики сео-страницы
        $event->page->pageable->entity_features->map(function ($ef) use (&$entity_features){
            $entity_features[$ef->feature_id]= [
                'feature_id' => $ef->feature_id,
                'feature_value_id'=> $ef->feature_value_id
            ];
        });

        $event->page->update([
            'pageable_id' => $event->pageable->id, // id созданого шаблона
            'pageable_type' => get_class($event->pageable), // путь к модели шаблона
            'controller' => $event->data['controller'], // путь к фронтенд контроллеру
            'data' =>[  // информация о бывшей сео-странице
                'entityable_type' =>  $event->page->pageable_type,
                'entityable_id' => $event->page->pageable_id,
                'product_category_id' => $event->page->pageable->product_category_id,
                'entity_features' => $entity_features,
                'alias' => $event->data['alias'] // уникальный ключ
            ]
        ]);
    }
}
