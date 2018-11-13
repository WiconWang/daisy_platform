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
    Route::resource('info', 'IndexController');
    Route::patch('status/{id}', 'IndexController@status')->name('status')->where('id','[0-9]+');
});

Route::group(['middleware' => 'auth:admin','namespace' => 'Article'], function () {
    Route::resource('articles', 'IndexController');
});



Route::group(['middleware' => 'auth:admin','namespace' => 'Channel'], function () {
    Route::resource('channels', 'IndexController');
});

