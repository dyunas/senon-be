<?php

namespace App\Http\Controllers\API;

use App\Policy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class PolicyController extends Controller
{
  protected function formValidator($request)
  {
    return $request->validate(
      [
        'policy' => 'required|string',
      ],
      $messages = [
        'required' => 'The :attribute field is required.',
        'string'   => 'Must be of string value'
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
    return Policy::all();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      // validates the data
      $this->formValidator($request);

      // creates new record after data is validated
      Policy::create([
        'policy_type' => $request->policy
      ]);

      return response()->json(['message' => 'Policy added'], 201);
    } catch (ValidationException $error) {
      return response()->json([
        'message' => 'Something went wrong while adding policy. Please try again.',
        'error'   => $error->errors()
      ], $error->status);
    } catch (\Throwable $error) {
      return response()->json([
        'message' => 'Something went wrong while adding policy. Please try again.',
        'error'   => $error->getMessage()
      ], 500);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $policy
   * @return \Illuminate\Http\Response
   */
  public function show(Policy $policy)
  {
    return $policy;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Policy $policy)
  {
    try {
      // validates the data
      $request->validate(
        [
          'data.policy' => 'required|string'
        ],
        $message = [
          'required' => 'The :attribute field is required.',
          'string'   => 'Must be of string value'
        ]
      );


      // creates new record after data is validated
      $policy->update([
        'policy_type' => $request->data['policy']
      ]);

      return response()->json(['message' => 'Policy updated'], 201);
    } catch (ValidationException $error) {
      return response()->json([
        'message' => 'Something went wrong while updating Policy. Please try again.',
        'error'   => $error->errors()
      ], $error->status);
    } catch (\Throwable $error) {
      return response()->json([
        'message' => 'Something went wrong while updating Policy. Please try again.',
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
