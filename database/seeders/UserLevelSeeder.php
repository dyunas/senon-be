<?php

namespace Database\Seeders;

use App\Models\UserLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserLevelSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('user_levels')->delete();

		$levels = [
			['user_level' => 'Admin'],
			['user_level' => 'User']
		];

		foreach ($levels as $level) {
			UserLevel::create($level);
		}
	}
}