<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $app->get('/', [
//   'uses' => 'UserController@all'
// ]);

// Register user
$app->post('user', [
  'uses' => 'UserController@create_user'
]);

// Login to get token
$app->post('login', [
  'uses' => 'TokenController@login'
]);

$app->group(['middleware' => 'jwt'], function($app) {
  // Retrieve user
  $app->get('user/{_itsc}', [
    'uses' => 'UserController@get_user_by_id'
  ]);

  // Update user information
  $app->put('user', [
    'uses' => 'UserController@update_user'
  ]);

  // Delete user
  $app->delete('user', [
    'uses' => 'UserController@delete_user'
  ]);
  
  // Create task
  $app->post('task', [
    'uses' => 'TaskController@create_task'
  ]);

  $app->get('task', [
    'uses' => 'TaskController@get_tasks'
  ]);

  // Retrieve task by id
  $app->get('task/{_id}', [
    'uses' => 'TaskController@get_tasks_by_id'
  ]);

  $app->put('task/{_id}', [
    'uses' => 'TaskController@update_tasks'
  ]);
});