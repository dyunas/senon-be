<?php

use App\Insurer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsurerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('insurers')->delete();

    $insurers = [
      [
        'insurer' => 'MALAYAN'
      ],
      [
        'insurer' => 'PRUDENTIAL'
      ],
      [
        'insurer' => 'UCPB'
      ],
      [
        'insurer' => 'CHARTER'
      ],
      [
        'insurer' => 'AIG'
      ],
      [
        'insurer' => 'MERCANTILE'
      ],
      [
        'insurer' => 'PIONEER'
      ],
      [
        'insurer' => 'APPRAISAL'
      ],
      [
        'insurer' => 'FPG'
      ],
      [
        'insurer' => 'ORIENTAL'
      ],
      [
        'insurer' => 'STANDARD'
      ],
      [
        'insurer' => 'ETIQA'
      ],
      [
        'insurer' => 'PHIL-FIRST'
      ],
      [
        'insurer' => 'MAA'
      ],
    ];

    /** creat insurer by reiterating through insurers array
     * 
     * @var = $insurers
     */
    foreach ($insurers as $insurer) {
      Insurer::create($insurer);
    }
  }
}
