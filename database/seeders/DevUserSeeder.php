<?php

namespace Database\Seeders;

use App\Models\Messenger;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DevUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 3; $i++) {
            $user = User::create([
                'first_name' => 'Test',
                'last_name' => $i,
                'initials' => 'T' . $i,
                'email' => 'invalid' . $i . '@example.com',
                'password' => Hash::make('password'),
                'organization_id' => 1,
                'line_color' => $this->rand_color()
            ]);

            $user->assignRole('siteAdmin');

            Messenger::create([
                'user_id' => $user->id,
                'feed_id' => '0-' . $i,
                'name' => 'M' . $i,
                'model' => 'Test',
                'mfr' => 'SPOT',
                'batt_state' => 'GOOD'
            ]);
        }
    }

    function rand_color()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}
