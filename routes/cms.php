<?php

use App\Helpers\PermissionHelper;

Route::group(['middleware' => ['auth', 'prepare.request', 'cmsLocale']], function () {

    /*** Роутинг для вкладки администрирование и связанных с ней елементов***/
    Route::group([
        'namespace' => 'Cms',
        'middleware' => ['role:developer|admin|manager'],
        'prefix' => 'cms',
        'as' => 'admin.'
    ], function () {

        /**
         *  Administration
         */

        Route::get('/user/{user}/permissions/', 'UserPermissionsController@show')->name('user_permissions.show');
        Route::match(array('PUT', 'PATCH'), "/user/{user}/permissions", array(
            'uses' => 'UserPermissionsController@update',
            'as' => 'user_permissions.update'
        ));
        Route::patch('/user/{user}/administration/change-password', 'AdministrationController@change_password')
            ->name('administration.change_password');

        Route::post('/user/{user}/administration/api-token', 'AdministrationController@api_token')
            ->name('administration.api_token');

        // test
        //Route::get('/user/{user}/api-token', 'AdministrationController@api_token');

        Route::resource('/administration', 'AdministrationController')->except(['show']);

        /**
         *  Customers - don`t used in this site
         */
        // Route::resource('/customer', 'CustomerController')->except(['show']);

        /**
         * Roles
         */
        Route::get('/role/{role}/permissions', 'RolePermissionsController@show')->name('role_permissions.show');
        Route::match(array('PUT', 'PATCH'), "/role/{role}/permissions", array(
            'uses' => 'RolePermissionsController@update',
            'as' => 'role_permissions.update'
        ));
        Route::resource('/role', 'RoleController')->except(['show']);
        /**
         * Languages
         */
        Route::post('/language/{language}/active', 'LanguageController@active')->name('language.active');
        Route::resource('/language', 'LanguageController')->except(['show', 'destroy']);
        /**
         * Backend menu
         */
        Route::post('/backend/menu/{menu}/active', 'BackendMenuController@active')->name('backend_menu.active');
        Route::get('/backend/menu', 'BackendMenuController@index')->name('backend_menu.index');
        Route::get('/backend/menu/create', 'BackendMenuController@create')->name('backend_menu.create');
        Route::post('/backend/menu/store', 'BackendMenuController@store')->name('backend_menu.store');
        Route::get('/backend/menu/{menu}/edit', 'BackendMenuController@edit')->name('backend_menu.edit');
        Route::patch('/backend/menu/{menu}/update', 'BackendMenuController@update')->name('backend_menu.update');
        Route::delete('/backend/menu/{menu}', 'BackendMenuController@destroy')->name('backend_menu.destroy');
    });


    /*** Роутинг для корневых элементов ***/
    Route::group([
        'namespace' => 'Cms',
        'middleware' => ['role:developer|admin|manager'],
        'prefix' => 'cms',
        'as' => 'root.'
    ], function () {

        /***
         *  Home
         */
        Route::get('/', 'HomeController@index')->name('home.index');

        /**
         * Site settings
         */
        Route::resource('settings', 'SettingsController')->except(['show']);

        /***
         *  Frontend menu
         */
        Route::get('/frontend/menu', 'FrontendMenuController@index')->name('frontend_menu.index');
        Route::get('/frontend/menu/{menu}/create', 'FrontendMenuController@create')->name('frontend_menu.create');
        Route::post('/frontend/menu/{menu}/{page}/{status}', 'FrontendMenuController@store')->name('frontend_menu.store');
        Route::get('/frontend/menu/{menu}/edit', 'FrontendMenuController@edit')->name('frontend_menu.edit');
        Route::patch('/frontend/menu/{menu}/update', 'FrontendMenuController@update')->name('frontend_menu.update');
        Route::delete('/frontend/menu/{menu}', 'FrontendMenuController@destroy')->name('frontend_menu.destroy');
        Route::post('/frontend/menu/{menu}/active', 'FrontendMenuController@active')->name('frontend_menu.active');

        Route::post('/frontend/menu/add-tree', 'FrontendMenuController@addTree')->name('frontend_menu.add_tree');

        /**
         *  Translation
         */
        Route::get('/translation', 'TranslationController@index')->name('translation.index');
        Route::get('/translation/{group?}/show', 'TranslationController@show')->name('translation.show');
        Route::get('/translation/store', 'TranslationController@store')->name('translation.store');
        Route::post('/translation/{group?}/create', 'TranslationController@create')->name('translation.create');
        Route::patch('/translation/{group}/update', 'TranslationController@update')->name('translation.update');
        Route::post('/translation/{group?}/publish', 'TranslationController@publish')->name('translation.publish');
        Route::delete('/translation/{translation:key}', 'TranslationController@destroy')->name('translation.destroy');

        /**
         *  ResponsiveFileManager
         */
        Route::resource('filemanager', 'FileManagerController')->only('index', 'view');
    });



    /*** Роутинг для вкладки разделы сайта и связанных с ней елементов***/
    Route::group([
        'namespace' => 'Cms',
        'middleware' => ['role:developer|admin|manager'],
        'prefix' => 'cms',
        'as' => 'section.'
    ], function () {
        /***
         *  Section
         */
        Route::get('/section', 'SectionController@index')->name('section.index');
        Route::post('/section/{page}/active', 'SectionController@active')->name('section.active');
        Route::delete('/section/{page}', 'SectionController@destroy')->name('section.destroy');

        /*** Дополнительные методы для cms route если необходимо дописывать тут***/



        /*** Динимические роуты ресурсов ***/
        app(App\Services\PermissionsRouteService::class)->routes();
    });

    // Внутренние роуты без привязки к меню
    Route::group(
        [
            'namespace' => 'Cms',
            'middleware' => ['role:developer|admin|manager'],
            'prefix' => 'cms',
            'as' => 'module.'
        ],
        function () {
            Route::get('page-component/{page}', 'PageComponentController@index')->name('page_component.index');
            Route::post('page-component/{id}/active', 'PageComponentController@active')->name('page_component.active');

            Route::group(['prefix' => 'laravel-filemanager'], function () {
                \UniSharp\LaravelFilemanager\Lfm::routes();
            });
        }
    );
});
