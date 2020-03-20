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
      ['report' => 'Letter Request'],
      ['report' => '1st Follow up'],
      ['report' => '2nd Follow up'],
      ['report' => '3rd Follow up'],
      ['report' => '4th Follow up'],
      ['report' => 'Ultimatum Letter'],
      ['report' => 'Ultimatum Lapse'],
      ['report' => 'AOD-Incomplete'],
      ['report' => 'AOD-Complete'],
      ['report' => 'AR-NIL'],
      ['report' => 'Loss Valuation Report'],
      ['report' => 'Letter Offer'],
      ['report' => 'Denial Offer'],
      ['report' => 'Final Report'],
    ];

    foreach ($lists as $list) {
      ReportList::create($list);
    }
  }
}
