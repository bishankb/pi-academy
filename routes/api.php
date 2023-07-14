<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
	'middleware' => 'jwt.auth'
], function(){
	Route::get('/questions/{set_id}', 'ExaminationQuestionController@getQuestions')->name('api.getQuestions');
	Route::post('user', 'UserController@getAuthUser')->name('api.getAuthUser');
	Route::post('take-exam', 'ExaminationQuestionController@takeExam')->name('api.takeExam');
});

Route::group([
	'namespace' => 'Auth'
], function(){
	Route::post('login', 'LoginController@login');
	Route::post('logout', 'LoginController@logout');
});
