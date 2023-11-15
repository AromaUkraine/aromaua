<?php

namespace Modules\Developer\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\SeoCatalog;
use Modules\Developer\Entities\Template;

class CreateTemplateBySeoPageListener
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
        $json= [
            'components'=>[
                [
                    "name" => $event->page->name,
                    "description" => "",
                    "alias" => $event->page->slug,
                    "type" => "module",
                    'data'=>[
                        'routes'=>[
                            'cms' => config('route-manager.cms'),
                        ]
                    ]
                ]
            ],
            'page_type'=>SeoCatalog::class
        ];
        $data = [
            'name'=>'Шаблон '.$event->page->name,
            'type'=>'seo-page',
            'data' =>$json
        ];
        $event->pageable = Template::create($data);

    }
}
