<?php

namespace App\Exports\Sheets;

use Carbon\Carbon;
use App\Assignment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssignmentsPerCaseSheet implements FromView, ShouldQueue, ShouldAutoSize, WithTitle, WithStyles
{
	private $case;
	private $params;

	public function __construct(array $params, int $case)
	{
		$this->case = $case;
		$this->params = $params;
	}

	public function view(): View
	{
		switch ($this->params['selection']) {
			case 'adjuster':
				return $this->adjuster();
				break;

			case 'broker':
				return $this->broker();
				break;

			case 'insurer':
				return $this->insurer();
				break;

			default:
				break;
		}
	}

	/**
	 * @return string
	 */
	public function title(): string
	{
		return ($this->case == 1) ? 'Active Cases' : 'Closed Cases';
	}

	public function styles(Worksheet $sheet)
	{
		$headerStyleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['rgb' => '000000'],
				],
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'color' => ['rgb' => '0099CC'],
			],
			'font' => [
				'bold' => TRUE,
			]
		];

		$contentStyleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['rgb' => '000000'],
				],
			],
		];

		$sheet->getStyle('A1:A2')->applyFromArray($headerStyleArray);
		$sheet->getStyle('A5:O5')->applyFromArray($headerStyleArray);
		$sheet->getStyle('B1:B2')->applyFromArray($contentStyleArray);
	}

	public function adjuster()
	{
		if ($this->case == 1) {
			return view('exports.adjuster', [
				'assignments' => Assignment::where('adjuster', $this->params['value'])->where('status_list_id', '<', 11)->get(),
				'adjuster'		=> $this->params['value'],
				'export_date' => Carbon::now()->format('M d, Y')
			]);
		}

		return view('exports.adjuster', [
			'assignments' => Assignment::where('adjuster', $this->params['value'])->where('status_list_id', '=', 11)->get(),
			'adjuster'		=> $this->params['value'],
			'export_date' => Carbon::now()->format('M d, Y')
		]);
	}

	public function broker()
	{
		if ($this->case == 1) {
			return view('exports.broker', [
				'assignments' => Assignment::where('broker', $this->params['value'])->where('status_list_id', '<', 11)->get(),
				'broker'		=> $this->params['value'],
				'export_date' => Carbon::now()->format('M d, Y')
			]);
		}

		return view('exports.broker', [
			'assignments' => Assignment::where('broker', $this->params['value'])->where('status_list_id', '=', 11)->get(),
			'broker'		=> $this->params['value'],
			'export_date' => Carbon::now()->format('M d, Y')
		]);
	}

	public function insurer()
	{
		if ($this->case == 1) {
			return view('exports.insurer', [
				'assignments' => Assignment::where('insurer', $this->params['value'])->where('status_list_id', '<', 11)->get(),
				'insurer'		=> $this->params['value'],
				'export_date' => Carbon::now()->format('M d, Y')
			]);
		}

		return view('exports.insurer', [
			'assignments' => Assignment::where('insurer', $this->params['value'])->where('status_list_id', '=', 11)->get(),
			'insurer'		=> $this->params['value'],
			'export_date' => Carbon::now()->format('M d, Y')
		]);
	}
}
