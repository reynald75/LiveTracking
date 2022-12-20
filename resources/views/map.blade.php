@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ Vite::Asset('resources/sass/map.scss') }}" />
    <link rel="stylesheet" href="{{ Vite::Asset('node_modules/leaflet/dist/leaflet.css') }}" />
    <div id="content_container">
        <div id="map">
        </div>
        <!--Bouton Pilotes-->
        <div class="map_overlay_container" id="dropdown_pilots_container">
            <button class="btn btn-secondary" id="dropdown_pilots_btn">
                <img id="img_btn_pilot" src="{{ Vite::Asset('resources/img/img_btn_pilot.png') }}" />
            </button>
            <div id="dropdown_pilots_content" class="content_open"></div>
        </div>
        <div class="map_overlay_container" id="pilot_menu_container">
            <button class="btn" id="pilot_menu_btn" onclick="map_visuals.togglePilotMenu()">
                <x-fas-list />
            </button>
            <table class="table table-striped" id="pilot_menu_table">
                <thead>
                    <td>Nom</td>
                    <td>Altitude</td>
                    <td>Trk/T.Off/Air Time</td>
                    <td>Last</td>
                    <td>Actions</td>
                </thead>
                <tbody id="pilot_menu_table_content"></tbody>
            </table>
        </div>
    </div>
    <script type="module">map_functions.init('{{$org_id}}');</script>
@endsection
