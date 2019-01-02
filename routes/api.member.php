<?php
// 用户后台 相关接口

Route::group(['namespace' => 'Login', "prefix" => 'login'], function () {
    Route::post('/', 'IndexController@login')->name('login');
});

// 以下所有接口需要经过 admin 的oAuth认证
Route::group(['middleware' => 'auth:user','namespace' => 'Login'], function () {
    Route::get('info', 'InfoController@index')->name('info');
    Route::get('logout', 'InfoController@logout')->name('logout');
});


Route::group(['middleware' => 'auth:user','namespace' => 'Article'], function () {
    Route::resource('articles', 'IndexController');
    Route::get('archive', 'IndexController@archive')->name('archive');
    Route::patch('archive/{id}', 'IndexController@changeArchived')->name('changeArchived')->where('id','[0-9]+');
});

Route::group(['middleware' => 'auth:user','namespace' => 'Tools', "prefix" => 'upload'], function () {
    Route::post('image', 'UploadController@uploadImage')->name('image');
});
