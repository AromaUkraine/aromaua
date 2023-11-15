<?php

namespace Modules\Catalog\Listeners;

use App\Services\PublishAttribute;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\FeatureKind;

class UpdateFeatureValueListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $data = app(PublishAttribute::class)->make($event->request);

        if($event->entity->kind->key == FeatureKind::IS_COLOR && isset($data['color_scheme_id'])) :
            // добавляем название цвета в feature_value
            $event->request['color_scheme_id'] = $data['color_scheme_id'];
        endif;

        $event->entity->update($data);
    }
}
