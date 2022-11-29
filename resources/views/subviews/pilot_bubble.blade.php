@php
    define('COORDS_DECIMAL_PRECISION', 5);
@endphp
@foreach ($viewData as $data)
    <div class="dropdown_pilot_bubble_container">
        <button class="dropdown_pilot_bubble_button" style="border-color: {{$data['user_info']['line_color']}}">
            <h1>{{ $data['user_info']['initials'] }}</h1>
            <p>{{ number_format($data['flight_info']['dist_actual'] / 1000, 1)}}km</p>
            <p>{{ $data['last_point_info']['alt']}}m</p>
        </button>
        <span class="dropdown_pilot_bubble_info">
            <div class="polygon_Pilot"></div>
            <table class="dropdown_pilot_bubble_info_content">
                <tbody>
                    <th>
                        <p><b>{{ $data['user_info']['name'] }}</b></p>
                        <hr/>
                    </th>
                    <tr>
                        <td id="dropdown_pilot_bubble_info_content_labels">
                            <p><b>Dist. parcouru:</b></p>
                            <p><b>Dist. décollage:</b></p>
                            <p><b>Altitude:</b></p>
                            <p><b>Vitesse moyenne:</b></p>
                            <p><b>Dernier contact:</b></p>
                        </td>
                        <td id="dropdown_pilot_bubble_info_content_values">
                            <p>{{ number_format($data['flight_info']['dist_actual'] / 1000, 1)}}km</p>
                            <p>{{ number_format($data['flight_info']['dist_SD'] / 1000, 1)}}km</p>
                            <p>{{ $data['last_point_info']['alt'] . 'm' }}</p>
                            <p>N/A</p>
                            <p>{{ date('H:i', strtotime($data['last_point_info']['time'])); }}</p>
                        </td>
                        <td>
                            <table class="dropdown_pilot_bubble_info_buttons">
                                <tbody>
                                    <tr>
                                        <td>
                                            <button class="dropdown_pilot_bubble_info_button" title="Focus on pilot"
                                                onclick="focusOnFlight({{ $data['flight_info']['id'] }})">
                                                <img src="{{ Vite::Asset('resources/img/Focus.png') }}" alt="Focus">
                                            </button>
                                        </td>
                                        <td>
                                            <button class="dropdown_pilot_bubble_info_button" title="Show/Hide flight"
                                                onclick="toggleFlightPath({{ $data['flight_info']['id'] }})">
                                                <img src="{{ Vite::Asset('resources/img/eye.png') }}"
                                                    alt="Show/Hide flight">
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button class="dropdown_pilot_bubble_info_button" title="Fly to last point"
                                                onclick="flyToLastPoint({{ json_encode([$data['last_point_info']['lat'], $data['last_point_info']['lon']]) }})">
                                                <img src="{{ Vite::Asset('resources/img/last.webp') }}"
                                                    alt="Last point">
                                            </button>
                                        </td>
                                        <td>
                                            <button class="dropdown_pilot_bubble_info_button Last_Icon"
                                                title="Show/Hide all markers for flight"
                                                onclick="toggleFlightPathMarkers({{ $data['flight_info']['id'] }})">
                                                <img src="{{ Vite::Asset('resources/img/ping.png') }}"
                                                    alt="All markers">
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </span>
    </div>
@endforeach
