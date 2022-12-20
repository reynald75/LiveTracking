<?php

namespace Database\Seeders;

use App\Models\Messenger;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'first_name' => 'Romain',
            'last_name' => 'Binggeli',
            'initials' => 'RB',
            'email' => 'rb@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 1,
            'line_color' => '#FF0000'
        ]);

        $user2 = User::create([
            'first_name' => 'Martin',
            'last_name' => 'Müller',
            'initials' => 'MM',
            'email' => 'mm@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 1,
            'line_color' => '#00FF00'
        ]);

        $user3 = User::create([
            'first_name' => 'Reynald',
            'last_name' => 'Mumenthaler',
            'initials' => 'RM',
            'email' => 'rm@example.com',
            'password' => Hash::make('password'),
            'organization_id' => 1,
            'line_color' => '#0000FF'
        ]);

        $user1->assignRole('siteAdmin');
        $user2->assignRole('siteAdmin');
        $user3->assignRole('siteAdmin');

        if (app()->environment('local', 'staging')) {

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

                Messenger::create([
                    'user_id' => $user->id,
                    'feed_id' => '0-' . $i,
                    'name' => 'M' . $i,
                    'model' => 'Test',
                    'mfr' => 'SPOT',
                    'batt_state' => 'GOOD'
                ]);
            }
        } else {
            Messenger::create([
                'user_id' => 1,
                'feed_id' => '0qm3EuuaEbIKRzUvi2EJzYHn77YAMcLi5',
                'name' => '',
                'model' => '',
                'mfr' => 'SPOT',
                'batt_state' => '',
            ]);

            Messenger::create([
                'user_id' => 2,
                'feed_id' => '0fjDmqApjzhZBSjsUeXOHlmDBSZOfSGzd',
                'name' => '',
                'model' => '',
                'mfr' => 'SPOT',
                'batt_state' => '',
            ]);

            Messenger::create([
                'user_id' => 3,
                'feed_id' => '0I7evhLHt03RRZxv3gu1gqibM7aIdbm2i',
                'name' => '',
                'model' => '',
                'mfr' => 'SPOT',
                'batt_state' => '',
            ]);
        }
    }

    function rand_color()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}
