<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneratedAssignmentReportCollection extends JsonResource
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'date_assigned'  => $this->date_assigned,
			'date_inspected' => $this->date_inspected,
			'ref_no'         => $this->ref_no,
			'claim_num'      => $this->claim_num,
			'insurer'        => $this->insurer,
			'broker'         => $this->broker,
			'adjuster'       => $this->adjuster,
			'name_insured'   => $this->name_insured,
			'third_party'    => $this->third_party,
			'pol_no'         => $this->pol_no,
			'pol_type'       => $this->pol_type,
			'risk_location'  => $this->risk_location,
			'nature_loss'    => $this->nature_loss,
			'date_loss'      => $this->date_loss,
			'loss_reserve'   => $this->loss_reserve,
			'status'         => $this->status_list->status,
		];
	}
}
