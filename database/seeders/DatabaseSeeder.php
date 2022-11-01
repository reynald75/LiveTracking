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
            'email' => 'invalid@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 1
        ]);
    }
}
