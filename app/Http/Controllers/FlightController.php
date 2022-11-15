<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\User;
use App\Models\Organization;
use App\Models\PilotInFlight;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $flight = Flight::create([
            'user_id' => $user->id,
            'start_time' => time(),
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
        return $flight;
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
