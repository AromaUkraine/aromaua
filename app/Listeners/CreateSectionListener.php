<?php

namespace App\Listeners;

use App\Events\CreateSectionEvent;
use App\Models\Section;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateSectionListener
{

    /**
     * Handle the event.
     *
     * @param  CreateSectionEvent  $event
     * @return void
     */
    public function handle($event)
    {

        try{

            \DB::beginTransaction();

            $event->pageable = Section::create([
                'template_id'=>$event->data['template_id']
            ]);
            unset($event->data['template_id']);

            (new CreatePageListener())->handle($event);
            (new CreatePermissionListener())->handle($event);
            (new CreateMenuItemListener())->handle($event);

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }


    }
}
