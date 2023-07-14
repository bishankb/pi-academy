<?php

/*
|--------------------------------------------------------------------------
| Exam Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Exam

Route::domain('exam.'.env('APP_URL'))->group(function () {
    Route::group([
	    'namespace' => 'Exam'
	   	], function(){
        //Home
        Route::get('/', 'HomeController@index')->name('exam.home');
        Route::get('/{set_type}/before-exam', 'HomeController@beforeExam')->name('exam.before-exam');
        Route::get('/{set_type}/exam', 'ExamController@index')->name('exam.take-exam');
        Route::post('/{set_type}/check', 'ExamController@check')->name('exam.check');
    });
    
    Route::group([
	    'namespace' => 'ExamAuth',
	], function(){	
	    Route::get('register', 'RegisterController@showRegistrationForm')->name('exam.show-register');
	    Route::post('register', 'RegisterController@register')->name('exam.register');
	    Route::get('/confirm-email', 'EmailConfirmController@pending')->name('email.confirm');
		Route::get('/email-verify/{token}', 'EmailConfirmController@verify')->name('email.verify');
		Route::post('/reverify', 'EmailConfirmController@resendVerificationToken')->name('email.reverify');

	    Route::get('login', 'LoginController@showLoginForm')->name('exam.show-login');
		Route::post('login', 'LoginController@login')->name('exam.login');
		Route::post('logout', 'LoginController@logout')->name('exam.logout');
		Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('exam-password.email');
		Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('exam-password.request');
		Route::post('password/reset', 'ResetPasswordController@reset')->name('exam-password.reset');
		Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('exam-password.reset');
	});
});