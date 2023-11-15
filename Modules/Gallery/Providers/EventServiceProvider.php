<?php


namespace Modules\Gallery\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Gallery\Events\CreatePageGalleryEvent;
use Modules\Gallery\Events\CreatePhotoGalleryEvent;
use Modules\Gallery\Events\CreateVideoGalleryEvent;
use Modules\Gallery\Events\UpdatePageGalleryEvent;
use Modules\Gallery\Events\UpdatePhotoGalleryEvent;
use Modules\Gallery\Events\UpdateVideoGalleryEvent;
use Modules\Gallery\Listeners\CreatePageGalleryListener;
use Modules\Gallery\Listeners\CreatePhotoGalleryListener;
use Modules\Gallery\Listeners\CreateVideoGalleryListener;
use Modules\Gallery\Listeners\UpdatePageGalleryListener;
use Modules\Gallery\Listeners\UpdatePhotoGalleryListener;
use Modules\Gallery\Listeners\UpdateVideoGalleryListener;
use Modules\Gallery\Listeners\RemoveRecordWithEmptyImageListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CreateVideoGalleryEvent::class=>[
            CreateVideoGalleryListener::class
        ],
        UpdateVideoGalleryEvent::class=>[
            UpdateVideoGalleryListener::class
        ],
        CreatePhotoGalleryEvent::class=>[
            CreatePhotoGalleryListener::class
        ],
        UpdatePhotoGalleryEvent::class=>[
            UpdatePhotoGalleryListener::class,

            RemoveRecordWithEmptyImageListener::class
        ],
        CreatePageGalleryEvent::class => [
            CreatePageGalleryListener::class
        ],
        UpdatePageGalleryEvent::class => [
            UpdatePageGalleryListener::class,


            RemoveRecordWithEmptyImageListener::class
        ]
    ];
}
