<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\GpsPoint;
use App\Models\Messenger;
use App\Models\PilotInFlight;
use App\Http\Controllers\UpdateController;

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
                        //$api_endpoint = 'https://api.findmespot.com/spot-main-web/consumer/rest-api/2.0/public/feed/';
                        $api_endpoint = 'http://127.0.0.1:9000/';

                        //$date = date_create_from_format('Y-m-d', '2022-12-08');
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

                $this->updateModels($messenger, $data->response->feedMessageResponse);

                sleep(4);
            }
        }
    }

    public function updateModels(Messenger $messenger, $response)
    {
        if (isset($response->messages)) {
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


            $newPointAdded = false;
            foreach ($response->messages->message as $message) {
                if (!GpsPoint::where('time', date("Y-m-d\TH:i:s", $message->unixTime))->exists()) {
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
                    $newPointAdded = true;
                }
            }

            if ($newPointAdded) {
                FlightController::calculateDistances($flight);
            }
        }
    }
}
