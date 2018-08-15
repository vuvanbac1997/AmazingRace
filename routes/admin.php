<?php

\Route::group(['middleware' => ['admin.values']], function () {

    \Route::group(['middleware' => ['admin.guest']], function () {
        \Route::get('signin', 'Admin\AuthController@getSignIn');
        \Route::post('signin', 'Admin\AuthController@postSignIn');
        \Route::get('forgot-password', 'Admin\PasswordController@getForgotPassword');
        \Route::post('forgot-password', 'Admin\PasswordController@postForgotPassword');
        \Route::get('reset-password/{token}', 'Admin\PasswordController@getResetPassword');
        \Route::post('reset-password', 'Admin\PasswordController@postResetPassword');
    });

    \Route::group(['middleware' => ['admin.auth']], function () {

        \Route::group(['middleware' => ['admin.has_role.admin']], function () {
            \Route::resource('users', 'Admin\UserController');
            \Route::resource('user-notifications', 'Admin\UserNotificationController');
            \Route::resource('oauth-clients', 'Admin\OauthClientController');
            \Route::resource('logs', 'Admin\LogController');

        });

        \Route::group(['middleware' => ['admin.has_role.coach']], function () {
            \Route::resource('admin-users', 'Admin\AdminUserController');
            \Route::resource('admin-user-notifications', 'Admin\AdminUserNotificationController');
            \Route::get('load-notification/{offset}', 'Admin\AdminUserNotificationController@loadNotification');
        });

        \Route::get('/', 'Admin\IndexController@index');
        \Route::get('/me', 'Admin\MeController@index');
        \Route::put('/me', 'Admin\MeController@update');
        \Route::get('/me/notifications', 'Admin\MeController@notifications');

        \Route::post('signout', 'Admin\AuthController@postSignOut');
        \Route::resource('players', 'Admin\PlayerController');
        \Route::resource('teams', 'Admin\TeamController');
        \Route::resource('companies', 'Admin\CompanyController');
        \Route::resource('companies', 'Admin\CompanyController');
        /* NEW ADMIN RESOURCE ROUTE */

    });
});
