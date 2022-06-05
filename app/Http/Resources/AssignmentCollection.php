<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentCollection extends JsonResource
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
			'id'             => $this->id,
			'date_assigned'  => $this->date_assigned,
			'date_inspected' => $this->date_inspected,
			'insurer'        => $this->insurer,
			'broker'         => $this->broker,
			'claim_no'       => $this->claim_no,
			'ref_no'         => $this->ref_no,
			'name_insured'   => $this->name_insured,
			'adjuster'       => $this->adjuster,
			'third_party'    => $this->third_party,
			'pol_no'         => $this->pol_no,
			'pol_type'       => $this->pol_type,
			'risk_location'  => $this->risk_location,
			'nature_loss'    => $this->nature_loss,
			'date_loss'      => $this->date_loss,
			'contact_person' => $this->contact_person,
			'contact_number' => $this->contact_number,
			'loss_reserve'   => $this->loss_reserve,
			'status'         => $this->status_list->status,
			'status_of_adjustment' => $this->status_of_adjustment,
			'risk' 					 => $this->risk,
			'value_of_risk'  => $this->value_of_risk,
			'amount_of_insurance'  => $this->amount_of_insurance,
			'recommended_payable'  => $this->recommended_payable,
			'date_of_adjustment'  => $this->date_of_adjustment,
			'change_logs'    => $this->change_logs,
			'remarks'        => $this->remarks,
			'created_by'     => $this->created_by,
			'updated_by'     => $this->updated_by,
			'created_at'     => $this->created_at,
			'updated_at'     => $this->updated_at
		];
	}
}