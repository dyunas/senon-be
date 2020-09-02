<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Assignment;
use Illuminate\Http\Request;
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
		// code here..
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

	/**
	 * Export a listing of the resource as .xlsx file.
	 */
	public function export(Request $request)
	{
		$params = array(
			'selection' 	=> $request->selection, // selection: adjuster, broker, insurer or quarterly
			'value' 			=> $request->value // value depends on selection
		);

		$filename = $params['value'] . '-' . Carbon::now()->format('Ymd') . '.xlsx';

		return (new AssignmentsExport($params))->download($filename);
	}
}
