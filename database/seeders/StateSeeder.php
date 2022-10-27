<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            'Penang', 'Selangor', 'Johor', 'Sabah', 'Sarawak', 'Perak', 'Kedah', 'Pahang', 'Kelantan', 'Terengganu',
            'Malacca', 'Negeri Sembilan', 'Perlis'
        ];

        foreach ($states as $key => $state) {
            State::create(['state' => $state]);
        }
    }
}
