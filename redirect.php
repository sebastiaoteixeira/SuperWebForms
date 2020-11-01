<?php
include_once 'config.php';

function dashboard()
{
    header("Location: " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/dashboard.php");
    echo '2';
    die();
}

function formEdit($title)
{
    header("Location: " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/formEdit.php?title=" . $title);
    die();
}

function index($time){
    echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/index.php"
                . "');
            }, " . $time . ");</script>";
    die();
}

function register($time){
    echo "<script>setTimeout(function () {
                window.location.replace('" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/register.html"
                . "');
            }, " . $time . ");</script>";
    die();
}
