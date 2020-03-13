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
    // run UserLevelSeeder
    $this->call(UserLevelSeeder::class);
    $this->command->info('user levels seeding completed!');

    // run UserTableSeeder
    $this->call(UsersTableSeeder::class);
    $this->command->info('users seeding completed!');

    // run StatusListSeeder
    $this->call(StatusListSeeder::class);
    $this->command->info('status lists seeding completed!');

    // run AssignmentSeeder
    $this->call(AssignmentSeeder::class);
    $this->command->info('Assignments seeding completed!');

    // run AdjusterSeeder
    $this->call(AdjusterSeeder::class);
    $this->command->info('Adjusters seeding completed!');

    // run PolicySeeder
    $this->call(PolicySeeder::class);
    $this->command->info('Policy seeding completed!');

    // run InsurerSeeder
    $this->call(InsurerSeeder::class);
    $this->command->info('Insurer seeding completed!');

    // run BrokerSeeder
    $this->call(BrokerSeeder::class);
    $this->command->info('Broker seeding completed!');

    // run AssignmentChangeLogSeeder
    $this->call(AssignmentChangeLogSeeder::class);
    $this->command->info('Assignment change logs seeding completed!');
  }
}
