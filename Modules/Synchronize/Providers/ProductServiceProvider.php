<?php

namespace Modules\Synchronize\Providers;


use Modules\Synchronize\Contracts\Product\Product;
use Modules\Synchronize\Service\Product\ProductService;
use Modules\Synchronize\Contracts\Product\ProductCollection;
use Modules\Synchronize\Contracts\Product\ProductDocumentation;
use Modules\Synchronize\Service\Product\ProductCollectionService;
use Modules\Synchronize\Service\Product\ProductDocumentationService;
use Modules\Synchronize\Contracts\Product\ProductProductCategoryPrice;
use Modules\Synchronize\Service\Product\ProductProductCategoryPriceService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->bind(ProductCollection::class, ProductCollectionService::class);
        $this->app->bind('productCollection', ProductCollectionService::class);

        $this->app->bind(Product::class, ProductService::class);
        $this->app->bind('product', ProductService::class);


        $this->app->bind(ProductProductCategoryPrice::class, ProductProductCategoryPriceService::class);
        $this->app->bind('productCategoryPrice', ProductProductCategoryPriceService::class);

        $this->app->bind(ProductDocumentation::class, ProductDocumentationService::class);
        $this->app->bind('productDocumentation', ProductDocumentationService::class);
    }
}