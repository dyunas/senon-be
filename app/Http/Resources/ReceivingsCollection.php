<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceivingsCollection extends JsonResource
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
      'id'            => $this->id,
      'attachment'    => $this->attachment,
      'report'        => $this->report_submitted->report,
      'status'        => $this->status_list->status,
      'received_by'   => $this->received_by,
      'received_date' => $this->received_date,
      'created_at'    => Carbon::createFromFormat('Y-m-d', $this->created_at),
    ];
  }
}
