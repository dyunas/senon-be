<?php

use App\AssignmentChangeLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentChangeLogSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('assignment_change_logs')->delete();

    AssignmentChangeLog::create([
      'assignment_id' => '19-8641',
      'log_message'   => 'Assignment created',
      'log_date'      => now()
    ]);
  }
}
