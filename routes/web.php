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

Auth::routes();

Crud::routes();

Route::group(['as' => 'auth.'], function(){
	Route::get('auth/{provider}', ['as'=>'provider', 'uses' => 'Auth\AuthController@redirectToProvider']);
	Route::get('auth/{provider}/callback', ['as'=>'provider.callback', 'uses' => 'Auth\AuthController@handleProviderCallback']);
});

Route::group(['as' => 'api.'], function(){
	Route::get('/api/search/{text}/{take?}/{offset?}', ['as'=>'search', 'uses' => 'ApiController@getSearch']);
	Route::get('/api/opcache/reset', ['as'=>'reset', 'uses' => 'ApiController@getOPcacheReset']);
	Route::get('/api/students/', ['as'=>'students', 'uses' => 'ApiController@getStudents']);

	Route::post('/api/search-by-phone/', ['as'=>'searchPhone', 'uses' => 'ApiController@postSobytiyaSearchPhone']);	
    Route::post('/api/subscribe/', ['as'=>'subscribe', 'uses' => 'ApiController@postSubscribe']);
    Route::post('/api/feedback/', ['as'=>'feedback', 'uses' => 'ApiController@postFeedback']);
	Route::post('/api/students/approve', ['as'=>'students', 'uses' => 'ApiController@postStudentsApprove']);
	Route::post('/api/students/reject', ['as'=>'students', 'uses' => 'ApiController@postStudentsReject']);
});

/************* forms ****************/

Route::group(['as' => 'forms.'], function(){
	Route::post('/students/register/', ['as'=>'students.register', 'uses' => 'ApiController@postStudentRegister']);
	Route::post('/students/login/', ['as'=>'students.login', 'uses' => 'ApiController@postStudentLogin']);
	Route::post('/students/password/new', ['as'=>'students.password', 'uses' => 'ApiController@postStudentChangePassword']);
	Route::post('/students/logout', ['as'=>'students.logout', 'uses' => 'ApiController@postStudentLogout']);

	Route::post('/sobytiya/register/', ['as'=>'sobytiya.register', 'uses' => 'ApiController@postSobytiyaRegister']);
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/',  ['as' => 'page', 'uses' => 'PagesController@getIndex']);

Route::get('/{page}', ['as' => 'page', 'uses' => 'PagesController@getPage'])->where(['page' => '^[а-яa-z-0-9_/.]+$']);


