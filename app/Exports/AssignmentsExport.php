<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\AssignmentsPerCaseSheet;

class AssignmentsExport implements WithMultipleSheets
{
	use Exportable;

	protected $params;

	public function __construct(array $params)
	{
		$this->params = $params;
	}

	/**
	 * @return array
	 */
	public function sheets(): array
	{
		$sheets = [];

		for ($case = 1; $case <= 2; $case++) {
			$sheets[] = new AssignmentsPerCaseSheet($this->params, $case);
		}

		return $sheets;
	}
}
