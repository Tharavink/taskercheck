<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ServiceStatus;

class ServiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusses = [
            0 => ['status' => 'Active', 'cssClass' => 'bg-green-500 text-white'],
            1 => ['status' => 'Inactive', 'cssClass' => 'bg-gray-600 text-white']
        ];

        foreach ($statusses as $key => $status) {
            ServiceStatus::create($status);
        }
    }
}
