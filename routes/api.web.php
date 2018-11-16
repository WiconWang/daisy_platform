<?php
// Web 页面 相关接口

Route::group(['namespace' => 'Site', "prefix" => 'site'], function () {
    Route::get('channels/{id}', 'ChannelController@getChannelList')->name('getChannelList')->where('id','[0-9]+');
});