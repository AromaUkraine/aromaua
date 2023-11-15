<?php

use App\Facades\Localization;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => Localization::locale(),
    'middleware' => ['setLocale'],
], function () {

    Route::group(['namespace' => 'Web'], function () {
        Route::group([
            'middleware' => [],
        ], function () {
            if (!strpos(\Request::url(),"cms" ) && !strpos(\Request::url(),"filemanager" )) {
                Route::get('/{category_slug}/{product_slug}', 'DynamicPageController@product')->name('product');
            }
            Route::get('/{slug?}', 'DynamicPageController@show')->name('page');
        });
    });
    
});
