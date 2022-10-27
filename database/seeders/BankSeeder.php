<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            'AFFIN BANK BERHAD',
            'ALLIANCE BANK MALAYSIA BERHAD',
            'AMBANK',
            'BANK ISLAM MALAYSIA BERHAD',
            'BANK KERJASAMA RAKYAT MALAYSIA BERHAD',
            'BANK SIMPANAN NASIONAL BERHAD',
            'CITIBANK BERHAD',
            'HONG LEONG BANK',
            'HSBC BANK MALAYSIA BERHAD',
            'J.P. MORGAN CHASE BANK BERHAD',
            'CIMB BANK BERHAD',
            'MAYBANK',
            'OCBC BANK (MALAYSIA) BERHAD',
            'PUBLIC BANK BERHAD',
            'RHB BANK',
            'STANDARD CHARTERED BANK MALAYSIA BERHAD',
            'UNITED OVERSEAS BANK BERHAD'
        ];

        foreach ($banks as $key => $bank) {
            Bank::create(['name' => $bank]);
        }
    }
}
