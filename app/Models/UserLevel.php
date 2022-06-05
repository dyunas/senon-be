<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
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

	public function users()
	{
		return $this->hasMany(User::class);
	}
}