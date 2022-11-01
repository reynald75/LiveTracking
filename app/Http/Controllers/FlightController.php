<?php

namespace App\Http\Controllers;

use App\Models\Flight;
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
        return Flight::where('organization_id', $org_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        Flight::create([
            'pilot_id' => $user->id,
            'start_time' => time(),
            'end_time' => null,
            'dist_FAI' => 0,
            'dist_SD' => 0,
            'dist_actual' => 0
        ]);
    }

    /**
     * Return the resource with specified id.
     *
     * @param  int  $id
     * @return Response
     */
    public function getById($id)
    {
        return Flight::find($id);
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
