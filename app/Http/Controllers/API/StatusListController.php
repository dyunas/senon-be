<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StatusList;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StatusListController extends Controller
{
	protected function formValidator($request)
	{
		return $request->validate(
			[
				'status' => 'required|string',
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
		return StatusList::all();
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
			StatusList::create([
				'status' => $request->status
			]);

			return response()->json(["message" => "Event status added"], 201);
		} catch (ValidationException $error) {
			return response()->json([
				"message" => "Something went wrong while adding event status. Please try again.",
				"error"   => $error->errors()
			], $error->status);
		} catch (\Throwable $error) {
			return response()->json([
				"message" => "Something went wrong while adding event status. Please try again.",
				"error"   => $error->getMessage()
			], 500);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\StatusList  $statusList
	 * @return \Illuminate\Http\Response
	 */
	public function show(StatusList $statusList)
	{
		return $statusList;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\StatusList  $statusList
	 * @return \Illuminate\Http\Response
	 */
	public function edit(StatusList $statusList)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\StatusList  $statusList
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, StatusList $statusList)
	{
		try {
			$request->validate(
				[
					'data.status' => 'required|string',
				],
				$messages = [
					'required' => 'The :attribute field is required.',
					'string'   => 'Must be of string value'
				]
			);

			$statusList->update([
				"status" => $request->data["status"]
			]);

			return response()->json(["message" => "Event status updated"], 201);
		} catch (ValidationException $error) {
			return response()->json([
				"message" => "Something went wrong while updating event status. Please try again",
				"error"   => $error->errors()
			], $error->status);
		} catch (\Throwable $error) {
			return response()->json([
				"message" => "Something went wrong while updating event status. Please try again",
				"error"   => $error->getMessage()
			], 500);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\StatusList  $statusList
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(StatusList $statusList)
	{
		//
	}
}