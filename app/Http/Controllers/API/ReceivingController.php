<?php

namespace App\Http\Controllers\API;

use App\Receiving;
use App\Assignment;
use App\StatusList;
use App\AssignmentChangeLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReceivingsCollection;
use App\ReportList;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

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
				'attachment'       => 'max: 4096',
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
	public function index(Request $request)
	{
		return ReceivingsCollection::collection(Receiving::where('assignment_id', $request->assignment_id)->get());
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

		DB::beginTransaction();

		try {
			$receiving = Receiving::create([
				'assignment_id'       => $request->assignment_id,
				'status_list_id'      => $request->status_list_id,
				'report_submitted_id' => $request->report_submitted_id,
				'received_by'         => $request->received_by,
				'received_date'       => $request->received_date,
				'created_at'          => now()
			]);

			$due_in_num_days = ReportList::where('id', $request->report_submitted_id)->first()->due_in_num_days;
			
			$due_date = ($request->report_submitted_id <= 8) ? Carbon::now()->addWeekdays($due_in_num_days) : null;

			if ($request->attachment !== "null") $this->uploadFileAttachment($receiving); // if attachment has value then upload the file attachment

			$status = StatusList::where('id', $receiving->status_list_id)->first();

			AssignmentChangeLog::create([
				'assignment_id' => $receiving->assignment_id,
				'log_message'   => 'Assignment status updated to ' . $status->status,
				'log_date'      => now()
			]);

			Assignment::where('ref_no', $request->assignment_id)->update([
				'status_list_id' => $receiving->status_list_id,
				'due_date'			 => $due_date,
			]);

			DB::commit(); // commit changes into the database tables

			return response()->json(["message" => "Attachment created! Assignment status updated to " . $status->status], 201);
		} catch (ValidationException $error) {
			DB::rollback(); // rollback changes when exception is caught

			return response()->json([
				'message' => 'Something went wrong while creating attachment. Please try again.',
				'error'   => $error->errors()
			], $error->status);
		} catch (\Throwable $error) {
			DB::rollback(); // rollback changes when exception is caught

			return response()->json([
				'message' => 'Something went wrong while creating attachment. Please try again.',
				'error'   => $error->getMessage()
			], 500);
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
