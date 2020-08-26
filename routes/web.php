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

use Carbon\Carbon;
use App\Assignment;
use App\ReportList;
use App\Http\Resources\AssignmentDues;

Route::get('/', function () {
	return view('welcome');
});

Route::get('/get_due', function () {
	$date = now();
	$date = Carbon::parse($date);

	$count = Assignment::where('due_date', '<=', now())->where('due_date', '!=', null)->update([
		'due' => 1
	]);

	$emails = array('jonathan.quebral0627@gmail.com', 'liza@senonadjuster.com');

	if ($count > 0) {
		$dues = AssignmentDues::collection(Assignment::where('due', 1)->get());

		// return $dues;
		return new App\Mail\AssignmentDue($dues);
	}
});
