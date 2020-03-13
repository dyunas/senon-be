<?php

use App\StatusList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusListSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('status_lists')->delete();

    $lists = [
      ['status' => 'For inspection'],
      ['status' => 'Inspected for Reporting'],
      ['status' => 'Awaiting Documents'],
      ['status' => 'Under evaluation'],
      ['status' => 'Awaiting Insurer\'s Position'],
      ['status' => 'Awaiting Insurer\'s Approval'],
      ['status' => 'Awaiting Insured\'s Acceptance of Offer'],
      ['status' => 'Awaiting Insured\'s Reaction'],
      ['status' => 'Closed'],
    ];

    foreach ($lists as $list) {
      StatusList::create($list);
    }
  }
}
