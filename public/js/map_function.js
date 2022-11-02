var x;
var y;
var map;
var org_id

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        this.x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    this.x = position.coords.latitude;
    this.y = position.coords.longitude;
    map.setView([this.x, this.y], 13);
}

function init(org_id) {
    this.org_id = org_id;
    this.map = L.map('map').setView([45, 5], 5);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(this.map);
    getLocation();
}