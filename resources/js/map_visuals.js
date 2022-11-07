var btn = document.getElementById('forme_btn_dropdown_pilot');
var tl = gsap.timeline({defaults: { ease: "power2.inOut"}})
var toggle =false;

tl.to('.Pilot_Bubble', {
    opacity:1,
    transform: 'translateX(0)',
    stagger: .05
 }, "-=.5")
 tl.pause();

 btn.addEventListener('click', () => {
    /*document.getElementById("forme_btn_dropdown_pilot").insertAdjacentHTML("afterend", new URL("../views/Pilot_Bubble.blade.php"));*/
    toggle =!toggle;
    if (toggle? tl.play() : tl.reverse());
 })