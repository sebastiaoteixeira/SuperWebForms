<?php
define('url', 'https://superwebforms.infinityfreeapp.com');

function dashboard()
{
    header("Location: " . url . "/dashboard.php");
    echo '2';
    die();
}

function formEdit($title)
{
    header("Location: " . url . "/formEdit.php?title=" . $title);
    die();
}

function index($time){
    echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/index.php"
                . "');
            }, " . $time . ");</script>";
    die();
}

function index($time){
    echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
            }, " . $time . ");</script>";
    die();
}