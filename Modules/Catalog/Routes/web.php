<?php

Route::group(['middleware' => ['auth', 'prepare.request']], function () {

    Route::group([
        'namespace' => 'Cms', // контроллеры лежат в директорииControllers/Cms
        'middleware' => ['role:developer|admin|manager', 'cmsLocale'],
        'prefix' => 'cms',    // добавляется в url-адрес
        'as' => 'catalog.'     // ключ для именования роутов (module.article.index) и т.д.
    ], function () {


        /**
         *  Категории товаров
         */
        Route::get('catalog/product-category', 'ProductCategoryController@index')->name('product_category.index');
        Route::get('catalog/product-category/create', 'ProductCategoryController@create')->name('product_category.create');
        Route::post('catalog/product-category', 'ProductCategoryController@store')->name('product_category.store');
        Route::get('catalog/product-category/{category}/edit', 'ProductCategoryController@edit')->name('product_category.edit');
        Route::patch('catalog/product-category/{category}', 'ProductCategoryController@update')->name('product_category.update');
        Route::get('catalog/product-category/{category}/restore', 'ProductCategoryController@restore')->name('product_category.restore');
        Route::post('catalog/product-category/{category}/active', 'ProductCategoryController@active')->name('product_category.active');
        Route::delete('catalog/product-category/{category}', 'ProductCategoryController@destroy')->name('product_category.destroy');
        Route::get('catalog/product-category/tree', 'ProductCategoryController@tree')->name('product_category.tree');


        /**
         *  Товары
         */
        Route::get('/catalog/product', 'ProductController@index')->name('product.index');
        Route::get('/catalog/product/create', 'ProductController@create')->name('product.create');
        Route::post('/catalog/product', 'ProductController@store')->name('product.store');
        Route::get('/catalog/product/{product}/edit', 'ProductController@edit')->name('product.edit');
        Route::patch('/catalog/product/{product}', 'ProductController@update')->name('product.update');
        Route::get('/catalog/product/{product}/restore', 'ProductController@restore')->name('product.restore');
        Route::post('/catalog/product/{product}/active', 'ProductController@active')->name('product.active');
        Route::delete('/catalog/product/{product}', 'ProductController@destroy')->name('product.destroy');

        /**
         *  Сео-каталог
         *
         */
        Route::get('/catalog/seo-catalog', 'SeoCatalogController@index')->name('seo_catalog.index');
        Route::get('/catalog/seo-catalog/create', 'SeoCatalogController@create')->name('seo_catalog.create');
        Route::post('/catalog/seo-catalog', 'SeoCatalogController@store')->name('seo_catalog.store');
        Route::get('/catalog/seo-catalog/{seo}/edit', 'SeoCatalogController@edit')->name('seo_catalog.edit');
        Route::patch('/catalog/seo-catalog/{seo}', 'SeoCatalogController@update')->name('seo_catalog.update');
        Route::post('/catalog/seo-catalog/{seo}/active', 'SeoCatalogController@active')->name('seo_catalog.active');
        Route::delete('/catalog/seo-catalog/{seo}', 'SeoCatalogController@destroy')->name('seo_catalog.destroy');
        Route::get('/catalog/seo-catalog/{seo}/restore', 'SeoCatalogController@restore')->name('seo_catalog.restore');


        /**
         *  Типы характеристик
         */
        Route::get('feature-kind', 'FeatureKindController@index')->name('feature_kind.index');
        Route::get('feature-kind/create', 'FeatureKindController@create')->name('feature_kind.create');
        Route::post('feature-kind', 'FeatureKindController@store')->name('feature_kind.store');
        Route::get('feature-kind/{kind}/edit', 'FeatureKindController@edit')->name('feature_kind.edit');
        Route::patch('feature-kind/{kind}', 'FeatureKindController@update')->name('feature_kind.update');
        Route::post('feature-kind/{kind}/active', 'FeatureKindController@active')->name('feature_kind.active');
        Route::delete('feature-kind/{kind}', 'FeatureKindController@destroy')->name('feature_kind.destroy');
        Route::get('feature-kind/{kind}/restore', 'FeatureKindController@restore')->name('feature_kind.restore');


        /**
         *  Список характеристик
         */
        Route::get('feature/', 'FeatureController@index')->name('feature.index');
        Route::get('feature/create', 'FeatureController@create')->name('feature.create');
        Route::post('feature', 'FeatureController@store')->name('feature.store');
        Route::get('feature/{feature}', 'FeatureController@edit')->name('feature.edit');
        Route::patch('feature/{feature}', 'FeatureController@update')->name('feature.update');
        Route::post('feature/{feature}/active', 'FeatureController@active')->name('feature.active');
        Route::delete('feature/{feature}', 'FeatureController@destroy')->name('feature.destroy');
        Route::get('feature/{feature}/restore', 'FeatureController@restore')->name('feature.restore');
    });

    //    Route::group([
    //        'namespace'=>'Cms', // контроллеры лежат в директорииControllers/Cms
    //        'middleware' =>['role:developer|admin|manager','cmsLocale'],
    //        'prefix'=>'cms',    // добавляется в url-адрес
    //        'as'=>'module.'     // ключ для именования роутов (module.article.index) и т.д.
    //    ], function () {
    //        Route::get('/page/{page}/catalog', 'CatalogController@index')->name('catalog.index');
    //    });
});

Route::group([
    'namespace' => 'Cms',
    'middleware' => ['role:developer|admin|manager', 'cmsLocale', 'prepare.request'],
    'prefix' => 'cms',
    'as' => 'module.' // этот алиас нужет чтобы модуль не попадал в основное меню cms
], function () {


    /**
     *  Значение характеристик
     */
    Route::get('feature-value/kind/{kind}/value', 'FeatureValueController@index')->name('feature_value.index');
    Route::get('feature-value/kind/{kind}/value/create', 'FeatureValueController@create')->name('feature_value.create');
    Route::post('feature-value/kind/{kind}/value', 'FeatureValueController@store')->name('feature_value.store');
    Route::get('feature-value/kind/{kind}/value/{value}/edit', 'FeatureValueController@edit')->name('feature_value.edit');
    Route::patch('feature-value/kind/{kind}/value/{value}', 'FeatureValueController@update')->name('feature_value.update');
    Route::post('feature-value/{value}/active', 'FeatureValueController@active')->name('feature_value.active');
    Route::delete('feature-value/{value}', 'FeatureValueController@destroy')->name('feature_value.destroy');
    Route::get('feature-value/kind/{kind}/value/{value}/restore', 'FeatureValueController@restore')->name('feature_value.restore');


    /**
     *  Характеристики для категории товара
     */
    Route::get('{table}/{id}/category/feature', 'CategoryFeatureController@index')->name('category_feature.index');
    Route::post('{table}/{id}/category/feature', 'CategoryFeatureController@store')->name('category_feature.store');

    Route::get('{table}/{id}/categoryprice', 'ProductCategoryPriceController@index')->name('product_category_price.index');


    /**
     *  Характеристики для товара
     */
    Route::get('{table}/{id}/product/feature', 'ProductFeatureController@index')->name('product_feature.index');
    Route::post('{table}/{id}/product/feature', 'ProductFeatureController@store')->name('product_feature.store');


    /***
     * Характеристики для сео-страниц
     */
    Route::get('{table}/{id}/seo-catalog/feature', 'SeoCatalogFeatureController@index')->name('seo_catalog_feature.index');
    Route::post('{table}/{id}/seo-catalog/feature', 'SeoCatalogFeatureController@store')->name('seo_catalog_feature.store');


    /***
     *  Товары на сео-странице
     */
    Route::get('{table}/{id}/seo-catalog/product', 'SeoCatalogProductController@index')->name('seo_catalog_product.index');
    Route::post('{table}/{id}/seo-catalog/change/{product}/{status}', 'SeoCatalogProductController@change')->name('seo_catalog_product.change');




    /**
     *  Модификация характеристик товара
     */
    Route::get('{table}/{id}/feature-modify', 'FeatureModifyController@index')->name('feature_modify.index');
    Route::get('{table}/{id}/feature-modify/create', 'FeatureModifyController@create')->name('feature_modify.create');
    Route::post('{table}/{id}/feature-modify', 'FeatureModifyController@store')->name('feature_modify.store');
    Route::get('{table}/{id}/feature-modify/edit', 'FeatureModifyController@edit')->name('feature_modify.edit');
    Route::patch('{table}/{id}/feature-modify', 'FeatureModifyController@update')->name('feature_modify.update');
    Route::post('feature-modify/change_parent', 'FeatureModifyController@change_parent')->name('feature_modify.change_parent');
    Route::get('{table}/{id}/feature-modify/copy', 'FeatureModifyController@copy')->name('feature_modify.copy');
    Route::get('{table}/{id}/feature-modify/join', 'FeatureModifyController@join')->name('feature_modify.join');
    Route::post('{table}/{id}/feature-modify/joined', 'FeatureModifyController@joined')->name('feature_modify.joined');
});


Route::group(['middleware' => ['auth', 'prepare.request']], function () {

    Route::group([
        'namespace' => 'Cms', // контроллеры лежат в директории Controllers/Cms
        'middleware' => ['role:developer|admin|manager', 'cmsLocale'],
        'prefix' => 'cms',    // добавляется в url-адрес
        'as' => 'admin.'     // ключ для именования роутов
    ], function () {

        //не используются на этом сайте

        /**
         *  Валюты
         */
        // Route::get('currency', 'CurrencyController@index')->name('currency.index');
        // Route::get('currency/create', 'CurrencyController@create')->name('currency.create');
        // Route::post('currency', 'CurrencyController@store')->name('currency.store');
        // Route::get('currency/{currency}/edit', 'CurrencyController@edit')->name('currency.edit');
        // Route::patch('currency/{currency}', 'CurrencyController@update')->name('currency.update');
        // Route::get('currency/{currency}/restore', 'CurrencyController@restore')->name('currency.restore');
        // Route::post('currency/{currency}/active', 'CurrencyController@active')->name('currency.active');
        // Route::delete('currency/{currency}', 'CurrencyController@destroy')->name('currency.destroy');


        /**
         *  Типы цен
         */
        // Route::get('price-type', 'PriceTypeController@index')->name('price_type.index');
        // Route::get('price-type/create', 'PriceTypeController@create')->name('price_type.create');
        // Route::post('price-type', 'PriceTypeController@store')->name('price_type.store');
        // Route::get('price-type/{type}/edit', 'PriceTypeController@edit')->name('price_type.edit');
        // Route::patch('price-type/{type}', 'PriceTypeController@update')->name('price_type.update');
        // Route::get('price-type/{type}/restore', 'PriceTypeController@restore')->name('price_type.restore');
        // Route::post('price-type/{type}/active', 'PriceTypeController@active')->name('price_type.active');
        // Route::delete('price-type/{type}', 'PriceTypeController@destroy')->name('price_type.destroy');
    });
});
