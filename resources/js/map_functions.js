var map

function init(org_id) {
    initMap();
    updatePilotsInFlight(org_id);
    updateFlightPaths(org_id);
    $('#dropdown_pilots_btn').on("click", togglePilotsDropdown);

    map.on("moveend", function() {
        updatePilotsInFlight(org_id);
    });
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

    let satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 18,
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    });

    let thunderforestLayer = L.tileLayer('https://tile.thunderforest.com/landscape/{z}/{x}/{y}.png?apikey=' + THUNDERFOREST_API_KEY, {
        maxZoom: 18,
        attribution: '&copy; <a href="http://www.thunderforest.com/">Thunderforest</a>, &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    this.map = L.map('map', {
        center: [47, 8],
        zoom: 9,
        layers: [opentopoLayer, openstreetmapLayer, satelliteLayer, thunderforestLayer]
    });

    let flightPaths = L.layerGroup([], {
        id: 'flight_paths_group'
    }).addTo(map);

    let baseMaps = {
        "OpenStreetMap": openstreetmapLayer,
        "OpenTopoMap": opentopoLayer,
        "Satellite": satelliteLayer,
        "ThunderForest Landscape": thunderforestLayer
    };

    let overlays = {
        "Flight paths": flightPaths
    }
    L.control.layers(baseMaps, overlays).addTo(this.map);

    L.control.scale().addTo(map);
    getLocation();
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        this.x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    map.setView([
        position.coords.latitude,
        position.coords.longitude
    ], 13);
}

function updatePilotsInFlight(org_id) {
    $.ajax({
        url: "/api/pilots/display?org_id=" + org_id,
        type: 'GET',
        async: true,
        dataType: "html",
        error: function(data) {
            console.log(data);
        },
        success: function(data) {
            $('#dropdown_pilots_content').html(data);
            let bubbles = $('.dropdown_pilot_bubble_container');
            setPilotBubbles(bubbles, 0);
        }
    });
}

function updateFlightPaths(org_id) {
    $.ajax({
        url: "/api/flights/active?org_id=" + org_id,
        type: 'GET',
        async: true,
        dataType: "json",
        error: function(data) {
            console.log(data);
        },
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
                    let lastMarkerRegEx = '(flight_marker-\\d)(?!_last)';
                    if (feature.options.id.match(lastMarkerRegEx)) {
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

        _.forEach(flight.points, function(point) {
            let marker = L.marker([point.lat, point.lon], {
                id: 'flight_marker-' + flight.id + (point == flight.points.at(-1) ? '_last' : '')
            });

            layer.addLayer(marker);
        });

        layers.addLayer(layer);
    });
    return layers;
}

function getFlightLayer(flightId) {
    let flightLayer;
    map.eachLayer(function(layer) {
        if (layer.options.id == 'flight-' + flightId) {
            flightLayer = layer;
        }
    });
    return flightLayer;
}