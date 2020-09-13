function imgadj() {
    var windowWidth = window.innerWidth;
    if (windowWidth < 1280) {
        $('#start-img').attr('src', 'img/icon/start.png');
        $('#start-img').css('width', '200px');
        $('#start-img').css('bottom', '0px');
    }
    else {
        $('#start-img').attr('src', 'img/background-1789175_960_720.png');
        $('#start-img').css('width', '100%');
        $('#start-img').css('max-height', '110%');
        $('#start-img').css('bottom', '55px');
    }
}

$(document).ready(function () {
    var title = ['C', 'R', 'I', 'A', ' ', 'A', 'V', 'A', 'L', 'I', 'A', '<br>', 'E', 'X', 'P', 'L', 'O', 'R', 'A']

    for (let i in title) {
        setTimeout(function () {
            $(".slogan").append(title[i]);
        }, (i * 400))
    }

    $("header").load("header.php");
    $("footer").load("footer.php");
    $("#flex_news").load("news.php")

    imgadj();
    setInterval(imgadj, 1500);

});

function contact(){
    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
}
