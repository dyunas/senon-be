<?php

namespace App\Http\Controllers\API;

use App\Receiving;
use App\Assignment;
use App\StatusList;
use App\AssignmentChangeLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReceivingController extends Controller
{
  /**
   * Form validation rules.
   *
   * @return \Illuminate\Http\Response
   */
  protected function formValidator($request)
  {
    return $request->validate(
      [
        'attachment'       => 'required|max: 4096',
        'report_submitted' => 'required|string',
        'received_by'      => 'required|string',
        'received_date'    => 'required',
        'status_list_id'   => 'required',
        'created_at'       => ''
      ],
      $messages = [
        'required' => 'The :attribute field is required.',
      ]
    );
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Receiving::all();
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

    try {
      $receiving = Receiving::create([
        'assignment_id'    => $request->assignment_id,
        'status_list_id'   => $request->status_list_id,
        'report_submitted' => $request->report_submitted,
        'received_by'      => $request->received_by,
        'received_date'    => $request->received_date,
        'created_at'       => now()
      ]);

      $status = StatusList::where('id', $receiving->status_list_id)->first();

      AssignmentChangeLog::create([
        'assignment_id' => $receiving->assignment_id,
        'log_message'   => 'Assignment status updated to ' . $status->status,
        'log_date'      => now()
      ]);

      Assignment::where('id', $request->assignment_id)->update([
        'status_list_id' => $receiving->status_list_id
      ]);

      $this->uploadFileAttachment($receiving);

      return response()->json(["message" => "Attachment created! Assignment status updated to " . $status->status], 201);
    } catch (\Throwable $error) {
      return response()->json(["message" => "Failed to create attachment. Please try again.", "error" => $error], 500);
    }
  }

  public function uploadFileAttachment($receiving)
  {
    $receiving->update([
      'attachment' => request()->attachment->store('uploads', 'public')
    ]);
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
