<?php
use think\facade\Route;

Route::get('admin', function () {
    return 'Hello,world!';
});

Route::post('auth/login','api/admin.auth/login');
Route::get('auth/info','api/admin.auth/info');
Route::get('menus/build','api/admin.menus/build');

