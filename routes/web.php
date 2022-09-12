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

Route::post('/backend-login', '\App\Http\Controllers\Auth\LoginController@login');
Route::match(['get','post'],'/forgot-login', '\App\Http\Controllers\Auth\LoginController@forgotLogin');
Route::match(['get','post'],'/forgot-password/{id}', '\App\Http\Controllers\Auth\LoginController@forgotPassword');
Route::get('/login', '\App\Http\Controllers\Auth\LoginController@showFormLogin');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::match(['get','post'],'/', '\App\Http\Controllers\Auth\LoginController@showFormLogin');
Route::get('/clear-cache', function() {Artisan::call('cache:clear');return "Cache is cleared";});

Route::group(['middleware' => ['auth','permissions'],'prefix' => 'admin'], function () {
    
    Route::match(['get'], '/dashboard', 'Admin\DashboardController@index');
    /** User Management Routes (Admin) */
    Route::match(['get','post'], '/user', 'Admin\UserController@index');
    Route::match(['get','post'], '/myprofile/{id}', 'Admin\UserController@myprofile');
    Route::match(['get','post'], '/user/add', 'Admin\UserController@add');
    Route::match(['get','post'], '/user/edit/{id}', 'Admin\UserController@edit');
    Route::match(['post'], '/user/delete', 'Admin\UserController@delete');
    Route::match(['post'], '/user/toggle', 'Admin\UserController@toggleStatus');
    Route::match(['get', 'post'], '/user/view/{id}', 'Admin\UserController@view');
    Route::match(['get','post'],'/user/get-rights', 'Admin\UserController@getRights');
    Route::match(['get','post'], 'admin/myprofile/changepassword/{id}', 'Admin\UserController@changepassword');
    /** Right Management Routes (Admin) */
    Route::match(['get', 'post'], '/rights', 'Admin\RightsController@index');
    Route::match(['get', 'post'], '/rights/add', 'Admin\RightsController@add');
    Route::match(['get', 'post'], '/rights/edit/{id}', 'Admin\RightsController@edit');
    Route::match(['post'], '/rights/delete', 'Admin\RightsController@delete');
    Route::match(['post'], '/rights/toggle', 'Admin\RightsController@toggleStatus');
    /** Role Management Routes (Admin) */
    Route::match(['get', 'post'], '/role', 'Admin\RoleController@index');
    Route::match(['get', 'post'], '/role/add', 'Admin\RoleController@add');
    Route::match(['get', 'post'], '/role/edit/{id}', 'Admin\RoleController@edit');
    Route::match(['post'], '/role/delete', 'Admin\RoleController@delete');
    Route::match(['post'], '/role/toggle', 'Admin\RoleController@toggleStatus');
    Route::match(['get', 'post'], '/role/view/{id}', 'Admin\RoleController@view');
    /** Menu Management Routes (Admin) */
    Route::match(['get', 'post'], '/menu', 'Admin\MenuController@index');
    Route::match(['get', 'post'], '/menu/add', 'Admin\MenuController@add');
    Route::match(['get', 'post'], '/menu/edit/{id}', 'Admin\MenuController@edit');
    Route::match(['post'], '/menu/delete', 'Admin\MenuController@delete');
    Route::match(['post'], '/menu/toggle', 'Admin\MenuController@toggleStatus');
    /** Menu-type Management Routes (Admin) */
    Route::match(['get','post'],'/menu-types', 'Admin\MenuTypesController@index');
    Route::match(['get','post'],'/menu-types/add', 'Admin\MenuTypesController@add');
    Route::match(['get','post'],'/menu-types/edit/{id}', 'Admin\MenuTypesController@edit');
    Route::match(['post'],'/menu-types/delete', 'Admin\MenuTypesController@delete');
    Route::match(['post'],'/menu-types/toggle', 'Admin\MenuTypesController@toggleStatus');
    Route::match(['get','post'],'/menu-types/order/{id}', 'Admin\MenuTypesController@orderMenuTypes');
    /** Team Management Routes (Admin) */
    Route::match(['get','post'], '/website', 'Admin\WebsiteController@index');
    Route::match(['get','post'], '/website/add', 'Admin\WebsiteController@add');
    Route::match(['get','post'], '/website/edit/{id}', 'Admin\WebsiteController@edit');
    Route::match(['post'], '/website/delete', 'Admin\WebsiteController@delete');
    Route::match(['post'], '/website/toggle', 'Admin\WebsiteController@toggleStatus');    
});
// Route::match(['get','post'],'/{slug}', '\App\Http\Controllers\HomeController@cms');
Auth::routes();