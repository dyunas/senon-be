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
    $this->command->info('user levels seeding completed!');

    $this->call(UsersTableSeeder::class);
    $this->command->info('users seeding completed!');

    $this->call(StatusListSeeder::class);
    $this->command->info('status lists seeding completed!');

    $this->call(AssignmentSeeder::class);
    $this->command->info('Assignments seeding completed!');
  }
}
