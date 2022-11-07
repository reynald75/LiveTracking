<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\PilotInFlight;
use App\Models\User;
use Illuminate\Http\Request;

class PilotInFlightController extends Controller
{

    /**
     * Return all the pilots in flight.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return PilotInFlight::all();
    }

    /**
     * Return the pilots in flight with specified organization_id.
     *
     * @param  int  $org_id
     * @return \Illuminate\Http\Response
     */
    public function getAllByOrgId($org_id)
    {
        $org = Organization::where('ref_uuid', $org_id)->get();
        $org_users = User::whereBelongsTo($org)->get();
        return PilotInFlight::whereBelongsTo($org_users)->get();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$request->validate([
            'user_id' => 'required|integer',
            'flight_id' => 'required|integer',
            'is_flying' => 'required|boolean',
            'sos' => 'required|boolean',
        ]);
        PilotInFlight::create()*/
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllByOrg(Request $request)
    {
        $pilots = $this->getAllByOrgId($request->org_id);
        $viewData = [];

        foreach ($pilots as $pilot) {
            $pilotData = [
                'pilot_info' => $pilot,
                'user_info' => $pilot->user,
                'flight_info' => $pilot->flight
            ];
            array_push($viewData, $pilotData);
        }

        return view('subviews.pilot_bubble')->with('viewData', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PilotInFlight  $pilotInFlight
     * @return \Illuminate\Http\Response
     */
    public function edit(PilotInFlight $pilotInFlight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PilotInFlight  $pilotInFlight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PilotInFlight $pilotInFlight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PilotInFlight  $pilotInFlight
     * @return \Illuminate\Http\Response
     */
    public function destroy(PilotInFlight $pilotInFlight)
    {
        //
    }
}
