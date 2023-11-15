<?php

Route::group(['middleware' => ['role:developer|admin|manager', 'prepare.request', 'cmsLocale']], function () {

    Route::group([
        'prefix' => 'cms',
        'as' => 'module.' // этот алиас нужет чтобы модуль не попадал в основное меню cms
    ], function () {

        /**
         *  Ссылки для подключения галереи к странице как виджета страницы .
         */
        Route::get('/page/{page}/gallery/{page_component}', 'PageGalleryController@index')->name('page_gallery.index');
        Route::get('/page/{page}/gallery/{page_component}/{type}/create', 'PageGalleryController@create')->name('page_gallery.create');
        Route::post('/page/{page}/gallery/{page_component}/{type}', 'PageGalleryController@store')->name('page_gallery.store');
        // такой длинный роутинг нужен чтобы субменю могло найти активный пункт меню
        Route::get('/page/{page}/gallery/{page_component}/{gallery}/edit', 'PageGalleryController@edit')->name('page_gallery.edit');
        Route::patch('/gallery/{gallery}/update', 'PageGalleryController@update')->name('page_gallery.update');
        // параметр page добавлен чтобы не конфликтовать с роутингами ниже
        Route::post('/page/gallery/{gallery}/active', 'PageGalleryController@active')->name('page_gallery.active');
        Route::delete('/page/gallery/{gallery}', 'PageGalleryController@destroy')->name('page_gallery.destroy');
        Route::get('/page/gallery/{gallery}/restore', 'PageGalleryController@restore')->name('page_gallery.restore');


        /**
         * если нет родительской страницы например во вкладке "категории товаров"
         */
        Route::get('entity-gallery/{table}/{id}', 'GalleryController@index')->name('gallery.index');
        //создание
        Route::get('entity-gallery/{table}/{id}/create/{type?}', 'GalleryController@create')->name('gallery.create');
        Route::post('entity-gallery/{table}/{id}/store/{type?}', 'GalleryController@store')->name('gallery.store');
        //редактирование
        Route::get('entity-gallery/{table}/{id}/{gallery}/edit', 'GalleryController@edit')->name('gallery.edit');
        Route::patch('entity-gallery/{table}/{id}/{gallery}/update', 'GalleryController@update')->name('gallery.update');
        // активировать/дезактивировать
        Route::post('entity-gallery/{gallery}/active', 'GalleryController@active')->name('gallery.active');
        // удаление
        Route::delete('entity-gallery/{gallery}', 'GalleryController@destroy')->name('gallery.destroy');
        // восстановление после soft delete
        Route::get('entity-gallery/{table}/{id}/{gallery}/restore', 'GalleryController@restore')->name('gallery.restore');


        /**
         *  Если галерея привязана к записи которая в свою очередь привязана к странице
         */
        Route::get('page/{page}/{table}/{id}/gallery', 'EntityGalleryController@index')->name('entity_gallery.index');
        //создание
        Route::get('page/{page}/{table}/{id}/gallery/{type}/create', 'EntityGalleryController@create')->name('entity_gallery.create');
        Route::post('page/{page}/{table}/{id}/gallery/{type}/store', 'EntityGalleryController@store')->name('entity_gallery.store');
        //редактирование
        Route::get('page/{page}/{table}/{id}/gallery/{gallery}/edit', 'EntityGalleryController@edit')->name('entity_gallery.edit');
        Route::patch('page/{page}/{table}/{id}/gallery/{gallery}/update', 'EntityGalleryController@update')->name('entity_gallery.update');
        // активировать/дезактивировать
        Route::post('entity/gallery/{gallery}/active', 'EntityGalleryController@active')->name('entity_gallery.active');
        // удаление
        Route::delete('entity/gallery/{gallery}', 'EntityGalleryController@destroy')->name('entity_gallery.destroy');
        // восстановление после soft delete
        Route::get('page/{page}/{table}/{id}/gallery/{gallery}/restore', 'EntityGalleryController@restore')->name('entity_gallery.restore');
    });
});