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

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::post('/login', 'Auth\LoginController@login');

Route::middleware('auth:api')->group(function () {
  Route::post('/logout', 'Auth\LogoutController@logout');
});

// Assignment CRUD routes
Route::get('/assignments', 'AssignmentController@index');
Route::post('/assignments', 'AssignmentController@store');
Route::get('/assignments/{assignment}', 'AssignmentController@show');
Route::get('/assignments/{assignment}/edit', 'AssignmentController@edit');
Route::put('/assignments/{assignment}', 'AssignmentController@update');
