<?php


Route::group(['middleware' => ['auth', 'prepare.request']], function () {

    Route::group([
        'middleware' => ['role:developer|admin|manager', 'cmsLocale'],
        'prefix' => 'cms',
        'as' => 'root.'// этот алиас нужет чтобы модуль  попадал в основное меню cms
    ], function () {

        Route::get('country', 'CountryController@index')->name('country.index');
        Route::get('country/create', 'CountryController@create')->name('country.create');
        Route::post('country/{country}/show', 'CountryController@show')->name('country.show');
        Route::post('country', 'CountryController@store')->name('country.store');
        Route::get('country/{country}/edit', 'CountryController@edit')->name('country.edit');
        Route::patch('country/{country}', 'CountryController@update')->name('country.update');
        Route::post('country/{country}/active','CountryController@active')->name('country.active');
        Route::delete('country/{country}', 'CountryController@destroy')->name('country.destroy');
        Route::get('country/{country}/restore', 'CountryController@restore')->name('country.restore');

        /**
         *
         */
        Route::get('shop', 'ShopController@index')->name('shop.index');
        Route::get('shop/create', 'ShopController@create')->name('shop.create');
        Route::post('shop', 'ShopController@store')->name('shop.store');
        Route::get('shop/{shop}/edit', 'ShopController@edit')->name('shop.edit');
        Route::patch('shop/{shop}', 'ShopController@update')->name('shop.update');
        Route::post('/shop/{shop}/active','ShopController@active')->name('shop.active');
        Route::delete('shop/{shop}', 'ShopController@destroy')->name('shop.destroy');
        Route::get('/shop/{shop}/restore', 'ShopController@restore')->name('shop.restore');
        // set central shop
        Route::post('/shop/{shop}/change','ShopController@change')->name('shop.change');
    });

    Route::group([
        'middleware' => ['role:developer|admin|manager', 'cmsLocale'],
        'prefix' => 'cms',
        'as' => 'module.'// этот алиас нужет чтобы модуль не попадал в основное меню cms
    ], function () {

        Route::get('entity-contact/{table}/{id}', 'EntityContactController@index')->name('entity_contact.index');
        Route::get('entity-contact/{table}/{id}/create', 'EntityContactController@create')->name('entity_contact.create');
        Route::post('entity-contact/{table}/{id}/store', 'EntityContactController@store')->name('entity_contact.store');
        Route::get('entity-contact/{table}/{id}/store', 'EntityContactController@store')->name('entity_contact.store');
        Route::get('entity-contact/{table}/{id}/{contact}/edit', 'EntityContactController@edit')->name('entity_contact.edit');
        Route::patch('entity-contact/{table}/{id}/{contact}', 'EntityContactController@update')->name('entity_contact.update');
        Route::delete('entity-contact/{contact}', 'EntityContactController@destroy')->name('entity_contact.destroy');
        Route::post('entity-contact/{contact}/active','EntityContactController@active')->name('entity_contact.active');
        Route::get('entity-contact/{table}/{id}/{contact}/restore', 'EntityContactController@restore')->name('entity_contact.restore');
    });

});