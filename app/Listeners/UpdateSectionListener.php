<?php

namespace App\Listeners;

use App\Events\UpdateSectionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateSectionListener
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

            $event->pageable->update([
                'template_id'=>$event->data['template_id']
            ]);
            unset($event->data['template_id']);

            (new UpdatePageListener())->handle($event);
            (new UpdatePermissionListener())->handle($event);
            (new UpdateMenuItemListener())->handle($event);

            \DB::commit();
        }catch (\Exception $e) {

            \DB::rollback();
            dd('Update failed with class "'.get_class($this).'" error : '.$e->getMessage());
        }
    }
}
