<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'create']);

Route::middleware('auth:api')->group(function () {
	Route::post('/logout', [App\Http\Controllers\Auth\LogoutController::class, 'logout']);
});

Route::apiResource('/users', App\Http\Controllers\API\UserController::class);

Route::apiResource('adjuster', App\Http\Controllers\API\AdjusterController::class);
Route::apiResource('assignment', App\Http\Controllers\API\AssignmentController::class);
Route::apiResource('brokers', App\Http\Controllers\API\BrokerController::class);
Route::apiResource('insurer', App\Http\Controllers\API\InsurerController::class);
Route::apiResource('policy', App\Http\Controllers\API\PolicyController::class);
Route::apiResource('receiving', App\Http\Controllers\API\ReceivingController::class);
Route::apiResource('status_lists', App\Http\Controllers\API\StatusListController::class);
Route::apiResource('report_lists', App\Http\Controllers\API\ReportListController::class);
Route::apiResource('user_levels', App\Http\Controllers\API\UserLevelController::class);


Route::get('/assignment/edit/{assignment}', [App\Http\Controllers\API\AssignmentController::class, 'edit']);

Route::get('/filtered_assignments_count', [App\Http\Controllers\API\AssignmentController::class, 'filtered_assignments_count']);

Route::get('/selection_options', [App\Http\Controllers\API\GenerateAssignmentReportController::class, 'selection_options']);
Route::get('/generate_report', [App\Http\Controllers\API\GenerateAssignmentReportController::class, 'index']);
Route::get('/export_report', [App\Http\Controllers\API\GenerateAssignmentReportController::class, 'export']);

Route::get('/graphs/cases_per_adjuster', [App\Http\Controllers\API\CasesPerAdjusterReportsController::class, 'index']);

Route::patch('/update_assignment_status/{assignment}', [App\Http\Controllers\API\AssignmentController::class, 'update_assignment_status']);

Route::get('/db_bckp', [App\Http\Controllers\API\BackUpController::class, 'index']);
Route::get('/create_bckp', [App\Http\Controllers\API\BackUpController::class, 'create']);
Route::get('/download_db_bckp/{file_name}', [App\Http\Controllers\API\BackUpController::class, 'download_db_backup']);
Route::get('/delete_bckp/{file_name}', [App\Http\Controllers\API\BackUpController::class, 'destroy']);
