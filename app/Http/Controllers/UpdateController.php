<?php

namespace App\Http\Controllers;

use App\Models\Update;
use Illuminate\Http\Request;

class UpdateController extends Controller {
    static function setUpdate(Request $request){
        $request->validate([
            'value' => 'boolean'
        ]);

        $updateData = Update::find(1);
        $updateData->updates_enabled = filter_var($request->value,FILTER_VALIDATE_BOOLEAN);
        $updateData->save();
    }

    static function setLastUpdateTime($value){
        $updateData = Update::find(1);
        $updateData->last_update_time = $value;
        $updateData->save();
    }

    static function hasUpdateDelayExpired(){
        $updateData = Update::find(1);
        if($updateData->updates_enabled){
            $diff = (now()->timestamp - strtotime($updateData->last_update_time)) / 60;
            return ($diff >= env('MESSENGER_API_UPDATE_DELAY'));
        } else {
            return false;
        }
    }
}