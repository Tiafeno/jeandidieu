(function ($) {
  $(document).ready(function () {
    var windowHeight = $(window).innerHeight();
    var windowWidth = 0;
    var container = $("main#container, #scroll-container");
    var group = $('.group-container');

    $("html, body").mousewheel(function (event, delta) {
      this.scrollLeft -= (delta * 30);
      event.preventDefault();
    });

    $("#formCommand").submit(function() {
      var mail = $('input[type=mail]').val().trim();
      var regexMail =  /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if (! regexMail.test(mail.toLowerCase())) {
        alert( "Veillez remplir le champ avec votre adresse email." );
        return;
      }
      $.get("controller.php", {
        method: "sendMail",
        sender: window.btoa(mail)
      })
      .done(function(data, status, jqXHR) { 
        if (data.success) {
          $('input[type=mail]').val('');
          alert(data.message);
        }
      }, "json")
      .fail(function( error ) {
        console.warn( error );
      });

      return false;
    });

    $('.lightbox-directive').click(function() {
      var idGallerie = $(this).data('ref');
      var galleries = $("#" + idGallerie).find(".product-image-link");
      $(galleries[0]).trigger("click");
    });

    /** set exactelly body width */
    var paragraphs = group.find('.paragraphs-items');
    paragraphs.each(function(index, element) {
      var currentWidth = $( this ).width();
      windowWidth += parseFloat(currentWidth);
      posWindow(); 
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

    function posWindow() {
      group.width(windowWidth);
    }

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