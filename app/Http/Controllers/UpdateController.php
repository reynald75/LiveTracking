<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;
use App\Models\PilotInFlight;
use App\Models\Flight;
use DateInterval;
use DateTime;

class UpdateController extends Controller
{

    static function setLastUpdateTime($value)
    {
        $updateData = Update::find('gps_update');
        $updateData->last_update_time = $value;
        $updateData->save();
    }

    static function hasUpdateDelayExpired()
    {
        $updateData = Update::find('gps_update');
        $diff = (now()->timestamp - strtotime($updateData->last_update_time)) / 60;
        return ($diff >= env('MESSENGER_API_UPDATE_DELAY'));
    }

    static function clearOldEntries()
    {
        $dateTime = new DateTime();
        PilotInFlight::where('created_at', '<=', $dateTime->format("Y-m-d"))->delete();

        $dateTime->sub(new DateInterval("P7D")); //Sub 7 days from current date
        Flight::where('created_at', '<=', $dateTime->format("Y-m-d"))->delete();
    }
}
