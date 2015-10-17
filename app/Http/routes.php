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

    Route::get('college/user/forgotpassword/{userId}', 'UserController@forgotPassword');

    Route::post('college/user/changepassword/{userId}', 'UserController@changePassword');

    Route::get('college/user/profile','UserController@getUserProfile');

    Route::get('college/users','UserController@getUsersWithinTenant');


    //Route::get('college/user/features/{userId}','UserController@getUserFeatures');

    Route::get('college/message/allusers/compose/{collegeId}','UserController@getAllUsersWithinTenantForCompose');

    Route::get('auth/logout', 'UserController@logoutUser');

    /*####################MessageController###############################*/

    Route::get('college/messages/{bucketname}/{userId}', 'MessageController@retrieveShortMessages');

    Route::get('college/messages/{msgId}', 'MessageController@retrieveMessageItem');

    Route::post('college/messages/compose', 'MessageController@submitMessages');

    Route::post('college/messages/delete/{msgId}', 'MessageController@deleteMessage');

    /*####################NewsController###############################*/
    Route::get('college/news', 'NewsController@getNewsItemsWithShortDescription');

    Route::get('college/news/{newsId}', 'NewsController@retrieveNewsItem');

    Route::post('college/news/add', 'NewsController@createNews');

    Route::post('college/news/delete/{newsId}', 'NewsController@deleteNews');

    Route::post('college/news/edit/{newsId}', 'NewsController@editNews');

    /*####################EventController###############################*/

    Route::get('college/events', 'EventsController@retrieveShortEventDesc');

    Route::get('college/events/{eventId}', 'EventsController@retrieveEventItem');

    Route::post('college/events/add', 'EventsController@createEvent');

    Route::post('college/events/delete/{eventId}', 'EventsController@deleteEvent');

    Route::post('college/events/edit/{eventId}', 'EventsController@editEvent');

    /*####################AdminController###############################*/
    //Yet to be implemented

    Route::get('college/user/features/{userId}', 'AdminController@retrieveRoleBasedFeatures');

    /*####################ModuleController###############################*/

    Route::get('college/modules/{collegeId}', 'ModuleController@retrieveAccessibleModulesList');

    /*####################CollegeController###############################*/

    Route::post('college/user/register', 'CollegeController@registerCollege');

    /*####################DepartmentController###############################*/

    Route::post('college/create/department', 'DepartmentController@createDepartment');

    /*####################PushDeviceRegController###############################*/
    Route::post('users/registerDeviceForPush', 'AccessTokenController@registerDeviceId');



});

//Route::post('auth/register', 'UserController@postRegister');

Route::post('register/college', 'UserController@postRegister');
