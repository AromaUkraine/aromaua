<?php

namespace Modules\Synchronize\Providers;


use Modules\Synchronize\Events\ApiSynchronizeEvent;




use Modules\Synchronize\Listeners\Api\AddCategoryTreeToMenu;
use Modules\Synchronize\Listeners\Api\LangSynchronizeListener;
use Modules\Synchronize\Listeners\Api\BuildCategoryTreeListener;
use Modules\Synchronize\Listeners\Api\StorageCacheClearListener;
use Modules\Synchronize\Listeners\Api\ProductSynchronizeListener;
use Modules\Synchronize\Listeners\Api\CategorySynchronizeListener;
use Modules\Synchronize\Listeners\Api\FeatureSynchronizeListener;
use Modules\Synchronize\Listeners\Api\ProductDocumentSynchronizeListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Synchronize\Listeners\Api\ProductProductCategoryPriceSynchronizeListener;


class EventServiceProvider extends ServiceProvider
{

    protected $listen = [

        // db version
        // SynchronizeImportEvent::class => [

        //     // получение дерева категории с удаленного сервера
        //     FetchRemoteCategoriesWithSubMenuListener::class,

        //     // получение номенклатур с типами цен и валюты
        //     FetchNomenclatureJoinPriceColumnListener::class,

        //     // получение документации для номенклатур
        //     FetchRemoteDocumentationListener::class,

        //     // синхронизация корневых категории
        //     SyncRemoteCategoriesListener::class,

        //     // синхронизация дочерних категории
        //     SyncRemoteChildCategoriesFromSubMenuListener::class,

        //     // синхронизация списка валют
        //     SyncCurrenciesListener::class,

        //     // синхронизация списка типов цен с валютами
        //     SyncPriceTypesListener::class,

        //     // синхронизация товаров, цен, таблицы синхронизации
        //     SyncProductListener::class,

        //     // синхронизация документов товара
        //     SyncProductDocumentationListener::class,
        // ],



        // api version
        ApiSynchronizeEvent::class => [

            // синхронизация языков сайта
            LangSynchronizeListener::class,

            // синхронизация характеристик и их значений
            FeatureSynchronizeListener::class,

            // синхронизация категории
            CategorySynchronizeListener::class,

            // создания дерева категории
            BuildCategoryTreeListener::class,

            // добавление дерева категории во фронтенд меню
            AddCategoryTreeToMenu::class,

            // синхронизация номенклатуры
            ProductSynchronizeListener::class,

            // синхронизация серии, цены товара относительно категории
            ProductProductCategoryPriceSynchronizeListener::class,

            // documents синхронизация документов номенклатуры
            ProductDocumentSynchronizeListener::class,

            // очистка кеширования
            StorageCacheClearListener::class
        ],

    ];
}
