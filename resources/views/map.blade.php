@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ Vite::Asset('resources/sass/map.scss') }}" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
        integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
        integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <div id="map"></div>
    <!--Bouton Pilotes-->
    <div class="dropdown_button_container" id="dropdown_pilots_container">
        <button class="btn btn-secondary" id="dropdown_pilots_btn">
            <img id="img_btn_pilot" src="{{ Vite::Asset('resources/img/img_btn_pilot.webp') }}" />
        </button>
        <div id="dropdown_pilots_content" class="dropdown_content content_open"></div>
    </div>
    <div class="dropdown_button_container" id="dropdown_actions_container">
        <div id="dropdown_action_content" class="dropdown_content"></div>
        <button class="btn btn-secondary" id="dropdown_actions_btn">
            <img id="img_btn_pilot" src="{{ Vite::Asset('resources/img/img_btn_pilot.webp') }}" />
        </button>
    </div>

    <script src="{{ Vite::Asset('resources/js/map_functions.js') }}"></script>
    <script src="{{ Vite::Asset('resources/js/map_visuals.js') }}"></script>
    <script type="module">init('{{$org_id}}');</script>
@endsection
