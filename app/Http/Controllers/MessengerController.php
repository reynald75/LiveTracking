<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\GpsPoint;
use App\Models\Messenger;
use App\Models\PilotInFlight;

class MessengerController extends Controller
{
    public function callFeeds(){
        $messengers = Messenger::all();

        foreach ($messengers as $messenger) {
            $api_endpoint = '';
            $api_feed_params = '';
            switch ($messenger->mfr) {
                case 'SPOT':
                    //$api_endpoint = 'https://api.findmespot.com/spot-main-web/consumer/rest-api/2.0/public/feed/';
                    $api_endpoint = 'http://127.0.0.1:9000/';
                    //$api_feed_params = '/message.json?startDate=$startDate&endDate=$endDate';
                    $api_feed_params = '/message.json';
                    break;
                
                default:
                    # code...
                    break;
            }

            $api_url = $api_endpoint . $messenger->feed_id . $api_feed_params;
            $data = json_decode(file_get_contents($api_url));

            $this->updateModels($messenger, $data);

            //sleep(3);
        }
    }

    public function updateModels(Messenger $messenger, $data){
        $user = $messenger->user()->first();
        $flight = null;
        if (!PilotInFlight::where('user_id', $user->id)->exists()) {
            $flight = Flight::create([
                'user_id' => $user->id,
                'start_time' => now(),
                'end_time' => null,
                'dist_FAI' => 0,
                'dist_SD' => 0,
                'dist_actual' => 0
            ]);
            PilotInFlight::create([
                'user_id' => $user->id,
                'flight_id' => $flight->id,
                'is_flying' => false,
                'sos' => false
            ]);
        } else {
            $flight = Flight::where('user_id', $user->id)->first();
        }

        $newPointAdded = true;
        foreach ($data as $point) {
            if(!GpsPoint::where('time', date("Y-m-d\TH:i:s", $point->unixTime))->exists()){
                GpsPoint::create([
                    'flight_id' => $flight->id,
                    'lat' => $point->latitude,
                    'lon' => $point->longitude,
                    'alt' => $point->altitude,
                    'msg_type' => $point->messageType,
                    'msg_content' => $point->messageContent ?? "",
                    'msg_show' => ($point->showCustomMsg == "Y"),
                    'time' => date("Y-m-d\TH:i:s", $point->unixTime),
                ]);
                $newPointAdded = true;
            }
        }
        if ($newPointAdded) {
            FlightController::calculateDistances($flight);
        }
    }
}
