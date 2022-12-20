<?php

namespace Database\Seeders;

use App\Models\Organization;
use DateTime;
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
        DB::table('updates')->insert([
            'id' => 'gps_update',
            'last_update_time' => date('Y-m-d\Th-m-s', 1)
        ]);

        $this->call(OrganizationSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
