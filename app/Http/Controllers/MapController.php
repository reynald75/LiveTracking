<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    private $org_id;

    public function index(Request $request)
    {
        //$this->org_id = $request->org_id;
        return view('map')->with('org_id', $request->org_id);
    }
}
