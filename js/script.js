$(function(){
  $(".slides").slidesjs({
    width: 500,
    height: 500,
    play: {
      active: false,
      effect: "fade",
      interval: 50000,
      auto: true,
      swap: true,
      pauseOnHover: false,
      restartDelay: 2500
    },
    effect: {
      slide: {
        // Slide effect settings.
        speed: 200
          // [number] Speed in milliseconds of the slide animation.
      },
      fade: {
        speed: 5000,
          // [number] Speed in milliseconds of the fade animation.
        crossfade: true
          // [boolean] Cross-fade the transition.
      }
    }
  });
  
});



