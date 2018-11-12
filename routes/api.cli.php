<?php
// 命令行 相关接口
Route::group(['namespace' => 'Login', "prefix" => 'login'], function () {
    Route::get('t', function () {
        return 'cli Routes';
    });
    Route::resource('index', 'IndexController');
});



