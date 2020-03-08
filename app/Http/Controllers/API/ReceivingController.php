<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Receiving;
use Illuminate\Http\Request;

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
        'attachment'    => 'required|image|mimes: jpeg|max: 4096',
        'received_by'   => 'required|string',
        'received_date' => 'required|string|max:20',
      ],
      $messages = [
        'require' => 'The :attribute field is required.',
        'mimes'   => 'Only .jpeg are allowed.'
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

    $receiving = Receiving::create([
      'assignment_id' => $request->assignment_id,
      'received_by'   => $request->received_by,
      'received_date' => $request->receibed_date
    ]);

    if (empty($receiving)) {
      return response()->json(['message' => 'Failed to create attachment. Please try again.'], 400);
    }

    $this->uploadFileAttachment($receiving);

    return response()->json(['message' => 'Attachment created!'], 201);
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
