<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(UserLevelSeeder::class);
    $this->call(UsersTableSeeder::class);
    $this->call(AssignmentSeeder::class);

    $this->command->info('Database seeding complete!');
  }
}
