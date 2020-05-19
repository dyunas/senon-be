<?php

namespace App\Http\Controllers\API;

use App\Assignment;
use App\StatusList;
use App\AssignmentChangeLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssignmentCollection;
use Illuminate\Validation\ValidationException;

class AssignmentController extends Controller
{
  /**
   * Form validation rules.
   *
   * @return \Illuminate\Http\Response
   */
  protected function formValidator($request)
  {
    return $request->validate([
      'insurer'        => 'required|string|max:20',
      'broker'         => 'required|string|max:20',
      'ref_no'         => '',
      'name_insured'   => 'required|string|max:255',
      'adjuster'       => 'required|string|max:50',
      'third_party'    => 'string|max:50',
      'pol_no'         => 'alpha_dash|max:32',
      'pol_type'       => 'required|string|max:50',
      'risk_location'  => 'required|string',
      'nature_loss'    => 'required|string|max:50',
      'date_loss'      => 'required|date',
      'contact_person' => 'required|string',
      'loss_reserve'   => 'string',
      'status_list_id' => 'required|numeric',
      'remarks'        => 'string|nullable',
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
    $ref_no = '';
    $year = date('y');
    $last = $this->get_last_assignment_in_table();
    $ref_no = $year . '-' . str_pad(($last->id + 1), 5, '0', STR_PAD_LEFT);

    $this->formValidator($request);

    try {
      $assignment = Assignment::create([
        'date_assigned'  => now(),
        'insurer'        => $request->insurer,
        'broker'         => $request->broker,
        'ref_no'         => $ref_no,
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

      AssignmentChangeLog::create([
        'assignment_id' => $assignment->id,
        'log_message'   => 'Assignment created',
        'log_date'      => now()
      ]);

      return response()->json(["message" => "Assignment created successfully!"], 201);
    } catch (ValidationException $error) {
      return response()->json([
        'message' => 'Something went wrong while creating assignment. Please try again.',
        'error'   => $error->errors()
      ], $error->status);
    } catch (\Throwable $error) {
      return response()->json([
        'message' => 'Something went wrong while creating assignment. Please try again.',
        'error'   => $error->getMessage()
      ], 500);
    }
  }

  public function get_last_assignment_in_table()
  {
    // return last assignment in the table
    return Assignment::get()->last();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Assignment $assignment)
  {
    // return $assignment;
    return new AssignmentCollection($assignment);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Feed  $feed
   * @return \Illuminate\Http\Response
   */
  public function edit(Assignment $assignment)
  {
    // data of the assignment to be editted
    return $assignment;
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
    $request->validate([
      'data.insurer'        => 'required|string|max:20',
      'data.broker'         => 'required|string|max:20',
      'data.ref_no'         => 'required|alpha_dash|max:32',
      'data.name_insured'   => 'required|string|max:255',
      'data.adjuster'       => 'required|string|max:50',
      'data.third_party'    => 'string|max:50',
      'data.pol_no'         => 'alpha_dash|max:32',
      'data.pol_type'       => 'required|string|max:50',
      'data.risk_location'  => 'required|string',
      'data.nature_loss'    => 'required|string|max:50',
      'data.date_loss'      => 'required|date',
      'data.contact_person' => 'required|string',
      'data.loss_reserve'   => 'string',
      'data.status_list_id' => 'required|numeric',
      'data.remarks'        => 'string|nullable',
    ]);

    try {
      $assignment->update([
        'insurer'        => $request->data['insurer'],
        'broker'         => $request->data['broker'],
        'ref_no'         => $request->data['ref_no'],
        'name_insured'   => $request->data['name_insured'],
        'adjuster'       => $request->data['adjuster'],
        'third_party'    => $request->data['third_party'],
        'pol_no'         => $request->data['pol_no'],
        'pol_type'       => $request->data['pol_type'],
        'risk_location'  => $request->data['risk_location'],
        'nature_loss'    => $request->data['nature_loss'],
        'date_loss'      => $request->data['date_loss'],
        'contact_person' => $request->data['contact_person'],
        'loss_reserve'   => $request->data['loss_reserve'],
        'status_list_id' => $request->data['status_list_id'],
        'remarks'        => $request->data['remarks'],
        'updated_by'     => $request->data['updated_by'],
      ]);

      return response()->json(["message" => "Assignment updated successfully!"], 201);
    } catch (ValidationException $error) {
      return response()->json([
        'message' => 'Something went wrong while updating assignment. Please try again.',
        'error'   => $error->errors()
      ], $error->status);
    } catch (\Throwable $error) {
      return response()->json([
        'message' => 'Something went wrong while updating assignment. Please try again.',
        'error'   => $error->getMessage()
      ], 500);
    }
  }

  public function update_assignment_status(Request $request, Assignment $assignment)
  {
    try {
      $assignment->update([
        'status_list_id' => $request->data['status_list_id']
      ]);

      $status = StatusList::where('id', $request->data['status_list_id'])->first();

      AssignmentChangeLog::create([
        'assignment_id' => $assignment->id,
        'log_message'   => 'Assignment status updated to ' . $status->status,
        'log_date'      => now()
      ]);

      return response()->json(["message" => "Assignment status updated to " . $status->status], 201);
    } catch (ValidationException $error) {
      return response()->json([
        'message' => 'Something went wrong while updating assignment status. Please try again.',
        'error'   => $error->errors()
      ], $error->status);
    } catch (\Throwable $error) {
      return response()->json([
        'message' => 'Something went wrong while updating assignment status. Please try again.',
        'error'   => $error->getMessage()
      ], 500);
    }
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
