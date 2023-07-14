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

Route::get('/', function() {

    return redirect(route('exam.login'));

});

//Backend Admin Panel
Route::group([
    'namespace' => 'Backend',
    'prefix' => 'admin',
    'middleware' => ['auth']
], function(){
    //Dashboard
    Route::get('/', 'DashboardController@index')->name('backend.dashboard');

    //User
    Route::resource('/users', 'UserController');
    Route::post('/users/edit-profile/{id}', 'UserController@editProfile')->name('users.editProfile');
    Route::post('/users/change-password/{id}', 'UserController@changePassword')->name('users.changePassword');
    Route::post('/users/change-status/{id}', 'UserController@changeStatus')->name('users.changeStatus');
    Route::post('/users/restore/{id}', 'UserController@restore')->name('users.restore');
    Route::delete('/users/force-delete/{id}', 'UserController@forceDestroy')->name('users.forceDestroy');
    Route::post('/users/delete-image/{id}', 'UserController@destroyImage')->name('users.destroyImage');

    //Role
    Route::resource('roles', 'RoleController');

    //Transaction
    Route::resource('/transactions', 'TransactionController');
    Route::post('/transactions/restore/{id}', 'TransactionController@restore')->name('transactions.restore');
    Route::delete('/transactions/force-delete/{id}', 'TransactionController@forceDestroy')->name('transactions.forceDestroy');

    //ScholarshipTest
    Route::resource('/scholarship-test', 'ScholarshipTestController');
    Route::post('/scholarship-test/restore/{id}', 'ScholarshipTestController@restore')->name('scholarship-test.restore');
    Route::delete('/scholarship-test/force-delete/{id}', 'ScholarshipTestController@forceDestroy')->name('scholarship-test.forceDestroy');
    Route::post('/scholarship-test/delete-image/{id}', 'ScholarshipTestController@destroyImage')->name('scholarship-test.destroyImage');

    //Visitor
    Route::resource('/visitors', 'VisitorController');
    Route::post('/visitors/restore/{id}', 'VisitorController@restore')->name('visitors.restore');
    Route::delete('/visitors/force-delete/{id}', 'VisitorController@forceDestroy')->name('visitors.forceDestroy');

    //StudentRegistration
    Route::resource('/student-registration', 'StudentRegistrationController');
    Route::post('/student-registration/restore/{id}', 'StudentRegistrationController@restore')->name('student-registration.restore');
    Route::delete('/student-registration/force-delete/{id}', 'StudentRegistrationController@forceDestroy')->name('student-registration.forceDestroy');
    Route::post('/student-registration/delete-image/{id}', 'StudentRegistrationController@destroyImage')->name('student-registration.destroyImage');

    //Student Payment History
    Route::group([
        'prefix' => 'student-registration/{student_id}'
    ], function(){
        Route::resource('payment-history', 'StudentPaymentHistoryController', [
            'names' => [
                'index'   => 'student-payment-history.index',
                'create'  => 'student-payment-history.create',
                'store'   => 'student-payment-history.store',
                'show'    => 'student-payment-history.show',
                'edit'    => 'student-payment-history.edit',
                'update'  => 'student-payment-history.update',
                'destroy' => 'student-payment-history.destroy',
            ]
        ]);
        Route::post('/payment-history/restore/{id}', 'StudentPaymentHistoryController@restore')->name('student-payment-history.restore');
        Route::delete('/payment-history/force-delete/{id}', 'StudentPaymentHistoryController@forceDestroy')->name('student-payment-history.forceDestroy');

        //Student Examination Credential
        Route::get('/examination-credential/{id}/edit', 'StudentRegistrationController@editExaminationCredential')->name('student-registration.editExaminationCredential');
        Route::put('/examination-credential/{id}/update', 'StudentRegistrationController@updateExaminationCredential')->name('student-registration.updateExaminationCredential');
        Route::post('/examination-credential/{id}/change-status', 'StudentRegistrationController@changeStatus')->name('examination-credential.changeStatus');
    });

    //Student Examination Result
    Route::get('/student-list', 'ExaminationResultController@studentList')->name('examination-results.student-list');
    Route::get('/student-list/{id}', 'ExaminationResultController@studentShow')->name('examination-results.student-show');
    Route::group([
        'prefix' => 'student-list/{student_id}'
    ], function(){
        Route::resource('examination-results', 'ExaminationResultController', [
            'names' => [
                'index' => 'examination-results.index',
                'show'  => 'examination-results.show',
            ]
        ])->only(['index', 'show']);
    });

    //Client List and Examination Result
    Route::resource('clients', 'ClientController')->except(['create', 'store']);
    Route::post('/clients/restore/{id}', 'ClientController@restore')->name('clients.restore');
    Route::delete('/clients/force-delete/{id}', 'ClientController@forceDestroy')->name('clients.forceDestroy');
    Route::post('/clients/change-status/{id}', 'ClientController@changeStatus')->name('clients.changeStatus');

    Route::group([
        'prefix' => 'clients/{client_id}'
    ], function(){
        Route::get('/examination-results', 'ClientController@resultIndex')->name('clients.resultIndex');
        Route::get('/examination-results/{id}', 'ClientController@resultShow')->name('clients.resultShow');
    });

    //DateConversion
    Route::get('/scholarship-test/date-converstion/{date}', 'ScholarshipTestController@getSelectedDate')->name('scholarship-test.date-converstion');

    //Attendence
    Route::get('/staff-list', 'AttendenceController@staffList')->name('attendence.staff-list');
    Route::group([
        'prefix' => 'staff-list/{staff_id}'
    ], function(){
        Route::resource('attendence', 'AttendenceController', [
            'names' => [
                'index'   => 'attendence.index',
                'create'  => 'attendence.create',
                'store'   => 'attendence.store',
                'show'    => 'attendence.show',
                'edit'    => 'attendence.edit',
                'update'  => 'attendence.update',
                'destroy' => 'attendence.destroy',
            ]
        ]);
        Route::post('/attendence/restore/{id}', 'AttendenceController@restore')->name('attendence.restore');
        Route::delete('/attendence/force-delete/{id}', 'AttendenceController@forceDestroy')->name('attendence.forceDestroy');
    });

    //Examination Question
    Route::resource('question-sets', 'QuestionSetController');
    Route::post('/question-sets/restore/{id}', 'QuestionSetController@restore')->name('question-sets.restore');
    Route::delete('/question-sets/force-delete/{id}', 'QuestionSetController@forceDestroy')->name('question-sets.forceDestroy');

    Route::group([
        'prefix' => '{set_type}/'
    ], function(){
        Route::resource('examination-questions', 'ExaminationQuestionController');
        Route::post('/examination-questions/restore/{id}', 'ExaminationQuestionController@restore')->name('examination-questions.restore');
        Route::delete('/examination-questions/force-delete/{id}', 'ExaminationQuestionController@forceDestroy')->name('examination-questions.forceDestroy');
    });
    Route::post('/examination-questions/delete-image/{id}', 'ExaminationQuestionController@destroyImage')->name('examination-questions.destroyImage');

    //Routine
    //Routine Class Time
    //Routine Group
    //Routine Teacher
    Route::resource('routine-groups', 'RoutineGroupController');
    Route::post('/routine-groups/restore/{id}', 'RoutineGroupController@restore')->name('routine-groups.restore');
    Route::delete('/routine-groups/force-delete/{id}', 'RoutineGroupController@forceDestroy')->name('routine-groups.forceDestroy');

    //Routine Class Time
    Route::group([
        'prefix' => 'routine-groups/{group_id}/'
    ], function(){
        Route::resource('routine-class-time', 'RoutineClassTimeController');
        Route::post('/routine-class-time/restore/{id}', 'RoutineClassTimeController@restore')->name('routine-class-time.restore');
        Route::delete('/routine-class-time/force-delete/{id}', 'RoutineClassTimeController@forceDestroy')->name('routine-class-time.forceDestroy');
        
        //Routine Class
        Route::resource('routines', 'RoutineController');
        Route::post('/routines/restore/{id}', 'RoutineController@restore')->name('routines.restore');
        Route::delete('/routines/force-delete/{id}', 'RoutineController@forceDestroy')->name('routines.forceDestroy');
    });

    //Routine Teacher
    Route::get('/teacher-list', 'RoutineTeacherController@teacherList')->name('routine.teacher-list');
    Route::get('/teacher-show/{id}', 'RoutineTeacherController@teacherShow')->name('routine.teacher-show');

    Route::group([
        'prefix' => 'teacher-list/{teacher_id}'
    ], function(){
        Route::resource('routine', 'RoutineTeacherController', [
            'names' => [
                'index' => 'teacher-routine.index',
                'show'  => 'teacher-routine.show',
            ]
        ])->only(['index', 'show']);
    });

    //Meeting
    Route::resource('meeting', 'MeetingController');
    Route::post('/meeting/restore/{id}', 'MeetingController@restore')->name('meeting.restore');
    Route::delete('/meeting/force-delete/{id}', 'MeetingController@forceDestroy')->name('meeting.forceDestroy');
    Route::post('/meeting/delete-file/{id}', 'MeetingController@destroyFile')->name('meeting.destroyFile');

    //Push Notification
    Route::resource('push-notification', 'MobilePushNotificationController')->only(['create', 'store']);

});

Route::group([
    'namespace' => 'Auth',
], function(){
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/reset', 'ResetPasswordController@reset');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
});