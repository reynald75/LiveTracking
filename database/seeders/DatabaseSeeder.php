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
            'name' => 'Romain Binggeli',
            'initials' => 'RB',
            'email' => 'invalid1@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 1,
            'line_color' => '#FF0000'
        ]);

        /*DB::table('users')->insert([
            'name' => 'Test User 2',
            'initials' => 'TU2',
            'email' => 'invalid2@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 1,
            'line_color' => '#0000FF'
        ]);

        DB::table('flights')->insert([
            'user_id' => 1,
            'start_time' => now(),
            'end_time' => null,
            'dist_FAI' => 0,
            'dist_SD' => 0,
            'dist_actual' => 0
        ]);

        DB::table('flights')->insert([
            'user_id' => 2,
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

        DB::table('pilots_in_flight')->insert([
            'user_id' => 2,
            'flight_id' => 2,
            'is_flying' => true,
            'sos' => false
        ]);*/

        DB::table('messengers')->insert([
            'user_id' => 1,
            'feed_id' => '0-1234567',
            'name' => '',
            'model' => '',
            'mfr' => 'SPOT',
            'batt_state' => '',
        ]); 

        //$this->call(GpsPointsSeeder::class);
    }
}
