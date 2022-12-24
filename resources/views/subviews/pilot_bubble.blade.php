@php
    define('COORDS_DECIMAL_PRECISION', 5);
@endphp
@foreach ($viewData as $data)
    <span class="dropdown_pilot_bubble_container">
        <button class="dropdown_pilot_bubble_button" style="border-color: {{$data['user_info']['line_color']}}">
            <h1>{{ $data['user_info']['initials'] }}</h1>
            <p>{{ number_format($data['flight_info']['dist_actual'] / 1000, 1)}}km</p>
            <p>{{ $data['last_point_info']['alt']}}m</p>
        </button>
        <span class="dropdown_pilot_bubble_info">
            <table class="dropdown_pilot_bubble_info_content">
                <tbody>
                    <th>
                        <p><b>{{ $data['user_info']['first_name'] . ' ' . $data['user_info']['last_name'][0] }}.</b></p>
                        <hr/>
                    </th>
                    <tr>
                        <td id="dropdown_pilot_bubble_info_content_labels">
                            <p><b>Dist. flown:</b></p>
                            <p><b>Dist. T.Off:</b></p>
                            <p><b>Altitude:</b></p>
                            <p><b>Avg. speed:</b></p>
                            <p><b>Last contact:</b></p>
                        </td>
                        <td id="dropdown_pilot_bubble_info_content_values">
                            <p><b>{{ number_format($data['flight_info']['dist_actual'] / 1000, 1)}}km</b></p>
                            <p><b>{{ number_format($data['flight_info']['dist_SD'] / 1000, 1)}}km</b></p>
                            <p><b>{{ $data['last_point_info']['alt'] . 'm' }}</b></p>
                            <p><b>N/A</b></p>
                            <p><b>{{ date('H:i', strtotime($data['last_point_info']['time'])); }}</b></p>
                        </td>
                        <td>
                            <table class="dropdown_pilot_bubble_info_buttons">
                                <tbody>
                                    <tr>
                                        <td>
                                            <button class="dropdown_pilot_bubble_info_button" title="Focus on pilot"
                                                onclick="map_visuals.focusOnFlight({{ $data['flight_info']['id'] }})">
                                                <x-fas-arrows-to-dot/>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="dropdown_pilot_bubble_info_button" title="Show/Hide flight"
                                                onclick="map_visuals.toggleFlightPath({{ $data['flight_info']['id'] }})">
                                                <x-fas-eye/>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button class="dropdown_pilot_bubble_info_button" title="Fly to last point"
                                                onclick="map_visuals.flyToLastPoint({{ json_encode([$data['last_point_info']['lat'], $data['last_point_info']['lon']]) }})">
                                                <x-fas-forward-step/>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="dropdown_pilot_bubble_info_button Last_Icon"
                                                title="Show/Hide all markers for flight"
                                                onclick="map_visuals.toggleFlightPathMarkers({{ $data['flight_info']['id'] }})">
                                                <x-fas-location-dot/>
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
    </span>
@endforeach
