<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Broker;
use App\Models\Insurer;
use App\Models\Adjuster;
use App\Models\Assignment;
use App\Exports\AssignmentsExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\GeneratedAssignmentReportCollection;

class GenerateAssignmentReportController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$params = array(
			'selection' 	=> $request->selection, // selection: adjuster, broker, insurer or quarterly
			'value' 			=> $request->value // value depends on selection
		);

		if ($params['selection'] == 'quarterly') {
			return $this->quaterlyReport($params['value']); // generate quarterly report
		}

		return $this->perSelectionReport($params['value']); // generate per selection report (adjuster, broker and insurer)
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function quarterlyReport($value)
	{
		try {
			$result = array();

			switch ($value) {
				case 'first_quarter':
					//
					break;

				case 'second_quarter':
					//
					break;

				case 'third_quarter':
					//
					break;

				case 'fourth_quarter':
					//
					break;

				default:
					break;
			}

			return json_encode($result);
		} catch (\Throwable $error) {
			return response()->json([
				'message' => 'Something went wrong while generating report. Please try again.',
				'error'   => $error->getMessage()
			], 500);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function perSelectionReport($value)
	{
		try {
			$result = array();

			$result['active'] = GeneratedAssignmentReportCollection::collection(
				Assignment::selectRaw('date_assigned, date_inspected, ref_no, claim_num, insurer, broker, adjuster, name_insured, third_party, pol_no, pol_type, risk_location, nature_loss, date_loss, loss_reserve, status_list_id')
					->whereRaw(
						'status_list_id < 11
						AND
						CASE
							WHEN insurer = "' . $value . '" THEN 1
							WHEN broker = "' . $value . '" THEN 1
							WHEN adjuster = "' . $value . '" THEN 1
							ELSE 0
						END'
					)->get()
			);

			$result['closed'] = GeneratedAssignmentReportCollection::collection(
				Assignment::selectRaw('date_assigned, date_inspected, ref_no, claim_num, insurer, broker, adjuster, name_insured, third_party, pol_no, pol_type, risk_location, nature_loss, date_loss, loss_reserve, status_list_id')
					->whereRaw(
						'status_list_id = 11
						AND
						CASE
							WHEN insurer = "' . $value . '" THEN 1
							WHEN broker = "' . $value . '" THEN 1
							WHEN adjuster = "' . $value . '" THEN 1
							ELSE 0
						END'
					)->get()
			);

			return json_encode($result);
		} catch (\Throwable $error) {
			return response()->json([
				'message' => 'Something went wrong while generating report. Please try again.',
				'error'   => $error->getMessage()
			], 500);
		}
	}

	public function selection_options(Request $request)
	{
		$selection = $request->selection;

		switch ($selection) {
			case 'adjuster':
				return Adjuster::select('adjuster')->get();
				break;

			case 'broker':
				return Broker::select('broker')->get();
				break;

			case 'insurer':
				return Insurer::select('insurer')->get();
				break;

			default:
				# code...
				break;
		}
	}

	/**
	 * Export a listing of the resource as .xlsx file.
	 */
	public function export(Request $request)
	{
		$params = array(
			'selection' 	=> $request->selection, // selection: adjuster, broker, insurer or quarterly
			'value' 			=> $request->value // value depends on selection
		);

		$filename = $params['selection'] . ' - ' . $params['value'] . '-' . Carbon::now()->format('Ymd') . '.xlsx';

		return (new AssignmentsExport($params))->download($filename);
	}
}