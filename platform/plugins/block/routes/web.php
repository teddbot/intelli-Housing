<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Block\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'blocks', 'as' => 'block.'], function () {
            Route::resource('', 'BlockController')->parameters(['' => 'block']);
        });
    });
});
