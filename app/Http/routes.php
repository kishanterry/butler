<?php
/**
 * Message Related Routes
 */
Route::group(['prefix' => 'messages'], function () {
    Route::get('search/users/{search_term?}', [
        'as' => 'search.users',
        'uses' => 'ConversationsController@searchUsers'
    ]);

    Route::get('all/{page?}', [
        'as' => 'messages.all',
        'uses' => 'ConversationsController@all'
    ]);

    Route::get('{conversation_id}', [
        'as' => 'messages.conversation',
        'uses' => 'ConversationsController@messages'
    ]);

    Route::post('/', [
        'as' => 'messages.send',
        'uses' => 'ConversationsController@send'
    ]);

    Route::get('/', [
        'as' => 'messages.index',
        'uses' => 'ConversationsController@index'
    ]);
});

/**
 * The API v1 Routes
 */
Route::group(['prefix' => 'api/v1'], function () {
    Route::post('publish', [
        'as' => 'apiv1.publish',
        'uses' => 'Api\v1\ApiController@publish'
    ]);
});

/**
 * Application Related Routes
 */
Route::group(['prefix' => 'apps'], function () {
    Route::get('all/{user_id?}', [
        'as' => 'apps.all',
        'uses' => 'AppsController@all',
    ]);

    Route::post('/', [
        'as' => 'apps.store',
        'uses' => 'AppsController@store',
    ]);

    Route::get('/', [
        'as' => 'apps.index',
        'uses' => 'AppsController@index',
    ]);
});

Route::group(['prefix' => 'doc'], function () {
    Route::get('/download/{what}', [
        'as' => 'doc.download',
        'uses' => 'DocumentationController@download'
    ]);

    Route::get('/', [
        'as' => 'doc.index',
        'uses' => 'DocumentationController@index'
    ]);
});

/**
 * The Application Dashboard
 */
Route::get('dashboard', [
    'as' => 'get_dashboard',
    'uses' => 'HomeController@getDashboard'
]);

/**
 * Laravel's Default Authentication Scaffolding
 */
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('/', function () {
    return redirect(route('get_dashboard'));
});

// Tinker
if (app()->environment() == 'local') {
    Route::get('tinker', 'TinkerController@index');
}

