@php
    define('COORDS_DECIMAL_PRECISION', 5);
@endphp
@foreach ($viewData as $data)
    <div class="dropdown_pilot_bubble_container">
        <button class="dropdown_pilot_bubble_button">
            <p>{{ $data['user_info']['initials'] }}</p>
        </button>
        <span class="dropdown_pilot_bubble_info">
            <div class="polygon_Pilot"></div>
            <table class="dropdown_pilot_bubble_info_content">
                <tbody>
                    <tr>
                        <td>
                            <p><b>Latitude:</b>
                                {{ number_format($data['last_point_info']['lat'], COORDS_DECIMAL_PRECISION) }}
                            </p>
                            <p><b>Longitude:</b>
                                {{ number_format($data['last_point_info']['lon'], COORDS_DECIMAL_PRECISION) }}
                            </p>
                            <p><b>Altitude:</b>
                                {{ $data['last_point_info']['alt'] . 'm' }}
                            </p>
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
