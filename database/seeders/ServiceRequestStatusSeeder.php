<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ServiceRequestStatus;

class ServiceRequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusses = [
            0 => ['status' => 'Requested by client', 'cssClass' => 'bg-orange-500 text-white'],
            1 => ['status' => 'Awaiting Payment', 'cssClass' => 'bg-teal-500 text-white'],
            2 => ['status' => 'Pending service', 'cssClass' => 'bg-yellow-500 text-white'],
            3 => ['status' => 'Service Completed', 'cssClass' => 'bg-green-500 text-white'],
            4 => ['status' => 'Servicer Paid', 'cssClass' => 'bg-green-500 text-white'],
            5 => ['status' => 'Rejected by servicer', 'cssClass' => 'bg-red-500 text-white'],
            6 => ['status' => 'Refund Requested', 'cssClass' => 'bg-yellow-500 text-white'],
            7 => ['status' => 'Refund Completed', 'cssClass' => 'bg-teal-500 text-white'],
            8 => ['status' => 'Cancelled by client', 'cssClass' => 'bg-gray-600 text-white']
        ];

        foreach ($statusses as $key => $status) {
            ServiceRequestStatus::create($status);
        }
    }
}
