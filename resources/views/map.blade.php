@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="/css/map.css"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
     integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
     crossorigin=""/>
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
     integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
     crossorigin=""></script>
    <div id="map"></div>
        <!--Bouton Pilotes-->
        <div class="dropdown_Pilot">
            <button id="forme_btn_dropdown_pilot">
                <img id="img_btn_pilot" src="/img/img_btn_pilot.webp"/>
            </button>
        </div>
    <!--Création des différents pilotes-->
    <!--foreach ($pilots as $pilot)-->
        <div class="Pilot_Bubble">
            <button class="form_Pilot_bubble">
                <!--Initiales-->
                <p>TZ</p>
            </button>
            <div class="Info_Pilot">
                <div class="polygon_Pilot"></div>
                <p>Latitude: <!--Info Recup--></p>
                <p>Longitude: <!--Info Recup--></p>
                <p>Altitude: <!--Info Recup--></p>
                <button class="Info_Pilot_Icon">
                    <img src="/img/Focus.png" alt="Focus">
                </button>
                <button class="Info_Pilot_Icon">
                    <img src="/img/eye.png" alt="Show">
                </button>
                <button class="Info_Pilot_Icon">
                    <img src="/img/last.webp" alt="last point">
                </button>
                <button class="Info_Pilot_Icon Last_Icon">
                    <img src="/img/ping.png" alt="all pings">
                </button>
            </div>
        </div>
    <!--endforeach-->

    <script src="/js/map_function.js"></script>
@endsection