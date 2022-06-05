<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListCollection extends JsonResource
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
			'name'					=> $this->name,
			'email'				  => $this->email,
			'user_level'    => $this->user_level->user_level,
			'created_at'    => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at),
			'updated_at'    => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)
		];
	}
}