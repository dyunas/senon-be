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

use App\Assignment;
use Carbon\Carbon;
use App\ReportList;

Route::get('/', function () {
	return view('welcome');
});

Route::get('/get_due', function () {
	$date = now();
	$date = Carbon::parse($date);

	$assignment = Assignment::where('due_date', '<=', now())->where('due_date', '!=', null)->update([
		'due' => 1
	]);

	return $assignment;
});

Route::get('/assignments', function () {
	$assignments = Assignment::where('due', 0);
	$dues = Assignment::where('due', 1)->union($assignments)->get();

	return $dues;
});
