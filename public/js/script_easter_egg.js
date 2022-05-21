var egg = new Egg("s,i,o", function() {
  jQuery('#img-hidden').fadeIn(500, function() {
    window.setTimeout(function() { jQuery('#img-hidden').fadeOut(); }, 5000);
  });
}).listen();