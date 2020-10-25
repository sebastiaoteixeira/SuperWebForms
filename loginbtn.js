$(document).ready(function () {
  $("div.hide-menu").hide();

  $("#namebtn").click(function () {

    $("#logout").click(function () {
      document.cookie =
        "Login_Token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        location.reload();
    });

    $(this).hide();
    $("div.hide-menu").show();
  });
});
