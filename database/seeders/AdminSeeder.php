<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin', 
            'email' => 'admin@simplyhired.site', 
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('admin@123'), 
            'is_admin' => 1
        ]);
    }
}
