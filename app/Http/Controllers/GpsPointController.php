<?php

namespace App\Http\Controllers;

use App\Models\GpsPoint;
use App\Models\Flight;
use Illuminate\Http\Request;

class GpsPointController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|integer',
            'messenger_id' => 'required|integer',
            'lat' => 'required',
            'lon' => 'required',
            'alt' => 'required',
            'time' => 'required|time',
        ]);
        GpsPoint::create([
            'flight_id' => $request->flight_id,
            'messenger_id' => $request->messenger_id,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'alt' => $request->alt,
            'time' => $request->time,
        ]);
    }

    /**
     * Return the GpsPoint from the specified Flight.
     *
     * @param  int  $id
     * @return Response
     */
    public function getAllFromFlight(Flight $flight)
    {
        return GpsPoint::where('flight_id', $flight->id)
            ->orderBy('time');
    }

    /**
     * 
     */
    static function calculateAverageSpeed(GpsPoint $point, GpsPoint $lastPoint){

    }
}
