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