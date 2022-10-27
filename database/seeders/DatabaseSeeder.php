<?php

namespace Database\Seeders;

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
        $this->call([
            AdminSeeder::class,
            UserStatusSeeder::class,
            BusinessStatusSeeder::class,
            ServiceStatusSeeder::class,
            ServiceRequestStatusSeeder::class,
            StateSeeder::class,
            BankSeeder::class
        ]);
    }
}
