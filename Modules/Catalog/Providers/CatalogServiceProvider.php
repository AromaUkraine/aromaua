<?php

namespace Modules\Catalog\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

use Modules\Catalog\View\Cms\FeatureKind\Types;
use Modules\Catalog\View\Cms\FeatureValues\CustomInput;
use Modules\Catalog\View\Cms\Filter\FilterFeature;
use Modules\Catalog\View\Cms\Filter\FilterFeatureValues;

//use Modules\Catalog\View\Cms\PriceDefault;
use Modules\Catalog\View\Cms\Product\FeatureItems;
use Modules\Catalog\View\Cms\Product\FeatureModify;
use Modules\Catalog\View\Cms\Product\ModifyFeatureValueList;
use Modules\Catalog\View\Cms\Product\ParentProductList;

use Modules\Catalog\View\Cms\Product\PriceDefault;
use Modules\Catalog\View\Cms\Product\PriceTypeList;

use Modules\Catalog\View\Cms\Product\RelatedByCategoryParentDaDLeftRight;
use Modules\Catalog\View\Cms\ProductCategory\DaDLeftRight;

use Modules\Catalog\View\Cms\ProductCategory\ItemList;
use Modules\Catalog\View\Cms\SeoCatalog\Brand;

use Modules\Catalog\View\Cms\SeoCatalog\Repeater;



//use Modules\Catalog\View\Cms\ProductPricesComponent;
//use Modules\Catalog\View\Web\Product\Price;

class CatalogServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Catalog';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'catalog';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        // компоненты blade
        $this->registerBladeComponents();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path($this->moduleName, 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

    private function registerBladeComponents()
    {
        Blade::components([
            'catalog-cms-product-category-item-list' => ItemList::class,
            'catalog-cms-product-feature-items' => FeatureItems::class,
            'catalog-cms-product-price-default' => PriceDefault::class,
            'catalog-cms-product-feature-modify' => FeatureModify::class,
            'catalog-cms-product-modify-feature-values-list' => ModifyFeatureValueList::class,
            'catalog-cms-product-parent-product-list' => ParentProductList::class,
            'catalog-cms-product-related-by-category-parent-dad-left-right'=>RelatedByCategoryParentDaDLeftRight::class,
            'catalog-cms-page-component-item-list' => \Modules\Catalog\View\Cms\PageComponent\ItemList::class,
            'catalog-cms-currency-item-list' => \Modules\Catalog\View\Cms\Currency\ItemList::class,
            'catalog-cms-feature-kind-item-list' => \Modules\Catalog\View\Cms\FeatureKind\ItemList::class,
            'catalog-cms-feature-kind-types' => \Modules\Catalog\View\Cms\FeatureKind\Types::class,
            'catalog-cms-product-category-dad-left-right' => DaDLeftRight::class,
            'cms-catalog-feature-value-custom-input' => CustomInput::class,

            'catalog-cms-seo-catalog-repeater' => Repeater::class,
            'catalog-cms-seo-catalog-brand' => Brand::class,

            'filter-feature' => FilterFeature::class,
            'filter-feature-values' =>  FilterFeatureValues::class,

            'catalog-cms-product-price-type' => PriceTypeList::class,
        ]);
    }
}
