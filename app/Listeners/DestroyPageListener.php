<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DestroyPageListener
{


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //

        try{

            \DB::beginTransaction();

            (new DestroyPagePermissionListener())->handle($event);
            (new DestroyMenuItemListener())->handle($event);


            if(config('app.softDelete')) :
                 $event->page->delete();
            else :
                $event->page->forceDelete();
            endif;

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }
    }
}
