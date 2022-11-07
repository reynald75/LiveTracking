@extends('layouts.app')

@section('content')
<div class="Pilot_Bubble">
        <button class="form_Pilot_bubble">
            <!--Initiales-->
            <p>TZ</p>
        </button>
        <div class="Info_Pilot">
            <div class="polygon_Pilot"></div>
            <p>Latitude:
                <!--Info Recup-->
            </p>
            <p>Longitude:
                <!--Info Recup-->
            </p>
            <p>Altitude:
                <!--Info Recup-->
            </p>
            <button class="Info_Pilot_Icon">
                <img src="{{ Vite::Asset('resources/img/Focus.png') }}" alt="Focus">
            </button>
            <button class="Info_Pilot_Icon">
                <img src="{{ Vite::Asset('resources/img/eye.png') }}" alt="Show">
            </button>
            <button class="Info_Pilot_Icon">
                <img src="{{ Vite::Asset('resources/img/last.webp') }}" alt="last point">
            </button>
            <button class="Info_Pilot_Icon Last_Icon">
                <img src="{{ Vite::Asset('resources/img/ping.png') }}" alt="all pings">
            </button>
        </div>
    </div>
@endsection