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
Route::get('/', 'HomeController@index')->name('home');

Route::get('/article', 'ArticleController@index')->name('article.list');

Route::get('/article/{slug}', 'ArticleController@show')->name('article.detail');

Route::get('/article/category/{slug}', 'ArticleController@getByCategory')->name('article.by.category');

Route::get('/lesson', 'LessonController@index')->name('lesson.list');

Route::get('/lesson/category/{slug}', 'LessonController@getByCategory')->name('lesson.by.category');

Route::get('/lesson/{slug}', 'LessonController@show')->name('lesson.detail');

Route::get('/lesson/{parent}/{slug}', 'LessonController@showVideo')->name('lesson.video');

Route::get('/auth/register', 'AuthController@getRegister')->name('auth.get.register');

Route::post('/auth/register', 'AuthController@postRegister')->name('auth.post.register');

Route::get('/auth/activation', 'AuthController@activation');

Route::get('/auth', 'AuthController@index')->name('auth.get.login');

Route::post('/auth/login', 'AuthController@postLogin')->name('auth.post.login');

Route::get('/auth/logout', 'AuthController@logout')->name('auth.logout');

Route::get('/account', 'AuthController@account')->name('profile');

Route::get('/account/update', 'AuthController@getUpdate')->name('profile.update');

Route::post('/account/update', 'AuthController@update')->name('profile.post.update');

Route::post('/account/changepassword', 'AuthController@changePassword')->name('profile.changepassword');

Route::get('/premium/register/{month}', 'PremiumController@register')->name('premium.register');

Route::get('/premium','PremiumController@get')->name('premium');


// Route::get('/lesson', function() {
//     return view('front.lesson');
// });

// Route::get('/lesson/{slug}', function() {
//     return view('front.lessondetail');
// });

// Route::get('/profile', function() {
//     return view ('front.profile');
// });
// Route::get('/article', function() {
//     return view ('front.article');
// });
// Route::get('/article/{slug}', function() {
//     return view ('front.articledetail');
// });
// Route::get('/auth/register', function() {
//     return view ('front.register');
// });
// Route::get('/auth/login', function() {
//     return view ('front.login');
// });
// Route::get('/auth/activation', function() {
//     return view ('front.activation');
// });