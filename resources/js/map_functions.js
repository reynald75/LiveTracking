var map

function init(org_id) {
    initMap();
    $('#forme_btn_dropdown_pilot').on("click", function() {
        updatePilotsInFlight(org_id)
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
        dataType: "json",
        error: function(data) {
            console.log(data);
        },
        success: function(data) {
            console.log(data);
        }
    });
}