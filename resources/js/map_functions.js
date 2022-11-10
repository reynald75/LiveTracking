var map

function init(org_id) {
    initMap();
    /*$('#dropdown_pilots_btn').on("click", function() {
        updatePilotsInFlight(org_id)
    });*/
    updatePilotsInFlight(org_id);
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
    this.map = L.map('map', {
        center: [47, 8],
        zoom: 9,
        layers: [opentopoLayer, openstreetmapLayer]
    });

    let baseMaps = {
        "OpenStreetMap": openstreetmapLayer,
        "OpenTopoMap": opentopoLayer
    };

    let overlayMaps = {};
    L.control.layers(baseMaps, overlayMaps).addTo(this.map);
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
    console.log(map.getCenter().toString());
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