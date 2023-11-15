<?php

namespace Modules\Gallery\Listeners;


use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Entities\GalleryTranslation;

class RemoveRecordWithEmptyImageListener
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

        $translations = $this->getRecordsWithEmptyImage();

        foreach ($translations as $record){
            $record->delete();
        }

        $records = Gallery::doesnthave('translations')->get();

        foreach ($records as $record){
            $record->forceDelete();
        }
    }

    private function getRecordsWithEmptyImage()
    {
        return GalleryTranslation::whereNull('image')->get();
    }
}
