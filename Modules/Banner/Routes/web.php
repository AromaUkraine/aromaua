<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['auth', 'prepare.request']], function(){

    Route::group([
        'namespace'=>'Cms', // контроллеры лежат в директорииControllers/Cms
        'middleware' =>['role:developer|admin|manager','cmsLocale'],
        'prefix'=>'cms',
        'as'=>'module.'// этот алиас нужет чтобы модуль не попадал в основное меню cms
    ], function () {

        /*
         *  Баннер для страниц (виджет), например для страницы новости, главной, каталог, контакты и т.д
         */
        // уникальный ключ виджета
        Route::get('/page/{page}/banner/{page_component}', 'PageBannerController@index')->name('page_banner.index');
        Route::get('/page/{page}/banner/{alias}/create', 'PageBannerController@create')->name('page_banner.create');
        Route::post('/page/{page}/banner/{page_component}', 'PageBannerController@store')->name('page_banner.store');
        // такой длинный роутинг нужен чтобы субменю могло найти активный пункт меню
        Route::get('/page/{page}/banner/{page_component}/{banner}/edit', 'PageBannerController@edit')->name('page_banner.edit');
        Route::patch('/page/banner/{banner}/update', 'PageBannerController@update')->name('page_banner.update');
        Route::post('/page/banner/{banner}/active','PageBannerController@active')->name('page_banner.active');
        Route::delete('/page/banner/{banner}', 'PageBannerController@destroy')->name('page_banner.destroy');
        Route::get('/page/banner/{banner}/restore', 'PageBannerController@restore')->name('page_banner.restore');



        /*
         *  Баннер для записей без родительской страницы (например категории товаров, товар и т.д)
         */
        Route::get('entity-banner/{table}/{id}', 'EntityBannerController@index')->name('entity_banner.index');
        //создание
        Route::get('entity-banner/{table}/{id}/create', 'EntityBannerController@create')->name('entity_banner.create');
        Route::post('entity-banner/{table}/{id}/store', 'EntityBannerController@store')->name('entity_banner.store');
        //редактирование
        Route::get('entity-banner/{table}/{id}/banner/{banner}/edit', 'EntityBannerController@edit')->name('entity_banner.edit');
        Route::patch('entity-banner/{table}/{id}/banner/{banner}/update', 'EntityBannerController@update')->name('entity_banner.update');
        // активировать/дезактивировать
        Route::post('entity-banner/{banner}/active', 'EntityBannerController@active')->name('entity_banner.active');
        // удаление
        Route::delete('/entity-banner/{banner}', 'EntityBannerController@destroy')->name('entity_banner.destroy');
        // восстановление после soft delete
        Route::get('entity-banner/{table}/{id}/banner/{banner}/restore', 'EntityBannerController@restore')->name('entity_banner.restore');

        /**
         *  Если баннер привязан к записи которая в свою очередь привязана к странице
         */
        Route::get('page/{page}/{table}/{id}/banner', 'PageEntityBannerController@index')->name('page_entity_banner.index');
        //создание
        Route::get('page/{page}/{table}/{id}/banner/create', 'PageEntityBannerController@create')->name('page_entity_banner.create');
        Route::post('page/{page}/{table}/{id}/banner/store', 'PageEntityBannerController@store')->name('page_entity_banner.store');
        //редактирование
        Route::get('page/{page}/{table}/{id}/banner/{banner}/edit', 'PageEntityBannerController@edit')->name('page_entity_banner.edit');
        Route::patch('page/{page}/{table}/{id}/banner/{banner}', 'PageEntityBannerController@update')->name('page_entity_banner.update');
        // активировать/дезактивировать
        Route::post('page-entity-banner/{banner}/active', 'PageEntityBannerController@active')->name('page_entity_banner.active');
        // удаление
        Route::delete('page-entity-banner/{banner}', 'PageEntityBannerController@destroy')->name('page_entity_banner.destroy');
        // восстановление после soft delete
        Route::get('page/{page}/{table}/{id}/banner/{banner}/restore', 'PageEntityBannerController@restore')->name('page_entity_banner.restore');


    });
});
