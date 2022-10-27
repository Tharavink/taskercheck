<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\UserStatus;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusses = [
            0 => ['status' => 'Pending Verification', 'cssClass' => 'bg-yellow-500 text-white'],
            1 => ['status' => 'Active', 'cssClass' => 'bg-green-500 text-white'],
            2 => ['status' => 'Suspended', 'cssClass' => 'bg-red-500 text-white'],
        ];

        foreach ($statusses as $key => $status) {
            UserStatus::create($status);
        }
    }
}
