<?php

Route::group(['middleware' => ['auth', 'prepare.request']], function () {

    Route::group([
        'middleware' => ['role:developer|admin|manager', 'cmsLocale'],
        'prefix' => 'cms',
        'as' => 'module.'// этот алиас нужет чтобы модуль не попадал в основное меню cms
    ], function () {

        /**
         *  Ссылки для подключения повторяющегося элемента к странице как виджета страницы . ???????
         */
//        Route::get('/page/{page}/google-map/{page_component}', 'GoogleMapController@index')->name('page_google_map.index');
//        Route::post('/page/{page}/google-map/{page_component}', 'GoogleMapController@update')->name('page_google_map.update');


        /**
         * Ссылка для подключения карты к записи например к контакту .
         */
        Route::get('entity-map/{table}/{id}', 'EntityMapController@index')->name('entity_map.index');
        Route::post('entity-map/{table}/{id}', 'EntityMapController@create')->name('entity_map.create');
        Route::patch('entity-map/{table}/{id}', 'EntityMapController@update')->name('entity_map.update');
        Route::get('entity-map/{table}/{id}/{map}/delete', 'EntityMapController@destroy')->name('entity_map.destroy');
    });

});
