<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->insert([
            'name' => 'Test Org',
            'ref_uuid' => 'd5e5622e-c856-46a0-a4cc-7484a827e549'
        ]);

        DB::table('users')->insert([
            'name' => 'Test User',
            'initials' => 'TU',
            'email' => 'invalid@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 1
        ]);

        DB::table('flights')->insert([
            'user_id' => 1,
            'start_time' => now(),
            'end_time' => null,
            'dist_FAI' => 0,
            'dist_SD' => 0,
            'dist_actual' => 0
        ]);

        DB::table('pilots_in_flight')->insert([
            'user_id' => 1,
            'flight_id' => 1,
            'is_flying' => true,
            'sos' => false
        ]);

        DB::table('messenger')->insert([
            'msg_id' => 0,
            'msg_name' => '',
            'msg_type' => '',
            'msg_model' => '',
            'msg_batt_state' => '',
        ]); 

        $this->call(GpsPointsSeeder::class);
    }
}
