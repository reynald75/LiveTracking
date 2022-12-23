<?php

namespace Database\Seeders;

use App\Models\Messenger;
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

        $users = [
            (object) [
                'first_name' => 'Romain',
                'last_name' => 'Binggeli',
                'initials' => 'RB',
                'email' => 'rb@example.com',
                'feed_id' => '0qm3EuuaEbIKRzUvi2EJzYHn77YAMcLi5',
                'role' => 'siteAdmin'
            ],
            (object) [
                'first_name' => 'Martin',
                'last_name' => 'Müller',
                'initials' => 'MM',
                'email' => 'mm@example.com',
                'feed_id' => '0fjDmqApjzhZBSjsUeXOHlmDBSZOfSGzd',
                'role' => 'siteAdmin'
            ],
            (object) [
                'first_name' => 'Reynald',
                'last_name' => 'Mumenthaler',
                'initials' => 'RM',
                'email' => 'rm@example.com',
                'feed_id' => '0I7evhLHt03RRZxv3gu1gqibM7aIdbm2i',
                'role' => 'siteAdmin'
            ],
            (object) [
                'first_name' => 'Axel',
                'last_name' => '',
                'initials' => 'A1',
                'email' => 'a1@example.com',
                'feed_id' => '0Z7eRKM9rCcrima9ic2qqvNFjDjgf87fG',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Alan',
                'last_name' => '',
                'initials' => 'A2',
                'email' => 'a2@example.com',
                'feed_id' => '0Xt9612cBl2Qyflho7aO2Pa8bzHzcTugT',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Paul',
                'last_name' => '',
                'initials' => 'P1',
                'email' => 'p1@example.com',
                'feed_id' => '0zoYne4G1uMCxWlYtmoWVa21oQETsRENa',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Damien',
                'last_name' => '',
                'initials' => 'D',
                'email' => 'd@example.com',
                'feed_id' => '0Sqp9zyH3ZOfaWhPi4KeUd2GNfqTW43aG',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Jedi',
                'last_name' => '',
                'initials' => 'J1',
                'email' => 'j1@example.com',
                'feed_id' => '0u6Lf1qaMcGnAshKof1AKJu3N9fpFPbxK',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Stephane',
                'last_name' => '',
                'initials' => 'S1',
                'email' => 's1@example.com',
                'feed_id' => '0DqDbA7W8aYtYeog1KuYxWzxsGY9RDPOk',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Jose',
                'last_name' => '',
                'initials' => 'J2',
                'email' => 'j2@example.com',
                'feed_id' => '0nBdBHPY5ecq1R3DcavOBylPkcE9FzcdY',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Patrick',
                'last_name' => '',
                'initials' => 'P2',
                'email' => 'p2@example.com',
                'feed_id' => '0exLUaY494ItFWhB9GGqgFH7xIUaBJ0AX',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Sebastian',
                'last_name' => '',
                'initials' => 'S2',
                'email' => 's2@example.com',
                'feed_id' => '0J6GDsRMyPHggJiQZgIMkJ5VqoCNCtu6o',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Colin',
                'last_name' => '',
                'initials' => 'C1',
                'email' => 'c1@example.com',
                'feed_id' => '0RKUQmnYcUhGflhlrrsm9jthBJo2WjNOq',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Gerald',
                'last_name' => '',
                'initials' => 'G1',
                'email' => 'g1@example.com',
                'feed_id' => '0RIzKreNFXTbzMKu27phCpZYiRCumqgtR',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Stefanie',
                'last_name' => '',
                'initials' => 'S3',
                'email' => 's3@example.com',
                'feed_id' => '0smxuLcDXXlQkR6Uzu2HcDvp7MmW7TCLc',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Ryan',
                'last_name' => '',
                'initials' => 'R',
                'email' => 'r@example.com',
                'feed_id' => '0XhukSgCEf8qqVlWui3vd1AgC4uqsXWMr',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Gilles',
                'last_name' => '',
                'initials' => 'G2',
                'email' => 'g2@example.com',
                'feed_id' => '0hAiGNOqiCJBrO00pihgqCgi21DnzEays',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Calina',
                'last_name' => '',
                'initials' => 'C2',
                'email' => 'c2@example.com',
                'feed_id' => '0D3D3Gdn4JqV4hEkp4TRiRoc02Hk5frJa',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Franco',
                'last_name' => '',
                'initials' => 'F',
                'email' => 'f@example.com',
                'feed_id' => '0Ejvlgbq6FODAqqQ2q1ANSdvMGeUczp59',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Yael',
                'last_name' => '',
                'initials' => 'Y',
                'email' => '@example.com',
                'feed_id' => '06nzc733u3mGUkCqNKM2PZMsqvFmSWQxs',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'PH',
                'last_name' => '',
                'initials' => 'PH',
                'email' => 'ph@example.com',
                'feed_id' => '0taTqoVWbU53AiJipF0HY1tREDdRN5iuQ',
                'role' => 'pilot'
            ],
            (object) [
                'first_name' => 'Piere',
                'last_name' => '',
                'initials' => 'P3',
                'email' => 'p3@example.com',
                'feed_id' => '09jZgRjaqWGSO5q9g7z6MYCE9myY3Fl3T',
                'role' => 'pilot'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'first_name' => $userData->first_name,
                'last_name' => $userData->last_name,
                'initials' => $userData->initials,
                'email' => $userData->email,
                'password' => Hash::make('password'),
                'organization_id' => 1,
                'line_color' => $this->rand_color()
            ]);

            $user->assignRole($userData->role);

            $messenger = Messenger::create([
                'user_id' => $user->id,
                'feed_id' => $userData->feed_id,
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
