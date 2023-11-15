<?php

namespace Modules\Developer\Listeners;

use App\Models\Page;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdatePageComponentsListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        $components = collect($event->pageable->getJsonData('components'));

        Page::where('pageable_id', $event->pageable->id)
            ->where('pageable_type', get_class($event->pageable))
            ->get()
            ->each(function ($page) use ($components){

                $aliases_temp = $components->pluck('alias');
                $aliases_exist = $page->components()->get()->pluck('alias');

                // create new component
                if(!$aliases_exist->count()):
                    if($aliases_temp->count()):
                        $this->addComponents($page, $components, $aliases_temp);
                    endif;
                else:
                    // add new component
                    if($aliases_diff = $aliases_temp->diff($aliases_exist)){
                        $this->addComponents($page, $components, $aliases_diff);
                    }
                    // remove old component
                    if($aliases_diff = $aliases_exist->diff($aliases_temp)){
                        $this->removeComponents($page, $aliases_diff);
                    }
                endif;
        });
    }

    private function addComponents($page, \Illuminate\Support\Collection $components, \Illuminate\Support\Collection $aliases_diff)
    {
        $aliases_diff->each(function ($alias) use ($page, $components){
            $component = $components->where('alias', $alias)->first();
            $page->components()->create($component);
        });

    }

    private function removeComponents($page,  $aliases_diff)
    {
        $aliases_diff->each(function ($alias) use ($page){
             $page->components()->where('alias', $alias)->delete();
        });
    }
}
