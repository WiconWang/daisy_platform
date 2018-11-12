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

Route::get('/', function () {
    return view('welcome');
});



//文档相关
Route::group(["prefix" => 'docs'], function () {
    Route::get('/', 'DocsController@index');
    Route::get('{type}.html', 'DocsController@index');

});


Route::get('article/{type}.html', 'ArticleController@index');
