<?php

Route::group(['middleware' => ['auth', 'prepare.request']], function () {

    Route::group([
        'namespace'=>'Cms',
        'middleware' => ['role:developer|admin|manager', 'cmsLocale'],
        'prefix' => 'cms',
        'as' => 'module.'// этот алиас нужет чтобы модуль не попадал в основное меню cms
    ], function () {

        /**
         *  Ссылки для подключения повторяющегося элемента к странице как виджета страницы .
         */
        Route::get('/page/{page}/information/{page_component}', 'PageInformationController@index')->name('page_info.index');
        Route::get('/page/{page}/information/{page_component}/create', 'PageInformationController@create')->name('page_info.create');
        Route::post('/page/{page}/information/{page_component}', 'PageInformationController@store')->name('page_info.store');
        // такой длинный роутинг нужен чтобы субменю могло найти активный пункт меню
        Route::get('/page/{page}/information/{page_component}/{info}/edit', 'PageInformationController@edit')->name('page_info.edit');
        Route::patch('/information/{info}/update', 'PageInformationController@update')->name('page_info.update');

        // параметр page добавлен чтобы не конфликтовать с роутингами ниже
        Route::post('/page/information/{info}/active','PageInformationController@active')->name('page_info.active');
        Route::delete('/page/information/{info}', 'PageInformationController@destroy')->name('page_info.destroy');
        Route::get('/page/information/{info}/restore', 'PageInformationController@restore')->name('page_info.restore');

        /***
         * Ссылки для вложенных (наследников), информационного блока
         */
        Route::get('/page/{page}/information/{page_component}/{parent}', 'PageInformationChildrenController@index')->name('page_info_child.index');
        Route::get('/page/{page}/information/{page_component}/{parent}/create', 'PageInformationChildrenController@create')->name('page_info_child.create');
        Route::post('/page/{page}/information/{page_component}/{parent}/', 'PageInformationChildrenController@store')->name('page_info_child.store');

        Route::get('/page/{page}/information/{page_component}/{parent}/edit/{child}', 'PageInformationChildrenController@edit')->name('page_info_child.edit');
        Route::patch('/page/{page}/information/{page_component}/{parent}/{child}', 'PageInformationChildrenController@update')->name('page_info_child.update');

        Route::post('/page-information-children/{child}/active', 'PageInformationChildrenController@active')->name('page_info_child.active');
        Route::delete('/page-information-children/{child}', 'PageInformationChildrenController@destroy')->name('page_info_child.destroy');

        Route::get('/page/{page}/information/{page_component}/{parent}/restore/{child}', 'PageInformationChildrenController@restore')->name('page_info_child.restore');
    });



});
