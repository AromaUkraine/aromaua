<?php

namespace App\Providers;



use App\Events\CreateEntityColorSchemeEvent;
use App\Events\DestroyEntityEvent;
use App\Events\DestroyPageEvent;
use App\Events\PushTreeToMenuTreeEvent;
use App\Events\SettingUpdateEvent;

use App\Events\ToggleActivePageEvent;

use App\Events\UpdateEntityColorSchemeEvent;
use App\Listeners\ChangeRolePermissionsListener;
use App\Listeners\ChangeUserPermissionsListener;
use App\Listeners\ChangeUserRoleListener;
use App\Listeners\CreateEntityColorSchemeListener;
use App\Listeners\CreateFrontendMenuItemListener;
use App\Listeners\CreateLanguageListener;
use App\Listeners\CreatePageListener;
use App\Listeners\DeleteRoleListener;
use App\Listeners\DestroyEntityListener;
use App\Listeners\DestroyPageListener;
use App\Listeners\PushTreeToMenuTreeListener;
use App\Listeners\ResetCacheFrontendMenuListener;

use App\Listeners\ResetPagesCacheListener;
use App\Listeners\SettingUpdateListener;

use App\Listeners\ToggleActivePageListener;
use App\Listeners\ToggleFrontendMenuItems;
use App\Listeners\UpdateEntityColorSchemeListener;
use App\Listeners\UpdateFrontendMenuItemListener;
use App\Listeners\UpdatePageListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Developer\Events\CreateTemplateEvent;
use Modules\Developer\Events\UpdateTemplateEvent;
use Modules\Developer\Listeners\CreateTemplateListener;
use Modules\Developer\Listeners\UpdateTemplateListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /*** Cms Events ***/
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\ChangeUserRoleEvent'=>[
            ChangeUserRoleListener::class
        ],
        'App\Events\ChangeUserPermissionsEvent'=>[
            ChangeUserPermissionsListener::class,
        ],
        'App\Events\ChangeRolePermissionsEvent'=>[
            ChangeRolePermissionsListener::class
        ],
        'App\Events\DeleteRoleEvent'=>[
            DeleteRoleListener::class
        ],
        'App\Events\CreateLanguageEvent'=>[
            CreateLanguageListener::class,
            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],
        'App\Events\UpdateLanguageEvent'=>[
            ResetPagesCacheListener::class,
        ],
        CreateTemplateEvent::class=>[
            CreateTemplateListener::class
        ],
        UpdateTemplateEvent::class=>[
            UpdateTemplateListener::class
        ],
        'App\Events\CreatePageEvent'=>[
            CreatePageListener::class,
            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],
        'App\Events\UpdatePageEvent'=>[
            UpdatePageListener::class,
            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],
        ToggleActivePageEvent::class=>[
            // включение/отключение active page
            ToggleActivePageListener::class,
            // включение/отключение active для фронтенд меню
            ToggleFrontendMenuItems::class,
            // сброс кеша страницы
            ResetPagesCacheListener::class,
            // сброс кеша меню
            ResetCacheFrontendMenuListener::class
        ],
        DestroyPageEvent::class =>[
            DestroyPageListener::class,
            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],
        'App\Events\ResetCachePagesRouteEvent'=>[
            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],
        'App\Events\CreateFrontendMenuItemEvent'=>[
            CreateFrontendMenuItemListener::class,
            // сброс кеша меню
            ResetCacheFrontendMenuListener::class
        ],
        'App\Events\UpdateFrontendMenuItemEvent'=>[
            UpdateFrontendMenuItemListener::class,
            // сброс кеша меню
            ResetCacheFrontendMenuListener::class
        ],
        // добавление в меню целого дерева
        PushTreeToMenuTreeEvent::class => [
            PushTreeToMenuTreeListener::class
        ],
        DestroyEntityEvent::class =>[
            DestroyEntityListener::class
        ],
        SettingUpdateEvent::class => [
            SettingUpdateListener::class
        ],
        // привязка цветовой схемы к сущности
        CreateEntityColorSchemeEvent::class => [
            CreateEntityColorSchemeListener::class
        ],
        // обновление цветовой схемы сущности
        UpdateEntityColorSchemeEvent::class => [
            UpdateEntityColorSchemeListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }
}
