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
        'namespace'=>'Cms',
        'middleware' =>['role:developer|admin|manager','cmsLocale'],
        'prefix'=>'cms',
        'as'=>'module.'
    ], function () {

        /***
         *  Articles
         */
        Route::get('/page/{page}/article', 'ArticleController@index')->name('article.index');
        Route::get('/page/{page}/article/create', 'ArticleController@create')->name('article.create');
        Route::post('/page/{page}/article', 'ArticleController@store')->name('article.store');
        Route::get('/page/{page}/article/{article}/restore', 'ArticleController@restore')->name('article.restore');
        Route::post('/article/{article}/active','ArticleController@active')->name('article.active');
        Route::get('/page/{page}/article/{article}/edit', 'ArticleController@edit')->name('article.edit');
        Route::patch('/page/{page}/article/{article}/update', 'ArticleController@update')->name('article.update');
        Route::delete('/article/{article}', 'ArticleController@destroy')->name('article.destroy');

        /***
         *  Article Category
         */
        Route::get('/page/{page}/category-article', 'ArticleCategoryController@index')->name('article_category.index');
        Route::get('/page/{page}/category-article/create', 'ArticleCategoryController@create')->name('article_category.create');
        Route::post('/page/{page}/category-article', 'ArticleCategoryController@store')->name('article_category.store');
        Route::get('/page/{page}/category-article/{category}/restore', 'ArticleCategoryController@restore')->name('article_category.restore');
        Route::post('/category-article/{category}/active','ArticleCategoryController@active')->name('article_category.active');
        Route::get('/page/{page}/category-article/{category}/edit', 'ArticleCategoryController@edit')->name('article_category.edit');
        Route::patch('/page/{page}/category-article/{category}/update', 'ArticleCategoryController@update')->name('article_category.update');
        Route::delete('/category-article/{category}', 'ArticleCategoryController@destroy')->name('article_category.destroy');
    });
});
