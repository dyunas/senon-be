<?php

namespace App\Http\Controllers;

use App\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
  /**
   * Form validation rules.
   *
   * @return \Illuminate\Http\Response
   */
  private function validateRequest($request)
  {
    return $request->validate([
      'date_assigned'  => 'date|nullable',
      'insurer'        => 'required|string|max:20',
      'broker'         => 'required|string|max:20',
      'ref_no'         => 'required|alpha_dash|max:32',
      'name_insured'   => 'required|string|max:255',
      'adjuster'       => 'required|string|max:50',
      'third_party'    => 'required|string|max:50',
      'pol_no'         => 'required|alpha_dash|max:32',
      'pol_type'       => 'required|string|max:50',
      'risk_location'  => 'required|string',
      'nature_loss'    => 'required|string|max:50',
      'date_loss'      => 'required|date',
      'contact_person' => 'required|digits:11',
      'loss_reserve'   => 'required|numeric|between:0,999999999.99',
      'status'         => 'required|numeric',
      'remarks'        => 'string|nullable',
      'created_by'     => 'required|string',
      'updated_by'     => 'string|nullable'
    ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Assignment::all();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validateRequest($request);

    Assignment::create([
      'insurer'        => $request->insurer,
      'broker'         => $request->broker,
      'ref_no'         => $request->ref_no,
      'name_insured'   => $request->name_insured,
      'adjuster'       => $request->adjuster,
      'third_party'    => $request->third_party,
      'pol_no'         => $request->pol_no,
      'pol_type'       => $request->pol_type,
      'risk_location'  => $request->risk_location,
      'nature_loss'    => $request->nature_loss,
      'date_loss'      => $request->date_loss,
      'contact_person' => $request->contact_person,
      'loss_reserve'   => $request->loss_reserve,
      'status'         => $request->status,
      'remarks'        => $request->remarks,
      'created_by'     => $request->created_by,
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Assignment  $assignment
   * @return \Illuminate\Http\Response
   */
  public function show(Assignment $assignment)
  {
    return $assignment->all();
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Assignment  $assignment
   * @return \Illuminate\Http\Response
   */
  public function edit(Assignment $assignment)
  {
    return $assignment->all();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Assignment  $assignment
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Assignment $assignment)
  {
    $this->validateRequest($request);

    $assignment->update([
      'date_assigned'  => $request->date_assigned,
      'insurer'        => $request->insurer,
      'broker'         => $request->broker,
      'ref_no'         => $request->ref_no,
      'name_insured'   => $request->name_insured,
      'adjuster'       => $request->adjuster,
      'third_party'    => $request->third_party,
      'pol_no'         => $request->pol_no,
      'pol_type'       => $request->pol_type,
      'risk_location'  => $request->risk_location,
      'nature_loss'    => $request->nature_loss,
      'date_loss'      => $request->date_loss,
      'contact_person' => $request->contact_person,
      'loss_reserve'   => $request->loss_reserve,
      'status'         => $request->status,
      'remarks'        => $request->remarks,
      'created_by'     => $request->created_by,
      'updated_by'     => $request->updated_by,
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Assignment  $assignment
   * @return \Illuminate\Http\Response
   */
  public function destroy(Assignment $assignment)
  {
    //
  }
}
