<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CategoryFeatureCreateFeatureListener
{


    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        $used = collect(json_decode($event->used, true) ?? []);
        $entity = $event->entity ?? null;

        $used->pluck('feature_id')
        ->map(function ($item) use ($entity) {
            $entity->entity_features()->create(['feature_id'=>$item]);
        });
    }
}
