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
     * Build viewData for all pilots in flight in org.
     *
     * @return viewData array
     */
    private function showAllByOrgId(Request $request)
    {
        $pilots = $this->getAllByOrgId($request->org_id);
        $viewData = [];

        foreach ($pilots as $pilot) {
            $pilotData = [
                'pilot_info' => $pilot,
                'user_info' => $pilot->user,
                'flight_info' => $pilot->flight,
                'last_point_info' => $pilot->flight->lastPoint()
            ];
            array_push($viewData, $pilotData);
        }

        return $viewData;
    }

    /**
     * Display pilot bubbles for active pilots.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllBubblesByOrgId(Request $request){
        $viewData = $this->showAllByOrgId($request);
        return view('subviews.pilot_bubble')->with('viewData', $viewData);
    }

    /**
     * Display pilot menu entries for active pilots.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAllMenuEntriesByOrgId(Request $request){
        $viewData = $this->showAllByOrgId($request);
        return view('subviews.pilot_menu_entry')->with('viewData', $viewData);
    }
}
