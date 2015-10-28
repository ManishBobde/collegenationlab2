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
//Web Routes
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');

Route::get('/', function () {
    return view('welcome');
});
/**
 * API Routes defined for each of the incoming requests
 * Each request after login needs to be validated
 */
Route::group(array('prefix' => 'api/v1'), function() {

    /*####################UserController###############################*/

    Route::post('auth/sendtemporarypassword', 'UserController@sendPasswordOnUserEmail');

    Route::post('auth/register', 'UserController@registerUser');

    Route::post('auth/login', 'UserController@loginUser');

    Route::get('college/user/details/{userId}','UserController@getOtherUserDetails');

    Route::post('auth/verifyOtp', 'UserController@verifyOtp');

    Route::get('auth/sendOTP/{mobileNo}', 'UserController@sendOtpToVerifyMobileNumber');

    Route::post('college/user/changepassword/{userId}', 'UserController@changePassword');

    Route::get('college/user/profile','UserController@getUserProfile');

    Route::get('college/users','UserController@getUsersWithinTenant');

    /*************************ForgotPassword Routes***************************/
    Route::post('college/user/forgotpassword', 'UserController@forgotPassword');

    /*************************ForgotPassword Routes***************************/



    //Route::get('college/user/features/{userId}','UserController@getUserFeatures');

    Route::get('college/message/allusers/compose/{collegeId}','UserController@getAllUsersWithinTenantForCompose');

    Route::get('auth/logout', 'UserController@logoutUser');

    /*####################MessageController###############################*/

    Route::get('college/messages/{bucketname}/{userId}', 'MessageController@retrieveShortMessages');

    Route::get('college/messages/{msgId}', 'MessageController@retrieveMessageItem');

    Route::post('college/messages/compose', 'MessageController@submitMessages');

    Route::delete('college/messages/delete', 'MessageController@deleteMessage');

    Route::post('college/messages/associateBucket/{bucketName}', 'MessageController@changeAssociatedBucket');

    Route::get('college/messages/restore', 'MessageController@restoreMessages');


    /*####################NewsController###############################*/
    Route::get('college/news/all', 'NewsController@getNewsItemsWithShortDescription');

    Route::get('college/news/view/{newsId}', 'NewsController@retrieveNewsItem');

    Route::post('college/news/add', 'NewsController@createNews');

    Route::delete('college/news/delete', 'NewsController@deleteNews');

    Route::put('college/news/edit/{newsId}', 'NewsController@editNews');

    /*####################EventController###############################*/

    Route::get('college/events/all', 'EventsController@getEventsWithShortDescription');

    Route::get('college/events/view/{eventId}', 'EventsController@retrieveEventItem');

    Route::post('college/events/add', 'EventsController@createEvent');

    Route::delete('college/events/delete', 'EventsController@deleteEvent');

    Route::put('college/events/edit/{eventId}', 'EventsController@editEvent');

    /*####################AdminController###############################*/
    //Yet to be implemented

    Route::get('college/domains', 'AdminController@retrieveDomains');

    Route::get('college/predefinedStreams/domain/{domainId}', 'AdminController@retrieveStreamsForDomain');

    Route::get('college/departments', 'AdminController@getDepartmentForTenant');

    Route::get('college/user/features/{userId}', 'AdminController@retrieveRoleBasedFeatures');

    Route::get('college/user/suspend/{userId}', 'AdminController@suspendUser');

    Route::get('college/user/resume/{userId}', 'AdminController@resumeUser');

    Route::get('college/user/delete/{userId}', 'AdminController@deleteUser');

    /*####################ModuleController###############################*/

    Route::get('college/modules/{collegeId}', 'ModuleController@retrieveAccessibleModulesList');

    /*####################CollegeController###############################*/

    Route::post('college/user/register', 'CollegeController@registerCollege');

    /*####################DepartmentController###############################*/
//Add Department in Department controller
    Route::post('college/department/add', 'DepartmentController@createDepartment');

    /*####################PushDeviceRegController###############################*/
    Route::post('device/pushnotification/save', 'AccessTokenController@registerDeviceId');



});

//Route::post('auth/register', 'UserController@postRegister');
/*************************ForgotPassword Routes***************************/
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');

Route::post('password/reset', 'Auth\PasswordController@postReset');
/*************************ForgotPassword Routes***************************/

Route::post('register/college', 'UserController@postRegister');



