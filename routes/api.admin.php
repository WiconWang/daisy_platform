<?php

// 超级管理员后台 开放接口
Route::group(['namespace' => 'Login', "prefix" => 'login'], function () {
    Route::post('/', 'IndexController@login')->name('login');
});

// 以下所有接口需要经过 admin 的oAuth认证
Route::group(['middleware' => 'auth:admin','namespace' => 'Login'], function () {
    Route::get('info', 'InfoController@index')->name('info');
    Route::get('logout', 'InfoController@logout')->name('logout');
});


Route::group(['middleware' => 'auth:admin','namespace' => 'User', "prefix" => 'users'], function () {
    Route::resource('members', 'MembersController');
    Route::resource('admins', 'AdminsController');
    Route::patch('status/members/{id}', 'MembersController@status')->name('status')->where('id','[0-9]+');
    Route::patch('status/admins/{id}', 'AdminsController@status')->name('status')->where('id','[0-9]+');
});

Route::group(['middleware' => 'auth:admin','namespace' => 'Article'], function () {
    Route::resource('articles', 'IndexController');
    Route::patch('status/articles/{id}', 'IndexController@status')->name('status')->where('id','[0-9]+');
});

Route::group(['middleware' => 'auth:admin','namespace' => 'Channel'], function () {
    Route::resource('channels', 'IndexController');
});


Route::group(['middleware' => 'auth:admin','namespace' => 'component', "prefix" => 'component'], function () {
    Route::resource('banners', 'BannerController');
});


Route::group(['middleware' => 'auth:admin','namespace' => 'Tools', "prefix" => 'upload'], function () {
    Route::post('image', 'UploadController@uploadImage')->name('image');
    Route::post('editorimage', 'UploadController@uploadEditorImage')->name('editorimage');
});


Route::group(['middleware' => 'auth:admin','namespace' => 'User', "prefix" => 'message'], function () {
    Route::get('count', 'MessageController@count')->name('count');
    Route::get('index', 'MessageController@index')->name('index');
    Route::get('content', 'MessageController@content')->name('content');
    Route::patch('reading', 'MessageController@reading')->name('reading');
    Route::patch('remove', 'MessageController@remove')->name('remove');
    Route::patch('restore', 'MessageController@restore')->name('restore');
});