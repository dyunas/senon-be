<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Adjuster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AdjusterController extends Controller
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
				'adjuster' => 'required|string',
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
		return Adjuster::all();
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

			// updates the record after data is validated
			Adjuster::create([
				'adjuster' => $request->adjuster
			]);

			return response()->json(['message' => 'Adjuster added'], 201);
		} catch (ValidationException $error) {
			return response()->json([
				'message' => 'Something went wrong while adding adjuster. Please try again.',
				'error'   => $error->errors()
			], $error->status);
		} catch (\Throwable $error) {
			return response()->json([
				'message' => 'Something went wrong while adding adjuster. Please try again.',
				'error'   => $error->getMessage()
			], 500);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Adjuster $adjuster)
	{
		return $adjuster;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $adjuster
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Adjuster $adjuster)
	{
		try {
			// validate the data
			$request->validate(
				[
					'data.adjuster' => 'required|string'
				],
				$message = [
					'required' => 'The :attribute field is required.',
					'string'   => 'Must be of string value'
				]
			);

			// updates record after data is validated
			$adjuster->update([
				'adjuster' => $request->data['adjuster']
			]);

			return response()->json(['message' => 'Adjuster updated'], 201);
		} catch (ValidationException $error) {
			return response()->json([
				'message' => 'Something went wrong while adding adjuster. Please try again.',
				'error'   => $error->errors()
			], $error->status);
		} catch (Exception $error) {
			return response()->json([
				'message' => 'Something went wrong while adding adjuster. Please try again.',
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