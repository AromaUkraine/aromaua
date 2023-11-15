<?php

namespace Modules\Developer\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\EntityFeature;

class UpdateRelationEntityFeatureListener
{


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $data = $event->page->data;
        // меняет связь с сое-страницей на связь с новой страницей
        EntityFeature::where('entityable_type',$data['entityable_type'])
            ->where(['entityable_id'=>$data['entityable_id']])
            ->get()
            ->each(function ($ef) use ($event){
                $ef->update([
                    'entityable_type' => get_class($event->page),
                    'entityable_id' => $event->page->id
                ]);
            });
    }
}
