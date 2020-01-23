<?php

use App\Assignment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('assignments')->delete();

    Assignment::create(
      array(
        'date_assigned'  => now(),
        'insurer'        => 'Malayan',
        'broker'         => 'MARSH',
        'ref_no'         => '19-8641',
        'name_insured'   => 'Masterpiece Asia Property, Inc.',
        'adjuster'       => 'JMC',
        'third_party'    => 'H&M Store',
        'pol_no'         => '',
        'pol_type'       => 'CAR',
        'risk_location'  => 'Highway',
        'nature_loss'    => 'CAR',
        'date_loss'      => now(),
        'contact_person' => '',
        'loss_reserve'   => '2000.00',
        'status_list_id'         => 1,
        'remarks'        => '',
        'created_by'     => 'Jonathan Quebral',
        'updated_by'     => 'Jonathan Quebral'
      )
    );
  }
}
