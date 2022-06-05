<?php

namespace Database\Seeders;

use App\Models\Policy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolicySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('policies')->delete();

		$policies = [
			[
				'policy_type' => 'FIRE'
			],
			[
				'policy_type' => 'MARINE'
			],
			[
				'policy_type' => 'CAR'
			],
			[
				'policy_type' => 'GPL'
			],
		];

		/** create policy by reiterating through the policies array
		 * 
		 * @var = $policies
		 */
		foreach ($policies as $policy) {
			Policy::create($policy);
		}
	}
}