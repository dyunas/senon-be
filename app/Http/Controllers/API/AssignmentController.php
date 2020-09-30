<?php

namespace App\Http\Controllers\API;

use App\Assignment;
use App\StatusList;
use App\AssignmentChangeLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssignmentCollection;
use App\Http\Resources\AssignmentListCollection;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

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
			'claim_num'      => '',
			'insurer'        => 'required|string|max:20',
			'broker'         => 'required|string|max:20',
			'ref_no'         => '',
			'name_insured'   => 'required|string|max:255',
			'adjuster'       => 'required|string|max:50',
			'third_party'    => '',
			'pol_no'         => '',
			'pol_type'       => 'required|string|max:50',
			'risk_location'  => 'required|string',
			'nature_loss'    => 'required|string|max:50',
			'date_loss'      => 'required',
			'contact_person' => '',
			'contact_number' => '',
			'loss_reserve'   => '',
			'status_list_id' => 'required|numeric',
			'remarks'        => 'string|nullable',
		]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$startRow   = (int) $request->startRow;
		$fetchCount = (int) $request->fetchCount;
		$sort    		= $request->sortBy;
		$filter			= $request->filterBy;

		if ($filter != 'undefined') {
			return AssignmentListCollection::collection(
				Assignment::whereRaw(
					'id > ' . $startRow . '
				AND
				CASE
					WHEN ref_no LIKE "%' . $filter . '%" THEN 1
					WHEN claim_num LIKE "%' . $filter . '%" THEN 1
					WHEN insurer LIKE "%' . $filter . '%" THEN 1
					WHEN broker LIKE "%' . $filter . '%" THEN 1
					WHEN adjuster LIKE "%' . $filter . '%" THEN 1
					WHEN name_insured LIKE "%' . $filter . '%" THEN 1
					ELSE 0
				END'
				)
					->take($fetchCount)
					->orderBy($sort)
					->get()
			);
		}

		return AssignmentListCollection::collection(
			Assignment::where('id', '>', $startRow)
				->take($fetchCount)
				->orderBy($sort)
				->get()
		);
	}

	/**
	 * Display filtered row count of the resource
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function filtered_assignments_count(Request $request)
	{
		$filter = $request->filter;

		if ($filter != 'undefined') {
			return DB::table('assignments')
				->selectRaw('COUNT(*) as count')
				->whereRaw(
					'(
						CASE
							WHEN ref_no LIKE "%' . $filter . '%" THEN 1
							WHEN claim_num LIKE "%' . $filter . '%" THEN 1
							WHEN insurer LIKE "%' . $filter . '%" THEN 1
							WHEN broker LIKE "%' . $filter . '%" THEN 1
							WHEN adjuster LIKE "%' . $filter . '%" THEN 1
							WHEN name_insured LIKE "%' . $filter . '%" THEN 1
							ELSE 0
						END
					)'
				)
				->get();
		}

		return DB::table('assignments')
			->selectRaw('COUNT(*) as count')
			->get();
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
		$last = Assignment::whereRaw('ref_no LIKE "%' . $year . '-%"')->orderBy('id', 'DESC')->first();

		if ($last) {
			$last_ref_no =	explode('-', $last->ref_no);
			$next_ref_no = $last_ref_no[0] . '-' . str_pad(($last_ref_no[1] + 1), 5, '0', STR_PAD_LEFT);
		} else {
			$next_ref_no = date('y') . '-' . str_pad(1, 5, '0', STR_PAD_LEFT);
		}

		$this->formValidator($request);

		DB::beginTransaction();

		try {
			$assignment = Assignment::create([
				'date_assigned'  => now(),
				'date_inspected' => $request->date_inspected,
				'insurer'        => $request->insurer,
				'broker'         => $request->broker,
				'ref_no'         => $next_ref_no,
				'claim_num'      => $request->claim_num,
				'name_insured'   => $request->name_insured,
				'adjuster'       => $request->adjuster,
				'third_party'    => $request->third_party,
				'pol_no'         => $request->pol_no,
				'pol_type'       => $request->pol_type,
				'risk_location'  => $request->risk_location,
				'nature_loss'    => $request->nature_loss,
				'date_loss'      => $request->date_loss,
				'contact_person' => $request->contact_person,
				'contact_number' => $request->contact_number,
				'loss_reserve'   => $request->loss_reserve,
				'status_list_id' => 1,
				'remarks'        => $request->remarks,
				'created_by'     => $request->created_by,
			]);

			AssignmentChangeLog::create([
				'assignment_id' => $assignment->ref_no,
				'log_message'   => 'Assignment created',
				'log_date'      => now()
			]);

			DB::commit(); // commit changes into the database tables

			return response()->json(["message" => "Assignment created successfully!"], 201);
		} catch (ValidationException $error) {
			DB::rollback(); // rollback changes when exception is caught

			return response()->json([
				'message' => 'Something went wrong while creating assignment. Please try again.',
				'error'   => $error->errors()
			], $error->status);
		} catch (\Throwable $error) {
			DB::rollback(); // rollback changes when exception is caught

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
		return AssignmentCollection::collection($assignment);
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
		return new AssignmentCollection($assignment);
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
			'data.ref_no'         => '',
			'data.claim_num'      => '',
			'data.name_insured'   => 'required|string|max:255',
			'data.adjuster'       => 'required|string|max:50',
			'data.third_party'    => '',
			'data.pol_no'         => '',
			'data.pol_type'       => 'required|string|max:50',
			'data.risk_location'  => 'required|string',
			'data.nature_loss'    => 'required|string|max:50',
			'data.date_loss'      => 'required',
			'data.contact_person' => '',
			'data.contact_number' => '',
			'data.loss_reserve'   => '',
			'data.status_list_id' => 'required|numeric',
			'data.remarks'        => 'string|nullable',
		]);

		try {
			$assignment->update([
				'date_inspected' => $request->data['date_inspected'],
				'insurer'        => $request->data['insurer'],
				'broker'         => $request->data['broker'],
				'ref_no'         => $request->data['ref_no'],
				'claim_num'      => $request->data['claim_num'],
				'name_insured'   => $request->data['name_insured'],
				'adjuster'       => $request->data['adjuster'],
				'third_party'    => $request->data['third_party'],
				'pol_no'         => $request->data['pol_no'],
				'pol_type'       => $request->data['pol_type'],
				'risk_location'  => $request->data['risk_location'],
				'nature_loss'    => $request->data['nature_loss'],
				'date_loss'      => $request->data['date_loss'],
				'contact_person' => $request->data['contact_person'],
				'contact_number' => $request->data['contact_number'],
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
		DB::beginTransaction();

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

			DB::commit(); // commit changes into the database tables

			return $status->status;
		} catch (ValidationException $error) {
			DB::rollback(); // rollback changes when exception is caught

			return response()->json([
				'message' => 'Something went wrong while updating assignment status. Please try again.',
				'error'   => $error->errors()
			], $error->status);
		} catch (\Throwable $error) {
			DB::rollback(); // rollback changes when exception is caught

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
