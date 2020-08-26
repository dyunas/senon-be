<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentDues extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'id'             => $this->id,
			'ref_no'         => $this->ref_no,
			'name_insured'   => $this->name_insured,
			'adjuster'       => $this->adjuster,
			'status'         => $this->status_list->status,
			'due_date'       => Carbon::createFromFormat('Y-m-d H:i:s', $this->due_date),
			'updated_at'     => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)
		];
	}
}
