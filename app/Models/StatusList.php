<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusList extends Model
{
	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	public function assignment()
	{
		return $this->hasMany(Assignment::class);
	}

	public function receiving()
	{
		return $this->hasMany(Receiving::class);
	}
}