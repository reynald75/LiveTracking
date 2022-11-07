<?php

namespace Database\Seeders;

use App\Models\GpsPoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GpsPointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GpsPoint::create([
            'flight_id' => 1,
            'messenger_id' => 1,
            'lat' => 46.13004,
            'lon' => 6.17144,
            'alt' => 1268,
            'time' => date("Y-m-d\TH:i:s",1656515873)
        ]);
        GpsPoint::create([
            'flight_id' => 1,
            'messenger_id' => 1,
            'lat' => 46.13126,
            'lon' => 6.17002,
            'alt' => 1286,
            'time' => date("Y-m-d\TH:i:s",1656516070)
        ]);
        GpsPoint::create([
            'flight_id' => 1,
            'messenger_id' => 1,
            'lat' => 46.12568,
            'lon' => 6.16266,
            'alt' => 1400,
            'time' => date("Y-m-d\TH:i:s",1656516364)
        ]);
        GpsPoint::create([
            'flight_id' => 1,
            'messenger_id' => 1,
            'lat' => 46.12204,
            'lon' => 6.15882,
            'alt' => 1106,
            'time' => date("Y-m-d\TH:i:s",1656516665)
        ]);
        GpsPoint::create([
            'flight_id' => 1,
            'messenger_id' => 1,
            'lat' => 46.11579,
            'lon' => 6.15893,
            'alt' => 0,
            'time' => date("Y-m-d\TH:i:s",1656516964)
        ]);
        GpsPoint::create([
            'flight_id' => 1,
            'messenger_id' => 1,
            'lat' => 46.10622,
            'lon' => 6.15224,
            'alt' => -103,
            'time' => date("Y-m-d\TH:i:s",1656517264)
        ]);
        GpsPoint::create([
            'flight_id' => 1,
            'messenger_id' => 1,
            'lat' => 46.08231,
            'lon' => 6.17713,
            'alt' => 0,
            'time' => date("Y-m-d\TH:i:s",1656517556)
        ]);
    }
}
