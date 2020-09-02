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
Route::post('/register', 'Auth\RegisterController@create');

Route::middleware('auth:api')->group(function () {
	Route::post('/logout', 'Auth\LogoutController@logout');
});

Route::apiResource('/users', 'API\UserController');

Route::apiResource('adjuster', 'API\AdjusterController');
Route::apiResource('assignment', 'API\AssignmentController');
Route::apiResource('brokers', 'API\BrokerController');
Route::apiResource('insurer', 'API\InsurerController');
Route::apiResource('policy', 'API\PolicyController');
Route::apiResource('receiving', 'API\ReceivingController');
Route::apiResource('status_lists', 'API\StatusListController');
Route::apiResource('report_lists', 'API\ReportListController');
Route::apiResource('user_levels', 'API\UserLevelController');


Route::get('/assignment/edit/{assignment}', 'API\AssignmentController@edit');

Route::get('/filtered_assignments_count', 'API\AssignmentController@filtered_assignments_count');

Route::get('/generate_report', 'API\GenerateAssignmentReportController@index');
Route::get('/export_report', 'API\GenerateAssignmentReportController@export');

Route::get('/graphs/cases_per_adjuster', 'API\CasesPerAdjusterReportsController@index');

Route::patch('/update_assignment_status/{assignment}', 'API\AssignmentController@update_assignment_status');

Route::get('/db_bckp', 'API\BackUpController@index');
Route::get('/create_bckp', 'API\BackUpController@create');
Route::get('/download_db_bckp/{file_name}', 'API\BackUpController@download_db_backup');
Route::get('/delete_bckp/{file_name}', 'API\BackUpController@destroy');
