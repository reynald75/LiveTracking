@foreach ($viewData as $data)
    @php
        $dateStart = DateTime::createFromFormat('Y-m-d H:i:s', $data['flight_info']['start_time']);
        $dateEnd = $data['flight_info']['end_time'] ?? $data['last_point_info']['time'];
        $dateEnd = DateTime::createFromFormat('Y-m-d H:i:s', $dateEnd);
        $dateDiff = date_diff($dateStart, $dateEnd);
    @endphp
    <tr>
        <td>
            <span
                style="background-color: {{ $data['user_info']['line_color'] }}; height: 15px; width: 15px; display: inline-block;"></span>
            {{ $data['user_info']['first_name'] . ' ' . $data['user_info']['last_name'] }}
        </td>
        <td>{{ $data['last_point_info']['alt'] . 'm' }}</td>
        <td>
            {{ number_format($data['flight_info']['dist_actual'] / 1000, 1) .
                'km/' .
                number_format($data['flight_info']['dist_SD'] / 1000, 1) .
                'km/' .
                $dateDiff->format('%H:%I') }}
        </td>
        <td>{{ $data['last_point_info']['msg_type'] }}</td>
        <td>
            <span id="pilot_menu_action_button_container">
                <button class="dropdown_pilot_bubble_info_button" title="Focus on pilot"
                    onclick="map_visuals.focusOnFlight({{ $data['flight_info']['id'] }})">
                    <x-fas-arrows-to-dot />
                </button>
                <button class="dropdown_pilot_bubble_info_button" title="Show/Hide flight"
                    onclick="map_visuals.toggleFlightPath({{ $data['flight_info']['id'] }})">
                    <x-fas-eye />
                </button>
                <button class="dropdown_pilot_bubble_info_button" title="Fly to last point"
                    onclick="map_visuals.flyToLastPoint({{ json_encode([$data['last_point_info']['lat'], $data['last_point_info']['lon']]) }})">
                    <x-fas-forward-step />
                </button>
                <button class="dropdown_pilot_bubble_info_button Last_Icon" title="Show/Hide all markers for flight"
                    onclick="map_visuals.toggleFlightPathMarkers({{ $data['flight_info']['id'] }})">
                    <x-fas-location-dot />
                </button>
            </span>
        </td>
    </tr>
@endforeach
