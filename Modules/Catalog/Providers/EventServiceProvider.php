<?php


namespace Modules\Catalog\Providers;


use App\Listeners\CreateEntityColorSchemeListener;
use App\Listeners\ResetPagesCacheListener;
use App\Listeners\UpdateEntityColorSchemeListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Catalog\Entities\PriceType;
use Modules\Catalog\Events\BrandCreateEvent;
use Modules\Catalog\Events\BrandUpdateEvent;
use Modules\Catalog\Events\CatalogProductCreateEvent;
use Modules\Catalog\Events\CatalogProductUpdateEvent;
use Modules\Catalog\Events\CategoryFeatureCreateFeatureEvent;
use Modules\Catalog\Events\CategoryFeatureUpdateFeatureEvent;
use Modules\Catalog\Events\CategoryProductPageCreateEvent;
use Modules\Catalog\Events\CategoryProductPageUpdateEvent;
use Modules\Catalog\Events\ChangeEntityFeatureEvent;
use Modules\Catalog\Events\CreateFeatureValueEvent;
use Modules\Catalog\Events\FeatureModifyChangeParentProductEvent;
use Modules\Catalog\Events\FeatureModifyCopyProductFeatureEvent;
use Modules\Catalog\Events\FeatureModifyCreateEvent;
use Modules\Catalog\Events\FeatureModifyUpdateEvent;
use Modules\Catalog\Events\JoinProductToParentProductEvent;
use Modules\Catalog\Events\ProductFeatureCreateFeatureValueEvent;
use Modules\Catalog\Events\ProductFeatureCreateValueEvent;
use Modules\Catalog\Events\ProductFeatureUpdateFeatureValueEvent;
use Modules\Catalog\Events\ProductFeatureUpdateValueEvent;
use Modules\Catalog\Events\SeoCatalogCreateEvent;
use Modules\Catalog\Events\SeoCatalogFeatureEvent;
use Modules\Catalog\Events\UpdateFeatureValueEvent;
use Modules\Catalog\Listeners\CatalogProductCreateListener;
use Modules\Catalog\Listeners\CatalogProductPriceDefaultListener;

use Modules\Catalog\Listeners\CatalogProductUpdateListener;
use Modules\Catalog\Listeners\CategoryFeatureCreateFeatureListener;
use Modules\Catalog\Listeners\CategoryFeatureUpdateFeatureListener;
use Modules\Catalog\Listeners\CategoryProductPageCreateListener;
use Modules\Catalog\Listeners\ChangeEntityFeatureListener;
use Modules\Catalog\Listeners\ChangeModifyProductListener;
use Modules\Catalog\Listeners\CreateFeatureValueListener;
use Modules\Catalog\Listeners\FeatureModifyChangeParentProductListener;
use Modules\Catalog\Listeners\FeatureModifyCopyProductFeatureListener;

use Modules\Catalog\Listeners\FeatureModifyUniteChildrenListener;
use Modules\Catalog\Listeners\FeatureModifyUpdateListener;
use Modules\Catalog\Listeners\JoinProductToParentProductListener;
use Modules\Catalog\Listeners\PriceTypeCreateListener;
use Modules\Catalog\Listeners\PriceTypeListener;
use Modules\Catalog\Listeners\PriceTypeUpdateListener;
use Modules\Catalog\Listeners\ProductFeatureCreateFeatureValueListener;
use Modules\Catalog\Listeners\ProductFeatureCreateValueListener;
use Modules\Catalog\Listeners\ProductFeatureUpdateFeatureValueListener;
use Modules\Catalog\Listeners\ProductFeatureUpdateValueListener;
use Modules\Catalog\Listeners\ProductPageCreateListener;
use Modules\Catalog\Listeners\ProductPriceCreateListener;
use Modules\Catalog\Listeners\ProductPriceListener;
use Modules\Catalog\Listeners\ProductPriceUpdateListener;
use Modules\Catalog\Listeners\ProductSetModifyListener;
use Modules\Catalog\Listeners\SeoCatalogAsBrandListener;
use Modules\Catalog\Listeners\SeoCatalogCreateListener;
use Modules\Catalog\Listeners\SeoCatalogFeatureListener;
use Modules\Catalog\Listeners\SeoCatalogModifyListener;
use Modules\Catalog\Listeners\SetParentForChildesListener;
use Modules\Catalog\Listeners\UpdateFeatureValueListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [

        CategoryProductPageCreateEvent::class => [
            CategoryProductPageCreateListener::class,
            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],
        CategoryProductPageUpdateEvent::class => [
            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],

        CatalogProductCreateEvent::class =>[

            ProductPageCreateListener::class,

            ProductPriceCreateListener::class,


            CatalogProductPriceDefaultListener::class,

            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],
        CatalogProductUpdateEvent::class =>[
            CatalogProductUpdateListener::class,
            CatalogProductPriceDefaultListener::class,

            ProductPriceUpdateListener::class,

            PriceTypeUpdateListener::class,


            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],

        CategoryFeatureCreateFeatureEvent::class=>[
            CategoryFeatureCreateFeatureListener::class
        ],
        CategoryFeatureUpdateFeatureEvent::class=>[
            CategoryFeatureUpdateFeatureListener::class,
        ],
        ProductFeatureCreateValueEvent::class =>[
            ProductFeatureCreateValueListener::class
        ],
        ProductFeatureCreateFeatureValueEvent::class =>[
            ProductFeatureCreateFeatureValueListener::class,
            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],
        ProductFeatureUpdateValueEvent::class => [

            ProductFeatureUpdateValueListener::class,
            // сброс кеша страницы
            ResetPagesCacheListener::class,
        ],

        ProductFeatureUpdateFeatureValueEvent::class => [
            // обновляет, удаляет, добавляет характеристики
            ProductFeatureUpdateFeatureValueListener::class,
        ],
        // добавление модификации для товара и его наследников
        FeatureModifyCreateEvent::class => [
            // смена значения модификации у товара
            ChangeModifyProductListener::class,
            // объединяет наследников
            FeatureModifyUniteChildrenListener::class,
            // устанавливаем основной товар и связывает с ним наследников
            SetParentForChildesListener::class
        ],

        // изменение модификации для товара
        FeatureModifyUpdateEvent::class => [
            // смена значения модификации у товара
            ChangeModifyProductListener::class,
            // подготовка для изменения
            FeatureModifyUpdateListener::class,
            // объединяет наследников
            FeatureModifyUniteChildrenListener::class,
            // устанавливаем основной товар и связывает с ним наследников
            SetParentForChildesListener::class
        ],

        // Изменение основного товара модификации
        FeatureModifyChangeParentProductEvent::class =>[
            // находим новый основной товар и все связанные со старым
            FeatureModifyChangeParentProductListener::class,
            // устанавливаем основной товар и связываем остальные с ним
            SetParentForChildesListener::class
        ],

        // копирование хар-тик родительского товара в дочерние
        FeatureModifyCopyProductFeatureEvent::class => [
            FeatureModifyCopyProductFeatureListener::class
        ],

        // присоединение к основному товару модификации
        JoinProductToParentProductEvent::class => [
            // смена значения модификации у товара
            ChangeModifyProductListener::class,
            // присоедениние товара к группе
            JoinProductToParentProductListener::class,
        ],


        SeoCatalogCreateEvent::class =>[
            // создание страниц сео-каталога
            SeoCatalogCreateListener::class,
        ],
        // добавление, изменение хар-тик у сео-каталога
        SeoCatalogFeatureEvent::class => [
            // обновляет дополнительные поля сео-каталога
            SeoCatalogModifyListener::class,
            // подготовка данных для сохранения
            SeoCatalogFeatureListener::class,
            // обновляет, удаляет, добавляет характеристики
            ProductFeatureUpdateFeatureValueListener::class
        ],

        //Удаление хар-тик, добавление хар-тик у сущности (использую для привязки-отвязки товара от сео-страницы)
        ChangeEntityFeatureEvent::class => [
            ChangeEntityFeatureListener::class,
        ],


        CreateFeatureValueEvent::class => [
            // create feature_value
            CreateFeatureValueListener::class,
            // привязка цветовой схемы к сущности
            CreateEntityColorSchemeListener::class
        ],
        // обновление цветовой схемы сущности
        UpdateFeatureValueEvent::class => [
            // update feature_value
            UpdateFeatureValueListener::class,
            // обновление цветовой схемы  сущности
            UpdateEntityColorSchemeListener::class
        ]
    ];
}
