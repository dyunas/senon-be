<?php

use App\Broker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrokerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('brokers')->delete();

    $brokers = [
      [
        'broker' => 'BDO'
      ],
      [
        'broker' => 'FUBON'
      ],
      [
        'broker' => 'MARSH'
      ],
      [
        'broker' => 'TRINITY'
      ],
      [
        'broker' => 'PL INSURANCE'
      ],
      [
        'broker' => 'UNIGUARANTEE'
      ],
      [
        'broker' => 'MGS'
      ],
      [
        'broker' => 'OMNI'
      ],
      [
        'broker' => 'JLT'
      ],
      [
        'broker' => 'LBP'
      ],
      [
        'broker' => 'NEW CANAAN'
      ],
      [
        'broker' => 'CEBUANA'
      ],
      [
        'broker' => 'CHINABANK'
      ],
      [
        'broker' => 'ANCHOR'
      ],
      [
        'broker' => 'PHILINSURE'
      ],
    ];

    /** create broker by reiterating through brokers array
     * 
     * @var = $brokers
     */
    foreach ($brokers as $broker) {
      Broker::create($broker);
    }
  }
}
