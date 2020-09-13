$(document).ready(function () {
    var windowWidth = $(window).width();
    if (windowWidth < 600) {
        $("section").width(windowWidth / 1.35);
        for (let i = 0; i < 2; i++) {
            $(".wrap").unwrap();
        }
        $(".wrap").wrap("<tr></tr>");
    }
});

$(document).ready(function () {
    $("#contact-btn").click(function () {
      window.scrollBy(500, 0);
    });
  
    $("#burger_menu").click(function () {
      var current_state = $(".top-buttons").css("visibility");
      if (current_state == "visible") {
        var next_state = "hidden";
      } else {
        alert("12");
        var next_state = "visible";
      }
  
      $(".top-buttons").css("visibility", next_state);
    });
  });