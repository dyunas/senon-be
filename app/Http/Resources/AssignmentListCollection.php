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
      'insurer'        => $this->insurer,
      'broker'         => $this->broker,
      'ref_no'         => $this->ref_no,
      'name_insured'   => $this->name_insured,
      'adjuster'       => $this->adjuster,
      'date_loss'      => $this->date_loss,
      'status'         => $this->status_list->status,
      'remarks'        => $this->remarks,
      'created_at'     => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at),
    ];
  }
}
