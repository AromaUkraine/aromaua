<?php

/*** Роутинг исключительно для разработчика***/


Route::group([
    'middleware' =>['role:developer','cmsLocale','prepare.request'],
    'prefix'=>'cms',
    'as'=>'developer.'
], function () {



    /**
     *  Создание страниц из шаблонов
     */
    Route::get('page','PageController@index')->name('page.index');
    Route::get('page/create','PageController@create')->name('page.create');
    Route::post('page/store','PageController@store')->name('page.store');
    Route::get('page/{page}/edit','PageController@edit')->name('page.edit');
    Route::patch('page/{page}', 'PageController@update')->name('page.update');
    Route::post('page/{page}/active','PageController@active')->name('page.active');
    Route::delete('page/{page}', 'PageController@destroy')->name('page.destroy');

    /**
     * Создание самостоятельных страниц из сео-страниц
     */
    Route::get('seo-page','SeoPageController@index')->name('seo_page.index');
    Route::get('seo-page/create','SeoPageController@create')->name('seo_page.create');
    Route::post('seo-page/store','SeoPageController@store')->name('seo_page.store');
    Route::get('seo-page/edit/{page}','SeoPageController@edit')->name('seo_page.edit');
    Route::patch('seo-page/{page}', 'SeoPageController@update')->name('seo_page.update');

    /**
     *  Создание виджета отобраных для показа на странице сущностей
     */
    Route::get('seo-page/make/widget/{page}/{alias}', 'MakeWidgetController@create')->name('make_widget.create');
    Route::post('seo-page/make/widget/{page}/{alias}', 'MakeWidgetController@store')->name('make_widget.store');


    /**
     *  Создание шаблонов страниц
     */
    Route::resource('/template', 'TemplateController')->except(['show','destroy']);

    /**
     * Роутинг
     */
    Route::get('/route', 'RouteController@index')->name('route.index');

    /**
     * Модули и виджеты
     */
    Route::get('/module','ModuleController@index')->name('module.index');
    Route::get('/module/create-item/{alias?}','ModuleController@create')->name('module.create');
    Route::post('/module/store','ModuleController@store')->name('module.store');
    Route::get('/module/edit-item/{module}','ModuleController@edit')->name('module.edit');
    Route::patch('/module/update-item/{module}', 'ModuleController@update')->name('module.update');

    /**
     *  Компоненты записей
     */
    Route::get('/entity-component','EntityComponentController@index')->name('entity_component.index');
    Route::get('/entity-component/create','EntityComponentController@create')->name('entity_component.create');
    Route::post('/entity-component','EntityComponentController@store')->name('entity_component.store');
    Route::get('/entity-component/edit/{item}','EntityComponentController@edit')->name('entity_component.edit');
    Route::patch('/entity-component/{item}', 'EntityComponentController@update')->name('entity_component.update');
    Route::delete('/entity-component/{item}', 'EntityComponentController@destroy')->name('entity_component.destroy');



    Route::get('frontend-menu-root', 'FrontendMenuRootController@index')->name('frontend_menu_root.index');
    Route::get('frontend-menu-root/create', 'FrontendMenuRootController@create')->name('frontend_menu_root.create');
    Route::post('frontend-menu-root', 'FrontendMenuRootController@store')->name('frontend_menu_root.store');
    Route::get('frontend-menu-root/{menu}/edit', 'FrontendMenuRootController@edit')->name('frontend_menu_root.edit');
    Route::patch('frontend-menu-root/{menu}', 'FrontendMenuRootController@update')->name('frontend_menu_root.update');
    Route::delete('frontend-menu-root/{menu}', 'FrontendMenuRootController@destroy')->name('frontend_menu_root.destroy');


});
