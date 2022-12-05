<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organization::create([
            'name' => 'AlpsFreeRide',
            'ref_uuid' => 'd5e5622e-c856-46a0-a4cc-7484a827e549'
        ]);
        Organization::create([
            'name' => 'OtherOrg',
            'ref_uuid' => 'c8874188-5023-42d5-83bb-8059dbbac490'
        ]);
    }
}
