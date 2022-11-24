<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * Return the flights with specified organization_id.
     *
     * @param  int  $org_id
     * @return \Illuminate\Http\Response
     */
    public function getAllByOrgId($org_id)
    {
        $org = Organization::where('ref_uuid', $org_id)->get();
        $org_users = User::whereBelongsTo($org)->get();
        return Flight::whereBelongsTo($org_users)->get();
    }

    /**
     * Return the Flight with the specified id.
     *
     * @param  int  $id
     * @return Response
     */
    public function getById($id)
    {
        return Flight::find($id);
    }

    /**
     * Return the Flight path with the specified id.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFlightPathById($id)
    {
        $flight = $this->getById($id);
        $flight->points;
        $flight->user;

        return $flight;
    }

    /**
     * Return the Flight path batch with the specified ids.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFlightPathBatchByIds(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $data = [];

        foreach ($request->ids as $id) {
            array_push($data, $this->getFlightPathById($id));
        }

        return $data;
    }

    /**
     * Return the active flight paths with specified organization_id.
     *
     * @param  int  $org_id
     * @return \Illuminate\Http\Response
     */
    public function getActiveFlightPathsByOrgId(Request $request)
    {
        $pilots = app('App\Http\Controllers\PilotInFlightController')->getAllByOrgId($request->org_id);
        $flight_ids = $pilots->pluck('flight_id')->toArray();

        $data_request = new Request();
        $data_request->replace(['ids' => $flight_ids]);

        return $this->getFlightPathBatchByIds($data_request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
        $user = auth()->user();
        if ($flight->pilot_id == $user->id) {
            $request->validate([
                'pilot_id' => 'required|integer',
                'start_time' => 'required|date',
                'end_time' => 'nullable|date',
                'dist_FAI' => 'required',
                'dist_SD' => 'required',
                'dist_actual' => 'required',
            ]);

            $flight->pilot_id = $request->pilot_id;
            $flight->start_time = $request->start_time;
            $flight->end_time = $request->end_time;
            $flight->dist_FAI = $request->dist_FAI;
            $flight->dist_SD = $request->dist_SD;
            $flight->dist_actual = $request->dist_actual;

            $flight->save();
        }
    }

    /**
     * Calculate and save flown distances
     *
     * @param  \App\Models\Flight  $flight
     */
    static function calculateDistances(Flight $flight)
    {
        $points = $flight->points()->orderBy('time')->get();

        $flight->dist_SD = FlightController::calculateStraightLineDistance($points);
        $flight->dist_actual = FlightController::calculateActualDistance($points);
        $flight->dist_FAI = FlightController::calculateFAITriangleDistance($points);

        $flight->save();
    }

    /**
     * Calculate straight line flown distance
     *
     * @param array $points
     * @return float distance
     */
    static function calculateStraightLineDistance($points)
    {
        $pointA = $points[0];
        $pointB = $points[count($points) - 1];

        return FlightController::haversineGreatCircleDistance($pointA['lat'], $pointA['lon'], $pointB['lat'], $pointB['lon']);
    }

    /**
     * Calculate actual flown distance
     *
     * @param array $points
     * @return float distance
     */
    static function calculateActualDistance($points)
    {
        $distance = 0;
        $pointIndex = 0;

        while ($pointIndex < count($points) - 1) {
            $pointA = $points[$pointIndex];
            $pointB = $points[$pointIndex + 1];

            $distance += FlightController::calculateStraightLineDistance(array($pointA, $pointB));
            $pointIndex += 1;
        }

        return $distance;
    }

    /**
     * Calculate FAI triangle flown distance
     *
     * @param array $points
     * @return float distance
     */
    static function calculateFAITriangleDistance($points)
    {
        return 0;
    }

    /**
     * Source: https://stackoverflow.com/a/14751773
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    static function haversineGreatCircleDistance(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371000
    ) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();
    }
}
