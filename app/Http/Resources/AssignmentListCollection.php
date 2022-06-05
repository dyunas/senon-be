<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentListCollection extends JsonResource
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
			'ref_no'         => $this->ref_no,
			'insurer'        => $this->insurer,
			'broker'         => $this->broker,
			'adjuster'       => $this->adjuster,
			'name_insured'   => $this->name_insured,
			'nature_loss'		 => $this->nature_loss,
			'date_loss'      => $this->date_loss,
			'contact_person' => $this->contact_person,
			'contact_number' => $this->contact_number,
			'status'         => $this->status_list->status,
			'created_at'     => $this->created_at,
		];
	}
}