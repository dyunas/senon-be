<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
	/**
	 * The attributes that are not mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public function status_list()
	{
		return $this->belongsTo(StatusList::class);
	}

	public function receiving_copy()
	{
		return $this->hasMany(Receiving::class, 'assignment_id', 'ref_no');
	}

	public function change_logs()
	{
		return $this->hasMany(AssignmentChangeLog::class, 'assignment_id', 'ref_no');
	}
}