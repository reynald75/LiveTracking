<?php

namespace App\Http\Controllers;

use App\Models\PilotInFlight;
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
     * @param  \App\Models\PilotInFlight  $pilotInFlight
     * @return \Illuminate\Http\Response
     */
    public function show(PilotInFlight $pilotInFlight)
    {
        //
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
