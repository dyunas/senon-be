<?php

namespace App\Http\Controllers\API;

use App\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssignmentCollection;

class AssignmentController extends Controller
{
  /**
   * Form validation rules.
   *
   * @return \Illuminate\Http\Response
   */
  private function formValidator($request)
  {
    return $request->validate([
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
      'loss_reserve'   => 'required|string',
      'status_list_id' => 'required|numeric',
      'remarks'        => 'string|nullable',
      'created_by'     => 'required|string',
      'updated_by'     => '',
      'date_assigned'  => '',
    ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return AssignmentCollection::collection(Assignment::orderBy('id', 'desc')->get());
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->formValidator($request);

    $create = Assignment::create([
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
      'status_list_id' => 1,
      'remarks'        => $request->remarks,
      'created_by'     => $request->created_by,
    ]);

    if (!$create) {
      return response()->json(["message" => "Failed to create assignment."], 500);
    }

    return response()->json(["message" => "Assignment created successfully!"], 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Assignment $assignment)
  {
    return AssignmentCollection::collection($assignment->all());
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Assignment $assignment)
  {
    $this->formValidator($request);

    $update = $assignment->update([
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
      'status_list_id' => $request->status_list_id,
      'remarks'        => $request->remarks,
      'created_by'     => $request->created_by,
      'updated_by'     => $request->updated_by,
    ]);

    if (!$update) {
      return response()->json(["message" => "Failed to update assignment."], 500);
    }

    return response()->json(["message" => "Assignment updated successfully!"], 201);
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
