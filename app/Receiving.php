<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receiving extends Model
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
    return $this->belongsTo(Assignment::class, 'ref_no', 'assignment_id');
  }

  public function status_list()
  {
    return $this->belongsTo(StatusList::class);
  }

  public function report_submitted()
  {
    return $this->belongsTo(ReportList::class);
  }
}
