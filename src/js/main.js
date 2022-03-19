(function ($) {
  $("#respond").on("click", "p.stars a", function () {
    var $star = $(this);
    switch ($star.text()) {
      case "1":
        $star.text("5");
        break;
      case "2":
        $star.text("4");
        break;
      case "4":
        $star.text("2");
        break;
      case "5":
        $star.text("1");
        break;
      default:
        $star.text("3");
        break;
    }
  });
})(jQuery);
