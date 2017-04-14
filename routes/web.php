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

$app->patch('task/{_id}', [
  'uses' => 'TaskController@update_tasks'
]);