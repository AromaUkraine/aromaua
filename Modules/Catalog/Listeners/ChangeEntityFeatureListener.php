<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeEntityFeatureListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if($event->status == 'remove'):
            $event->entity->entity_features->map(function ($ef) use ($event){
                foreach ($event->feature as $feature_id=>$values){
                    $this->remove($ef, $feature_id, $values);
                }
            });
        endif;

        if($event->status == 'add'):
            foreach ($event->feature as $feature_id => $values):
                foreach ($values as $feature_value_id) :
                    $record = $event->entity->entity_features->where('feature_id', $feature_id)->where('feature_value_id', $feature_value_id)->first();
                    if (!$record) :
                        $event->entity->entity_features()->create(['feature_id' => $feature_id, 'feature_value_id' => $feature_value_id]);
                    endif;
                endforeach;
            endforeach;
        endif;

    }

    private function remove($ef, int $feature_id, $values)
    {
        if($ef->feature_id == $feature_id):
            foreach ($values as $feature_value_id){
                if($ef->feature_value_id == $feature_value_id):
                    $ef->delete();
                endif;
            }
        endif;
    }

}
