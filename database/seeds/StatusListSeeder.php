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
      ['status' => 'Awaiting Documents'],
      ['status' => 'Awaiting Insurer\'s position'],
      ['status' => 'Awaiting lacking documents'],
      ['status' => 'With 15 days ultimatum until'],
      ['status' => 'Awaiting Insured\'s/Broker reaction'],
      ['status' => 'Under evaluation'],
      ['status' => 'Awaiting Insurer\'s approval'],
      ['status' => 'Awaiting acceptance of offer'],
      ['status' => 'For closing'],
    ];

    foreach ($lists as $list) {
      StatusList::create($list);
    }
  }
}
