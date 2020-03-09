<?php

namespace App\Http\Controllers\API;

use stdClass;
use App\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CasesPerAdjusterReportsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return DB::select('
      SELECT a.adjuster,
        (
          SELECT COALESCE(COUNT(b.id), 0) 
          FROM assignments b 
          WHERE b.adjuster = a.adjuster 
          AND b.status_list_id != 11
        ) as active,
        (
          SELECT COALESCE(COUNT(c.id), 0)
          FROM assignments c
          WHERE c.adjuster = a.adjuster
          AND c.status_list_id = 11
        ) as completed
      FROM adjusters a
    ');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
