<?php

namespace App\Http\Controllers\API;

use App\Models\Assignment;
use App\Models\StatusList;
use App\Models\AssignmentChangeLog;
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
			'insurer'        => 'required|string',
			'broker'         => '',
			'ref_no'         => '',
			'name_insured'   => 'required|string',
			'adjuster'       => 'required|string',
			'third_party'    => '',
			'pol_no'         => '',
			'pol_type'       => 'required|string',
			'risk_location'  => 'required|string',
			'nature_loss'    => 'required|string',
			'date_loss'      => 'required',
			'contact_person' => '',
			'contact_number' => '',
			'loss_reserve'   => '',
			'status_list_id' => 'required|numeric',
			'status_of_adjustment' => '',
			'risk' 					 => '',
			'value_of_risk'  => '',
			'amount_of_insurance' => '',
			'recommended_payable' => '',
			'date_of_adjustment'   => '',
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
					WHEN insurer LIKE "%' . $filter . '%" THEN 1
					WHEN broker LIKE "%' . $filter . '%" THEN 1
					WHEN adjuster LIKE "%' . $filter . '%" THEN 1
					WHEN name_insured LIKE "%' . $filter . '%" THEN 1
					WHEN nature_loss LIKE "%' . $filter . '%" THEN 1
					WHEN date_loss LIKE "%' . $filter . '%" THEN 1
					WHEN contact_person LIKE "%' . $filter . '%" THEN 1
					WHEN contact_number LIKE "%' . $filter . '%" THEN 1
					ELSE 0
				END'
				)
					->take($fetchCount)
					->orderBy($sort, 'DESC')
					->get()
			);
		}

		return AssignmentListCollection::collection(
			Assignment::where('id', '>', $startRow)
				->take($fetchCount)
				->orderBy($sort, 'DESC')
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
							WHEN claim_no LIKE "%' . $filter . '%" THEN 1
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
				'claim_no'       => $request->claim_no,
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
				'status_of_adjustment' => $request->status_of_adjustment,
				'risk' 					 => $request->risk,
				'value_of_risk'  => $request->value_of_risk,
				'amount_of_insurance' => $request->amount_of_insurance,
				'recommended_payable' => $request->recommended_payable,
				'date_of_adjustment'   => $request->date_of_adjustment,
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
			'data.insurer'        => 'required|string',
			'data.broker'         => 'required|string',
			'data.ref_no'         => '',
			'data.claim_no'      => '',
			'data.name_insured'   => 'required|string',
			'data.adjuster'       => 'required|string',
			'data.third_party'    => '',
			'data.pol_no'         => '',
			'data.pol_type'       => 'required|string',
			'data.risk_location'  => 'required|string',
			'data.nature_loss'    => 'required|string',
			'data.date_loss'      => 'required',
			'data.contact_person' => '',
			'data.contact_number' => '',
			'data.loss_reserve'   => '',
			'data.status_of_adjustment' => '',
			'data.risk' 					 => '',
			'data.value_of_risk'  => '',
			'data.amount_of_insurance' => '',
			'data.recommended_payable' => '',
			'data.date_of_adjustment'   => '',
			'data.remarks'        => 'string|nullable',
		]);

		try {
			$assignment->update([
				'date_inspected' => $request->data['date_inspected'],
				'insurer'        => $request->data['insurer'],
				'broker'         => $request->data['broker'],
				'ref_no'         => $request->data['ref_no'],
				'claim_no'      => $request->data['claim_no'],
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
				'status_of_adjustment' => $request->data['status_of_adjustment'],
				'risk' 					 => $request->data['risk'],
				'value_of_risk'  => $request->data['value_of_risk'],
				'amount_of_insurance' => $request->data['amount_of_insurance'],
				'recommended_payable' => $request->data['recommended_payable'],
				'date_of_adjustment'  => $request->data['date_of_adjustment'],
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