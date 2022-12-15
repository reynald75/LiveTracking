import map_functions from "./map_functions";

export default {
    togglePilotsDropdown,
    setPilotBubbles,
    toggleFlightInfo,
    focusOnFlight,
    flyToLastPoint,
    toggleFlightPathMarkers,
    toggleFlightPath,
    togglePilotMenu
}

function togglePilotsDropdown() {
    let contentContainer = $('#dropdown_pilots_content');
    let open = contentContainer.hasClass('content_open');
    let bubbles = $('.dropdown_pilot_bubble_container');

    if (open) {
        stowPilotBubbles(bubbles);
        contentContainer.removeClass('content_open');
        contentContainer.addClass('content_closed');
    } else {
        contentContainer.removeClass('content_closed');
        contentContainer.addClass('content_open');
        setPilotBubbles(bubbles);
    }
}

function moveBubbles(bubbles, duration, yCalc) {
    _.forEach(bubbles, function(bubble, index) {
        gsap.to(bubble, {
            y: yCalc(index),
            ease: "power2",
            duration: duration
        })
    });
}

function setPilotBubbles(bubbles, duration = 0.5) {
    let yCalc = function(index) {
        return (85 + 35 + 15) * (index + 1);
    };
    moveBubbles(bubbles, duration, yCalc);
}

function stowPilotBubbles(bubbles) {
    let yCalc = function() {
        return 0;
    };
    moveBubbles(bubbles, 0.5, yCalc);
}

function toggleFlightPath(flightId) {
    let flightLayer = getFlightLayer(flightId);

    if (flightLayer.isHidden()) {
        flightLayer.show();
    } else {
        flightLayer.hide();
    }
}

function toggleFlightPathMarkers(flightId) {
    let flightLayer = getFlightLayer(flightId);

    if (flightLayer.isHidden()) {
        flightLayer.show();
    } else {
        flightLayer.getLayers()
            .filter(layer => layer.options.id == 'flight_info_marker-' + flightId)
            .map(layer => (layer.isHidden()) ? layer.show() : layer.hide());
    }
}

function toggleFlightInfo(sender) {
    let parentNode = sender.currentTarget.parentNode;
    let flightInfoSpan = parentNode.lastElementChild;
    if (flightInfoSpan.style.display != "inline-block") {
        flightInfoSpan.style.display = "inline-block";
    } else {
        flightInfoSpan.style.display = "none";
    }
}

function togglePilotMenu() {
    let table = $('#pilot_menu_table')[0];
    if (table.style.display != "block") {
        table.style.display = "block";
    } else {
        table.style.display = "none";
    }
}

function focusOnFlight(flightId) {
    let flightLayer = getFlightLayer(flightId);
    let map = map_functions.getMap();

    map.flyToBounds(flightLayer.getBounds());
}

function flyToLastPoint(lastPoint) {
    let map = map_functions.getMap();
    map.flyTo(lastPoint, 16);
}

function getFlightLayer(flightId) {
    let flightLayer;
    let map = map_functions.getMap();
    map.eachLayer(function(layer) {
        if (layer.options.id == 'flight-' + flightId) {
            flightLayer = layer;
        }
    });
    return flightLayer;
}