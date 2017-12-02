(function ($) {
  $(document).ready(function () {
    var windowHeight = $(window).innerHeight();
    var container = $("main#container, #scroll-container");
    $("html").mousewheel(function (event, delta) {
      this.scrollLeft -= (delta * 30);
      event.preventDefault();
    });

    positionHeight()
      .then(function successCallback(height) {
        container.css({height: height + "px", visibility: 'visible'});
      });

    $(window).resize(function() {
      positionHeight()
      .then(function successCallback(height) {
        container.css({height: height + "px", visibility: 'visible'});
      });
    });

    function positionHeight() {
      return new Promise(function(resolve, reject) {
        container.css({height : parseFloat(windowHeight), visibility: 'hidden'});
        var currentHeight = $(window).innerHeight();
        if (parseFloat(windowHeight) > parseFloat(currentHeight)) {
          resolve(parseFloat(currentHeight));
        } else resolve( windowHeight );
      })
    }
    
  });
})(jQuery)