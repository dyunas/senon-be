<?php

namespace App\Http\Controllers\API;

use App\Insurer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class InsurerController extends Controller
{
  protected function formValidator($request)
  {
    return $request->validate(
      [
        'insurer' => 'required|string',
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
    return Insurer::all();
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
      Insurer::create([
        'insurer' => $request->insurer
      ]);

      return response()->json(['message' => 'Insurer added'], 201);
    } catch (ValidationException $error) {
      return response()->json([
        'message' => 'Something went wrong while adding insurer. Please try again.',
        'error'   => $error->errors()
      ], $error->status);
    } catch (\Throwable $error) {
      return response()->json([
        'message' => 'Something went wrong while adding insurer. Please try again.',
        'error'   => $error->getMessage()
      ], 500);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $insurer
   * @return \Illuminate\Http\Response
   */
  public function show(Insurer $insurer)
  {
    return $insurer;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $insurer
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Insurer $insurer)
  {
    try {
      // validates the data
      $request->validate(
        [
          'data.insurer' => 'required|string'
        ],
        $message = [
          'required' => 'The :attribute field is required.',
          'string'   => 'Must be of string value'
        ]
      );


      // creates new record after data is validated
      $insurer->update([
        'insurer' => $request->data['insurer']
      ]);

      return response()->json(['message' => 'Insurer updated'], 201);
    } catch (ValidationException $error) {
      return response()->json([
        'message' => 'Something went wrong while updating insurer. Please try again.',
        'error'   => $error->errors()
      ], $error->status);
    } catch (\Throwable $error) {
      return response()->json([
        'message' => 'Something went wrong while updating insurer. Please try again.',
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
