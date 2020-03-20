<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportList extends Model
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


  public function receivings()
  {
    return $this->hasMany(Receiving::class);
  }
}
