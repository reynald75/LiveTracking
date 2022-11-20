function togglePilotsDropdown() {
    let contentContainer = $('#dropdown_pilots_content');
    let open = contentContainer.hasClass('content_open');
    let bubbles = $('.dropdown_pilot_bubble_container');

    if (open) {
        contentContainer.removeClass('content_open');
        contentContainer.addClass('content_closed');
        stowPilotBubbles(bubbles);
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
        return (75 + 15) + (75 + 25) * index;
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
            .filter(layer => layer.options.id == 'flight_marker-' + flightId)
            .map(layer => (layer.isHidden()) ? layer.show() : layer.hide());
    }
}

function focusOnFlight(flightId) {
    let flightLayer = getFlightLayer(flightId);

    map.flyToBounds(flightLayer.getBounds());
}

function flyToLastPoint(lastPoint) {
    map.flyTo(lastPoint, 16);
}