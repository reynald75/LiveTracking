@php
    $coordinates_decimal_precision = 5;
@endphp
@foreach ($viewData as $data)
    <div class="Pilot_Bubble">
            <button class="form_Pilot_bubble">
                <p>{{$data['user_info']['initials'] }}</p>
            </button>
            <div class="Info_Pilot">
                <div class="polygon_Pilot"></div>
                <p>Latitude:
                    {{number_format($data['last_point_info']['lat'], $coordinates_decimal_precision)}}
                </p>
                <p>Longitude:
                    {{number_format($data['last_point_info']['lon'], $coordinates_decimal_precision)}}
                </p>
                <p>Altitude:
                    {{$data['last_point_info']['alt'] . "m"}}
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
@endforeach