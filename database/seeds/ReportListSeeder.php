<?php

use App\ReportList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportListSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('report_lists')->delete();

    $lists = [
      ['report' => 'Letter Request', 'due_in_num_days' => '3', 'notification_msg' => 'Due for LR'],
      ['report' => '1st Follow up', 'due_in_num_days' => '15', 'notification_msg' => 'Due for 1st Follow Up'],
      ['report' => '2nd Follow up', 'due_in_num_days' => '15', 'notification_msg' => 'Due for 2nd Follow Up'],
      ['report' => '3rd Follow up', 'due_in_num_days' => '15', 'notification_msg' => 'Due for 3rd Follow Up'],
      ['report' => 'Ultimatum Letter', 'due_in_num_days' => '15', 'notification_msg' => 'Due for Ultimatum Letter'],
      ['report' => 'Ultimatum Lapse', 'due_in_num_days' => '15', 'notification_msg' => 'Due for Ultimatum Lapse'],
      ['report' => 'AOD-Incomplete', 'due_in_num_days' => '15', 'notification_msg' => 'Due for Follow Up'],
      ['report' => 'AOD-Complete', 'due_in_num_days' => '3', 'notification_msg' => 'Due for LVR'],
      ['report' => 'AR-NIL', 'due_in_num_days' => null, 'notification_msg' => null],
      ['report' => 'Loss Valuation Report', 'due_in_num_days' => null, 'notification_msg' => null],
      ['report' => 'Letter Offer', 'due_in_num_days' => null, 'notification_msg' => null],
      ['report' => 'Denial Offer', 'due_in_num_days' => null, 'notification_msg' => null],
      ['report' => 'Final Report', 'due_in_num_days' => null, 'notification_msg' => null],
    ];

    foreach ($lists as $list) {
      ReportList::create($list);
    }
  }
}
