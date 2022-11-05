<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;

class MapController extends Controller
{

    public function index(Request $request)
    {
        $org_id = null;
        if (isset($request->org_id)){
            if (Organization::where('ref_uuid', $request->org_id)->exists()) {
                $org_id = $request->org_id;
            }
        } else {
            if ($user = auth()->user()){
                $org = Organization::find($user->org_id);
                $org_id = $org->ref_uuid;
            }
        }
        return view('map')->with('org_id', $org_id);
    }
}
