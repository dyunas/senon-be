<?php

namespace App\Http\Controllers\API;

use App\Models\Broker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class BrokerController extends Controller
{
	protected function formValidator($request)
	{
		return $request->validate(
			[
				'broker' => 'required|string',
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
		return Broker::all();
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
			Broker::create([
				'broker' => $request->broker
			]);

			return response()->json(['message' => 'Broker added'], 201);
		} catch (ValidationException $error) {
			return response()->json([
				'message' => 'Something went wrong while adding broker. Please try again.',
				'error'   => $error->errors()
			], $error->status);
		} catch (\Throwable $error) {
			return response()->json([
				'message' => 'Something went wrong while adding broker. Please try again.',
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
	public function show(Broker $broker)
	{
		return $broker;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $broker
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Broker $broker)
	{
		try {
			// validates the data
			$request->validate(
				[
					'data.broker' => 'required|string'
				],
				$message = [
					'required' => 'The :attribute field is required.',
					'string'   => 'Must be of string value'
				]
			);

			// updates the record after data is validated
			$broker->update([
				'broker' => $request->data['broker']
			]);

			return response()->json(['message' => 'Broker updated'], 201);
		} catch (ValidationException $error) {
			return response()->json([
				'message' => 'Something went wrong while updating broker. Please try again.',
				'error'   => $error->errors()
			], $error->status);
		} catch (\Throwable $error) {
			return response()->json([
				'message' => 'Something went wrong while updating broker. Please try again.',
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