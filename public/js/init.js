(function() {
  var elements = document.querySelectorAll('.materialboxed');

  Array.prototype.forEach.call(elements, function(el, i) {
    var instance = M.Materialbox.init(el);
  });
})();