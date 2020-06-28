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

Route::get('/', function () {
  return view('welcome');
});

Route::get('/get_due', function () {
  // $date = now();
  // $date = Carbon::parse($date);

  // return $date->addWeekdays(3);

  // $assignment = Assignment::where('due_date', '<=', now())->where('due_date', '!=', null)->update(['due' => 1]);

  $assign = Assignment::get()->last();;
  $last_ref_no = explode('-', $assign->ref_no);

  $next_ref_no = ($last_ref_no[0] === date('y')) ? $last_ref_no[0] . '-' . str_pad(($last_ref_no[1] + 1), 5, '0', STR_PAD_LEFT) : date('y') . '-' . str_pad(1, 5, '0', STR_PAD_LEFT);
  return $next_ref_no;
});
