"use strict";

(function (window, document) {
  var app = {};
  app.state = false; // toggled

  app.init = function () {
    var search = document.getElementById('mist-search');
    console.log(search);
  };

  document.ready(app.init);
  return app;
})(window, document);