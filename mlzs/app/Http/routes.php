<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::get('/','IndexController@index');
Route::get('/index','IndexController@index');
Route::get('/article_statis','ArticleController@statis');
Route::get('/article/getStatisByDay','ArticleController@getStatisByDay');
Route::get('/article/getStatisByMonth','ArticleController@getStatisByMonth');
Route::get('/test','TestController@index');
Route::get('/accountlist','AccountController@index');
Route::get('/account/{biz}','AccountController@detail');
Route::get('home', 'HomeController@index');




// 认证路由...
 Route::get('auth/login', 'Auth\AuthController@getLogin');
 Route::post('/login', 'Auth\AuthController@postLogin');
 Route::get('auth/logout', 'Auth\AuthController@getLogout');
// // 注册路由...
 Route::get('auth/register', 'Auth\AuthController@getRegister');
 Route::post('auth/register', 'Auth\AuthController@postRegister');



 //管理后台
 //
 Route::get('/admin/login',  'AdminController@getLogin');
 Route::get('/admin/logout',  'AdminController@logout');
 Route::post('/admin/login', 'AdminController@postLogin');
 Route::get('admin/index', 'AdminController@index');
 Route::post('/account/update','AccountController@update');
 Route::get('/admin/adminaccount/{biz}','AccountController@admindetail');
 Route::get('/admin/user',  'UserController@index');
 Route::post('/user/add',  'UserController@add');
 Route::post('/user/update',  'UserController@update');
 Route::post('/user/delete',  'UserController@delete');
