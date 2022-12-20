<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\GpsPoint;
use App\Models\Messenger;
use App\Models\PilotInFlight;
use App\Http\Controllers\UpdateController;
use DateTime;

class MessengerController extends Controller
{
    public function callFeeds()
    {
        if (UpdateController::hasUpdateDelayExpired()) {

            UpdateController::setLastUpdateTime(now());

            $messengers = Messenger::all();

            foreach ($messengers as $messenger) {
                $api_endpoint = '';
                $api_feed_params = '';
                switch ($messenger->mfr) {
                    case 'SPOT':
                        if (app()->environment('local', 'staging')) {
                            $api_endpoint = 'http://127.0.0.1:9000/';
                        } else {
                            $api_endpoint = 'https://api.findmespot.com/spot-main-web/consumer/rest-api/2.0/public/feed/';
                        }

                        $date = now();

                        $startDate = date_format($date, 'Y-m-d\T00:00:00-0000');
                        $endDate = date_format($date, 'Y-m-d\T23:59:59-0000');
                        $api_feed_params = '/message.json?startDate=' . $startDate . '&endDate=' . $endDate;
                        break;

                    default:
                        break;
                }

                $api_url = $api_endpoint . $messenger->feed_id . $api_feed_params;
                $data = json_decode(file_get_contents($api_url));
                
                $this->updateModels($messenger, $data->response);

                if (!app()->environment('local', 'staging')) {
                    sleep(4);
                }
            }
        }
    }

    public function updateModels(Messenger $messenger, $response)
    {
        if (isset($response->feedMessageResponse)) {
            $data = $response->feedMessageResponse;
            if (isset($data->messages)) {
                $user = $messenger->user()->first();
                $flight = null;
                $dateTime = new DateTime();
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
                    $flightAttrs = [
                        ['user_id', '=', $user->id],
                        ['start_time', '>=', $dateTime->format("Y-m-d")]
                    ];
                    $flight = Flight::where($flightAttrs)->first();
                }
    
                $newPointAdded = false;
                if (is_array($data->messages->message)) {
                    foreach ($data->messages->message as $message) {
                        $newPointAdded = ($this->registerPoint($flight, $message) | $newPointAdded);
                    }
                } else {
                    $newPointAdded = $this->registerPoint($flight, $data->messages->message);
                }
    
                if ($newPointAdded) {
                    FlightController::calculateDistances($flight);
                }
            }
        }
    }

    private function registerPoint($flight, $message){
        $point_attrs = [
            ['time', '=', date("Y-m-d\TH:i:s", $message->unixTime)],
            ['lat', '=', $message->latitude ],
            ['lon', '=', $message->longitude ]
        ];
        if (!GpsPoint::where($point_attrs)->exists()) {
            GpsPoint::create([
                'flight_id' => $flight->id,
                'lat' => $message->latitude,
                'lon' => $message->longitude,
                'alt' => $message->altitude,
                'msg_type' => $message->messageType,
                'msg_content' => $message->messageContent ?? "",
                'msg_show' => ($message->showCustomMsg == "Y"),
                'time' => date("Y-m-d\TH:i:s", $message->unixTime),
            ]);
            return true;
        } else {
            return false;
        }
    }
}
