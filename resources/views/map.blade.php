@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ Vite::Asset('resources/sass/map.scss') }}" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
        integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
        integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>
    <div id="map"></div>
    <!--Bouton Pilotes-->
    <div class="dropdown_button" id="dropdown_Pilot">
        <button class="btn btn-secondary" id="forme_btn_dropdown_pilot">
            <img id="img_btn_pilot" src="{{ Vite::Asset('resources/img/img_btn_pilot.webp') }}" />
        </button>
    </div>
    <div class="dropdown_button" id="dropdown_Actions">
        <button class="btn btn-secondary" id="forme_btn_dropdown_actions">
            <img id="img_btn_pilot" src="{{ Vite::Asset('resources/img/img_btn_pilot.webp') }}" />
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
    <!--endforeach-->

    <script src="{{ Vite::Asset('resources/js/map_functions.js') }}"></script>
    <script src="{{ Vite::Asset('resources/js/map_visuals.js') }}"></script>
    <script type="module">init('{{$org_id}}');</script>
@endsection
