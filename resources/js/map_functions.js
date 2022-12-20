import _ from "lodash";

export default {
    init,
    getMap
}

var map = null;

function init(org_id) {
    initMap();
    updateMap(org_id);
    $('#dropdown_pilots_btn').on("click", map_visuals.togglePilotsDropdown);

    setInterval(function() {
        updateMap(org_id);
    }, (1 * 60 * 1000));

}

function initMap() {
    let openstreetmapLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    let opentopoLayer = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        maxZoom: 17,
        attribution: '&copy; <a href="https://opentopomap.org/credits">OpenTopoMap</a>'
    });

    let thunderforestLayer = L.tileLayer('https://tile.thunderforest.com/landscape/{z}/{x}/{y}.png?apikey=' + THUNDERFOREST_API_KEY, {
        maxZoom: 18,
        attribution: '&copy; <a href="http://www.thunderforest.com/">Thunderforest</a>, &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    map = L.map('map', {
        center: [47, 8],
        zoom: 9,
        layers: [opentopoLayer, openstreetmapLayer, thunderforestLayer]
    });

    let flightPaths = L.layerGroup([], {
        id: 'flight_paths_group'
    }).addTo(map);

    let baseMaps = {
        "OpenStreetMap": openstreetmapLayer,
        "OpenTopoMap": opentopoLayer,
        "ThunderForest Landscape": thunderforestLayer
    };

    let overlays = {
        "Flight paths": flightPaths
    }
    L.control.layers(baseMaps, overlays).addTo(map);

    L.control.scale().addTo(map);
    getLocation();
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        //this.x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    map.setView([
        position.coords.latitude,
        position.coords.longitude
    ], 13);
}

function updateMap(org_id) {
    requestMessengerUpdates();
    updatePilotsInFlight(org_id);
    updateFlightPaths(org_id);
}

function requestMessengerUpdates() {
    $.ajax({
        url: "/api/updates/request",
        type: 'GET',
        async: true,
        dataType: "html",
    });
}

function updatePilotsInFlight(org_id) {
    $.ajax({
        url: "/api/pilots/display/bubbles?org_id=" + org_id,
        type: 'GET',
        async: true,
        dataType: "html",
        success: function(data) {
            $('#dropdown_pilots_content').html(data);
            let bubbles = $('.dropdown_pilot_bubble_container');
            map_visuals.setPilotBubbles(bubbles, 0);
            $('.dropdown_pilot_bubble_button').on("click", map_visuals.toggleFlightInfo);
        }
    });
    $.ajax({
        url: "/api/pilots/display/menu?org_id=" + org_id,
        type: 'GET',
        async: true,
        dataType: "html",
        success: function(data) {
            $('#pilot_menu_table_content').html(data);
        }
    });
}

function updateFlightPaths(org_id) {
    $.ajax({
        url: "/api/flights/active?org_id=" + org_id,
        type: 'GET',
        async: true,
        dataType: "json",
        success: function(data) {
            let layers = constructFlightPathLayers(data);
            let layerGroup;

            map.eachLayer(function(layer) {
                if (layer instanceof L.LayerGroup && layer.options.id == 'flight_paths_group') {
                    layerGroup = layer;
                }
            });

            layerGroup.clearLayers();
            layerGroup.addLayer(layers);

            layers.getLayers().map(layerGroups => {
                layerGroups.getLayers().map(feature => {
                    let lastMarkerRegEx = '(flight_info_marker-\\d)(?!_last)';
                    if (feature.options.id != null && feature.options.id.match(lastMarkerRegEx)) {
                        feature.hide();
                    }
                })
            })
        }
    });
}

function constructFlightPathLayers(data) {
    let layers = L.layerGroup();
    _.forEach(data, function(flight) {
        let layer = L.featureGroup([], {
            id: 'flight-' + flight.id
        });

        layer.addLayer(L.polyline(flight.points.map(p => [p.lat, p.lon, p.alt]), {
            color: flight.user.line_color,
            id: 'flight_polyline-' + flight.id
        }));

        layer = createMarkers(flight, layer);

        layers.addLayer(layer);
    });
    return layers;
}

function createMarkers(flight, layer) {
    let points = _.sortBy(flight.points, ['time']);

    const markerTemplate = '<svg xmlns="http://www.w3.org/2000/svg" class="svg-icon-svg" style="width:32px;height:48px">' +
        '<path class="svg-icon-path" d="m1 16 15 30 15-30a8 8 0 0 0-30 0Z" stroke-width="2" stroke="COLOR" stroke-opacity="undefined" fill="COLOR" fill-opacity=".4"/>' +
        '<circle class="svg-icon-circle" cx="16" cy="16" r="10" fill="#FFF" stroke="COLOR" stroke-width="2"/>' +
        '<text text-anchor="middle" x="16" y="18.8" style="font-size:11.5px" fill="TXTCLR">TEXT</text>' +
        '</svg>';

    _.forEach(points, function(point) {
        let markerColor;
        let markerText;
        let markerTextColor = "#000000";

        switch (point.msg_type) {
            default:
            case 'TRACK':
            case 'UNLIMITED-TRACK':
            case 'SIMPLE-POINT':

                switch (_.indexOf(points, point)) {
                    case 0:
                        markerColor = "#0000FF"
                        markerText = "ST";
                        break;
                    case points.length - 1:
                        markerColor = flight.user.line_color;
                        markerText = "TK";
                        break;
                    default:
                        markerColor = flight.user.line_color;
                        markerText = _.indexOf(points, point);
                        break;
                }
                break;
            case 'OK':
                markerColor = "#228B22";
                markerText = "OK";
                break;
            case 'HELP':
            case 'SOS':
                markerColor = "#000000";
                markerText = "SOS";
                markerTextColor = "#FF0000";
                break;
        }

        let markerSvg = markerTemplate;
        markerSvg = markerSvg.replaceAll('COLOR', markerColor);
        markerSvg = markerSvg.replace('TEXT', markerText);
        markerSvg = markerSvg.replace('TXTCLR', markerTextColor);
        let markerIconUrl = 'data:image/svg+xml;base64,' + btoa(markerSvg);

        let icon = L.icon({
            iconUrl: markerIconUrl,
            iconSize: [32, 48],
            iconAnchor: [16, 48],
            popupAnchor: [-3, -48],
            shadowUrl: 'data:image/svg+xml;base64,' + btoa('<svg xmlns="http://www.w3.org/2000/svg"></svg>')
        });

        let info_marker = L.marker([point.lat, point.lon], {
            id: 'flight_info_marker-' + flight.id + (point == points.at(-1) ? '_last' : ''),
            icon: icon,
            zIndexOffset: (point == points.at(0) || point == points.at(-1) ? 1000 : _.indexOf(points, point) * 10)
        });

        addMarkerPopup(info_marker, point);

        let polyline_marker = L.circleMarker([point.lat, point.lon], {
            color: flight.user.line_color,
            radius: 2
        });

        layer.addLayer(info_marker);
        layer.addLayer(polyline_marker);
    });

    return layer;
}

function addMarkerPopup(marker, point) {
    let table = document.createElement("table");
    let row = document.createElement("tr");
    let labels = document.createElement("td");
    let values = document.createElement("td");

    labels.innerHTML = "<b>Latitude:</b><br/>" +
        "<b>Longitude:</b><br/>" +
        "<b>Altitude:</b><br/>" +
        "<b>Heure:</b><br/>";

    values.innerHTML = point['lat'] + "°<br/>" +
        point['lon'] + "°<br/>" +
        point['alt'] + "m<br/>" +
        point['time'] + "<br/>";

    values.style.textAlign = "right";

    row.appendChild(labels);
    row.appendChild(values);
    table.appendChild(row);

    marker.bindPopup(table);
}

function getMap() {
    return map;
}