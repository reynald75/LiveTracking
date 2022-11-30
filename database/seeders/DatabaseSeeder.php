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
            'email' => 'invalid@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 1,
            'line_color' => '#FF0000'
        ]);

        DB::table('messengers')->insert([
            'user_id' => 1,
            'feed_id' => '0-1234567',
            'name' => '',
            'model' => '',
            'mfr' => 'SPOT',
            'batt_state' => '',
        ]); 

        for ($i=0; $i < 5; $i++) { 

            DB::table('users')->insert([
                'name' => 'Test ' . $i,
                'initials' => 'T' . $i,
                'email' => 'invalid' . $i . '@example.com',
                'password' => Hash::make('password'),
                'organization_id' => 1,
                'line_color' => $this->rand_color()
            ]);
    
            DB::table('messengers')->insert([
                'user_id' => $i + 2,
                'feed_id' => '0-' . $i,
                'name' => '',
                'model' => '',
                'mfr' => 'SPOT',
                'batt_state' => '',
            ]); 
        }
    }

    function rand_color() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}
