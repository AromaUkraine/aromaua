<?php


namespace Modules\Developer\Providers;



use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Developer\Events\CreateTemplateBySeoPageEvent;
use Modules\Developer\Events\UpdateTemplateEvent;
use Modules\Developer\Listeners\AddComponentListener;
use Modules\Developer\Listeners\AddPageComponentListener;
use Modules\Developer\Listeners\BindSeoPageToTemplateListener;
use Modules\Developer\Listeners\CreateMenuItemBySeoPageListener;
use Modules\Developer\Listeners\CreatePermissionBySeoPageListener;
use Modules\Developer\Listeners\CreateTemplateBySeoPageListener;
use Modules\Developer\Listeners\DeleteSeoPageListener;
use Modules\Developer\Listeners\UpdatePageComponentsListener;
use Modules\Developer\Listeners\UpdateRelationEntityFeatureListener;
use Modules\Developer\Listeners\UpdateTemplateListener;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
    UpdateTemplateEvent::class => [
        UpdateTemplateListener::class,
        UpdatePageComponentsListener::class,
    ],

    CreateTemplateBySeoPageEvent::class =>[

        // создает шаблон для сео-страницы
        CreateTemplateBySeoPageListener::class,

        // привязывает шаблон к странице, меняя связь ( страница в сео-калаоге становится самостоятельной со своим шаблоном,
        // компонентами и т.д)
        BindSeoPageToTemplateListener::class,

        // Добавление компонента в таблицу компонентов, добавление компонента cтраницы в таблицу компонентов страниц
        AddComponentListener::class,

        // Меняем полиморфную связь удаленной сео-страницы на новую с pages
        UpdateRelationEntityFeatureListener::class,

        // Удаляем не нужную сео-страницу (у нее нет больше связи со страницей)
        DeleteSeoPageListener::class,

        // Создаем доступы в админке
        CreatePermissionBySeoPageListener::class,

        // обновляем меню админки
        CreateMenuItemBySeoPageListener::class
    ]

];
}
