<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeModifyProductListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        if(isset($event->product) && isset($event->data['modify_value'])) :
            // если было значение модификации и оно изменилось
            if($event->product->modify_value !== $event->data['modify_value']):

                $old_modify = $event->product->entity_features
                    ->where('feature_id',$event->product->category->modify_feature)
                    ->where('feature_value_id', $event->product->modify_value)
                    ->where('modify_value', true)
                    ->first();

                if($old_modify):
                    $old_modify->update(['modify_value'=>!$old_modify->modify_value]);
                endif;

                $new_modify = $event->product->entity_features
                    ->where('feature_id',$event->product->category->modify_feature)
                    ->where('feature_value_id', $event->data['modify_value'])
                    ->first();

                $new_modify->update(['modify_value'=>!$new_modify->modify_value]);

            endif;

        endif;
    }
}
