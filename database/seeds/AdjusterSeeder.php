<?php

use App\Adjuster;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdjusterSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('adjusters')->delete();

    $adjusters = [
      [
        'adjuster' => 'JGD'
      ],
      [
        'adjuster' => 'JMC'
      ],
      [
        'adjuster' => 'REC'
      ],
      [
        'adjuster' => 'VVP'
      ],
      [
        'adjuster' => 'JSS'
      ],
      [
        'adjuster' => 'JCD'
      ],
      [
        'adjuster' => 'CSR'
      ],
      [
        'adjuster' => 'JUM'
      ],
      [
        'adjuster' => 'RJD'
      ],
      [
        'adjuster' => 'DCC'
      ],
      [
        'adjuster' => 'RPT'
      ],
      [
        'adjuster' => 'FLD'
      ],
      [
        'adjuster' => 'EBS'
      ],
      [
        'adjuster' => 'KBD'
      ],
      [
        'adjuster' => 'RLE'
      ],
      [
        'adjuster' => 'JAL'
      ],
    ];

    /** create adjuster by reiterating through the adjusters array
     * 
     * @var = $adjusters
     */
    foreach ($adjusters as $adjuster) {
      Adjuster::create($adjuster);
    }
  }
}
